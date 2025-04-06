@extends('layouts.app')
@section('content')
    <!-- start page title -->
    <form method="POST" action="{{ route('order.store.all') }}">
        @csrf
    <!-- Hidden Inputs for Common Data -->
    <input type="hidden" name="name" value="{{ $order1['name'] }}">
    <input type="hidden" name="contact" value="{{ $order1['contact'] }}">
    <input type="hidden" name="date" value="{{ $order1['date'] }}">
    <input type="hidden" name="order_type1" value="{{ $order1['order_type'] }}">
    <input type="hidden" name="order_type2" value="{{ $order2['order_type'] }}">
    <input type="hidden" name="order_type3" value="{{ $order3['order_type'] }}">
    <input type="hidden" name="package_amt" value="{{ $order1['package_amt'] }}">
    <input type="hidden" name="amount2" value="{{ $order2['amount'] }}">
    <input type="hidden" name="amount3" value="{{ $order3['amount'] }}">
    <input type="text" name="inv" value="bdv{{ $inv_id }}" hidden>
    <input type="text" name="inv_no" value="{{ $inv_id }}" hidden>
    <input type="text" name="total" id="total_due" hidden>


    <div class="container mx-auto p-4 bg-white shadow rounded border font-sans" style="max-width: 800px;">
        <!-- Header Section -->
        <div class="border-bottom pb-4 mb-4">
            <div class="row">
                <!-- Left Column - Company Info -->
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
        
                <!-- Right Column - Invoice Info -->
                <div class="col-md-4 mt-4 mt-md-0">
                    <div class="border-bottom pb-2 mb-2 border-primary">
                        <h1 class="h3 font-weight-bold text-uppercase text-dark mb-0">INVOICE</h1>
                    </div>
                    <div class="text-md-right">
                        <dl class="row mb-0">
                            <dt class="col-sm-6 text-md-right small">Invoice #:</dt>
                            <dd class="col-sm-6 text-md-left small">bdv{{ $inv_id }}</dd>
                            
                            <dt class="col-sm-6 text-md-right small">Date:</dt>
                            <dd class="col-sm-6 text-md-left small">{{ $order1['date'] }}</dd>
                        </dl>
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
                <p class="text-muted small mb-0">Invoice #: bdv{{ $inv_id }}</p>
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
            <!-- Order Items -->
            <tr>
                <td class="border">{{ $order1['order_type'] }}</td>
                <td class="border">
                    <input type="number" class="form-control qty-input" name="quantity1" value="1" min="1">
                </td>
                <td class="border" data-price="{{ $order1['package_amt'] }}">
                    {{ number_format($order1['package_amt'], 2) }}
                </td>
                <td class="border text-right total">0.00</td>
            </tr>
            <tr>
                <td class="border">{{ $order2['order_type'] }}</td>
                <td class="border">
                    <input type="number" class="form-control qty-input" name="quantity2" value="1" min="1">
                </td>
                <td class="border" data-price="{{ $order2['amount'] }}">
                    {{ number_format($order2['amount'] , 2) }}
                </td>
                <td class="border text-right total">0.00</td>
            </tr>
            <tr>
                <td class="border">{{ $order3['order_type'] }}</td>
                <td class="border">
                    <input type="number" class="form-control qty-input" name="quantity3" value="1" min="1">
                </td>
                <td class="border" data-price="{{ $order3['amount'] }}">
                    {{ number_format($order3['amount'], 2) }}
                </td>
                <td class="border text-right total">0.00</td>
            </tr>
            
            <!-- Subtotal Row -->
            <tr>
                <td colspan="3" class="border text-right">Subtotal</td>
                <td class="border text-right ab-total">0.00</td>
            </tr>

            <!-- Service & Tax Row -->
            <tr>
                <td colspan="2" class="border text-right">Service & Tax</td>
                <td class="border text-right" colspan="2">
                    <div class="form-inline justify-content-end">
                        <!-- Base Tax stored in data-base attribute -->
                        <input type="number" class="form-control tax-input mb-2"
                            name="tax" 
                            value="{{ $order1['tax'] }}" 
                            data-base="{{ $order1['tax'] }}" 
                            step="0.01" style="width: 200px;">
                        <!-- Base Service stored in data-base attribute -->
                        <input type="number" class="form-control service-input ml-1"
                            name="service" 
                            value="{{ $order1['service'] }}" 
                            data-base="{{ $order1['service'] }}" 
                            step="0.01" style="width: 200px;">
                    </div>
                </td>
            </tr>
            
            <!-- Total Due Row -->
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
        <button type="submit" class="btn btn-info">
            Submit
        </button>
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

        // Calculate subtotal for each order item row
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

        // Get the first row's quantity to compute tax and service
        const qtyForCalc = parseInt(document.querySelectorAll('.qty-input')[0].value) || 0;

        // Retrieve base values from data attributes
        const taxInput = document.querySelector('.tax-input');
        const serviceInput = document.querySelector('.service-input');
        const baseTax = parseFloat(taxInput.getAttribute('data-base')) || 0;
        const baseService = parseFloat(serviceInput.getAttribute('data-base')) || 0;

        // Multiply base values by the quantity
        const computedTax = baseTax * qtyForCalc;

        // For every 5 units, reduce service by 1000 from the multiplied service amount
        const discount = Math.floor(qtyForCalc / 5) * 1000;
        const computedService = (baseService * qtyForCalc) - discount;

        // Update the tax and service inputs to show computed values
        taxInput.value = computedTax.toFixed(2);
        serviceInput.value = computedService.toFixed(2);

        // Final total = subtotal + computed tax + computed service
        const finalTotal = subtotal + computedTax + computedService;
        document.querySelector('.tt-due').textContent = finalTotal.toFixed(2);

        // **Update hidden input field live**
        document.getElementById("total_due").value = finalTotal.toFixed(2);
    }

    // Attach event listeners for input changes
    document.addEventListener("DOMContentLoaded", function () {
        updateInvoice(); // initial calculation on page load

        // Listen for changes in all quantity inputs
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
