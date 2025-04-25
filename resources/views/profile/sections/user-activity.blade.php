<div class="container">
    <div class="row">
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
                                    <td>{{ $boosting_user->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentMonth())->count() }}</td>
                                    <td>{{ $designs_user->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentMonth())->count() }}</td>
                                    <td>{{ $video_user->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentMonth())->count() }}</td>
                                    <td>{{ $other_orders_user->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentMonth())->count() }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

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
                                {{-- Yearly payment rows here --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-5">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">{{ __(Carbon\Carbon::now()->format('F Y')) }} Attendance</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <td>Mon</td>
                                    <td>Tue</td>
                                    <td>Wed</td>
                                    <td>Thu</td>
                                    <td>Fri</td>
                                    <td>Sat</td>
                                    <td>Sun</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
