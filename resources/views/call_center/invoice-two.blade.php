@extends('layouts.app')
@section('content')
    <!-- start page title -->
    <form method="POST" action="{{ route('order.store.two') }}" id="invoiceForm">
        @csrf

        <input type="hidden" name="name" value="{{ $order1['name'] }}">
        <input type="hidden" name="contact" value="{{ $order1['contact'] }}">
        <input type="hidden" name="date" value="{{ $order1['date'] }}">
        <input type="hidden" name="order_type1" value="{{ $order1['order_type'] }}">
        <input type="hidden" name="order_type2" value="{{ $order2['order_type'] }}">
        @if ($order1['order_type'] == 'boosting')
            <input type="hidden" name="package_amt" value="{{ $order1['package_amt'] }}">
        @else
            <input type="hidden" name="amount" value="{{ $order1['amount'] }}">
        @endif
        <input type="hidden" name="total" id="total">
        <input type="text" name="inv" value="@if($order1['order_type'] == 'boosting' && $order2['order_type'] == 'designs')bd @elseif($order1['order_type'] == 'boosting' && $order2['order_type'] == 'video')bv @elseif($order1['order_type'] == 'designs' && $order2['order_type'] == 'video')dv @endif{{ $inv_id }}" hidden>
        <input type="text" name="inv_no" value="{{ $inv_id }}" hidden>
        <input type="text" name="total" id="total_due" hidden>

