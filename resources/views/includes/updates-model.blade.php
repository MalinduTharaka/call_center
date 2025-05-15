<!-- Modal -->
<div class="modal fade" id="updateSheetModal" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="updateSheetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateSheetModalLabel">Updates</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <form action="/admin/update/sheet/add" method="post">
            @csrf
            <div class="modal-body">
                <!-- input field to hold the order ID -->
                <div class="mb-3">
                    <label for="order-id-input" class="form-label">Order ID</label>
                    <input type="text" class="form-control" id="order-id-input" name="order_id" readonly>
                </div>
                <div class="mb-3">
                    <label for="order-id-update" class="form-label">Update</label>
                    <textarea class="form-control" id="order-id-update" name="update" rows="4" required></textarea>
                </div>

                <!-- you can put other form fields here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
        </div>
    </div>
</div>