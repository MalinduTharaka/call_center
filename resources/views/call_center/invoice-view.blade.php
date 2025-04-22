@extends('layouts.app')

@section('content')
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
                        <dd class="col-sm-6 text-md-left small">{{ $orders->first()->invoice ?? 'N/A' }}</dd>
                        <dt class="col-sm-6 text-md-right small">Date:</dt>
                        <dd class="col-sm-6 text-md-left small">{{ $orders->first()->date ?? now()->format('Y-m-d') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Details -->
    <div class="pb-3 mb-3 d-flex justify-content-between">
        <div class="mb-3">
            <h2 class="h5 font-weight-semibold text-secondary">Bill To:</h2>
            <p class="text-dark">{{ $orders->first()->name ?? 'N/A' }}</p>
            <p class="text-muted small">Phone: {{ $orders->first()->contact ?? 'N/A' }}</p>
        </div>
        <div class="mb-3 text-right">
            <p class="text-muted small mb-0">Invoice #: {{ $orders->first()->invoice ?? 'N/A' }}</p>
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

    <!-- Invoice Table -->
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
                    @foreach ($work_types as $work_type)
                        @if ($work_type->id == $item->work_type_id)
                            <td>{{ $work_type->name }}</td>
                        @endif
                    @endforeach<td>{{ $item->work_type_id }}</td>
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

            <!-- Totals -->
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

    <div class="text-muted small border-top pt-3 mt-3">
        <p>Payment is due within 30 days of receipt.</p>
    </div>

    <div class="d-print-none mt-4 text-center">
        <button onclick="window.print()" class="btn btn-primary mr-2">
            <i class="fas fa-print mr-1"></i> Print
        </button>
    </div>
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
    }

    document.addEventListener("DOMContentLoaded", updateInvoice);
</script>
@endsection
