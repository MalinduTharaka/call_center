@extends('layouts.app')
@section('content')
    <!-- start page title -->
    <div class="container mx-auto p-4 bg-white shadow rounded border font-sans" style="max-width: 800px;">
        <!-- Header - Updated with larger logo and marketing partner text -->
        <!-- Header Section -->
        <div class="border-bottom pb-4 mb-4">
            <div class="row">
                <!-- Left Column - Company Info -->
                <div class="col-8">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('logos/wishwavideo.jpg')}}" alt="Company Logo" class="img-fluid mr-3"
                            style="height: 100px; width: auto;">
                        <div>
                            <h1 class="h3 font-weight-bold text-primary mb-0">STUDIO WISHWA</h1>
                            <p class="lead text-muted mb-0" style="font-size: 1.1rem;">Feel The Quality of Professionals</p>
                        </div>
                    </div>
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

                <!-- Right Column - Invoice Title -->
                <div class="col-4 text-right">
                    <div class="border-bottom pb-2 mb-2 border-primary">
                        <h2 class="h1 font-weight-bold text-uppercase text-muted mb-0">INVOICE</h2>
                    </div>
                    <div class="pt-1">
                        <p class="mb-1 small">
                            <span class="font-weight-bold">Invoice #:</span> {{$order->id}}
                        </p>
                        <p class="mb-0 small">
                            <span class="font-weight-bold">Date:</span> {{$order->date}}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rest of your content remains the same -->
        <div class="pb-3 mb-3 d-flex justify-content-between">
            <!-- Customer Information -->
            <div class="mb-3">
                <h2 class="h5 font-weight-semibold text-secondary">Bill To:</h2>
                <p class="text-dark">{{$order->name}}</p>
                <p class="text-muted small">Phone: {{$order->contact}}</p>
            </div>

            <!-- Invoice Information -->
            <div class="mb-3 text-right">
                <p class="text-muted small mb-0">Invoice #: {{$order->id}}</p>
                <p class="text-muted small mb-0">Date: {{$order->date}}</p>
            </div>
        </div>

        <!-- Invoice Table -->
        <table class="table table-bordered mb-5">
            <thead class="thead-light">
                <tr>
                    <th class="text-left">Item</th>
                    <th class="text-left">Qty</th>
                    <th class="text-left">Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border">{{$order->order_type}}<br/>{{$order->package_id}}</td>
                    <td class="border">1</td>
                    <td class="border">$100.00</td>
                    <td class="border text-right">$100.00</td>
                </tr>
                <tr>
                    <td colspan="3" class="border text-right">Subtotal</td>
                    <td class="border text-right">$200.00</td>
                </tr>
                <tr>
                    <td colspan="3" class="border text-right">Service</td>
                    <td class="border text-right">$20.00</td>
                </tr>
                <tr class="font-weight-bold">
                    <td colspan="3" class="border text-right">Total Due</td>
                    <td class="border text-right">$220.00</td>
                </tr>
            </tbody>
        </table>

        <!-- Footer -->
        <div class="text-muted small border-top pt-3 mt-3">
            <p>Payment is due within 30 days of receipt.</p>
        </div>
    </div>

    <div class="d-print-none mt-4">
        <div class="text-center">
            <button onclick="window.print()" class="btn btn-primary mr-2">
                <i class="fas fa-print mr-1"></i> Print
            </button>
            <button class="btn btn-info">
                Submit
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
        function printPage() {
            window.print();
        }
    </script>
@endsection