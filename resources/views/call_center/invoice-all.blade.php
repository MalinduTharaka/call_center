@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('order.store.all') }}">
    @csrf

    <!-- Hidden Inputs -->
    @php $counter = 0; @endphp

    @foreach($boostingOrders as $order)
        <input type="hidden" name="orders[{{ $counter }}][order_type]" value="{{ $order['order_type'] }}">
        <input type="hidden" name="orders[{{ $counter }}][package_amt]"  value="{{ $order['package_amt'] }}">
        <input type="hidden" name="orders[{{ $counter }}][tax]"          value="{{ $order['tax'] }}">
        <input type="hidden" name="orders[{{ $counter }}][service]"      value="{{ $order['service'] }}">
        <input type="hidden" name="orders[{{ $counter }}][work_type]"    value="{{ $order['work_type'] }}">
        @php $counter++; @endphp
    @endforeach

    @foreach($designOrders as $order)
        <input type="hidden" name="orders[{{ $counter }}][order_type]" value="{{ $order['order_type'] }}">
        <input type="hidden" name="orders[{{ $counter }}][amount]"      value="{{ $order['amount'] }}">
        <input type="hidden" name="orders[{{ $counter }}][work_type]"   value="{{ $order['work_type'] }}">
        @php $counter++; @endphp
    @endforeach

    @foreach($videoOrders as $order)
        <input type="hidden" name="orders[{{ $counter }}][order_type]" value="{{ $order['order_type'] }}">
        <input type="hidden" name="orders[{{ $counter }}][amount]"      value="{{ $order['amount'] }}">
        <input type="hidden" name="orders[{{ $counter }}][time]"        value="{{ $order['time'] }}">
        <input type="hidden" name="orders[{{ $counter }}][work_type]"   value="{{ $order['work_type'] }}">
        @php $counter++; @endphp
    @endforeach

    <input type="hidden" name="name"
           value="{{ $boostingOrders[0]['name'] ?? $designOrders[0]['name'] ?? $videoOrders[0]['name'] ?? '' }}">
    <input type="hidden" name="contact"
           value="{{ $boostingOrders[0]['contact'] ?? $designOrders[0]['contact'] ?? $videoOrders[0]['contact'] ?? '' }}">
    <input type="hidden" name="date" value="{{ now()->toDateString() }}">
    <input type="hidden" name="inv"  value="bdv{{ $inv_id }}">
    <input type="hidden" name="inv_no"  value="{{ $inv_id }}">
    <input type="hidden" name="total" id="total_due">
    <input type="hidden" name="type"  value="{{ $type }}">

    @php
        $boostGroups = collect($boostingOrders)
            ->groupBy(fn($o) => $o['work_type'].'|'.$o['package_amt'])
            ->map(fn($grp) => (object)[
                'work_type'=> $grp[0]['work_type'],
                'unit_price'=> $grp[0]['package_amt'],
                'tax'=> $grp->sum('tax'),
                'service'=> $grp->sum('service'),
                'count'=> $grp->count(),
            ]);
        $designGroups = collect($designOrders)
            ->groupBy(fn($o) => $o['work_type'].'|'.$o['amount'])
            ->map(fn($grp) => (object)[
                'work_type'=> $grp[0]['work_type'],
                'unit_price'=> $grp[0]['amount'],
                'count'=> $grp->count(),
            ]);
        $videoGroups = collect($videoOrders)
            ->groupBy(fn($o) => $o['work_type'].'|'.$o['amount'].'|'.$o['time'])
            ->map(fn($grp) => (object)[
                'work_type'=> $grp[0]['work_type'],
                'unit_price'=> $grp[0]['amount'],
                'time'=> $grp[0]['time'],
                'count'=> $grp->count(),
            ]);

        $totalTax     = $boostGroups->sum('tax');
        $totalService = $boostGroups->sum('service');
        $hasVideo     = $videoGroups->isNotEmpty();
        $colSpan      = $hasVideo ? 5 : 4;
    @endphp

    <div class="container mx-auto p-4 bg-white shadow rounded border font-sans" style="max-width:800px;">

        <!-- Header -->
        <div class="border-bottom pb-4 mb-2">
            <div class="row">
                <div class="col-md-8">
                    <div class="row align-items-center">
                        <div class="col-sm-12 mb-4 mb-sm-0">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('logos/WishwaAdsStudio.png') }}"
                                     alt="Wishwa Ads Logo"
                                     class="img-fluid mr-3"
                                     style="max-height:80px;">
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
                            077 1855 1910
                        </p>
                        <p class="mb-1 small text-muted">
                            <i class="fas fa-envelope mr-1"></i>
                            info.studiowishwa@gmail.com
                        </p>
                    </div>
                </div>

                <div class="col-md-4 mt-4 mt-md-0">
                    <div class="border-bottom pb-2 mb-2 border-primary">
                        <h2 class="h1 font-weight-bold text-uppercase text-muted mb-0">
                            {{ $type==1 ? 'QUOTATION' : 'INVOICE' }}
                        </h2>
                    </div>
                    <div class="text-md-right">
                        <dl class="row mb-0">
                            <dt class="col-sm-6 text-md-right small">ID #:</dt>
                            <dd class="col-sm-6 text-md-left small">bdv{{ $inv_id }}</dd>
                            <dt class="col-sm-6 text-md-right small">Date:</dt>
                            <dd class="col-sm-6 text-md-left small">{{ now()->format('Y-m-d H:i:s') }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bill To -->
        <div class="pb-2 mb-2 d-flex justify-content-between">
            <div>
                <h2 class="h5 font-weight-semibold text-secondary">Bill To:</h2>
                <p class="text-dark">
                    {{ $boostingOrders[0]['name'] ?? $designOrders[0]['name'] ?? $videoOrders[0]['name'] ?? '' }}
                </p>
                <p class="text-muted small">
                    Phone: {{ $boostingOrders[0]['contact'] ?? $designOrders[0]['contact'] ?? $videoOrders[0]['contact'] ?? '' }}
                </p>
            </div>
            <div class="text-right">
                <p class="text-muted small mb-0">Invoice #: bdv{{ $inv_id }}</p>
                <p class="text-muted small mb-0">Date: {{ now()->format('Y-m-d H:i:s') }}</p>
            </div>
        </div>

        <!-- Items Table -->
        <table class="table table-bordered mb-2">
            <thead class="thead-light">
                <tr>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Count</th>
                    @if($hasVideo)<th>Time</th>@endif
                    <th>Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($boostGroups as $item)
                    <tr>
                        <td>Boosting</td>
                        @foreach($work_types as $wt)
                            @if($wt->id==$item->work_type)
                                <td>{{ $wt->name }}</td>
                            @endif
                        @endforeach
                        <td>{{ $item->count }}</td>
                        @if($hasVideo)<td>—</td>@endif
                        <td data-price="{{ $item->unit_price * $item->count }}">
                            {{ number_format($item->unit_price,2) }}
                        </td>
                        <td class="text-right total">
                            {{ number_format($item->unit_price * $item->count,2) }}
                        </td>
                    </tr>
                @endforeach

                @foreach($designGroups as $item)
                    <tr>
                        <td>Design</td>
                        @foreach($work_types as $wt)
                            @if($wt->id==$item->work_type)
                                <td>{{ $wt->name }}</td>
                            @endif
                        @endforeach
                        <td>{{ $item->count }}</td>
                        @if($hasVideo)<td>—</td>@endif
                        <td data-price="{{ $item->unit_price * $item->count }}">
                            {{ number_format($item->unit_price,2) }}
                        </td>
                        <td class="text-right total">
                            {{ number_format($item->unit_price * $item->count,2) }}
                        </td>
                    </tr>
                @endforeach

                @foreach($videoGroups as $item)
                    <tr>
                        <td>Video</td>
                        @foreach($work_types as $wt)
                            @if($wt->id==$item->work_type)
                                <td>{{ $wt->name }}</td>
                            @endif
                        @endforeach
                        <td>{{ $item->count }}</td>
                        <td data-time="{{ $item->time }}">{{ $item->time }}</td>
                        <td data-price="{{ $item->unit_price * $item->count }}">
                            {{ number_format($item->unit_price,2) }}
                        </td>
                        <td class="text-right total">
                            {{ number_format($item->unit_price * $item->count,2) }}
                        </td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="{{ $colSpan }}" class="border text-right">Subtotal</td>
                    <td class="border text-right ab-total">0.00</td>
                </tr>
                @if($totalTax>0)
                    <tr>
                        <td colspan="{{ $colSpan }}" class="border text-right">Verified Ad account fee & tax</td>
                        <td class="border text-right" id="tax-amount">{{ number_format($totalTax,2) }}</td>
                    </tr>
                @endif
                @if($totalService>0)
                    <tr>
                        <td colspan="{{ $colSpan }}" class="border text-right">Boosting service charge</td>
                        <td class="border text-right" id="service-amount">{{ number_format($totalService,2) }}</td>
                    </tr>
                @endif
                @php
                    // Count how many boosting orders have service == 0
                    $discountCount = collect($boostingOrders)
                        ->where('service', 0)
                        ->count();

                    // Each “free” service line becomes a Rs.1,000 discount
                    $discountAmount = $discountCount * 1000;
                @endphp
                @if($discountCount > 0)
                    <tr class="text-danger">
                        <td colspan="{{ $colSpan }}" class="border text-right">
                            Discount ({{ $discountCount }})
                        </td>
                        <td class="border text-right">
                            {{ number_format($discountAmount, 2) }}
                        </td>
                    </tr>
                @endif
            

                <tr class="font-weight-bold">
                    <td colspan="{{ $colSpan }}" class="border text-right">Total Due</td>
                    <td class="border text-right">Rs.<span class="tt-due"></span></td>
                </tr>
            </tbody>
        </table>

        <!-- Footer Note -->
        <div class="text-muted small border-top pt-3 mt-2">
            @if($type==1)
                <p>Quotation valid for 30 days.</p>
            @else
                <p>Payment is due within 30 days of receipt.</p>
            @endif
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
    <div class="d-print-none mt-4 text-center">
        <button type="submit" class="btn btn-info mr-2">
            <i class="fas fa-check mr-1"></i> Submit
        </button>
        <button type="button" onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print mr-1"></i> Print
        </button>
    </div>
</form>

<!-- Print Styles -->
<style>
    @media print {
        body { padding:5mm!important; margin:0!important; font-size:12pt; background:#fff!important; color:#000!important; }
        .container { width:100%!important; max-width:100%!important; padding:0!important; margin:0!important; box-shadow:none!important; border:none!important; }
        .table { width:100%!important; font-size:10pt!important; border-collapse:collapse!important; }
        .table th, .table td { padding:6px!important; border:1px solid #ddd!important; }
        .thead-light th { background:#f8f9fa!important; -webkit-print-color-adjust:exact; print-color-adjust:exact; }
        .d-print-none { display:none!important; }
        img { max-height:70px!important; }
        .row, .d-flex { page-break-inside:avoid!important; }
        .bank-details-table {
                font-size: 9pt !important;
            }
        @page { size:auto; margin:5mm; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', updateInvoice);
    function updateInvoice() {
        let subtotal = 0;
        document.querySelectorAll('[data-price]').forEach(cell => {
            subtotal += parseFloat(cell.dataset.price) || 0;
        });
        const tax     = {{ $totalTax }};
        const service = {{ $totalService }};
        document.querySelector('.ab-total').textContent = subtotal.toFixed(2);
        document.querySelector('.tt-due').textContent = (subtotal + tax + service).toFixed(2);
        document.getElementById('total_due').value = (subtotal + tax + service).toFixed(2);
    }
</script>
@endsection
