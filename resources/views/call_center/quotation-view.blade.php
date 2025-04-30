@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 bg-white shadow rounded border font-sans" style="max-width: 800px;">
    <!-- Header Section - Original Structure Preserved -->
    <div class="border-bottom pb-4 mb-4">
        <div class="row">
            <!-- Company Info - Original Layout -->
            <div class="col-md-8">
                <div class="row align-items-center">
                    <!-- First Company - Original Position -->
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
                    <!-- Second Company - Original Position -->
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
                <!-- Contact Info - Original Position -->
                <div class="mt-3">
                    <p class="mb-1 small text-muted">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        No.151, Ward City Shopping Complex, Gampaha
                    </p>
                    <p class="mb-1 small text-muted">
                        <i class="fas fa-phone mr-1"></i>
                        077 1855 1910
                    </p>
                    <p class="mb-1 small text-muted">
                        <i class="fas fa-envelope mr-1"></i>
                        info.studiowishwa@gmail.com
                    </p>
                </div>
            </div>

            <!-- Invoice Info - Original Position -->
            <div class="col-md-4 mt-4 mt-md-0">
                <div class="border-bottom pb-2 mb-2 border-primary">
                    <h1 class="h3 font-weight-bold text-uppercase text-dark mb-0">QUOTATION</h1>
                </div>
                <div class="text-md-right">
                    <dl class="row mb-0">
                        <dt class="col-sm-6 text-md-right small">ID #:</dt>
                        <dd class="col-sm-6 text-md-left small">{{ $orders->first()->invoice ?? 'N/A' }}</dd>
                        <dt class="col-sm-6 text-md-right small">Date:</dt>
                        <dd class="col-sm-6 text-md-left small">{{ $orders->first()->date ?? now()->format('Y-m-d') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Details - Original Structure -->
    <div class="pb-3 mb-3 d-flex justify-content-between">
        <div class="mb-3">
            <h2 class="h5 font-weight-semibold text-secondary">Bill To:</h2>
            <p class="text-dark">{{ $orders->first()->name ?? 'N/A' }}</p>
            <p class="text-muted small">Phone: {{ $orders->first()->contact ?? 'N/A' }}</p>
        </div>
        <div class="mb-3 text-right">
            <p class="text-muted small mb-0">ID #: {{ $orders->first()->invoice ?? 'N/A' }}</p>
            <p class="text-muted small mb-0">Date: {{ $orders->first()->date->format('Y-m-d') ?? now()->format('Y-m-d') }}</p>
        </div>
    </div>

    @php
        $groupedOrders = $orders->groupBy(function($item) {
            return $item->work_type . '|' . $item->package_amt . '|' . ($item->order_type === 'video' ? $item->video_time : '');
        })->map(function($group) {
            return (object) [
                'work_type_id' => $group->first()->work_type_id,
                'order_type' => $group->first()->order_type,
                'unit_price' => $group->first()->package_amt ?? $group->first()->amount,
                'count' => $group->count(),
                'tax' => $group->sum('tax'),
                'service' => $group->sum('service'),
                'time' => $group->first()->video_time ?? null
            ];
        });

        $totalTax = $groupedOrders->sum('tax');
        $totalService = $groupedOrders->sum('service');
        $hasVideo = $groupedOrders->contains('order_type', 'video');
        $colSpan = $hasVideo ? 5 : 4;
    @endphp

    <!-- Invoice Table - Original Structure -->
    <table class="table table-bordered mb-5">
        <thead class="thead-light">
            <tr>
                <th>Type</th>
                <th>Description</th>
                <th>Count</th>
                @if($hasVideo)
                    <th>Time</th>
                @endif
                <th>Price</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($groupedOrders as $item)
                <tr>
                    <td>{{ ucfirst($item->order_type) }}</td>
                    <td>
                        @foreach ($work_types as $work_type)
                            @if ($work_type->id == $item->work_type_id)
                                {{ $work_type->name }}
                            @endif
                        @endforeach
                    </td>
                    <td>{{ $item->count }}</td>
                    @if($hasVideo)
                        <td>{{ $item->time ?? '—' }}</td>
                    @endif
                    <td data-price="{{ $item->unit_price * $item->count }}">
                        {{ number_format($item->unit_price, 2) }}
                    </td>
                    <td class="text-right total">
                        {{ number_format($item->unit_price * $item->count, 2) }}
                    </td>
                </tr>
            @endforeach

            <!-- Totals - Original Structure -->
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

    <!-- Footer - Original Position -->
    <div class="text-muted small border-top pt-3 mt-3">
        <p>Quotation is due within 30 days of receipt.</p>
    </div>

    <!-- Print Button - Original Position -->
    <div class="d-print-none mt-4 text-center">
        <button onclick="window.print()" class="btn btn-primary mr-2">
            <i class="fas fa-print mr-1"></i> Print
        </button>
    </div>
</div>

<!-- Print-specific CSS (Added at bottom to override without changing structure) -->
<style>
    @media print {
        /* General print reset */
        body {
            padding: 5mm !important;
            margin: 0 !important;
            font-size: 12pt;
            background: white !important;
            color: black !important;
        }
        
        /* Container adjustments */
        .container {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            box-shadow: none !important;
            border: none !important;
        }
        
        /* Ensure all text is black */
        .text-muted, .text-secondary {
            color: #555 !important;
        }
        
        /* Table styling */
        .table {
            width: 100% !important;
            font-size: 10pt !important;
            border-collapse: collapse !important;
        }
        
        .table th, .table td {
            padding: 6px !important;
            border: 1px solid #ddd !important;
        }
        
        .table thead th {
            background-color: #f8f9fa !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        /* Hide print button */
        .d-print-none {
            display: none !important;
        }
        
        /* Images */
        img {
            max-height: 70px !important;
        }
        
        /* Prevent page breaks inside key elements */
        .row, .d-flex {
            page-break-inside: avoid;
        }
        
        @page {
            size: auto;
            margin: 5mm;
        }
    }
</style>

<script>
    // Original JavaScript preserved
    document.addEventListener("DOMContentLoaded", function() {
        updateInvoice();
    });

    function updateInvoice() {
        let subtotal = 0;

        document.querySelectorAll('[data-price]').forEach(priceCell => {
            subtotal += parseFloat(priceCell.dataset.price) || 0;
        });

        const tax = {{ $totalTax }};
        const service = {{ $totalService }};

        document.querySelector('.ab-total').textContent = subtotal.toFixed(2);
        document.querySelector('.tt-due').textContent = (subtotal + tax + service).toFixed(2);
    }
</script>
@endsection