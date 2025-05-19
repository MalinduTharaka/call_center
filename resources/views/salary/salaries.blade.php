{{-- resources/views/salaries/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">

            <ul class="nav nav-tabs nav-justified nav-bordered mb-3" role="tablist">
                <li class="nav-item">
                    <a href="#this-month" data-bs-toggle="tab" class="nav-link active">Previous Month</a>
                </li>
                <li class="nav-item">
                    <a href="#selected-month" data-bs-toggle="tab" class="nav-link">Selected Month</a>
                </li>
            </ul>

            <div class="tab-content">
                {{-- THIS MONTH TAB --}}
                <div class="tab-pane active show" id="this-month">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Month</th>
                                    <th>Basic</th>
                                    <th>Allowance</th>
                                    <th>Bonus</th>
                                    <th>OT</th>
                                    <th>Transport</th>
                                    <th>Attendance Bonus</th>
                                    <th>Deduction</th>
                                    <th>Net Salary</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salariesTM as $sal)
                                    <tr>
                                        <td>{{ $sal->user->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($sal->month)->format('F Y') }}</td>
                                        <td>{{ $sal->basic }}</td>
                                        <td>{{ $sal->allowance }}</td>
                                        <td>{{ $sal->bonus }}</td>
                                        <td>{{ $sal->ot }}</td>
                                        <td>{{ $sal->transport }}</td>
                                        <td>{{ $sal->attendace_bonus }}</td>
                                        <td>{{ $sal->deduction }}</td>
                                        <td>{{ $sal->net_salary }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#salaryeditModal-{{ $sal->id }}">
                                                Edit Salary
                                            </button>
                                        </td>
                                    </tr>

                                    {{-- Edit Modal for this salary record --}}
                                    <div class="modal fade" id="salaryeditModal-{{ $sal->id }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="salaryeditLabel-{{ $sal->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="salaryeditLabel-{{ $sal->id }}">
                                                        Edit Salary – {{ $sal->user->name }}
                                                        ({{ \Carbon\Carbon::parse($sal->month)->format('F Y') }})
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="/salary/edit/{{ $sal->id }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="name-{{ $sal->id }}" class="form-label">Employee
                                                                Name</label>
                                                            <input type="text" class="form-control" id="name-{{ $sal->id }}"
                                                                value="{{ $sal->user->name }}" readonly>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="basic-{{ $sal->id }}" class="form-label">Basic</label>
                                                            <input type="text" class="form-control" id="basic-{{ $sal->id }}"
                                                                name="basic" value="{{ $sal->basic }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="allowance-{{ $sal->id }}"
                                                                class="form-label">Allowance</label>
                                                            <input type="text" class="form-control"
                                                                id="allowance-{{ $sal->id }}" name="allowance"
                                                                value="{{ $sal->allowance }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="bonus-{{ $sal->id }}" class="form-label">Bonus</label>
                                                            <input type="text" class="form-control" id="bonus-{{ $sal->id }}"
                                                                name="bonus" value="{{ $sal->bonus }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="ot-{{ $sal->id }}" class="form-label">OT</label>
                                                            <input type="text" class="form-control" id="ot-{{ $sal->id }}"
                                                                name="ot" value="{{ $sal->ot }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="transport-{{ $sal->id }}"
                                                                class="form-label">Transport</label>
                                                            <input type="text" class="form-control"
                                                                id="transport-{{ $sal->id }}" name="transport"
                                                                value="{{ $sal->transport }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="attendace_bonus-{{ $sal->attendace_bonus }}"
                                                                class="form-label">Attendace Bonus</label>
                                                            <input type="text" class="form-control"
                                                                id="attendace_bonus-{{ $sal->attendace_bonus }}"
                                                                name="attendace_bonus" value="{{ $sal->attendace_bonus }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="deduction-{{ $sal->id }}"
                                                                class="form-label">Deduction</label>
                                                            <input type="text" class="form-control"
                                                                id="deduction-{{ $sal->id }}" name="deduction"
                                                                value="{{ $sal->deduction }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="net_salary-{{ $sal->id }}" class="form-label">Net
                                                                Salary</label>
                                                            <input type="text" class="form-control"
                                                                id="net_salary-{{ $sal->id }}" name="net_salary"
                                                                value="{{ $sal->net_salary }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- SELECTED MONTH TAB --}}
                <div class="tab-pane" id="selected-month">
                    <div class="row g-3 align-items-end mb-4">
                        <div class="col-md-4">
                            <label for="selMonth" class="form-label">Month</label>
                            <select id="selMonth" class="form-select">
                                @for($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="selYear" class="form-label">Year</label>
                            <select id="selYear" class="form-select">
                                @php $current = now()->year; @endphp
                                @for($y = $current; $y >= $current - 5; $y--)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button id="fetchBtn" class="btn btn-primary w-100">Fetch Salaries</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="selectedMonthTable" class="table table-bordered mb-0" style="display:none;">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Month</th>
                                    <th>Basic</th>
                                    <th>Allowance</th>
                                    <th>Bonus</th>
                                    <th>OT</th>
                                    <th>Transport</th>
                                    <th>Attendance Bonus</th>
                                    <th>Deduction</th>
                                    <th>Net Salary</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Axios CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        document.getElementById('fetchBtn').addEventListener('click', () => {
            const mo = document.getElementById('selMonth').value;
            const yr = document.getElementById('selYear').value;
            const table = document.getElementById('selectedMonthTable');
            const tbody = table.querySelector('tbody');
            tbody.innerHTML = '';

            axios.get(`/salaries/selected-month/${mo}/${yr}`)
                .then(({ data }) => {
                    if (!data.length) {
                        tbody.innerHTML = '<tr><td colspan="9" class="text-center">No records found.</td></tr>';
                    } else {
                        data.forEach(s => {
                            const pretty = new Date(s.month)
                                .toLocaleString('default', { month: 'long', year: 'numeric' });
                            tbody.insertAdjacentHTML('beforeend', `
                                  <tr>
                                    <td>${s.user.name}</td>
                                    <td>${pretty}</td>
                                    <td>${s.basic}</td>
                                    <td>${s.allowance}</td>
                                    <td>${s.bonus}</td>
                                    <td>${s.ot}</td>
                                    <td>${s.transport}</td>
                                    <td>${s.attendace_bonus}</td>
                                    <td>${s.deduction}</td>
                                    <td>${s.net_salary}</td>
                                  </tr>
                                `);
                        });
                    }
                    table.style.display = 'table';
                })
                .catch(err => {
                    console.error(err);
                    alert('Failed to fetch salaries. Check console for details.');
                });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function calculateNetSalary(modal) {
                const basic = parseFloat(modal.querySelector('[id^="basic-"]')?.value || 0);
                const allowance = parseFloat(modal.querySelector('[id^="allowance-"]')?.value || 0);
                const bonus = parseFloat(modal.querySelector('[id^="bonus-"]')?.value || 0);
                const ot = parseFloat(modal.querySelector('[id^="ot-"]')?.value || 0);
                const transport = parseFloat(modal.querySelector('[id^="transport-"]')?.value || 0);
                const attendace_bonus = parseFloat(modal.querySelector('[id^="attendace_bonus-"]')?.value || 0);
                const deduction = parseFloat(modal.querySelector('[id^="deduction-"]')?.value || 0);

                const net = basic + allowance + bonus + ot + transport + attendace_bonus - deduction;
                modal.querySelector('[id^="net_salary-"]').value = net.toFixed(2);
            }

            document.querySelectorAll('.modal').forEach(modal => {
                const fields = modal.querySelectorAll('[id^="basic-"], [id^="allowance-"], [id^="bonus-"], [id^="ot-"], [id^="transport-"], [id^="attendace_bonus-"], [id^="deduction-"]');
                fields.forEach(field => {
                    field.addEventListener('input', () => calculateNetSalary(modal));
                });
            });
        });
    </script>
@endsection