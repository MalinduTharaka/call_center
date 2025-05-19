@extends('layouts.app')
@section('content')
    <div class=" mt-2">
        <h2>User Attendance Report</h2>

        <ul class="nav nav-tabs nav-justified nav-bordered mb-3" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-0 py-2" id="this-month-tab" data-bs-toggle="tab" data-bs-target="#this-month" type="button" role="tab" aria-controls="this-month" aria-selected="true">
                    <span class="d-none d-sm-inline">This Month</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-0 py-2" id="select-month-tab" data-bs-toggle="tab" data-bs-target="#select-month" type="button" role="tab" aria-controls="select-month" aria-selected="false">
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
                                <option value="{{ $m }}" {{ $m == now()->month ? 'selected' : '' }}>{{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
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

    <style>
        .calendar {
            width: 100%;
            border-collapse: collapse;
        }

        .calendar th,
        .calendar td {
            border: 1px solid #ddd;
            width: 14.28%;
            height: 60px;
            vertical-align: top;
            position: relative;
            padding: 2px;
        }

        .calendar th {
            background: #f8f9fa;
            text-align: center;
        }

        .day-number {
            font-weight: bold;
        }

        .full {
            background-color: #28a745;
            color: #fff;
        }

        .partial {
            background-color: #90ee90;
        }

        .no-att {
            background-color: #fff3cd;
        }

        .time {
            display: block;
            font-size: 0.8em;
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
                    method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
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
                           ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'].map(d => `<th>${d}</th>`).join('') +
                           '</tr></thead><tbody><tr>';

                for (let i = 0; i < firstDay; i++) html += '<td></td>';
                for (let day = 1; day <= daysInMonth; day++) {
                    const dateObj = new Date(year, month - 1, day);
                    const isFuture = dateObj > today;
                    const rec = map[day];
                    let cls = rec ? (rec.arr && rec.leave ? 'full' : 'partial') : (!isFuture ? 'no-att' : '');
                    html += `<td class="${cls}"><div class="day-number">${day}</div>`;
                    if (rec && rec.arr) html += `<span class="time">In: ${rec.arr}</span>`;
                    if (rec && rec.leave) html += `<span class="time">Out: ${rec.leave}</span>`;
                    html += '</td>';
                    if ((firstDay + day) % 7 === 0 && day !== daysInMonth) html += '</tr><tr>';
                }

                html += '</tr></tbody></table>';
                return html;
            }
        });
    </script>

@endsection