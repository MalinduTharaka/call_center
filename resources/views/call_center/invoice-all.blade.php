@extends('layouts.app')
@section('content')
    <!-- start page title -->
    <form method="POST" action="{{ route('order.store.all') }}">
        @csrf

        <!-- Hidden Inputs -->
        @php $counter = 0; @endphp

        @foreach($boostingOrders as $order)
            <input type="hidden" name="orders[{{ $counter }}][order_type]" value="{{ $order['order_type'] }}">
            <input type="hidden" name="orders[{{ $counter }}][package_amt]" value="{{ $order['package_amt'] }}">
            <input type="hidden" name="orders[{{ $counter }}][tax]" value="{{ $order['tax'] }}">
            <input type="hidden" name="orders[{{ $counter }}][service]" value="{{ $order['service'] }}">
            <input type="hidden" name="orders[{{ $counter }}][work_type]" value="{{ $order['work_type'] }}">
            @php $counter++; @endphp
        @endforeach

        @foreach($designOrders as $order)
            <input type="hidden" name="orders[{{ $counter }}][order_type]" value="{{ $order['order_type'] }}">
            <input type="hidden" name="orders[{{ $counter }}][amount]" value="{{ $order['amount'] }}">
            <input type="hidden" name="orders[{{ $counter }}][work_type]" value="{{ $order['work_type'] }}">
            @php $counter++; @endphp
        @endforeach

        @foreach($videoOrders as $order)
            <input type="hidden" name="orders[{{ $counter }}][order_type]" value="{{ $order['order_type'] }}">
            <input type="hidden" name="orders[{{ $counter }}][amount]" value="{{ $order['amount'] }}">
            <input type="hidden" name="orders[{{ $counter }}][time]" value="{{ $order['time'] }}">
            <input type="hidden" name="orders[{{ $counter }}][work_type]" value="{{ $order['work_type'] }}">
            @php $counter++; @endphp
        @endforeach


        <input type="hidden" name="name"
            value="{{ $boostingOrders[0]['name'] ?? $designOrders[0]['name'] ?? $videoOrders[0]['name'] ?? '' }}">
        <input type="hidden" name="contact"
            value="{{ $boostingOrders[0]['contact'] ?? $designOrders[0]['contact'] ?? $videoOrders[0]['contact'] ?? '' }}">
        <input type="hidden" name="date" value="{{ \Carbon\Carbon::now()->toDateString() }}">
        <input type="hidden" name="inv" value="bdv{{ $inv_id }}">
        <input type="hidden" name="inv_no" value="{{ $inv_id }}">
        <input type="hidden" name="total" id="total_due">

        @php
            $totalTax = collect($boostingOrders)->sum('tax');
            $totalService = collect($boostingOrders)->sum('service');
        @endphp

        <div class="container mx-auto p-4 bg-white shadow rounded border font-sans" style="max-width: 800px;">
            <!-- Header Section -->
            <div class="border-bottom pb-4 mb-4">
                <div class="row">
                    <!-- Company Info -->
                    <div class="col-md-8">
                        <div class="row align-items-center">
                            <!-- First Company -->
                            <div class="col-sm-6 mb-4 mb-sm-0">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('logos/wishwaads.jpg') }}" alt="Wishwa Ads Logo"
                                        class="img-fluid mr-3" style="max-height: 80px; width: auto;">
                                    <div>
                                        <h2 class="h5 font-weight-bold text-danger mb-0">WISHWA ADS</h2>
                                        <p class="text-muted mb-0 small">Your Marketing Partner</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Second Company -->
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('logos/wishwavideo.jpg') }}" alt="Studio Wishwa Logo"
                                        class="img-fluid mr-3" style="max-height: 80px; width: auto;">
                                    <div>
                                        <h2 class="h5 font-weight-bold text-danger mb-0">STUDIO WISHWA</h2>
                                        <p class="text-muted mb-0 small">Feel The Quality Of Professionals</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Info -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="d-flex flex-wrap">
                                    <p class="mb-1 small text-muted mr-3">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        No.151, Ward City Shopping Complex, Gampaha
                                    </p>
                                    <p class="mb-1 small text-muted mr-3">
                                        <i class="fas fa-phone mr-1"></i>
                                        077 1855 1910
                                    </p>
                                    <p class="mb-1 small text-muted">
                                        <i class="fas fa-envelope mr-1"></i>
                                        info.studiowishwa@gmail.com
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Invoice Info -->
                    <div class="col-md-4 mt-4 mt-md-0">
                        <div class="border-bottom pb-2 mb-2 border-primary">
                            <h1 class="h3 font-weight-bold text-uppercase text-dark mb-0">INVOICE</h1>
                        </div>
                        <div class="text-md-right">
                            <dl class="row mb-0">
                                <dt class="col-sm-6 text-md-right small">Invoice #:</dt>
                                <dd class="col-sm-6 text-md-left small">bdv{{ $inv_id }}</dd>

                                <dt class="col-sm-6 text-md-right small">Date:</dt>
                                <dd class="col-sm-6 text-md-left small">{{ now()->format('Y-m-d H:i:s') }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Details -->
            <div class="pb-3 mb-3 d-flex justify-content-between">
                <div class="mb-3">
                    <h2 class="h5 font-weight-semibold text-secondary">Bill To:</h2>
                    <p class="text-dark">
                        {{ $boostingOrders[0]['name'] ?? $designOrders[0]['name'] ?? $videoOrders[0]['name'] ?? '' }}
                    </p>
                    <p class="text-muted small">Phone:
                        {{ $boostingOrders[0]['contact'] ?? $designOrders[0]['contact'] ?? $videoOrders[0]['contact'] ?? '' }}
                    </p>
                </div>
                <div class="mb-3 text-right">
                    <p class="text-muted small mb-0">Invoice #: bdv{{ $inv_id }}</p>
                    <p class="text-muted small mb-0">Date: {{ now()->format('Y-m-d H:i:s') }}</p>
                </div>
            </div>

            @php
                // Group and count similar orders
                $boostGroups = collect($boostingOrders)
                    ->groupBy(fn($o) => $o['work_type'] . '|' . $o['package_amt'])
                    ->map(fn($grp) => (object) [
                        'work_type' => $grp[0]['work_type'],
                        'unit_price' => $grp[0]['package_amt'],
                        'tax' => $grp->sum('tax'),
                        'service' => $grp->sum('service'),
                        'count' => $grp->count(),
                    ]);

                $designGroups = collect($designOrders)
                    ->groupBy(fn($o) => $o['work_type'] . '|' . $o['amount'])
                    ->map(fn($grp) => (object) [
                        'work_type' => $grp[0]['work_type'],
                        'unit_price' => $grp[0]['amount'],
                        'count' => $grp->count(),
                    ]);

                $videoGroups = collect($videoOrders)
                    ->groupBy(fn($o) => $o['work_type'] . '|' . $o['amount'] . '|' . $o['time'])
                    ->map(fn($grp) => (object) [
                        'work_type' => $grp[0]['work_type'],
                        'unit_price' => $grp[0]['amount'],
                        'time' => $grp[0]['time'],
                        'count' => $grp->count(),
                    ]);

                $totalTax = $boostGroups->sum('tax');
                $totalService = $boostGroups->sum('service');
            @endphp

            <div class="container mx-auto p-4 bg-white shadow rounded border font-sans" style="max-width: 800px;">
                <!-- HEADER OMITTED FOR BREVITY - keep your current header section -->

                <!-- Invoice Table -->
                <table class="table table-bordered mb-5">
                    <thead class="thead-light">
                        <tr>
                            <th>Item</th>
                            <th>Description</th>
                            <th>Count</th>
                            @if ($videoGroups->isNotEmpty())
                            <th>Time</th> @endif
                            <th>Price</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($boostGroups as $item)
                            <tr>
                                <td>Boosting</td>
                                @foreach ($work_types as $work_type)
                                    @if ($work_type->id == $item->work_type)
                                        <td class="border">{{ $work_type->name }}</td>
                                    @endif
                                @endforeach
                                <td>{{ $item->count }}</td>
                                @if ($videoGroups->isNotEmpty())
                                <td>—</td> @endif
                                <td data-price="{{ $item->unit_price * $item->count }}">
                                    {{ number_format($item->unit_price, 2) }}
                                </td>
                                <td class="text-right total">
                                    {{ number_format($item->unit_price * $item->count, 2) }}
                                </td>
                            </tr>
                        @endforeach

                        @foreach($designGroups as $item)
                            <tr>
                                <td>Design</td>
                                @foreach ($work_types as $work_type)
                                    @if ($work_type->id == $item->work_type)
                                        <td class="border">{{ $work_type->name }}</td>
                                    @endif
                                @endforeach
                                <td>{{ $item->count }}</td>
                                @if ($videoGroups->isNotEmpty())
                                <td>—</td> @endif
                                <td data-price="{{ $item->unit_price * $item->count }}">
                                    {{ number_format($item->unit_price, 2) }}
                                </td>
                                <td class="text-right total">
                                    {{ number_format($item->unit_price * $item->count, 2) }}
                                </td>
                            </tr>
                        @endforeach

                        @foreach($videoGroups as $item)
                            <tr>
                                <td>Video</td>
                                @foreach ($work_types as $work_type)
                                    @if ($work_type->id == $item->work_type)
                                        <td class="border">{{ $work_type->name }}</td>
                                    @endif
                                @endforeach
                                <td>{{ $item->count }}</td>
                                <td data-time="{{ $item->time }}">{{ $item->time }}</td>
                                <td data-price="{{ $item->unit_price * $item->count }}">
                                    {{ number_format($item->unit_price, 2) }}
                                </td>
                                <td class="text-right total">
                                    {{ number_format($item->unit_price * $item->count, 2) }}
                                </td>
                            </tr>
                        @endforeach

                        <!-- Totals -->
                        <tr>
                            <td colspan="{{ $videoGroups->isNotEmpty() ? 5 : 4 }}" class="border text-right">Subtotal</td>
                            <td class="border text-right ab-total">0.00</td>
                        </tr>

                        @if($boostGroups->isNotEmpty())
                            <tr>
                                <td colspan="{{ $videoGroups->isNotEmpty() ? 5 : 4 }}" class="border text-right">Tax</td>
                                <td class="border text-right" id="tax-amount">
                                    {{ number_format($totalTax, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="{{ $videoGroups->isNotEmpty() ? 5 : 4 }}" class="border text-right">Service</td>
                                <td class="border text-right" id="service-amount">
                                    {{ number_format($totalService, 2) }}
                                </td>
                            </tr>
                        @endif

                        <tr class="font-weight-bold">
                            <td colspan="{{ $videoGroups->isNotEmpty() ? 5 : 4 }}" class="border text-right">Total Due</td>
                            <td class="border text-right">Rs.<span class="tt-due"></span></td>
                        </tr>
                    </tbody>
                </table>

                <div class="text-muted small border-top pt-3 mt-3">
                    <p>Payment is due within 30 days of receipt.</p>
                </div>
            </div>

            <div class="d-print-none mt-4 text-center">
                
                <button type="submit" class="btn btn-info">Submit</button>
    </form>
    <button onclick="window.print()" class="btn btn-primary mr-2">
        <i class="fas fa-print mr-1"></i> Print
    </button>
            </div>
    

    <style>
        @media print {
            .table thead th {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .table-bordered th,
            .table-bordered td {
                border: 1px solid #dee2e6 !important;
            }

            .d-print-none {
                display: none !important;
            }

            body {
                padding: 20px;
            }
        }
    </style>

    <script>
        function updateInvoice() {
            let subtotal = 0;

            document.querySelectorAll('[data-price]').forEach(priceCell => {
                subtotal += parseFloat(priceCell.dataset.price) || 0;
            });

            const tax = {{ $totalTax }};
            const service = {{ $totalService }};

            document.querySelector('.ab-total').textContent = subtotal.toFixed(2);
            document.querySelector('.tt-due').textContent = (subtotal + tax + service).toFixed(2);
            document.getElementById("total_due").value = (subtotal + tax + service).toFixed(2);
        }

        document.addEventListener("DOMContentLoaded", updateInvoice);
    </script>
@endsection