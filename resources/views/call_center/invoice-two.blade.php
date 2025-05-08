@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('order.store.two') }}">
    @csrf

    @php $counter = 0; @endphp

    @foreach($boostingOrders as $order)
        <input type="hidden" name="orders[{{ $counter }}][order_type]"  value="{{ $order['order_type'] }}">
        <input type="hidden" name="orders[{{ $counter }}][package_amt]"  value="{{ $order['package_amt'] }}">
        <input type="hidden" name="orders[{{ $counter }}][tax]"          value="{{ $order['tax'] }}">
        <input type="hidden" name="orders[{{ $counter }}][service]"      value="{{ $order['service'] }}">
        <input type="hidden" name="orders[{{ $counter }}][work_type]"    value="{{ $order['work_type'] }}">
        @php $counter++; @endphp
    @endforeach

    @foreach($designOrders as $order)
        <input type="hidden" name="orders[{{ $counter }}][order_type]"  value="{{ $order['order_type'] }}">
        <input type="hidden" name="orders[{{ $counter }}][amount]"      value="{{ $order['amount'] }}">
        <input type="hidden" name="orders[{{ $counter }}][work_type]"   value="{{ $order['work_type'] }}">
        @php $counter++; @endphp
    @endforeach

    @foreach($videoOrders as $order)
        <input type="hidden" name="orders[{{ $counter }}][order_type]"  value="{{ $order['order_type'] }}">
        <input type="hidden" name="orders[{{ $counter }}][time]"        value="{{ $order['time'] }}">
        <input type="hidden" name="orders[{{ $counter }}][amount]"      value="{{ $order['amount'] }}">
        <input type="hidden" name="orders[{{ $counter }}][work_type]"   value="{{ $order['work_type'] }}">
        @php $counter++; @endphp
    @endforeach

    <input type="hidden" name="contact" value="{{ $boostingOrders[0]['contact']  ?? $designOrders[0]['contact']  ?? $videoOrders[0]['contact']  ?? '' }}">
    <input type="hidden" name="date"    value="{{ \Carbon\Carbon::now()->toDateString() }}">
    <input type="hidden" name="name"    value="{{ $boostingOrders[0]['name']     ?? $designOrders[0]['name']     ?? $videoOrders[0]['name']     ?? '' }}">
    <input type="hidden" name="inv"     value="@if (!empty($boostingOrders))b @elseif (!empty($designOrders))d @else v @endif{{ $inv_id }}">
    <input type="hidden" name="inv_no"  value="{{ $inv_id }}">
    <input type="hidden" name="total" id="total_due">
    <input type="hidden" name="type"    value="{{ $type }}">

    <div class="container mx-auto p-4 bg-white shadow rounded border font-sans" style="max-width: 800px;">
        <!-- Header Section -->
        <div class="border-bottom pb-4 mb-2">
            <div class="row">
                <!-- Company Info -->
                <div class="col-md-8">
                    <div class="row align-items-center">
                        <div class="{{ count($videoOrders) > 0 ? 'col-sm-6' : 'col-12' }} mb-4 mb-sm-0">
                            <div class="d-flex align-items-center justify-content-{{ count($videoOrders) > 0 ? 'start' : 'center' }}">
                                <img src="{{ asset('logos/WishwaAds.png') }}" alt="Wishwa Ads Logo"
                                     class="img-fluid" style="{{ count($videoOrders) > 0 ? 'height: 100px; width: auto;' : 'width: 100%; height: auto;' }}">
                            </div>
                        </div>
                        @if(count($videoOrders) > 0)
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('logos/Studio.png') }}" alt="Studio Wishwa Logo"
                                     class="img-fluid mr-3" style="height: 100px; width: auto;">
                            </div>
                        </div>
                        @endif
                    </div>
                    <!-- Contact Info -->
                    <div class="mt-3">
                        <p class="mb-1 small text-muted">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            No.151, Ward City Shopping Complex, Gampaha
                        </p>
                        <p class="mb-1 small text-muted">
                            <i class="fas fa-phone mr-1"></i>
                            077 1855 191
                        </p>
                        <p class="mb-1 small text-muted">
                            <i class="fas fa-envelope mr-1"></i>
                            info@wishwaads.com
                        </p>
                    </div>
                </div>
                <!-- Invoice/Quotation Info -->
                <div class="col-md-4 mt-4 mt-md-0">
                    <div class="border-bottom pb-2 mb-2 border-primary">
                        <h1 class="h3 font-weight-bold text-uppercase text-dark mb-0">
                            {{ $type == 1 ? 'QUOTATION' : 'INVOICE' }}
                        </h1>
                    </div>
                    <div class="text-md-right">
                        <dl class="row mb-0">
                            <dt class="col-sm-6 text-md-right small">ID #:</dt>
                            <dd class="col-sm-6 text-md-left small">
                                @if(count($boostingOrders) && count($designOrders)) bd
                                @elseif(count($boostingOrders) && count($videoOrders)) bv
                                @elseif(count($designOrders) && count($videoOrders))  dv
                                @endif{{ $inv_id }}
                            </dd>
                            <dt class="col-sm-6 text-md-right small">Date:</dt>
                            <dd class="col-sm-6 text-md-left small">{{ now()->format('Y-m-d H:i:s') }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Details -->
        <div class="pb-2 mb-2 d-flex justify-content-between">
            <div class="mb-3">
                <h2 class="h5 font-weight-semibold text-secondary">Bill To:</h2>
                <p class="text-dark">{{ $boostingOrders[0]['name']  ?? $designOrders[0]['name']  ?? $videoOrders[0]['name']  ?? '' }}</p>
                <p class="text-muted small">Phone: {{ $boostingOrders[0]['contact']  ?? $designOrders[0]['contact']  ?? $videoOrders[0]['contact']  ?? '' }}</p>
            </div>
            <div class="mb-2 text-right">
                <p class="text-muted small mb-0">{{ $type == 1 ? 'Quotation' : 'Invoice' }} #: 
                    @if(count($boostingOrders) && count($designOrders)) bd
                    @elseif(count($boostingOrders) && count($videoOrders)) bv
                    @elseif(count($designOrders) && count($videoOrders))  dv
                    @endif{{ $inv_id }}
                </p>
                <p class="text-muted small mb-0">Date: {{ now()->format('Y-m-d') }}</p>
            </div>
        </div>

        <!-- Invoice Table -->
        <table class="table table-bordered mb-2">
            <thead class="thead-light">
                <tr>
                    <th>Type</th>
                    <th>Description</th>
                    @if(count($videoOrders) > 0)
                        <th>Time</th>
                    @endif
                    <th>Qty</th>
                    <th>Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($boostingOrders as $order)
                    <tr class="detail-row">
                        <td>Boosting</td>
                        @foreach($work_types as $wt)
                            @if($wt->id == $order['work_type'])
                                <td>{{ $wt->name }}</td>
                            @endif
                        @endforeach
                        @if(count($videoOrders) > 0)
                            <td>—</td>
                        @endif
                        <td class="qty">1</td>
                        <td data-price="{{ $order['package_amt'] }}">{{ number_format($order['package_amt'],2) }}</td>
                        <td class="text-right total">{{ number_format($order['package_amt'],2) }}</td>
                    </tr>
                @endforeach

                @foreach($designOrders as $order)
                    <tr class="detail-row">
                        <td>Design</td>
                        @foreach($work_types as $wt)
                            @if($wt->id == $order['work_type'])
                                <td>{{ $wt->name }}</td>
                            @endif
                        @endforeach
                        @if(count($videoOrders) > 0)
                            <td>—</td>
                        @endif
                        <td class="qty">1</td>
                        <td data-price="{{ $order['amount'] }}">{{ number_format($order['amount'],2) }}</td>
                        <td class="text-right total">{{ number_format($order['amount'],2) }}</td>
                    </tr>
                @endforeach

                @foreach($videoOrders as $order)
                    <tr class="detail-row">
                        <td>Video</td>
                        @foreach($work_types as $wt)
                            @if($wt->id == $order['work_type'])
                                <td>{{ $wt->name }}</td>
                            @endif
                        @endforeach
                        <td>{{ $order['time'] }}</td>
                        <td class="qty">1</td>
                        <td data-price="{{ $order['amount'] }}">{{ number_format($order['amount'],2) }}</td>
                        <td class="text-right total">{{ number_format($order['amount'],2) }}</td>
                    </tr>
                @endforeach

                {{-- Totals below --}}
                @php $colSpan = count($videoOrders) > 0 ? 5 : 4; @endphp
                <tr>
                    <td colspan="{{ $colSpan }}" class="text-right">Subtotal</td>
                    <td class="text-right ab-total">0.00</td>
                </tr>
                <tr>
                    <td colspan="{{ $colSpan }}" class="text-right">Verified Ad account fee & tax</td>
                    <td class="text-right" id="tax-amount">0.00</td>
                </tr>
                <tr>
                    <td colspan="{{ $colSpan }}" class="text-right">Boosting service charge</td>
                    <td class="text-right" id="service-amount">0.00</td>
                </tr>
                @php
                    $discountCount  = collect($boostingOrders)->where('service',0)->count();
                    $discountAmount = $discountCount * 1000;
                @endphp
                @if($discountCount > 0)
                    <tr class="text-danger">
                        <td colspan="{{ $colSpan }}" class="border text-right">Discount</td>
                        <td class="border text-right">
                            <input type="text" class="form-control" value="{{ number_format($discountAmount,2) }}">
                        </td>
                    </tr>
                @endif
                <tr class="font-weight-bold">
                    <td colspan="{{ $colSpan }}" class="text-right">Total Due</td>
                    <td class="text-right">Rs.<span class="tt-due"></span></td>
                </tr>
            </tbody>
        </table>

        <!-- Footer Note & Bank Details (unchanged) -->
        <div class="text-muted small border-top pt-3 mt-3">
            <p>{{ $type == 1 ? 'Quotation valid for 30 days.' : 'Payment is due within 30 days of receipt.' }}</p>
        </div>
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

    <!-- Actions -->
    <div class="text-center d-print-none mt-4">
        <button type="submit" class="btn btn-info mr-2">
            <i class="fas fa-check mr-1"></i> Submit
        </button>
    </form>
        <button onclick="window.print()" class="btn btn-primary" type="button">
            <i class="fas fa-print mr-1"></i> Print
        </button>
    </div>

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

            .bank-details-table {
                font-size: 9pt !important;
            }
            input {
                background: transparent !important;
                border: none !important;
                box-shadow: none !important;
                appearance: none !important;
                -webkit-appearance: none !important;
                -moz-appearance: none !important;
            }
            
            @page {
                size: auto;
                margin: 5mm;
            }
        }
    </style>

