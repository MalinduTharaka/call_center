<div class="modal fade" id="slipupload" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Payment Slips</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/slip/update" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    {{-- Invoice selector --}}
                    <div class="mb-3">
                        <label for="invop" class="form-label">Invoice Number</label>
                        <select id="invop" class="form-select select2" name="inv">
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
                                        data-order-details='@json($orderDetails)'
                                    >
                                        {{ $invoice->inv }} – {{ $invoice->contact }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    {{-- Totals display --}}
                    <div class="row mb-2">
                        <div class="col-md-6 mb-2">
                            <label for="total" class="form-label">Total</label>
                            <input type="text" class="form-control" id="total" placeholder="Advance" readonly>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="paid" class="form-label">Paid</label>
                            <input type="text" class="form-control" id="paid" placeholder="Paid amount display here" readonly>
                        </div>
                    </div>

                    {{-- Bank & Payment type --}}
                    <div class="row mb-2">
                        <div class="col-md-6 mb-2">
                            <label for="bank" class="form-label">Bank</label>
                            <select id="bank" class="form-select" name="bank">
                                <option value="com">Commercial Bank</option>
                                <option value="boc">BOC</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="payment_type" class="form-label">Payment Type</label>
                            <select id="payment_type" class="form-select" name="payment_type">
                                <option value="completed" selected>Complete</option>
                                <option value="partial">Advance</option>
                            </select>
                        </div>
                    </div>

                    {{-- Dynamic advance inputs will go here --}}
                    <div class="row mb-2">
                        <label class="form-label">Advance Payment</label>
                        <div id="advance_inputs_container" class="row"></div>
                    </div>

                    {{-- Due date for partial --}}
                    <div class="row mb-2" id="due_date_div" style="display: none;">
                        <label class="form-label">Payment Completion Date</label>
                        <select id="due_date" class="form-select" name="due_date">
                            <option value="1">01 Day</option>
                            <option value="2">02 Days</option>
                            <option value="3">03 Days</option>
                            <option value="4">04 Days</option>
                            <option value="5">05 Days</option>
                            <option value="6">06 Days</option>
                            <option value="7">07 Days</option>
                        </select>
                    </div>

                    {{-- File upload --}}
                    <div class="mb-2">
                        <label for="slip" class="form-label">Slip</label>
                        <input type="file" class="form-control" name="slip" id="slip" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize select2 inside the modal
    $('#slipupload').on('shown.bs.modal', function () {
        $('#invop').select2({
            dropdownParent: $('#slipupload'),
            placeholder: "Search Invoice...",
            allowClear: true,
            width: '100%'
        });
    });

    // Build advance inputs given the three arrays
    function generateAdvanceInputs(boostingOrders, designOrders, videoOrders) {
        const container = $('#advance_inputs_container');
        container.empty();

        // Boosting: placeholder = package_amt + tax + service
        boostingOrders.forEach((order, idx) => {
            const total = (
                parseFloat(order.package_amt) +
                parseFloat(order.tax) +
                parseFloat(order.service)
            ).toFixed(2);
            container.append(`
                <div class="col-md-4 mb-2">
                    <label class="form-label">Boosting Payment ${idx+1}</label>
                    <input
                        type="text"
                        class="form-control"
                        name="advanceb[]"
                        placeholder="${total}"
                    >
                </div>
            `);
        });

        // Designs: placeholder = amount
        designOrders.forEach((order, idx) => {
            container.append(`
                <div class="col-md-4 mb-2">
                    <label class="form-label">Design Payment ${idx+1}</label>
                    <input
                        type="text"
                        class="form-control"
                        name="advanced[]"
                        placeholder="${parseFloat(order.amount).toFixed(2)}"
                    >
                </div>
            `);
        });

        // Video: placeholder = amount
        videoOrders.forEach((order, idx) => {
            container.append(`
                <div class="col-md-4 mb-2">
                    <label class="form-label">Video Payment ${idx+1}</label>
                    <input
                        type="text"
                        class="form-control"
                        name="advancev[]"
                        placeholder="${parseFloat(order.amount).toFixed(2)}"
                    >
                </div>
            `);
        });
    }

    // Whenever an invoice is picked: load totals + reset inputs
    $('#invop').on('change', function() {
        const sel    = $(this).find('option:selected');
        const total  = sel.data('total');
        const paid   = sel.data('paid');
        const details = sel.data('orderDetails') || [];

        // segregate by type
        const boosting = details.filter(o => o.type === 'boosting');
        const designs  = details.filter(o => o.type === 'designs');
        const videos   = details.filter(o => o.type === 'video');

        $('#total').val(total);
        $('#paid').val(paid);

        // reset payment type to Completed so we always regenerate cleanly
        $('#payment_type').val('completed').trigger('change');

        if ($('#payment_type').val() === 'partial') {
            generateAdvanceInputs(boosting, designs, videos);
            $('#due_date_div').show();
        } else {
            $('#advance_inputs_container').empty();
            $('#due_date_div').hide();
        }
    });

    // When payment type toggles between completed/partial
    $('#payment_type').on('change', function() {
        const type = $(this).val();
        const sel  = $('#invop').find('option:selected');
        const details = sel.data('orderDetails') || [];

        const boosting = details.filter(o => o.type === 'boosting');
        const designs  = details.filter(o => o.type === 'designs');
        const videos   = details.filter(o => o.type === 'video');

        if (type === 'partial' && sel.val()) {
            generateAdvanceInputs(boosting, designs, videos);
            $('#due_date_div').show();
        } else {
            $('#advance_inputs_container').empty();
            $('#due_date_div').hide();
        }
    });
});
</script>
