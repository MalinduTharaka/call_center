<div class="modal fade" id="otherorder" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Other Order</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/other_invoice" method="post">
            @csrf
  
            <div class="form-check form-switch mb-3">
              <input type="hidden" name="type" value="0">
              <input type="checkbox" class="form-check-input" id="customSwitch1" name="type" value="1">
              <label class="form-check-label" for="customSwitch1">Turn on to create quotation</label>
            </div>
  
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row g-2">
                      <div class="mb-3 col-md-6 all">
                        <label for="inputEmail4" class="form-label">Name / Company</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name / Company">
                      </div>
                      <div class="mb-3 col-md-6">
                        <label for="Contact" class="form-label">Contact</label>
                        <input type="text" class="form-control" name="contact" id="contact" placeholder="Contact" required>
                      </div>
                    </div>
  
                    <hr>
  
                    <!-- Container for dynamic order items -->
                    <div id="orders-container">
                      <div class="order-item mb-3">
                        <div class="row g-2 align-items-end">
                          <div class="col-md-4">
                            <label class="form-label">Work Type</label>
                            <input type="text" class="form-control" name="work_type[]" placeholder="Work Type" required>
                          </div>
                          <div class="col-md-3">
                            <label class="form-label">Amount</label>
                            <input type="number" step="0.01" class="form-control" name="amount[]" placeholder="Amount" required>
                          </div>
                          <div class="col-md-5">
                            <label class="form-label">Note</label>
                            <input type="text" class="form-control" name="note[]" placeholder="Note">
                          </div>
                          <div class="col-md-1 text-end">
                            <!-- Remove button, hidden on first item -->
                            <button type="button" class="btn btn-danger btn-sm remove-order" style="display: none;">&minus;</button>
                          </div>
                        </div>
                      </div>
                    </div>
  
                    <!-- Add-order button -->
                    <div class="text-end">
                      <button type="button" class="btn btn-success btn-sm" id="add-order-btn">&plus;</button>
                    </div>
  
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Place Order</button>
        </div>
          </form>
      </div>
    </div>
  </div>
  
  <!-- Script for dynamic addition/removal -->
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('orders-container');
    const addBtn = document.getElementById('add-order-btn');
  
    addBtn.addEventListener('click', () => {
      // Clone the first order-item
      const firstItem = container.querySelector('.order-item');
      const newItem = firstItem.cloneNode(true);
  
      // Clear inputs
      newItem.querySelectorAll('input').forEach(input => input.value = '');
  
      // Show remove button on cloned item
      const removeBtn = newItem.querySelector('.remove-order');
      removeBtn.style.display = 'block';
      removeBtn.addEventListener('click', () => newItem.remove());
  
      container.appendChild(newItem);
    });
  
    // If user wants to remove initial items after adding clones
    container.querySelectorAll('.remove-order').forEach(btn => {
      btn.addEventListener('click', function() {
        this.closest('.order-item').remove();
      });
    });
  });
  </script>