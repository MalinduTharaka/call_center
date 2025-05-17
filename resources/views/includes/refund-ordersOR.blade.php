<!-- Refunds Modal -->
<div class="modal fade" id="refundordersOR" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="refundLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="/refund/orders/OR" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="refundLabel">Refunds Other Orders</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {{-- 1) Invoice selector --}}
                    <div class="mb-3">
                        <label for="invro" class="form-label">Invoice Number</label>
                        <select id="invOR" class="form-select select2" name="inv" required>
                            <option value="" disabled selected>Search Invoice…</option>
                            @foreach ($invoices as $invoice)
                            @if (Str::startsWith($invoice->inv, 'OR'))
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
    const orders = @json($other_orders); // orders must include id and invoice

    $(function () {
        $('#refundordersOR').on('shown.bs.modal', function () {
            $('#invOR').select2({
                dropdownParent: $('#refundordersOR'),
                placeholder: "Search Invoice…",
                allowClear: true,
                width: '100%'
            });
        });

        $('#invOR').on('change', function () {
            const inv = $(this).val();
            const container = $('#order-checkboxes');
            container.empty();

            if (!inv) {
                container.append('<p class="text-muted">No invoice selected.</p>');
                return;
            }

            const matches = orders.filter(o => o.invoice_id === inv);

            if (matches.length === 0) {
                container.append('<p class="text-danger">No orders found for invoice ' + inv + '.</p>');
                return;
            }

            matches.forEach(o => {
                const id = o.id;
                const html = `
          <div class="mb-2 border p-2 rounded">
            <div class="form-check">
              <input class="form-check-input"
                     type="checkbox"
                     name="orders[${id}][order_id]"
                     value="${id}"
                     id="order_${id}">
              <label class="form-check-label" for="order_${id}">
                Order #${id}
              </label>
            </div>
            <input type="text"
                   class="form-control mt-1"
                   name="orders[${id}][reason]"
                   placeholder="Enter reason for refund">
          </div>`;
                container.append(html);
            });
        });
    });
</script>