<div class="modal fade" id="deleteorderslip" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete Order Slip</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/delete/slip/orders" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    {{-- Invoice selector --}}
                    <div class="mb-3">
                        <label for="invop" class="form-label">Invoice Number</label>
                        <select id="invopdeleteo" class="form-select select2" name="inv">
                            <option value="" disabled selected>Search Invoice...</option>
                            @foreach ($invoices as $invoice)
                                @if ($invoice->status == 'pending' && $invoice->type == 0 && !Str::startsWith($invoice->inv, 'OR'))
                                    @php
                                        // Gather just the fields we need for each order on this invoice
                                        $orderDetails = $orders
                                            ->where('invoice', $invoice->inv)
                                            ->map(fn($o) => [
                                                'type'        => $o->order_type,
                                                'package_amt' => $o->package_amt,
                                                'tax'         => $o->tax,
                                                'service'     => $o->service,
                                                'amount'      => $o->amount,
                                            ])
                                            ->values();
                                    @endphp
                                    <option 
                                        value="{{ $invoice->inv }}"
                                        data-total="{{ $invoice->total }}"
                                        data-paid="{{ $invoice->amt1 + $invoice->amt2 + $invoice->amt3 }}"
                                        data-order-details='@json($orderDetails)'>
                                        {{ $invoice->inv }} – {{ $invoice->contact }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize select2 inside the modal
    $('#deleteorderslip').on('shown.bs.modal', function () {
        $('#invopdeleteo').select2({
            dropdownParent: $('#deleteorderslip'),
            placeholder: "Search Invoice...",
            allowClear: true,
            width: '100%'
        });
    });

})
</script>
