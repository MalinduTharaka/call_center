<div class="card mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">Order Summary (Count Only)</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-centered mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Order Type</th>
                        <th>Today Count</th>
                        <th>This Month Count</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Boosting</td>
                        <td>{{ $boosting->where('created_at', '>=', \Carbon\Carbon::today())->count() }}</td>
                        <td>{{ $boosting->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentMonth())->count() }}</td>
                    </tr>
                    <tr>
                        <td>Designs</td>
                        <td>{{ $designs->where('created_at', '>=', \Carbon\Carbon::today())->count() }}</td>
                        <td>{{ $designs->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentMonth())->count() }}</td>
                    </tr>
                    <tr>
                        <td>Video</td>
                        <td>{{ $video->where('created_at', '>=', \Carbon\Carbon::today())->count() }}</td>
                        <td>{{ $video->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentMonth())->count() }}</td>
                    </tr>
                    <tr>
                        <td>Other</td>
                        <td>{{ $other_orders->where('created_at', '>=', \Carbon\Carbon::today())->count() }}</td>
                        <td>{{ $other_orders->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentMonth())->count() }}</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td>Total</td>
                        <td>
                            {{
                                $boosting->where('created_at', '>=', \Carbon\Carbon::today())->count() +
                                $designs->where('created_at', '>=', \Carbon\Carbon::today())->count() +
                                $video->where('created_at', '>=', \Carbon\Carbon::today())->count() +
                                $other_orders->where('created_at', '>=', \Carbon\Carbon::today())->count()
                            }}
                        </td>
                        <td>
                            {{
                                $boosting->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentMonth())->count() +
                                $designs->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentMonth())->count() +
                                $video->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentMonth())->count() +
                                $other_orders->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentMonth())->count()
                            }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
