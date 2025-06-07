@extends('layouts.app')
@section('content')
<div class="mt-2">

    <ul class="nav nav-tabs nav-justified nav-bordered mb-3" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active rounded-0 py-2" id="this-month-tab" data-bs-toggle="tab"
                data-bs-target="#this-month" type="button" role="tab" aria-controls="this-month" aria-selected="true">
                <span class="d-none d-sm-inline">This Month</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-0 py-2" id="select-month-tab" data-bs-toggle="tab"
                data-bs-target="#select-month" type="button" role="tab" aria-controls="select-month"
                aria-selected="false">
                <span class="d-none d-sm-inline">Selected Month</span>
            </button>
        </li>
    </ul>

    <div class="tab-content" id="attendanceTabContent">
        <div class="tab-pane fade show active" id="this-month" role="tabpanel" aria-labelledby="this-month-tab">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="userThis" class="form-label">Select User</label>
                    <select id="userThis" class="form-select">
                        <option value="" disabled selected>-- Choose User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button id="showThis" class="btn btn-primary">Show Attendance</button>
                </div>
            </div>
            <div id="thisMonthCalendar"></div>
        </div>

        <div class="tab-pane fade" id="select-month" role="tabpanel" aria-labelledby="select-month-tab">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="userSelect" class="form-label">Select User</label>
                    <select id="userSelect" class="form-select">
                        <option value="" disabled selected>-- Choose User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="monthSelect" class="form-label">Month</label>
                    <select id="monthSelect" class="form-select">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $m == now()->month ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="yearSelect" class="form-label">Year</label>
                    <select id="yearSelect" class="form-select">
                        @php $currentYear = now()->year; @endphp
                        @for($y = $currentYear; $y >= $currentYear - 5; $y--)
                            <option value="{{ $y }}" {{ $y == $currentYear ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button id="showSelected" class="btn btn-primary">Show Attendance</button>
                </div>
            </div>
            <div id="selectedMonthCalendar"></div>
        </div>
    </div>
</div>
<!-- Edit Attendance Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="attendanceForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Attendance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="modal-user-id">
                    <input type="hidden" id="modal-date">

                    <div class="mb-3">
                        <label for="arr_time" class="form-label">Arrival Time</label>
                        <input type="time" id="arr_time" name="arr_time" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="leave_time" class="form-label">Leave Time</label>
                        <input type="time" id="leave_time" name="leave_time" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .calendar {
        width: 100%;
        border-collapse: separate;
        border-spacing: 4px;
        table-layout: fixed;
    }

    .calendar th {
        background-color: #f0f0f0;
        padding: 8px 0;
        font-weight: 600;
        color: #333;
        text-align: center;
        border-radius: 4px;
        font-size: 0.9rem;
    }

    .calendar td {
        background-color: #ffffff;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        padding: 4px 6px;
        height: 70px; /* Shortened from 100px to 70px */
        vertical-align: top;
        position: relative;
        border-radius: 6px;
        transition: all 0.2s ease-in-out;
        cursor: pointer;
        overflow: hidden;
    }

    .calendar td:hover {
        background-color: #f5f5f5;
    }

    .day-number {
        font-weight: bold;
        font-size: 0.9rem;
        color: #007bff;
        display: block;
        margin-bottom: 2px;
    }

    .calendar .time {
        display: block;
        font-size: 0.75em;
        color: #555;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .calendar td.full {
        background-color: #d1e7dd !important;
        color: #0f5132;
    }

    .calendar td.partial {
        background-color: #fff3cd !important;
        color: #664d03;
    }

    .calendar td.no-att {
        background-color: #f8d7da !important;
        color: #842029;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const today = new Date();

        document.getElementById('showThis').addEventListener('click', () => {
            const userId = document.getElementById('userThis').value;
            if (!userId) return alert('Please select a user.');
            fetch(`/attendance/this-month/${userId}`)
                .then(res => res.json())
                .then(data => renderCalendar(data, 'thisMonthCalendar', today.getMonth() + 1, today.getFullYear()))
                .catch(console.error);
        });

        document.getElementById('showSelected').addEventListener('click', () => {
            const userId = document.getElementById('userSelect').value;
            const month = parseInt(document.getElementById('monthSelect').value);
            const year = parseInt(document.getElementById('yearSelect').value);
            if (!userId) return alert('Please select a user.');
            fetch(`/attendance/month/${userId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ month, year })
            })
                .then(res => res.json())
                .then(data => renderCalendar(data, 'selectedMonthCalendar', month, year))
                .catch(console.error);
        });

        function renderCalendar(data, containerId, month, year) {
            const map = {};
            data.forEach(d => {
                const day = new Date(d.date).getDate();
                map[day] = { arr: d.arr_time, leave: d.leave_time };
            });
            document.getElementById(containerId).innerHTML = buildCalendar(map, month, year);
        }

        function buildCalendar(map, month, year) {
            const firstDay = new Date(year, month - 1, 1).getDay();
            const daysInMonth = new Date(year, month, 0).getDate();
            let html = '<table class="calendar"><thead><tr>' +
                ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'].map(d => `<th>${d}</th>`).join('') +
                '</tr></thead><tbody><tr>';

            for (let i = 0; i < firstDay; i++) html += '<td></td>';
            for (let day = 1; day <= daysInMonth; day++) {
                const dateObj = new Date(year, month - 1, day);
                const isFuture = dateObj > today;
                const rec = map[day];
                let cls = rec ? (rec.arr && rec.leave ? 'full' : 'partial') : (!isFuture ? 'no-att' : '');
                html += `<td class="${cls}"><div class="day-number">${day}</div>`;
                if (rec && rec.arr) html += `<span class="time">⏰ In: ${rec.arr}</span>`;
                if (rec && rec.leave) html += `<span class="time">🚪 Out: ${rec.leave}</span>`;
                html += '</td>';
                if ((firstDay + day) % 7 === 0 && day !== daysInMonth) html += '</tr><tr>';
            }

            html += '</tr></tbody></table>';
            return html;
        }

        document.addEventListener('click', function (e) {
            if (e.target.closest('td')) {
                const td = e.target.closest('td');
                const day = td.querySelector('.day-number')?.innerText;
                if (!day) return;

                const containerId = td.closest('table').parentElement.id;
                const userId = containerId === 'thisMonthCalendar'
                    ? document.getElementById('userThis').value
                    : document.getElementById('userSelect').value;

                const month = containerId === 'thisMonthCalendar'
                    ? (new Date()).getMonth() + 1
                    : parseInt(document.getElementById('monthSelect').value);

                const year = containerId === 'thisMonthCalendar'
                    ? (new Date()).getFullYear()
                    : parseInt(document.getElementById('yearSelect').value);

                const formattedDate = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

                fetch(`/attendance/get/${userId}/${formattedDate}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('modal-user-id').value = userId;
                        document.getElementById('modal-date').value = formattedDate;
                        document.getElementById('arr_time').value = data.arr_time ?? '';
                        document.getElementById('leave_time').value = data.leave_time ?? '';
                        new bootstrap.Modal(document.getElementById('staticBackdrop')).show();
                    });
            }
        });

        document.getElementById('attendanceForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const userId = document.getElementById('modal-user-id').value;
            const date = document.getElementById('modal-date').value;
            const arr_time = document.getElementById('arr_time').value;
            const leave_time = document.getElementById('leave_time').value;

            fetch(`/attendance/update`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ user_id: userId, date, arr_time, leave_time })
            })
                .then(res => res.json())
                .then(data => {
                    alert('Attendance updated!');
                    document.querySelector('.modal .btn-close').click();
                    document.getElementById('showThis').click();
                });
        });
    });
</script>


@endsection
