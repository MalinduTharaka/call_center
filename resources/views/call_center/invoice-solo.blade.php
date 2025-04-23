@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('order.store.solo') }}">
    @csrf

    {{-- Hidden Inputs --}}
    @foreach($boostingOrders as $index => $order)
        <input type="hidden" name="orders[{{$index}}][order_type]" value="{{ $order['order_type'] }}">
        <input type="hidden" name="orders[{{$index}}][date]" value="{{ $order['date'] }}">
        <input type="hidden" name="orders[{{$index}}][name]" value="{{ $order['name'] }}">
        <input type="hidden" name="orders[{{$index}}][contact]" value="{{ $order['contact'] }}">
        <input type="hidden" name="orders[{{$index}}][package_amt]" value="{{ $order['package_amt'] }}">
        <input type="hidden" name="orders[{{$index}}][tax]" value="{{ $order['tax'] }}">
        <input type="hidden" name="orders[{{$index}}][service]" value="{{ $order['service'] }}">
        <input type="hidden" name="orders[{{$index}}][work_type]" value="{{ $order['work_type'] }}">
    @endforeach

    @foreach($designOrders as $index => $order)
        <input type="hidden" name="orders[{{$index}}][order_type]" value="{{ $order['order_type'] }}">
        <input type="hidden" name="orders[{{$index}}][date]" value="{{ $order['date'] }}">
        <input type="hidden" name="orders[{{$index}}][name]" value="{{ $order['name'] }}">
        <input type="hidden" name="orders[{{$index}}][contact]" value="{{ $order['contact'] }}">
        <input type="hidden" name="orders[{{$index}}][amount]" value="{{ $order['amount'] }}">
        <input type="hidden" name="orders[{{$index}}][work_type]" value="{{ $order['work_type'] }}">
    @endforeach

    @foreach($videoOrders as $index => $order)
        <input type="hidden" name="orders[{{$index}}][order_type]" value="{{ $order['order_type'] }}">
        <input type="hidden" name="orders[{{$index}}][date]" value="{{ $order['date'] }}">
        <input type="hidden" name="orders[{{$index}}][name]" value="{{ $order['name'] }}">
        <input type="hidden" name="orders[{{$index}}][contact]" value="{{ $order['contact'] }}">
        <input type="hidden" name="orders[{{$index}}][time]" value="{{ $order['time'] }}">
        <input type="hidden" name="orders[{{$index}}][amount]" value="{{ $order['amount'] }}">
        <input type="hidden" name="orders[{{$index}}][work_type]" value="{{ $order['work_type'] }}">
    @endforeach

    <input type="text" name="inv" value="@if (!empty($boostingOrders))b @elseif (!empty($designOrders))d @else v @endif{{ $inv_id }}" hidden>
    <input type="text" name="inv_no" value="{{ $inv_id }}" hidden>
    <input type="text" name="total" id="total_due" hidden>
    <input type="text" name="contact" id="contact" value="{{ $boostingOrders[0]['contact'] ?? $designOrders[0]['contact'] ?? $videoOrders[0]['contact'] ?? '' }}" hidden>
    <input type="hidden" name="date" value="{{ \Carbon\Carbon::now()->toDateString() }}">
    <input type="text" name="name" id="name" value="{{ $boostingOrders[0]['name'] ?? $designOrders[0]['name'] ?? $videoOrders[0]['name'] ?? '' }}" >
    <input type="hidden" name="type" value="{{ $type }}">

    {{-- Invoice Container --}}
    <div class="container mx-auto p-4 bg-white shadow rounded border font-sans" style="max-width: 800px;">
        {{-- Header --}}
        <div class="row border-bottom pb-4 mb-4">
            <div class="col-8">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset(!empty($videoOrders) ? 'logos/wishwavideo.jpg' : 'logos/wishwaads.jpg') }}" alt="Logo" class="img-fluid mr-3" style="height: 100px;">
                    <div>
                        <h1 class="h3 font-weight-bold text-danger mb-0">
                            {{ !empty($boostingOrders) || !empty($designOrders) ? 'WISHWA ADS' : 'STUDIO WISHWA' }}
                        </h1>
                        <p class="lead text-muted mb-0" style="font-size: 1.1rem;">
                            {{ !empty($boostingOrders) || !empty($designOrders) ? 'Your Marketing Partner' : 'Feel The quality Of Professionals' }}
                        </p>
                    </div>
                </div>
                <div class="pl-2">
                    <p class="small text-muted mb-1"><i class="fas fa-map-marker-alt mr-1"></i>No.151, Ward City Shopping Complex, Gampaha</p>
                    <p class="small text-muted mb-1"><i class="fas fa-phone mr-1"></i>077 1855 1910</p>
                    <p class="small text-muted mb-0"><i class="fas fa-envelope mr-1"></i>info.studiowishwa@gmail.com</p>
                </div>
            </div>
            <div class="col-4 text-right">
                <div class="border-bottom pb-2 mb-2 border-primary">
                    <h2 class="h1 font-weight-bold text-uppercase text-muted mb-0">
                        @if ($type == 0)
                            INVOICE
                        @elseif ($type == 1)
                            QUOTATION
                        @else
                            INVOICE
                        @endif
                    </h2>
                </div>
                <p class="mb-1 small"><strong>ID #:</strong> {{ !empty($boostingOrders) ? 'b' : (!empty($designOrders) ? 'd' : 'v') }}{{ $inv_id }}</p>
                <p class="mb-0 small"><strong>Date:</strong> {{ now()->format('Y-m-d H:i:s') }}</p>
            </div>
        </div>

        {{-- Customer Info --}}
        <div class="pb-3 mb-3 d-flex justify-content-between">
            <div>
                <h2 class="h5 text-secondary">Bill To:</h2>
                <p class="text-dark">{{ $boostingOrders[0]['name'] ?? $designOrders[0]['name'] ?? $videoOrders[0]['name'] ?? '' }}</p>
                <p class="text-muted small">Phone: {{ $boostingOrders[0]['contact'] ?? $designOrders[0]['contact'] ?? $videoOrders[0]['contact'] ?? '' }}</p>
            </div>
        </div>

        {{-- Table --}}
        <table class="table table-bordered mb-5">
            <thead class="thead-light">
                <tr>
                    <th>Item</th>
                    <th>Description</th>
                    <th>Time</th>
                    <th>Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($boostingOrders as $order)
                    <tr>
                        <td>Boosting</td>
                        @foreach ($work_types as $work_type)
                            @if ($work_type->id == $order['work_type'])
                                <td>{{ $work_type->name }}</td>
                            @endif
                        @endforeach
                        <td data-price="{{ $order['package_amt'] }}">{{ number_format($order['package_amt'], 2) }}</td>
                        <td class="text-right total">{{ number_format($order['package_amt'], 2) }}</td>
                    </tr>
                @endforeach
        
                @foreach($designOrders as $order)
                    <tr>
                        <td>Design</td>
                        @foreach ($work_types as $work_type)
                            @if ($work_type->id == $order['work_type'])
                                <td>{{ $work_type->name }}</td>
                            @endif
                        @endforeach
                        <td data-price="{{ $order['amount'] }}">{{ number_format($order['amount'], 2) }}</td>
                        <td class="text-right total">{{ number_format($order['amount'], 2) }}</td>
                    </tr>
                @endforeach
        
                @foreach($videoOrders as $order)
                    <tr>
                        <td>Video</td>
                        @foreach ($work_types as $work_type)
                            @if ($work_type->id == $order['work_type'])
                                <td>{{ $work_type->name }}</td>
                            @endif
                        @endforeach
                        <td class="border" data-time="{{ $order['time'] }}">{{ $order['time'] }}</td>
                        <td data-price="{{ $order['amount'] }}">{{ number_format($order['amount'], 2) }}</td>
                        <td class="text-right total">{{ number_format($order['amount'], 2) }}</td>
                    </tr>
                @endforeach
        
                <tr>
                    <td colspan="4" class="text-right">Subtotal</td>
                    <td class="text-right ab-total">0.00</td>
                </tr>
        
                @if (!empty($boostingOrders))
                    <tr>
                        <td colspan="4" class="text-right">Tax</td>
                        <td class="text-right" id="tax-amount">{{ number_format(array_sum(array_column($boostingOrders, 'tax')), 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">Service</td>
                        <td class="text-right" id="service-amount">{{ number_format(array_sum(array_column($boostingOrders, 'service')), 2) }}</td>
                    </tr>
                @endif
        
                <tr class="font-weight-bold">
                    <td colspan="4" class="text-right">Total Due</td>
                    <td class="text-right">Rs.<span class="tt-due"></span></td>
                </tr>
            </tbody>
        </table>
        
        @if ($type == 0)
            <p class="text-muted small">Payment is due within 30 days.</p>
        @elseif ($type == 1)
            <p class="text-muted small">quotation is due within 30 days.</p>
        @else
            <p class="text-muted small">Payment is due within 30 days.</p>
        @endif
        
    </div>

    <div class="text-center d-print-none mt-4">
        <button onclick="window.print()" class="btn btn-primary mr-2">
            <i class="fas fa-print mr-1"></i> Print
        </button>
        <button type="submit" class="btn btn-info">Submit</button>
        <button id="download-pdf" class="btn btn-success">Download PDF</button>
    </div>
</form>

{{-- Print Styling --}}
<style>
    @media print {
        .d-print-none { display: none !important; }
        .table thead th { background-color: #f8f9fa !important; }
        body { padding: 20px; }
    }
</style>

{{-- JS --}}
<script>
    function parseNumber(value) {
        return parseFloat(value.replace(/,/g, '')) || 0;
    }

    function updateInvoice() {
        let subtotal = 0;
        let totalTax = 0;
        let totalService = 0;

        document.querySelectorAll('[data-price]').forEach(cell => {
            subtotal += parseNumber(cell.dataset.price);
        });

        totalTax = parseNumber(document.getElementById('tax-amount')?.textContent || "0");
        totalService = parseNumber(document.getElementById('service-amount')?.textContent || "0");

        document.querySelector('.ab-total').textContent = subtotal.toFixed(2);
        const finalTotal = subtotal + totalTax + totalService;
        document.querySelector('.tt-due').textContent = finalTotal.toFixed(2);
        document.getElementById("total_due").value = finalTotal.toFixed(2);
    }

    document.addEventListener("DOMContentLoaded", updateInvoice);
</script>

{{-- PDF Libraries --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
    document.getElementById("download-pdf").addEventListener("click", function () {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF("p", "mm", "a4");
        const container = document.querySelector(".container");

        html2canvas(container, { scale: 2 }).then(canvas => {
            const imgData = canvas.toDataURL("image/png");
            const imgWidth = 210;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;
            pdf.addImage(imgData, "PNG", 0, 0, imgWidth, imgHeight);
            pdf.save("invoice.pdf");
        });
    });
</script>
@endsection
