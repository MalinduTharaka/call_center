<div class="modal fade" id="updatesheetadd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="updatesheetadd" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatesheetadd">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> <!-- end modal header -->
            <form action="/update/sheet/manual/add" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="order_id" class="form-label">Order Id</label>
                            <input type="text" class="form-control" id="order_id" name="order_id">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="invoice_id" class="form-label">Invoice Id</label>
                            <input type="text" class="form-control" id="invoice_id" name="invoice_id">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="contact" class="form-label">Contact</label>
                            <input type="text" class="form-control" id="contact" name="contact" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="contact" class="form-label">Work Type</label>
                            <select name="work_type" class="form-select">
                                <option value="" selected>Select Work Type</option>
                                @foreach($work_types as $wt)
                                    <option value="{{ $wt->id }}">
                                        {{ $wt->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="contact" class="form-label">Page</label>
                            <select name="page" class="form-select">
                                <option value="" selected>Select Page</option>
                                <option value="new">new</option>
                                <option value="our">our</option>
                                <option value="existing">existing</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="contact" class="form-label">Work Status</label>
                            <select name="work_status" class="form-select">
                                @foreach(['pending', 'done', 'send to customer', 'send to designer', 'error'] as $status)
                                    <option value="{{ $status }}">
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="contact" class="form-label">Advertiser</label>
                            <select name="advertiser_id" class="form-select">
                                <option value="" selected>Select Advertisers</option>
                                @foreach($users as $user)
                                    @if(in_array($user->role, ['adv', 'admin']))
                                        <option value="{{ $user->id }}">
                                            {{ $user->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="contact" class="form-label">Add Link</label>
                        <input type="url" name="add_acc_id" id="add_acc_id" class="form-control"
                            oninvalid="this.setCustomValidity('Please enter a valid URL')"
                            oninput="this.setCustomValidity('')" />

                    </div>
                    <div class="mb-3">
                        <label for="sheet_description" class="form-label">Update</label>
                        <textarea class="form-control" id="update" name="update" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div> <!-- end modal footer -->
            </form>
        </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
</div> <!-- end modal-->