<input type="hidden" name="amount_order2" value="{{ $order2['amount'] }}">
<input type="hidden" name="amount_order2" value="{{ $order2['amount'] }}">
    <div class="container mx-auto p-4 bg-white shadow rounded border font-sans" style="max-width: 800px;">
        <!-- Header Section -->
        <div class="border-bottom pb-4 mb-4">
            <div class="row">
                <!-- Left Column - Company Info -->
                <div class="col-8">
                    <div class="d-flex align-items-center mb-3">
                        <!-- Always show first company -->
                        <div class="{{ $order2['order_type'] == 'video' ? 'col-6 ' : 'col-12' }} d-flex align-items-center">
                            <img src="{{ asset('logos/wishwaads.jpg')}}" alt="WISHWA ADS Logo" 
                            class="img-fluid mr-3" style="max-height: 80px; width: auto;">
                            <div>
                                @if ($order2['order_type'] == 'video')
                                <h2 class="h5 font-weight-bold text-danger mb-0">WISHWA ADS</h2>
                                <p class="text-muted mb-0 small">Your Marketing Partner</p>
                                @else
                                <h1 class="h4 font-weight-bold text-danger mb-0">WISHWA ADS</h1>
                                <p class="lead text-muted mb-0" style="font-size: 1.1rem;">Your Marketing Partner</p>
                                @endif
                            </div>
                        </div>
        
                        <!-- Conditionally show second company -->
                        @if($order2['order_type'] == 'video')
                        <div class="col-6 d-flex align-items-center">
                            <img src="{{ asset('logos/wishwavideo.jpg')}}" alt="Studio WISHWA Logo" 
                                 class="img-fluid mr-3" style="max-height: 80px; width: auto;">
                            <div>
                                @if ($order2['order_type'] == 'video')
                                <h2 class="h5 font-weight-bold text-danger mb-0">STUDIO WISHWA</h2>
                                    <p class="text-muted mb-0 small">Feel The Quality Of Professionals</p>
                                @else
                                <h1 class="h4 font-weight-bold text-danger mb-0">STUDIO WISHWA</h1>
                                <p class="lead text-muted mb-0" style="font-size: 1.1rem;">Feel The Quality Of Professionals</p>
                                @endif
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
        
                <!-- Right Column - Invoice Title -->
                <div class="col-4 text-right">
                    <div class="border-bottom pb-2 mb-2 border-primary">
                        <h2 class="h1 font-weight-bold text-uppercase text-muted mb-0">INVOICE</h2>
                    </div>
                    <div class="pt-1">
                        <p class="mb-1 small">
                            <span class="font-weight-bold">Invoice #:</span>
                            @if ($order1['order_type'] == 'boosting' && $order2['order_type'] == 'designs')
                                bd
                            @elseif ($order1['order_type'] == 'boosting' && $order2['order_type'] == 'video')
                                bv
                            @elseif ($order1['order_type'] == 'designs' && $order2['order_type'] == 'video')
                                dv
                            @endif{{ $inv_id }}
                        </p>
                        <p class="mb-0 small">
                            <span class="font-weight-bold">Date:</span> {{ $order1['date'] }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

       <!-- Customer and Invoice Details -->
       <div class="pb-3 mb-3 d-flex justify-content-between">
        <div class="mb-3">
            <h2 class="h5 font-weight-semibold text-secondary">Bill To:</h2>
            <p class="text-dark">{{ $order1['name'] }}</p>
            <p class="text-muted small">Phone: {{ $order1['contact'] }}</p>
        </div>
        <div class="mb-3 text-right">
            <p class="text-muted small mb-0">Invoice #:
                @if ($order1['order_type'] == 'boosting' && $order2['order_type'] == 'designs')
                    bd
                @elseif ($order1['order_type'] == 'boosting' && $order2['order_type'] == 'video')
                    bv
                @elseif ($order1['order_type'] == 'designs' && $order2['order_type'] == 'video')
                    dv
                @endif
                {{ $inv_id }}
            </p>
            <p class="text-muted small mb-0">Date: {{ $order1['date'] }}</p>
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
            @if ($order1['order_type']  == 'boosting')
            <tr>
                <td class="border">{{ $order1['order_type'] }}</td>
                <td class="border">
                    <input type="number" name="quantity1" class="form-control qty-input" value="1" min="1">
                </td>
                <td class="border" data-price="{{ $order1['package_amt'] }}">
                    {{ number_format($order1['package_amt'] , 2) }}
                </td>
                <td class="border text-right total">0.00</td>
            </tr>
            @else
            <tr>
                <td class="border">{{ $order1['order_type'] }}</td>
                <td class="border">
                    <input type="number" name="quantity1" class="form-control qty-input" value="1" min="1">
                </td>
                <td class="border" data-price="{{ $order1['amount'] }}">
                    {{ number_format($order1['amount'], 2) }}
                </td>
                <td class="border text-right total">0.00</td>
            </tr>
            @endif
           
            <tr>
                <td class="border">{{ $order2['order_type'] }}</td>
                <td class="border">
                    <input type="number" name="quantity2" class="form-control qty-input" value="1" min="1">
                </td>
                <td class="border" data-price="{{ $order2['amount'] }}">
                    {{ number_format($order2['amount'], 2) }}
                </td>
                <td class="border text-right total">0.00</td>
            </tr>
            
            <tr>
                <td colspan="3" class="border text-right">Subtotal</td>
                <td class="border text-right ab-total">0.00</td>
            </tr>

            @if ($order1['order_type'] == 'boosting')
            <tr>
                <td colspan="2" class="border text-right">Service</td>
                <td class="border text-right" colspan="2">
                    <div class="form-inline justify-content-end">
                        <input type="number" name="tax" class="form-control tax-input mb-2" value="{{ $order1['tax'] }}" step="0.01" style="width: 200px;">
                        
                        <input type="number" name="service" class="form-control service-input ml-1" value="{{ $order1['service'] }}" step="0.01" style="width: 200px;">
                    </div>
                </td>
            </tr>
            @endif
            
            <tr class="font-weight-bold">
                <td colspan="3" class="border text-right">Total Due</td>
                <td class="border text-right">Rs.<span class="tt-due"></span></td>
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
    // Function to update the invoice calculations
    function updateInvoice() {
        let subtotal = 0;

        // Iterate over each row in the table to calculate row totals
        document.querySelectorAll('tbody tr').forEach(row => {
            const qtyInput = row.querySelector('.qty-input');
            const priceCell = row.querySelector('[data-price]');
            const totalCell = row.querySelector('.total');

            if (qtyInput && priceCell && totalCell) {
                const qty = parseInt(qtyInput.value) || 0;
                const price = parseFloat(priceCell.dataset.price) || 0;
                const rowTotal = qty * price;
                totalCell.textContent = rowTotal.toFixed(2);
                subtotal += rowTotal;
            }
        });

        // Update subtotal display
        document.querySelector('.ab-total').textContent = subtotal.toFixed(2);

        // Initialize final total
        let finalTotal = subtotal;
        let calculatedTax = 0, calculatedService = 0;

        // Get tax and service input elements
        const taxInputEl = document.querySelector('.tax-input');
        const serviceInputEl = document.querySelector('.service-input');

        if (taxInputEl && serviceInputEl) {
            // Get base tax and service values (keep original values on first load)
            const baseTax = parseFloat(taxInputEl.dataset.baseValue) || parseFloat(taxInputEl.value) || 0;
            const baseService = parseFloat(serviceInputEl.dataset.baseValue) || parseFloat(serviceInputEl.value) || 0;

            // Assume boosting quantity is from the first boosting row's quantity input
            const boostingQtyInput = document.querySelector('tbody tr .qty-input');
            const boostingQty = parseInt(boostingQtyInput.value) || 0;

            // Calculate tax by multiplying base tax by boosting quantity
            calculatedTax = baseTax * boostingQty;

            // Calculate service: multiply base service by boosting quantity and reduce discount
            // For every 5 units, reduce 1000 from the service charge
            const discount = Math.floor(boostingQty / 5) * 1000;
            calculatedService = (baseService * boostingQty) - discount;

            // Ensure service doesn't go negative
            calculatedService = Math.max(calculatedService, 0);

            // ✅ Keep initial values visible and update dynamically
            if (!taxInputEl.dataset.baseValue) taxInputEl.dataset.baseValue = baseTax;
            if (!serviceInputEl.dataset.baseValue) serviceInputEl.dataset.baseValue = baseService;

            taxInputEl.value = calculatedTax.toFixed(2);
            serviceInputEl.value = calculatedService.toFixed(2);

            // Update final total to include recalculated tax and service
            finalTotal = subtotal + calculatedTax + calculatedService;
        }

        // Update the final total due
        document.querySelector('.tt-due').textContent = finalTotal.toFixed(2);

        // **Update hidden input field live**
        document.getElementById("total_due").value = finalTotal.toFixed(2);
    }

    // Attach event listeners for all quantity, tax, and service inputs once the document is loaded
    document.addEventListener("DOMContentLoaded", function () {
        updateInvoice(); // Initial calculation on page load

        // Listen for changes in quantity inputs
        document.querySelectorAll('.qty-input').forEach(input => {
            input.addEventListener('input', updateInvoice);
        });

        // Listen for changes in tax and service inputs
        document.querySelectorAll('.tax-input, .service-input').forEach(input => {
            input.addEventListener('input', updateInvoice);
        });
    });
</script>


@endsection
