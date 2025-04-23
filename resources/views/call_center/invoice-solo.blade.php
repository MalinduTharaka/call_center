@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('order.store.solo') }}">
    @csrf

    @php
        // determine invoice prefix
        $prefix = !empty($boostingOrders)
                  ? 'b'
                  : (!empty($designOrders) ? 'd' : 'v');
    @endphp

    {{-- Hidden Inputs --}}
    @foreach(array_merge($boostingOrders, $designOrders, $videoOrders) as $index => $order)
        @foreach($order as $key => $value)
            <input type="hidden"
                   name="orders[{{ $index }}][{{ $key }}]"
                   value="{{ $value }}">
        @endforeach
    @endforeach

    <input type="hidden" name="inv"     value="{{ $prefix.$inv_id }}">
    <input type="hidden" name="inv_no"  value="{{ $inv_id }}">
    <input type="hidden" name="total"   id="total_due">
    <input type="hidden" name="contact" value="{{ $boostingOrders[0]['contact'] ?? $designOrders[0]['contact'] ?? $videoOrders[0]['contact'] ?? '' }}">
    <input type="hidden" name="date"    value="{{ now()->toDateString() }}">
    <input type="hidden" name="name"    value="{{ $boostingOrders[0]['name'] ?? $designOrders[0]['name'] ?? $videoOrders[0]['name'] ?? '' }}">
    <input type="hidden" name="type"    value="{{ $type }}">

    @php
        $gb = collect($boostingOrders)
            ->groupBy(fn($o) => $o['work_type'].'-'.$o['package_amt']);
        $gd = collect($designOrders)
            ->groupBy(fn($o) => $o['work_type'].'-'.$o['amount']);
        $gv = collect($videoOrders)
            ->groupBy(fn($o) => $o['work_type'].'-'.$o['amount'].'-'.$o['time']);

        $taxTotal     = collect($boostingOrders)->sum('tax');
        $serviceTotal = collect($boostingOrders)->sum('service');
    @endphp

    <div class="container mx-auto p-4 bg-white shadow rounded border font-sans" style="max-width: 800px;">
        <!-- Header Section -->
        <div class="border-bottom pb-4 mb-4">
            <div class="row">
                <!-- Company Info -->
                <div class="col-md-8">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset(!empty($videoOrders)?'logos/wishwavideo.jpg':'logos/wishwaads.jpg') }}" 
                             alt="Logo" class="mr-3" style="max-height: 80px; width: auto;">
                        <div>
                            <h2 class="h5 font-weight-bold text-danger mb-0">
                                {{ (!empty($boostingOrders)||!empty($designOrders))?'WISHWA ADS':'STUDIO WISHWA' }}
                            </h2>
                            <p class="text-muted mb-0 small">
                                {{ (!empty($boostingOrders)||!empty($designOrders))
                                   ? 'Your Marketing Partner'
                                   : 'Feel The Quality Of Professionals'
                                }}
                            </p>
                        </div>
                    </div>
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
                            <dd class="col-sm-6 text-md-left small">{{ $prefix.$inv_id }}</dd>
                            <dt class="col-sm-6 text-md-right small">Date:</dt>
                            <dd class="col-sm-6 text-md-left small">{{ now()->format('Y-m-d H:i:s') }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Details -->
        <div class="pb-3 mb-3 d-flex justify-content-between">
            <div class="mb-3">
                <h2 class="h5 font-weight-semibold text-secondary">Bill To:</h2>
                <p class="text-dark">{{ $boostingOrders[0]['name'] ?? $designOrders[0]['name'] ?? $videoOrders[0]['name'] ?? '' }}</p>
                <p class="text-muted small">Phone: {{ $boostingOrders[0]['contact'] ?? $designOrders[0]['contact'] ?? $videoOrders[0]['contact'] ?? '' }}</p>
            </div>
            <div class="mb-3 text-right">
                <p class="text-muted small mb-0">{{ $type == 1 ? 'Quotation' : 'Invoice' }} #: {{ $prefix.$inv_id }}</p>
                <p class="text-muted small mb-0">Date: {{ now()->format('Y-m-d') }}</p>
            </div>
        </div>

        <!-- Items Table -->
        <table class="table table-bordered mb-5">
            <thead class="thead-light">
                <tr>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gb as $group)
                    @php
                        $o = $group->first();
                        $cnt = $group->count();
                        $desc = $work_types->firstWhere('id',$o['work_type'])->name;
                        $unit = $o['package_amt'];
                        $rowTotal = $unit * $cnt;
                    @endphp
                    <tr>
                        <td>Boosting</td>
                        <td>{{ $desc }}</td>
                        <td data-quantity="{{ $cnt }}">{{ $cnt }}</td>
                        <td data-unit-price="{{ $unit }}">{{ number_format($unit,2) }}</td>
                        <td class="text-right total" data-row-total="{{ $rowTotal }}">
                            {{ number_format($rowTotal,2) }}
                        </td>
                    </tr>
                @endforeach

                @foreach($gd as $group)
                    @php
                        $o = $group->first();
                        $cnt = $group->count();
                        $desc = $work_types->firstWhere('id',$o['work_type'])->name;
                        $unit = $o['amount'];
                        $rowTotal = $unit * $cnt;
                    @endphp
                    <tr>
                        <td>Design</td>
                        <td>{{ $desc }}</td>
                        <td data-quantity="{{ $cnt }}">{{ $cnt }}</td>
                        <td data-unit-price="{{ $unit }}">{{ number_format($unit,2) }}</td>
                        <td class="text-right total" data-row-total="{{ $rowTotal }}">
                            {{ number_format($rowTotal,2) }}
                        </td>
                    </tr>
                @endforeach

                @foreach($gv as $group)
                    @php
                        $o = $group->first();
                        $cnt = $group->count();
                        $desc = $work_types->firstWhere('id',$o['work_type'])->name;
                        $unit = $o['amount'];
                        $rowTotal = $unit * $cnt;
                    @endphp
                    <tr>
                        <td>Video</td>
                        <td>{{ $desc }}</td>
                        <td data-quantity="{{ $cnt }}">{{ $cnt }}</td>
                        <td data-unit-price="{{ $unit }}">{{ number_format($unit,2) }}</td>
                        <td class="text-right total" data-row-total="{{ $rowTotal }}">
                            {{ number_format($rowTotal,2) }}
                        </td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="4" class="text-right">Subtotal</td>
                    <td class="text-right ab-total">0.00</td>
                </tr>

                @if(!empty($boostingOrders))
                    <tr>
                        <td colspan="4" class="text-right">Tax</td>
                        <td class="text-right" id="tax-amount">{{ number_format($taxTotal,2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">Service</td>
                        <td class="text-right" id="service-amount">{{ number_format($serviceTotal,2) }}</td>
                    </tr>
                @endif

                <tr class="font-weight-bold">
                    <td colspan="4" class="text-right">Total Due</td>
                    <td class="text-right">Rs.<span class="tt-due"></span></td>
                </tr>
            </tbody>
        </table>

        <!-- Footer Note -->
        <div class="text-muted small border-top pt-3 mt-3">
            <p>{{ $type == 1 ? 'Quotation valid for 30 days.' : 'Payment is due within 30 days of receipt.' }}</p>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="text-center d-print-none mt-4">
        <button type="submit" class="btn btn-info mr-2">
            <i class="fas fa-check mr-1"></i> Submit
        </button>
        
    </div>
</form>
<button onclick="window.print()" class="btn btn-primary">
    <i class="fas fa-print mr-1"></i> Print
</button>

<!-- Print-specific CSS -->
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

<!-- PDF & Print Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    function parseNumber(v){ return parseFloat(v.replace(/,/g,''))||0; }

    function updateInvoice(){
        let subtotal = 0;
        document.querySelectorAll('[data-row-total]').forEach(td=>{
            subtotal += parseNumber(td.dataset.rowTotal);
        });
        document.querySelector('.ab-total').textContent = subtotal.toFixed(2);

        const tax     = parseNumber(document.getElementById('tax-amount')?.textContent||"0");
        const service = parseNumber(document.getElementById('service-amount')?.textContent||"0");
        const total   = subtotal + tax + service;

        document.querySelector('.tt-due').textContent   = total.toFixed(2);
        document.getElementById('total_due').value      = total.toFixed(2);
    }

    document.addEventListener('DOMContentLoaded', updateInvoice);

    document.getElementById('download-pdf').addEventListener('click', ()=> {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('p','mm','a4');
        html2canvas(document.querySelector('.container'),{scale:2}).then(canvas=>{
            const img = canvas.toDataURL('image/png');
            const w = 210, h = canvas.height * w / canvas.width;
            pdf.addImage(img,'PNG',0,0,w,h);
            pdf.save('{{ ($type == 1 ? 'quotation' : 'invoice') }}_{{ $inv_id }}.pdf');
        });
    });
</script>
@endsection