<div class="card mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">Order Summary (Income &amp; Count)</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-centered mb-0">
                <thead class="bg-light">
                    <tr>
                        <th rowspan="2" class="align-middle">Order Type</th>
                        <th colspan="2" class="text-center">Today</th>
                        <th colspan="2" class="text-center">This Month</th>
                        <th colspan="2" class="text-center">This Year</th>
                        <th colspan="2" class="text-center">All Time</th>
                    </tr>
                    <tr>
                        <th>Count</th> <th>Income</th>
                        <th>Count</th> <th>Income</th>
                        <th>Count</th> <th>Income</th>
                        <th>Count</th> <th>Income</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Boosting</td>
                        <td>{{ $boosting->where('created_at', '>=', \Carbon\Carbon::today())->count() }}</td> <td>{{ number_format($boostingSummary['today'], 2) }}</td>
                        <td>{{ $boosting->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentMonth())->count() }}</td> <td>{{ number_format($boostingSummary['this_month'], 2) }}</td>
                        <td>{{ $boosting->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentYear())->count() }}</td> <td>{{ number_format($boostingSummary['this_year'], 2) }}</td>
                        <td>{{ count($boosting) }}</td> <td>{{ number_format($boostingSummary['all'], 2) }}</td>
                    </tr>
                    <tr>
                        <td>Designs</td>
                        <td>{{ $designs->where('created_at', '>=', \Carbon\Carbon::today())->count() }}</td> <td>{{ number_format($designsSummary['today'], 2) }}</td>
                        <td>{{ $designs->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentMonth())->count() }}</td> <td>{{ number_format($designsSummary['this_month'], 2) }}</td>
                        <td>{{ $designs->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentYear())->count() }}</td> <td>{{ number_format($designsSummary['this_year'], 2) }}</td>
                        <td>{{ count($designs) }}</td> <td>{{ number_format($designsSummary['all'], 2) }}</td>
                    </tr>
                    <tr>
                        <td>Video</td>
                        <td>{{ $video->where('created_at', '>=', \Carbon\Carbon::today())->count() }}</td> <td>{{ number_format($videoSummary['today'], 2) }}</td>
                        <td>{{ $video->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentMonth())->count() }}</td> <td>{{ number_format($videoSummary['this_month'], 2) }}</td>
                        <td>{{ $video->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentYear())->count() }}</td> <td>{{ number_format($videoSummary['this_year'], 2) }}</td>
                        <td>{{ count($video) }}</td> <td>{{ number_format($videoSummary['all'], 2) }}</td>
                    </tr>
                    <tr>
                        <td>Other</td>
                        <td>{{ $other_orders->where('created_at', '>=', \Carbon\Carbon::today())->count() }}</td> <td>{{ number_format($otherSummary['today'], 2) }}</td>
                        <td>{{ $other_orders->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentMonth())->count() }}</td> <td>{{ number_format($otherSummary['this_month'], 2) }}</td>
                        <td>{{ $other_orders->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentYear())->count() }}</td> <td>{{ number_format($otherSummary['this_year'], 2) }}</td>
                        <td>{{ count($other_orders) }}</td> <td>{{ number_format($otherSummary['all'], 2) }}</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td>Total</td>
                        <td>{{ 
                            $boosting->where('created_at', '>=', \Carbon\Carbon::today())->count() +
                            $designs->where('created_at', '>=', \Carbon\Carbon::today())->count() +
                            $video->where('created_at', '>=', \Carbon\Carbon::today())->count() +
                            $other_orders->where('created_at', '>=', \Carbon\Carbon::today())->count() 
                        }}</td>
                        <td>{{ number_format($boostingSummary['today'] + $designsSummary['today'] + $videoSummary['today'] + $otherSummary['today'], 2) }}</td>
                    
                        <td>{{ 
                            $boosting->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentMonth())->count() +
                            $designs->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentMonth())->count() +
                            $video->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentMonth())->count() +
                            $other_orders->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentMonth())->count()
                        }}</td>
                        <td>{{ number_format($boostingSummary['this_month'] + $designsSummary['this_month'] + $videoSummary['this_month'] + $otherSummary['this_month'], 2) }}</td>
                    
                        <td>{{ 
                            $boosting->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentYear())->count() +
                            $designs->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentYear())->count() +
                            $video->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentYear())->count() +
                            $other_orders->filter(fn($order) => \Carbon\Carbon::parse($order->created_at)->isCurrentYear())->count()
                        }}</td>
                        <td>{{ number_format($boostingSummary['this_year'] + $designsSummary['this_year'] + $videoSummary['this_year'] + $otherSummary['this_year'], 2) }}</td>
                    
                        <td>{{ 
                            count($boosting) + count($designs) + count($video) + count($other_orders) 
                        }}</td>
                        <td>{{ number_format($boostingSummary['all'] + $designsSummary['all'] + $videoSummary['all'] + $otherSummary['all'], 2) }}</td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>