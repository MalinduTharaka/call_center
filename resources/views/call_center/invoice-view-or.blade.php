@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 bg-white shadow rounded border font-sans" style="max-width: 800px;">
    <!-- Header Section -->
    <div class="border-bottom pb-4 mb-4">
        <div class="row">
            <div class="col-md-8">
                <div class="row align-items-center">
                    <div class="col-sm-12 mb-2 mb-sm-0">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('logos/WishwaAdsStudio.png') }}" alt="Wishwa Ads Logo"
                                 class="img-fluid mr-3" style="max-height: 80px; width: auto;">
                        </div>
                    </div>
                </div>
                <div class="mt-3">
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

            <!-- Invoice Info -->
            <div class="col-md-4 mt-4 mt-md-0">
                <div class="border-bottom pb-2 mb-2 border-primary">
                    <h1 class="h3 font-weight-bold text-uppercase text-dark mb-0">INVOICE</h1>
                </div>
                <div class="text-md-right">
                    <dl class="row mb-0">
                        <dt class="col-sm-6 text-md-right small">ID #:</dt>
                        <dd class="col-sm-6 text-md-left small">{{ $orders->first()->invoice_id ?? 'N/A' }}</dd>
                        <dt class="col-sm-6 text-md-right small">Date:</dt>
                        <dd class="col-sm-6 text-md-left small">{{ $orders->first()->date ?? now()->format('Y-m-d') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Info -->
    <div class="pb-3 mb-2 d-flex justify-content-between">
        <div class="mb-3">
            <h2 class="h5 font-weight-semibold text-secondary">Bill To:</h2>
            <p class="text-dark">{{ $orders->first()->name ?? 'N/A' }}</p>
            <p class="text-muted small">Phone: {{ $orders->first()->contact ?? 'N/A' }}</p>
        </div>
        <div class="mb-3 text-right">
            <p class="text-muted small mb-0">ID #: {{ $orders->first()->invoice_id ?? 'N/A' }}</p>
            <p class="text-muted small mb-0">Date: {{ $orders->first()->date ?? now()->format('Y-m-d') }}</p>
        </div>
    </div>

    @php
        $groupedOrders = $orders->groupBy('work_type')->map(function($group) {
            return (object) [
                'work_type' => $group->first()->work_type,
                'count' => $group->count(),
                'unit_price' => $group->avg('amount'),
                'total' => $group->sum('amount'),
                'note' => $group->first()->note,
            ];
        });

        $grandTotal = $groupedOrders->sum('total');
    @endphp

    <!-- Invoice Table -->
    <table class="table table-bordered mb-2">
        <thead class="thead-light">
            <tr>
                <th>Type</th>
                <th>Description</th>
                <th>Count</th>
                <th>Price</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($groupedOrders as $item)
                <tr>
                    <td>{{ $item->work_type }}</td>
                    <td>{{ $item->note }}</td>
                    <td>{{ $item->count }}</td>
                    <td>{{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-right">{{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
            <tr class="font-weight-bold">
                <td colspan="4" class="border text-right">Total Due</td>
                <td class="border text-right">Rs. {{ number_format($grandTotal, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Footer -->
    <div class="text-muted small border-top pt-3 mt-3">
        <p>Payment is due within 30 days of receipt.</p>
    </div>

    <!-- Print Button -->
    
    <table class="bank-details-table" style="width: 100%;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <p>Commercial Bank<br>
                    Account Number -  1000620243<br>
                    Name -  WISHWA ADS TEAM<br>
                    Bank -  COMMERCIAL BANK<br>
                    Branch - GANEMULLA BRANCH</p>
            </td>
            <td style="width: 50%; vertical-align: top;">
                <p>BOC<br>
                    Account Number - 1425126<br>
                    Name - W C C WISHWAJITH<br>
                    Bank - BANK OF CEYLON ( BOC )<br>
                    Branch - GAMPAHA BRANCH</p>
            </td>
        </tr>
    </table>
</div>

<div class="d-print-none mt-4 text-center">
    <button onclick="window.print()" class="btn btn-primary mr-2">
        <i class="fas fa-print mr-1"></i> Print
    </button>
</div>

<!-- Print CSS -->
<style>
    @media print {
        body {
            padding: 5mm !important;
            margin: 0 !important;
            font-size: 12pt;
            background: white !important;
            color: black !important;
        }

        .container {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            box-shadow: none !important;
            border: none !important;
        }

        .text-muted, .text-secondary {
            color: #555 !important;
        }

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

        .d-print-none {
            display: none !important;
        }

        img {
            max-height: 70px !important;
        }

        .row, .d-flex {
            page-break-inside: avoid;
        }

        .bank-details-table {
                font-size: 9pt !important;
            }

        @page {
            size: auto;
            margin: 5mm;
        }
    }
</style>
@endsection
