<!-- Refunds Modal -->
<div class="modal fade" id="refundorders" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="refundLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <form action="/refund/orders" method="post">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="refundLabel">Refunds</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          {{-- 1) Invoice selector --}}
          <div class="mb-3">
            <label for="invro" class="form-label">Invoice Number</label>
            <select id="invro" class="form-select select2" name="inv" required>
              <option value="" disabled selected>Search Invoice…</option>
              @foreach ($invoices as $invoice)
            @if (!Str::startsWith($invoice->inv, 'OR'))
          <option value="{{ $invoice->inv }}">
          {{ $invoice->inv }} – {{ $invoice->contact }}
          </option>
        @endif
        @endforeach
            </select>
          </div>

          {{-- 2) Container for dynamic checkboxes and reason fields --}}
          <div id="order-checkboxes" class="mb-3">
            <small class="text-muted">Select orders for refund…</small>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit Refund</button>
        </div>
      </form>

    </div>
  </div>
</div>
<!-- Script section -->
<script>
  const orders = @json($orders->items());
  // orders must include id and invoice

  $(function () {
    // Initialize Select2 when modal opens
    $('#refundorders').on('shown.bs.modal', function () {
      $('#invro').select2({
        dropdownParent: $('#refundorders'),
        placeholder: "Search Invoice…",
        allowClear: true,
        width: '100%'
      });
    });

    // When invoice changes, rebuild the checkbox list
    $('#invro').on('change', function () {
      const inv = $(this).val();
      const container = $('#order-checkboxes');
      container.empty();

      if (!inv) {
        return container.append('<p class="text-muted">No invoice selected.</p>');
      }

      $.getJSON('/orders/by-invoice', { invoice: inv }, function (matches) {
        if (!matches.length) {
          return container.append(
            '<p class="text-danger">No orders found for invoice ' + inv + '.</p>'
          );
        }

        matches.forEach(o => {
          const id = o.id;
          container.append(`
        <div class="mb-2 border p-2 rounded">
          <div class="form-check">
            <input class="form-check-input refund-checkbox"
                   type="checkbox"
                   name="orders[${id}][order_id]"
                   value="${id}"
                   id="order_${id}">
            <label class="form-check-label" for="order_${id}">
              Order #${id}
            </label>
          </div>
          <input type="text"
                 class="form-control mt-1 reason-input"
                 name="orders[${id}][reason]"
                 placeholder="Enter reason for refund"
                 disabled>
        </div>
      `);
        });
      });
    });


    // DELEGATED: enable/disable the sibling reason-input when you check/uncheck
    $('#order-checkboxes').on('change', '.refund-checkbox', function () {
      const $reason = $(this)
        .closest('.border')
        .find('.reason-input');

      // enable if checked, otherwise disable
      $reason.prop('disabled', !this.checked);
    });
  });
</script>