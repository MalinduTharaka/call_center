<div>
    <div class="row">
        @if (Auth::user()->role == 'cro')
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">User Profile</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <caption>Order Count This Month</caption>
                            <table class="table table-bordered table-centered mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Boosting</th>
                                        <th>Designs</th>
                                        <th>Video</th>
                                        <th>Other</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $boosting_user->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentMonth())->count() }}
                                        </td>
                                        <td>{{ $designs_user->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentMonth())->count() }}
                                        </td>
                                        <td>{{ $video_user->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentMonth())->count() }}
                                        </td>
                                        <td>{{ $other_orders_user->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentMonth())->count() }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (Auth::user()->role == 'adv')
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="m-0">Advertiser Works</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-centered mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Today</th>
                                        <th>This Month</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{$addcount_today}}</td>
                                        <td>{{$addcount_month}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        <div class="col-7">
            <div class="card mb-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <caption>Payment This Year</caption>
                        <table class="table table-bordered table-centered mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Month</th>
                                    <th>Basic</th>
                                    <th>Allowance</th>
                                    <th>Bonus</th>
                                    <th>OT</th>
                                    <th>Transport</th>
                                    <th>Attendance Bonus</th>
                                    <th>Deduction</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($salaries as $salary)
                                    <tr>
                                        <td>{{ $salary->month }}</td>
                                        <td>{{ $salary->basic }}</td>
                                        <td>{{ $salary->allowance }}</td>
                                        <td>{{ $salary->bonus }}</td>
                                        <td>{{ $salary->ot }}</td>
                                        <td>{{ $salary->transport }}</td>
                                        <td>{{ $salary->attendace_bonus }}</td>
                                        <td>{{ $salary->deduction }}</td>
                                        <td>{{ $salary->net_salary }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-5">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">{{ now()->format('F Y') }} Attendance</h5>
                </div>
                <div class="card-body p-0">
                    <div class="px-3 py-2">
                        {{-- Calendar will render here --}}
                        <div id="attendanceCalendar"></div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .calendar {
                width: 100%;
                border-collapse: collapse;
                margin: 0;
            }

            .calendar th,
            .calendar td {
                border: 1px solid #ddd;
                width: 14.28%;
                height: 80px;
                /* shrink height to taste */
                padding: 4px;
                /* shrink padding */
                vertical-align: top;
                position: relative;
                font-size: 0.8rem;
                /* overall font size */
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

            /* in+out */
            .partial {
                background-color: #90ee90;
            }

            /* only in */
            .no-att {
                background-color: #fff3cd;
            }

            /* missed past */
            .time {
                display: block;
                font-size: 0.7rem;
                margin-top: 2px;
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // 1) Prepare a map: day → { arr, leave }
                const raw = @json($attendances);
                const map = {};
                raw.forEach(d => {
                    const day = new Date(d.date).getDate();
                    map[day] = { arr: d.arr_time, leave: d.leave_time };
                });

                // 2) Build & insert the calendar
                const container = document.getElementById('attendanceCalendar');
                container.innerHTML = buildCalendar(map, {{ now()->month }}, {{ now()->year }});

                // 3) Calendar builder
                function buildCalendar(map, month, year) {
                    const today = new Date();
                    const firstDay = new Date(year, month - 1, 1).getDay();
                    const daysInMon = new Date(year, month, 0).getDate();
                    let html = '<table class="calendar"><thead><tr>'
                        + ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
                            .map(d => `<th>${d}</th>`).join('')
                        + '</tr></thead><tbody><tr>';

                    // empty leading cells
                    for (let i = 0; i < firstDay; i++) html += '<td></td>';

                    // each day cell
                    for (let day = 1; day <= daysInMon; day++) {
                        const dateObj = new Date(year, month - 1, day);
                        const isFuture = dateObj > today;
                        const rec = map[day];
                        let cls = rec
                            ? (rec.arr && rec.leave ? 'full' : 'partial')
                            : (!isFuture ? 'no-att' : '');

                        html += `<td class="${cls}"><div class="day-number">${day}</div>`;
                        if (rec && rec.arr) html += `<span class="time">In: </br> ${rec.arr}</span>`;
                        if (rec && rec.leave) html += `<span class="time">Out:</br> ${rec.leave}</span>`;
                        html += '</td>';

                        // break row on Saturdays
                        if ((firstDay + day) % 7 === 0 && day !== daysInMon) html += '</tr><tr>';
                    }

                    html += '</tr></tbody></table>';
                    return html;
                }
            });
        </script>

    </div>
</div>