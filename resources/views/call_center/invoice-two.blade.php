@extends('layouts.app')
@section('content')
    <form method="POST" action="{{ route('order.store.two') }}">
        @csrf

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
            <input type="hidden" name="orders[{{ $counter }}][time]" value="{{ $order['time'] }}">
            <input type="hidden" name="orders[{{ $counter }}][amount]" value="{{ $order['amount'] }}">
            <input type="hidden" name="orders[{{ $counter }}][work_type]" value="{{ $order['work_type'] }}">
            @php $counter++; @endphp
        @endforeach

        <input type="text" name="contact" id="contact"
            value="{{ $boostingOrders[0]['contact'] ?? $designOrders[0]['contact'] ?? $videoOrders[0]['contact'] ?? '' }}"
            hidden>
        <input type="hidden" name="date" value="{{ \Carbon\Carbon::now()->toDateString() }}">
        <input type="text" name="name" id="name"
            value="{{ $boostingOrders[0]['name'] ?? $designOrders[0]['name'] ?? $videoOrders[0]['name'] ?? '' }}">
        <input type="text" name="inv" value="@if (!empty($boostingOrders))b @elseif (!empty($designOrders))d @else v @endif{{ $inv_id }}" hidden>
        <input type="hidden" name="inv_no" value="{{ $inv_id }}">
        <input type="hidden" name="total" id="total_due">
        <input type="hidden" name="type" value="{{ $type }}">

        <div class="container mx-auto p-4 bg-white shadow rounded border font-sans" style="max-width: 800px;">
            <!-- Header Section -->
            <div class="border-bottom pb-4 mb-4">
                <div class="row">
                    <!-- Left Column - Company Info -->
                    <div class="col-8">
                        <div class="d-flex align-items-center mb-3">
                            <!-- Determine if we need to show two companies -->
                            @php
                                $showTwoCompanies = count($videoOrders) > 0;
                            @endphp

                            <!-- First Company - Always show -->
                            <div class="{{ $showTwoCompanies ? 'col-6' : 'col-12' }} d-flex align-items-center">
                                <img src="{{ asset('logos/wishwaads.jpg')}}" alt="WISHWA ADS Logo" class="img-fluid mr-3"
                                    style="max-height: 80px; width: auto;">
                                <div>
                                    @if($showTwoCompanies)
                                        <h2 class="h5 font-weight-bold text-danger mb-0">WISHWA ADS</h2>
                                        <p class="text-muted mb-0 small">Your Marketing Partner</p>
                                    @else
                                        <h1 class="h4 font-weight-bold text-danger mb-0">WISHWA ADS</h1>
                                        <p class="lead text-muted mb-0" style="font-size: 1.1rem;">Your Marketing Partner</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Second Company - Only show if video orders exist -->
                            @if($showTwoCompanies)
                                <div class="col-6 d-flex align-items-center">
                                    <img src="{{ asset('logos/wishwavideo.jpg')}}" alt="Studio WISHWA Logo"
                                        class="img-fluid mr-3" style="max-height: 80px; width: auto;">
                                    <div>
                                        <h2 class="h5 font-weight-bold text-danger mb-0">STUDIO WISHWA</h2>
                                        <p class="text-muted mb-0 small">Feel The Quality Of Professionals</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Contact Info -->
                        <div class="pl-2">
                            <p class="small text-muted mb-1">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                No.151, Ward City Shopping Complex, Gampaha
                            </p>
                            <p class="small text-muted mb-1">
                                <i class="fas fa-phone mr-1"></i>
                                077 1855 1910
                            </p>
                            <p class="small text-muted mb-0">
                                <i class="fas fa-envelope mr-1"></i>
                                info.studiowishwa@gmail.com
                            </p>
                        </div>
                    </div>

                    <!-- Right Column - Invoice Info -->
                    <div class="col-4 text-right">
                        <div class="border-bottom pb-2 mb-2 border-primary">
                            <h2 class="h1 font-weight-bold text-uppercase text-muted mb-0">
                                @if ($type == 0)
                                    INVOICE
                                @elseif ($type == 1)
                                    QUOTATION
                                @else
                                    INVOICE
                                @endif
                            </h2>
                        </div>
                        <div class="pt-1">
                            <p class="mb-1 small">
                                <span class="font-weight-bold">ID #:</span>
                                @if(count($boostingOrders) > 0 && count($designOrders) > 0)
                                    bd
                                @elseif(count($boostingOrders) > 0 && count($videoOrders) > 0)
                                    bv
                                @elseif(count($designOrders) > 0 && count($videoOrders) > 0)
                                    dv
                                @endif{{ $inv_id }}
                            </p>
                            <p class="mb-0 small">
                                <span class="font-weight-bold">Date:</span> {{ now()->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer and Invoice Details -->
            <div class="pb-3 mb-3 d-flex justify-content-between">
                <div class="mb-3">
                    <h2 class="h5 font-weight-semibold text-secondary">Bill To:</h2>
                    <p class="text-dark">
                        {{ $boostingOrders[0]['name'] ?? $designOrders[0]['name'] ?? $videoOrders[0]['name'] ?? '' }}</p>
                    <p class="text-muted small">Phone:
                        {{ $boostingOrders[0]['contact'] ?? $designOrders[0]['contact'] ?? $videoOrders[0]['contact'] ?? '' }}
                    </p>
                </div>
                <div class="mb-3 text-right">
                    <p class="text-muted small mb-0">Invoice #:
                        @if(count($boostingOrders) > 0 && count($designOrders) > 0)
                            bd
                        @elseif(count($boostingOrders) > 0 && count($videoOrders) > 0)
                            bv
                        @elseif(count($designOrders) > 0 && count($videoOrders) > 0)
                            dv
                        @endif{{ $inv_id }}
                    </p>
                    <p class="text-muted small mb-0">Date: {{ now()->format('Y-m-d H:i:s') }}</p>
                </div>
            </div>

            <!-- Invoice Table -->
            <table class="table table-bordered mb-5">
                <thead class="thead-light">
                    <tr>
                        <th class="text-left">Item</th>
                        <th class="text-left">Description</th>
                        @if ($videoOrders)
                            <th>Time</th>
                        @endif
                        <th class="text-left">Price</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($boostingOrders as $order)
                        <tr>
                            <td class="border">Boosting</td>
                            @foreach ($work_types as $work_type)
                                @if ($work_type->id == $order['work_type'])
                                    <td class="border">{{ $work_type->name }}</td>
                                @endif
                            @endforeach
                            @if($videoOrders)
                                <td class="border">—</td>
                            @endif
                            <td class="border" data-price="{{ $order['package_amt'] }}">
                                {{ number_format($order['package_amt'], 2) }}
                            </td>
                            <td class="border text-right total">{{ number_format($order['package_amt'], 2) }}</td>
                        </tr>
                    @endforeach
                
                    @foreach($designOrders as $order)
                        <tr>
                            <td class="border">Design</td>
                            @foreach ($work_types as $work_type)
                                @if ($work_type->id == $order['work_type'])
                                    <td class="border">{{ $work_type->name }}</td>
                                @endif
                            @endforeach
                            @if($videoOrders)
                                <td class="border">—</td>
                            @endif
                            <td class="border" data-price="{{ $order['amount'] }}">
                                {{ number_format($order['amount'], 2) }}
                            </td>
                            <td class="border text-right total">{{ number_format($order['amount'], 2) }}</td>
                        </tr>
                    @endforeach
                
                    @foreach($videoOrders as $order)
                        <tr>
                            <td class="border">Video</td>
                            @foreach ($work_types as $work_type)
                                @if ($work_type->id == $order['work_type'])
                                    <td class="border">{{ $work_type->name }}</td>
                                @endif
                            @endforeach
                            @if($videoOrders)
                                <td class="border" data-time="{{ $order['time'] }}">{{ $order['time'] }}</td>
                            @endif
                            <td class="border" data-price="{{ $order['amount'] }}">
                                {{ number_format($order['amount'], 2) }}
                            </td>
                            <td class="border text-right total">{{ number_format($order['amount'], 2) }}</td>
                        </tr>
                    @endforeach
                
                    <!-- Totals -->
                    <tr>
                        <td colspan="{{ $videoOrders ? 4 : 3 }}" class="border text-right">Subtotal</td>
                        <td class="border text-right ab-total">0.00</td>
                    </tr>
                    <tr>
                        <td colspan="{{ $videoOrders ? 4 : 3 }}" class="border text-right">Tax</td>
                        <td class="border text-right" id="tax-amount">0.00</td>
                    </tr>
                    <tr>
                        <td colspan="{{ $videoOrders ? 4 : 3 }}" class="border text-right">Service</td>
                        <td class="border text-right" id="service-amount">0.00</td>
                    </tr>
                    <tr class="font-weight-bold">
                        <td colspan="{{ $videoOrders ? 4 : 3 }}" class="border text-right">Total Due</td>
                        <td class="border text-right">Rs.<span class="tt-due"></span></td>
                    </tr>
                </tbody>
                
            </table>

            <!-- Footer -->
            <div class="text-muted small border-top pt-3 mt-3">
                @if ($type == 0)
                    <p class="text-muted small">Payment is due within 30 days.</p>
                @elseif ($type == 1)
                    <p class="text-muted small">quotation is due within 30 days.</p>
                @else
                    <p class="text-muted small">Payment is due within 30 days.</p>
                @endif
            </div>
        </div>

        <div class="d-print-none mt-4">
            <div class="text-center">
                <button onclick="window.print()" class="btn btn-primary mr-2">
                    <i class="fas fa-print mr-1"></i> Print
                </button>
                <button type="submit" class="btn btn-info">Submit</button>
            </div>
        </div>
    </form>

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
            let totalTax = 0;
            let totalService = 0;

            // Calculate subtotal, tax and service
            document.querySelectorAll('[data-price]').forEach(priceCell => {
                subtotal += parseFloat(priceCell.dataset.price) || 0;
            });

            @foreach($boostingOrders as $order)
                totalTax += {{ $order['tax'] ?? 0 }};
                totalService += {{ $order['service'] ?? 0 }};
            @endforeach

            // Update displays
            document.querySelector('.ab-total').textContent = subtotal.toFixed(2);
            document.querySelector('#tax-amount').textContent = totalTax.toFixed(2);
            document.querySelector('#service-amount').textContent = totalService.toFixed(2);
            document.querySelector('.tt-due').textContent = (subtotal + totalTax + totalService).toFixed(2);
            document.getElementById("total_due").value = (subtotal + totalTax + totalService).toFixed(2);
        }

        document.addEventListener("DOMContentLoaded", updateInvoice);
    </script>
@endsection