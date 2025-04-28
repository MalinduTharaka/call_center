<!-- Serialize all other_orders for frontend use -->
<script>
    window.otherOrders = @json($other_orders);
</script>

<!-- Payment Slips Modal -->
<div class="modal fade" id="otherorderslip" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Payment Slips Other Orders</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/storeor/slip" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    {{-- Invoice selector --}}
                    <div class="mb-3">
                        <label for="invor" class="form-label">Invoice Number</label>
                        <select id="invor" class="form-select select2" name="inv">
                            <option value="" disabled selected>Search Invoice...</option>
                            @foreach ($invoices as $invoice)
                                @if ($invoice->status == 'pending' && $invoice->type == 0 && Str::startsWith($invoice->inv, 'OR'))
                                    @php
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
                            <label for="totalor" class="form-label">Total</label>
                            <input type="text" class="form-control" id="totalor" placeholder="Total" readonly>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="paidor" class="form-label">Paid</label>
                            <input type="text" class="form-control" id="paidor" placeholder="Paid amount display here" readonly>
                        </div>
                    </div>

                    {{-- Bank & Payment type --}}
                    <div class="row mb-2">
                        <div class="col-md-6 mb-2">
                            <label for="bankor" class="form-label">Bank</label>
                            <select id="bankor" class="form-select" name="bank" required>
                                <option value="com">Commercial Bank</option>
                                <option value="boc">BOC</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="payment_typeor" class="form-label">Payment Type</label>
                            <select id="payment_typeor" class="form-select" name="payment_type">
                                <option value="completed" selected>Complete</option>
                                <option value="partial">Advance</option>
                            </select>
                        </div>
                    </div>

                    {{-- Advance payment & Due date containers --}}
                    <div id="advance_sectionor" class="row mb-2" style="display: none;">
                        <label class="form-label">Advance Payment</label>
                        <div id="advance_inputs_containeror" class="row"></div>
                    </div>

                    <div class="row mb-2" id="due_date_divor" style="display: none;">
                        <label class="form-label">Payment Completion Date</label>
                        <select id="due_dateor" class="form-select" name="due_date">
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
                        <label for="slipor" class="form-label">Slip</label>
                        <input type="file" class="form-control" name="slip" id="slipor" required>
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

<!-- Frontend-only JS -->
<script>
$(document).ready(function() {
  // Initialize select2 inside the modal
  $('#otherorderslip').on('shown.bs-modal shown.bs.modal', function () {
    $('#invor').select2({
      dropdownParent: $('#otherorderslip'),
      placeholder: "Search Invoice...",
      allowClear: true,
      width: '100%'
    });
  });

  // When an invoice is selected
  $('#invor').on('change', function() {
    // reset to Complete on every invoice change
    $('#payment_typeor').val('completed').trigger('change');

    const $opt    = $(this).find('option:selected');
    const inv     = $opt.val();
    const total   = $opt.data('total')   || 0;
    const paid    = $opt.data('paid')    || 0;
    const $cont   = $('#advance_inputs_containeror').empty();

    // Show totals
    $('#totalor').val(total);
    $('#paidor').val(paid);

    // Populate advance inputs (hidden by default)
    const matches = window.otherOrders.filter(o => o.invoice_id == inv);
    matches.forEach((o, i) => {
      const workType = o.work_type || `Order ${i+1}`;
      const advance  = o.advance     || '';
      const html = `
        <div class="col-md-6 mb-2">
          <label class="form-label">Advance for ${workType}</label>
          <input 
            type="text" 
            name="advance[${i}]" 
            class="form-control" 
            value="${advance}"
          >
        </div>
      `;
      $cont.append(html);
    });
  });

  // Toggle advance fields & due-date based on payment type
  $('#payment_typeor').on('change', function() {
    const isPartial = $(this).val() === 'partial';
    $('#due_date_divor')[isPartial ? 'show' : 'hide']();
    $('#advance_sectionor')[isPartial ? 'show' : 'hide']();
    if (!isPartial) {
      $('#advance_inputs_containeror').empty();
    }
  });

  // On modal open, ensure correct initial state
  $('#otherorderslip').on('show.bs-modal show.bs.modal', function() {
    $('#payment_typeor').trigger('change');
  });
});
</script>