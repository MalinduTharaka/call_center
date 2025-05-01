@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 bg-white shadow rounded border font-sans" style="max-width: 800px;">
        <!-- Header Section -->
        <div class="border-bottom pb-4 mb-4">
            <div class="row">
                <div class="col-md-8">
                    @php
                        $hasVideo = $orders->contains('order_type', 'video');
                        $hasOther = $orders->contains(function ($order) {
                            return $order->type !== 'video';
                        });
                    @endphp

                    <div class="row align-items-center">
                        <div class="col-sm-6 mb-2 sm-0">
                            @if (!$hasVideo && $hasOther)
                                {{-- Only non-video orders: show 1st image --}}
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('logos/WishwaAds.png') }}" alt="Wishwa Ads Logo" class="print-logo"
                                        style="max-height: 80px; width: 400px;">
                                </div>
                            @elseif ($hasVideo && !$hasOther)
                                {{-- Only video orders: show 2nd image --}}
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('logos/Studio.png') }}" alt="Studio Logo" class="print-logo"
                                        style="max-height: 80px; width: 400px;">
                                </div>
                            @elseif ($hasVideo && $hasOther)
                                {{-- Both video and other types: show 3rd image --}}
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('logos/WishwaAdsStudio.png') }}" alt="Wishwa Ads Studio Logo" class="print-logo"
                                        style="max-height: 80px; width: 400px;">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-2">
                        <p class="mb-1 small text-muted">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            No.151, Ward City Shopping Complex, Gampaha
                        </p>
                        <p class="mb-1 small text-muted">
                            <i class="fas fa-phone mr-1"></i>
                            077 1855 191
                        </p>
                        <p class="mb-1 small text-muted">
                            <i class="fas fa-envelope mr-1"></i>
                            info@wishwaads.com
                        </p>
                    </div>

                </div>
                <div class="col-md-4 mt-2 mt-md-0">
                    <div class="border-bottom pb-2 mb-2 border-primary">
                        <h1 class="h3 font-weight-bold text-uppercase text-dark mb-0">INVOICE</h1>
                    </div>
                    <div class="text-md-right">
                        <dl class="row mb-0">
                            <dt class="col-sm-6 text-md-right small">ID #:</dt>
                            <dd class="col-sm-6 text-md-left small">{{ $orders->first()->invoice ?? 'N/A' }}</dd>
                            <dt class="col-sm-6 text-md-right small">Date:</dt>
                            <dd class="col-sm-6 text-md-left small">{{ $orders->first()->date ?? now()->format('Y-m-d') }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Details -->
        <div class="pb-3 mb-2 d-flex justify-content-between">
            <div class="mb-3">
                <h2 class="h5 font-weight-semibold text-secondary">Bill To:</h2>
                <p class="text-dark">{{ $orders->first()->name ?? 'N/A' }}</p>
                <p class="text-muted small">Phone: {{ $orders->first()->contact ?? 'N/A' }}</p>
            </div>
            <div class="mb-3 text-right">
                <p class="text-muted small mb-0">ID #: {{ $orders->first()->invoice ?? 'N/A' }}</p>
                <p class="text-muted small mb-0">Date:
                    {{ $orders->first()->date->format('Y-m-d') ?? now()->format('Y-m-d') }}
                </p>
            </div>
        </div>

        @php
            // Group truly identical orders (same work_type, order_type, unit_price, video_time) and count them.
            $groupedOrders = $orders
                ->groupBy(function ($item) {
                    return implode('|', [
                        $item->work_type_id,
                        $item->order_type,
                        $item->package_amt ?? $item->amount,
                        $item->order_type === 'video' ? $item->video_time : ''
                    ]);
                })
                ->map(function ($group) {
                    $first = $group->first();
                    return (object) [
                        'work_type_id' => $first->work_type_id,
                        'order_type' => $first->order_type,
                        'unit_price' => $first->package_amt ?? $first->amount,
                        'count' => $group->count(),
                        'tax' => $group->sum('tax'),
                        'service' => $group->sum('service'),
                        'time' => $first->video_time ?? null,
                    ];
                });

            $totalTax = $groupedOrders->sum('tax');
            $totalService = $groupedOrders->sum('service');
            $hasVideo = $groupedOrders->contains('order_type', 'video');
            $colSpan = $hasVideo ? 5 : 4;
        @endphp

        <!-- Invoice Table -->
        <table class="table table-bordered mb-2">
            <thead class="thead-light">
                <tr>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Count</th>
                    @if($hasVideo)
                    <th>Time</th>@endif
                    <th>Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($groupedOrders as $item)
                    <tr>
                        <td>{{ ucfirst($item->order_type) }}</td>
                        <td>
                            @foreach ($work_types as $wt)
                                @if ($wt->id == $item->work_type_id) {{ $wt->name }} @endif
                            @endforeach
                        </td>
                        <td>{{ $item->count }}</td>
                        @if($hasVideo)
                        <td>{{ $item->time ?? '—' }}</td>@endif
                        <td data-price="{{ $item->unit_price * $item->count }}">
                            {{ number_format($item->unit_price, 2) }}
                        </td>
                        <td class="text-right total">
                            {{ number_format($item->unit_price * $item->count, 2) }}
                        </td>
                    </tr>
                @endforeach

                <!-- Subtotal -->
                <tr>
                    <td colspan="{{ $colSpan }}" class="border text-right">Subtotal</td>
                    <td class="border text-right ab-total">0.00</td>
                </tr>

                @if($totalTax > 0)
                    <tr>
                        <td colspan="{{ $colSpan }}" class="border text-right">Tax</td>
                        <td class="border text-right" id="tax-amount">
                            {{ number_format($totalTax, 2) }}
                        </td>
                    </tr>
                @endif

                @if($totalService > 0)
                    <tr>
                        <td colspan="{{ $colSpan }}" class="border text-right">Service</td>
                        <td class="border text-right" id="service-amount">
                            {{ number_format($totalService, 2) }}
                        </td>
                    </tr>
                @endif

                <tr class="font-weight-bold">
                    <td colspan="{{ $colSpan }}" class="border text-right">Total Due</td>
                    <td class="border text-right">Rs.<span class="tt-due"></span></td>
                </tr>
            </tbody>
        </table>

        <!-- Footer -->
        <div class="text-muted small border-top pt-3 mt-2">
            <p>Payment is due within 30 days of receipt.</p>
        </div>
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p>Commercial Bank<br>
                        ACCOUNT NUMBER - 1000620243<br>
                        NAME - WISHWA ADS TEAM<br>
                        COMMERCIAL BANK<br>
                        GANEMULLA BRANCH</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p>BOC<br>
                        ACCOUNT NUMBER - 1425126<br>
                        NAME - W C C WISHWAJITH<br>
                        Bank of Ceylon ( BOC )<br>
                        GAMPAHA BRANCH</p>
                </td>
            </tr>
        </table>


    </div>
    <!-- Print Button -->
    <div class="d-print-none mt-2 text-center">
        <button onclick="window.print()" class="btn btn-primary mr-2">
            <i class="fas fa-print mr-1"></i> Print
        </button>
    </div>

    <!-- Print-specific CSS -->
    <style>
        @media print {
            body {
                padding: 5mm !important;
                margin: 0 !important;
                font-size: 12pt;
                background: white !important;
                color: black !important;
            }
            .col-sm-6, 
    .col-md-8 {
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }

    /* Ensure the image itself stretches */
    .print-logo {
        width: 100% !important;
        height: auto !important;
        max-height: none !important;
        display: block;
    }

            .header-logo img {
                width: 100% !important;
                max-height: none !important;
                height: auto !important;
            }

            .container {
                width: 100% !important;
                max-width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
                box-shadow: none !important;
                border: none !important;
            }

            .text-muted,
            .text-secondary {
                color: #555 !important;
            }

            .table {
                width: 100% !important;
                font-size: 10pt !important;
                border-collapse: collapse !important;
            }

            .table th,
            .table td {
                padding: 6px !important;
                border: 1px solid #ddd !important;
            }

            .table thead th {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .d-print-none {
                display: none !important;
            }

            .row,
            .d-flex {
                page-break-inside: avoid;
            }

            @page {
                size: auto;
                margin: 5mm;
            }
        }
    </style>

    <!-- JavaScript -->
    <script>
        document.addEventListener("DOMContentLoaded", updateInvoice);

        function updateInvoice() {
            let subtotal = 0;
            document.querySelectorAll('[data-price]').forEach(cell => {
                subtotal += parseFloat(cell.dataset.price) || 0;
            });
            const tax = {{ $totalTax }};
            const service = {{ $totalService }};
            document.querySelector('.ab-total').textContent = subtotal.toFixed(2);
            document.querySelector('.tt-due').textContent = (subtotal + tax + service).toFixed(2);
        }
    </script>
@endsection