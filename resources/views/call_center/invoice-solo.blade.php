@extends('layouts.app')
@section('content')
    <!-- start page title -->
    <form method="POST" action="{{ route('order.store.solo') }}">
        @csrf

        <input type="hidden" name="order_type" value="{{ $order['order_type'] }}">
        <input type="hidden" name="date" value="{{ $order['date'] }}">
        <input type="hidden" name="name" value="{{ $order['name'] }}">
        <input type="hidden" name="contact" value="{{ $order['contact'] }}">

        @if($order['order_type'] == 'boosting')
            <input type="hidden" name="package_amt" value="{{ $order['package_amt'] }}">
        @else
            <input type="hidden" name="amount" value="{{ $order['amount'] }}">
        @endif
        <input type="text" name="inv" value="@if ($order['order_type'] == 'boosting')b @elseif ($order['order_type'] == 'designs')d @else v @endif{{ $inv_id }}" hidden>
        <input type="text" name="inv_no" value="{{ $inv_id }}" hidden>
        <input type="text" name="total" id="total_due" hidden>

        <div class="container mx-auto p-4 bg-white shadow rounded border font-sans" style="max-width: 800px;">
            <!-- Header Section -->
            <div class="border-bottom pb-4 mb-4">
                <div class="row">
                    <!-- Company Info -->
                    <div class="col-8">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset($order['order_type'] == 'video' ? 'logos/wishwavideo.jpg' : 'logos/wishwaads.jpg') }}"
                                alt="Company Logo" class="img-fluid mr-3" style="height: 100px; width: auto;">
                            <div>
                                @if ($order['order_type'] == 'boosting' || $order['order_type'] == 'design')
                                    <h1 class="h3 font-weight-bold text-danger mb-0">WISHWA ADS</h1>
                                    <p class="lead text-muted mb-0" style="font-size: 1.1rem;">Your Marketing Partner</p>
                                @else
                                    <h1 class="h3 font-weight-bold text-danger mb-0">STUDIO WISHWA</h1>
                                    <p class="lead text-muted mb-0" style="font-size: 1.1rem;">Feel The quality Of Professionals
                                    </p>
                                @endif
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
                    <!-- Invoice Info -->
                    <div class="col-4 text-right">
                        <div class="border-bottom pb-2 mb-2 border-primary">
                            <h2 class="h1 font-weight-bold text-uppercase text-muted mb-0">INVOICE</h2>
                        </div>
                        <div class="pt-1">
                            <p class="mb-1 small">
                                <span class="font-weight-bold">Invoice #:</span>
                                @if ($order['order_type'] == 'boosting')
                                    b
                                @elseif ($order['order_type'] == 'design')
                                    d
                                @else
                                    v
                                @endif
                                {{ $inv_id }}
                            </p>
                            <p class="mb-0 small">
                                <span class="font-weight-bold">Date:</span> {{ $order['date'] }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer and Invoice Details -->
            <div class="pb-3 mb-3 d-flex justify-content-between">
                <div class="mb-3">
                    <h2 class="h5 font-weight-semibold text-secondary">Bill To:</h2>
                    <p class="text-dark">{{ $order['name'] }}</p>
                    <p class="text-muted small">Phone: {{ $order['contact'] }}</p>
                </div>
                <div class="mb-3 text-right">
                    <p class="text-muted small mb-0">Invoice #:
                        @if ($order['order_type'] == 'boosting')
                            b
                        @elseif ($order['order_type'] == 'design')
                            d
                        @else
                            v
                        @endif
                        {{ $inv_id }}
                    </p>
                    <p class="text-muted small mb-0">Date: {{ $order['date'] }}</p>
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
                    @if ($order['order_type'] == 'boosting')
                        <tr>
                            <td class="border">{{ $order['order_type'] }}</td>
                            <td class="border">
                                <input type="number" name="quantity" class="form-control qty-input" value="1" min="1">
                            </td>
                            <td class="border" data-price="{{ $order['package_amt'] }}">
                                {{ number_format($order['package_amt'], 2) }}
                            </td>
                            <td class="border text-right total">0.00</td>
                        </tr>
                    @else
                        <tr>
                            <td class="border">{{ $order['order_type'] }}</td>
                            <td class="border">
                                <input type="number" name="quantity" class="form-control qty-input" value="1" min="1">
                            </td>
                            <td class="border" data-price="{{ $order['amount'] }}">
                                {{ number_format($order['amount'], 2) }}
                            </td>
                            <td class="border text-right total">0.00</td>
                        </tr>
                    @endif

                    <tr>
                        <td colspan="3" class="border text-right">Subtotal</td>
                        <td class="border text-right ab-total">0.00</td>
                    </tr>
                    @if ($order['order_type'] == 'boosting')
                        <tr>
                            <td colspan="2" class="border text-right">Service</td>
                            <td class="border text-right" colspan="2">
                                <div class="form-inline justify-content-end">
                                    <input type="number" name="tax" class="form-control tax-input mb-2"
                                        value="{{ $order['tax'] }}" step="0.01">

                                    <input type="number" name="service" class="form-control service-input ml-1"
                                        value="{{ $order['service'] }}" step="0.01">
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
            let totalTax = 0;
            let totalService = 0;

            // Get base tax and service rates from the inputs.
            const taxInput = document.querySelector('.tax-input');
            const serviceInput = document.querySelector('.service-input');

            const baseTaxRate = taxInput ? parseFloat(taxInput.getAttribute('data-base')) || parseFloat(taxInput.value) || 0 : 0;
            const baseServiceRate = serviceInput ? parseFloat(serviceInput.getAttribute('data-base')) || parseFloat(serviceInput.value) || 0 : 0;

            // Iterate over each row that has a quantity input.
            document.querySelectorAll('tbody tr').forEach(row => {
                const qtyInput = row.querySelector('.qty-input');
                if (qtyInput) {
                    const qty = parseInt(qtyInput.value) || 0;
                    const priceCell = row.querySelector('[data-price]');

                    if (priceCell) {
                        const price = parseFloat(priceCell.dataset.price) || 0;
                        const rowTotal = qty * price;

                        // Update the row's total cell.
                        const totalCell = row.querySelector('.total');
                        if (totalCell) {
                            totalCell.textContent = rowTotal.toFixed(2);
                        }

                        subtotal += rowTotal;

                        // Correct tax calculation (No discount applied)
                        totalTax += baseTaxRate * qty;

                        // Correct service calculation (Only applies discount to service)
                        if ("{{ $order['order_type'] }}" === 'boosting') {
                            let serviceDiscount = Math.floor(qty / 5) * 1000;
                            totalService += (baseServiceRate * qty) - serviceDiscount;
                        } else {
                            totalService += baseServiceRate * qty;
                        }

                    }
                }
            });

            // Update subtotal element
            document.querySelector('.ab-total').textContent = subtotal.toFixed(2);

            // Update tax and service fields with computed totals
            if (taxInput) {
                taxInput.value = totalTax.toFixed(2); // Tax is correctly updated
            }
            if (serviceInput) {
                serviceInput.value = totalService.toFixed(2); // Service is correctly updated with discount
            }

        
            // Calculate the final total
            const finalTotal = subtotal + totalTax + totalService;
            document.querySelector('.tt-due').textContent = finalTotal.toFixed(2);
            // **Update hidden input field live**
            document.getElementById("total_due").value = finalTotal.toFixed(2);
        }

        // Event listeners for input changes
        document.addEventListener("DOMContentLoaded", function () {
            const taxInput = document.querySelector('.tax-input');
            if (taxInput) {
                taxInput.setAttribute('data-base', taxInput.value);
            }
            const serviceInput = document.querySelector('.service-input');
            if (serviceInput) {
                serviceInput.setAttribute('data-base', serviceInput.value);
            }

            updateInvoice();

            document.querySelectorAll('.qty-input, .tax-input, .service-input').forEach(input => {
                input.addEventListener('input', updateInvoice);
            });
        });

    </script>

    <!-- Include html2canvas and jsPDF libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <!-- Download Button -->
    <button id="download-pdf" class="btn btn-success">Download Invoice as PDF</button>

    <script>
        document.getElementById("download-pdf").addEventListener("click", function () {
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF("p", "mm", "a4");

            const container = document.querySelector(".container"); // Select only the invoice container

            html2canvas(container, { scale: 2 }).then(canvas => {
                const imgData = canvas.toDataURL("image/png");
                const imgWidth = 210; // A4 width in mm
                const imgHeight = (canvas.height * imgWidth) / canvas.width;

                pdf.addImage(imgData, "PNG", 0, 0, imgWidth, imgHeight);
                pdf.save("invoice.pdf");
            });
        });
    </script>


@endsection