<script>
    // existing invoice calculator
    function updateInvoice() {
        let subtotal     = 0, totalTax = 0, totalService = 0;

        // Sum line totals = unit price × qty
        document.querySelectorAll('tr.detail-row').forEach(row => {
            const price = parseFloat(row.querySelector('[data-price]').dataset.price) || 0;
            const qty   = parseInt(row.querySelector('.qty').textContent) || 0;
            subtotal += price * qty;
        });

        @foreach($boostingOrders as $o)
            totalTax     += {{ $o['tax']     ?? 0 }};
            totalService += {{ $o['service'] ?? 0 }};
        @endforeach

        document.querySelector('.ab-total').textContent      = subtotal.toFixed(2);
        document.querySelector('#tax-amount').textContent    = totalTax.toFixed(2);
        document.querySelector('#service-amount').textContent = totalService.toFixed(2);

        const totalDue = subtotal + totalTax + totalService;
        document.querySelector('.tt-due').textContent        = totalDue.toFixed(2);
        document.getElementById("total_due").value           = totalDue.toFixed(2);
    }

    document.addEventListener("DOMContentLoaded", () => {
        // group duplicates front-end
        const tbody    = document.querySelector("table.table tbody");
        const hasTime  = {{ count($videoOrders)>0 ? 'true' : 'false' }};
        const detailRows = Array.from(tbody.querySelectorAll("tr.detail-row"));
        const map      = new Map();

        detailRows.forEach(row => {
            const cells = row.children;
            const type  = cells[0].textContent.trim();
            const desc  = cells[1].textContent.trim();
            const time  = hasTime ? cells[2].textContent.trim() : "";
            const priceIdx = hasTime ? 4 : 3;
            const price = parseFloat(cells[priceIdx].dataset.price);
            const key   = [type, desc, time, price].join("|");

            if (!map.has(key)) {
                map.set(key, { row: row.cloneNode(true), count: 1 });
            } else {
                map.get(key).count++;
            }
        });

        // remove old detail rows
        detailRows.forEach(r => r.remove());

        // re-append aggregated rows
        const subtotalRow = tbody.querySelector(".ab-total").closest("tr");
        for (let { row, count } of map.values()) {
            row.querySelector(".qty").textContent = count;
            const pricCell = row.querySelector("[data-price]");
            const unit     = parseFloat(pricCell.dataset.price);
            row.querySelector(".total").textContent = (unit * count).toFixed(2);
            tbody.insertBefore(row, subtotalRow);
        }

        // now recalc totals
        updateInvoice();
    });
</script>
@endsection
