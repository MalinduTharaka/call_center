@extends('layouts.app')
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert"
            style="color: #155724; background-color: #d4edda; border-color: #c3e6cb;">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert"
            style="color: #721c24; background-color: #f8d7da; border-color: #f5c6cb;">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <script>
        setTimeout(function () {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 1000); // Auto-dismiss after 1 seconds
    </script>
    <style>
        .pay-edit-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1 1 0;
            border-radius: 12px;
            padding: 1rem;
            font-size: 1.1rem;
            font-weight: 500;
            cursor: pointer;
            text-align: center;
            transition: transform .15s ease;
            margin: .5rem;
            position: relative;
            border: none;
        }

        .pay-edit-btn:hover {
            transform: translateY(-2px);
        }

        .pay-edit-btn.light {
            background-color: #101859;
            color: #fff;
        }

        .pay-edit-btn.dark {
            background-color: #101859;
            color: #fff;
        }

        .card-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1 1 0;
            min-height: 50px;
            border-radius: 12px;
            padding: 1rem;
            font-size: 1.1rem;
            font-weight: 500;
            cursor: pointer;
            text-align: center;
            transition: transform .15s ease;
            margin: .5rem;
            position: relative;
            border: none;
        }

        .card-btn:hover {
            transform: translateY(-2px);
        }

        /* light style (like your left example) */
        .card-btn.light {
            background-color: #101859;
            color: #fff;
        }

        .card-btn.light .icon {
            position: absolute;
            top: 12px;
            right: 12px;
            font-size: 1.2rem;
        }

        /* dark style (like your right example) */
        .card-btn.dark {
            background-color: #101859;
            color: #fff;
        }

        .card-btn.dark .icon {
            font-size: 1.5rem;
            margin-right: 8px;
        }
    </style>
    <style>
        /* style.css */
        tr[data-add-acc="1"] {
            background-color: #f8d7da;
        }

        tr[data-add-acc="2"] {
            background-color: rgb(146, 217, 247);
        }

        tr[data-add-acc="3"] {
            background-color: rgb(245, 247, 129);
        }
    </style>

    <button type="button" class="card-btn light" data-bs-toggle="modal" data-bs-target="#refundorders">
        Refund Orders
    </button>

    @include('includes.refund-orders')

    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title mb-0"> Orders</h4>
                </div>
                <div class="card-body">
                    <div id="basicwizard">

                        <ul class="nav nav-tabs nav-justified nav-bordered mb-3">
                            <li class="nav-item">
                                <a href="#basictab1" class="nav-link rounded-0 py-2">
                                    <span class="d-none d-sm-inline">Boosting</span>
                                    <span class="badge bg-secondary ms-1 fs-4" id="boosting-count">0</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#basictab2" class="nav-link rounded-0 py-2">
                                    <span class="d-none d-sm-inline">Designs</span>
                                    <span class="badge bg-secondary ms-1 fs-4" id="designs-count">0</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#basictab3" class="nav-link rounded-0 py-2">
                                    <span class="d-none d-sm-inline">Video</span>
                                    <span class="badge bg-secondary ms-1 fs-4" id="video-count">0</span>
                                </a>
                            </li>
                        </ul>


                        <div class="tab-content b-0 mb-0">
                            <div class="tab-pane tab-panebtn" id="basictab1" style="display: block;">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="col-12 mb-3">
                                            <div class="input-group">
                                                <form method="GET" action="{{ route('admin.orders') }}" class="row g-3">
                                                    <div class="col-md-2">
                                                        <input type="text" name="id" class="form-control"
                                                            placeholder="Order ID" value="{{ request('id') }}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" name="contact" class="form-control"
                                                            placeholder="Contact" value="{{ request('contact') }}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" name="name" class="form-control"
                                                            placeholder="Name" value="{{ request('name') }}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" name="invoice" class="form-control"
                                                            placeholder="Invoice" value="{{ request('invoice') }}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <select name="payment_status" class="form-select">
                                                            <option value="">Payment Status</option>
                                                            <option value="done"
                                                                @selected(request('payment_status') == 'done')>Done</option>
                                                            <option value="partial"
                                                                @selected(request('payment_status') == 'partial')>Partial
                                                            </option>
                                                            <option value="pending"
                                                                @selected(request('payment_status') == 'pending')>Pending
                                                            </option>
                                                            <option value="rejected"
                                                                @selected(request('payment_status') == 'rejected')>Rejected
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <select name="work_status" class="form-select">
                                                            <option value="">Work Status</option>
                                                            <option value="done" @selected(request('work_status') == 'done')>
                                                                Done</option>
                                                            <option value="pending"
                                                                @selected(request('work_status') == 'pending')>Pending
                                                            </option>
                                                            <option value="send to customer"
                                                                @selected(request('work_status') == 'send to customer')>Send
                                                                to Customer</option>
                                                            <option value="send to designer"
                                                                @selected(request('work_status') == 'send to designer')>Send
                                                                to Designer</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <select name="work_type" class="form-select">
                                                            <option value="">Work Type</option>
                                                            @foreach ($work_types as $type)
                                                                @if ($type->order_type == 'boosting')
                                                                    <option value="{{ $type->id }}"
                                                                        @selected(request('work_type') == $type->id)>{{ $type->name }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <select name="old_new" class="form-select">
                                                            <option value="">Old/New</option>
                                                            <option value="old" @selected(request('old_new') == 'old')>Old
                                                            </option>
                                                            <option value="new" @selected(request('old_new') == 'new')>New
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 d-flex align-items-end">
                                                        <button class="btn btn-primary me-2" type="submit">Search</button>
                                                        <a href="{{ route('admin.orders') }}"
                                                            class="btn btn-secondary">Clear</a>
                                                    </div>

                                                </form>

                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table
                                                class="table table-hover table-centered table-bordered border-primary mb-0">
                                                <thead class="table-dark table-bordered border-primary">
                                                    <tr>
                                                        <th>Priority</th>
                                                        <th>ID</th>
                                                        <th>Slip <br /> Upload <br /> Date</th>
                                                        <th>CC</th>
                                                        <th>CRO</th>
                                                        <th>C/E</th>
                                                        <th>Invoice</th>
                                                        <th>Name<br />Company</th>
                                                        <th>O/N</th>
                                                        <th>Contact</th>
                                                        <th>Page</th>
                                                        <th>Work<br />Status</th>
                                                        <th>Payment</th>
                                                        <th>Cash</th>
                                                        <th>Advertiser</th>
                                                        <th>Work<br />Type</th>
                                                        <th>Full</th>
                                                        <th>FB Fee</th>
                                                        <th>Service</th>
                                                        <th>Tax</th>
                                                        <th>Available Fee</th>
                                                        <th>Advance</th>
                                                        <th>Details</th>
                                                        <th>Add<br />Link</th>
                                                        <th>slip</th>
                                                        <th>Updates</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @include('admin.partials.ad-boosting-orders')
                                                </tbody>
                                            </table>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            </div>

                            @include('includes.updates-model')
                            {{-- <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const modal = document.getElementById('viewSlipModal');
                                    const slipContent = document.getElementById('slipContent');

                                    modal.addEventListener('show.bs.modal', function (event) {
                                        const button = event.relatedTarget;
                                        const invoice = button.getAttribute('data-invoice');

                                        slipContent.innerHTML = `
                                                                                            <div class="text-center">
                                                                                                <div class="spinner-border" role="status">
                                                                                                    <span class="visually-hidden">Loading...</span>
                                                                                                </div>
                                                                                            </div>`;

                                        fetch(`/orders/get-slips/${invoice}`)
                                            .then(response => response.json())
                                            .then(data => {
                                                if (data.length === 0) {
                                                    slipContent.innerHTML = '<p>No slips uploaded for this order.</p>';
                                                    return;
                                                }

                                                let content = '';
                                                data.forEach(slip => {
                                                    content += `
                                                                                                        <div class="mb-3">
                                                                                                            <p><strong>Bank Name:</strong> ${slip.bank}</p>
                                                                                                            ${getSlipContent(slip)}
                                                                                                        </div>`;
                                                });
                                                slipContent.innerHTML = content;
                                            })
                                            .catch(error => {
                                                slipContent.innerHTML = '<p>Error loading slips. Please try again.</p>';
                                                console.error('Error:', error);
                                            });
                                    });

                                    function getSlipContent(slip) {
                                        const extension = slip.type.toLowerCase();
                                        if (['jpg', 'jpeg', 'png', 'gif'].includes(extension)) {
                                            return `<a href="${slip.path}" target="_blank">
                                                                                                        <img src="${slip.path}" alt="Slip Image" 
                                                                                                             class="img-fluid rounded" 
                                                                                                             style="width: 300px; height: 200px;">
                                                                                                    </a>`;
                                        }
                                        if (extension === 'pdf') {
                                            return `<iframe src="${slip.path}" 
                                                                                                            width="100%" height="400px" 
                                                                                                            style="border: none;"></iframe>`;
                                        }
                                        return '<p>Unsupported file type.</p>';
                                    }
                                });
                            </script> --}}

                            <div class="modal fade" id="viewSlipModal" data-bs-backdrop="static" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Uploaded Slips</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" id="slipContent">
                                            <!-- Content will be loaded here -->
                                            <div class="text-center">
                                                <div class="spinner-border" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane tab-panebtn" id="basictab2" style="display: none;">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="col-12 mb-3">
                                            <div class="input-group">
                                                <form method="GET" action="{{ route('admin.orders') }}" class="row g-3">
                                                    <div class="col-md-2">
                                                        <input type="text" name="id" class="form-control"
                                                            placeholder="Order ID" value="{{ request('id') }}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" name="contact" class="form-control"
                                                            placeholder="Contact" value="{{ request('contact') }}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" name="name" class="form-control"
                                                            placeholder="Name" value="{{ request('name') }}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" name="invoice" class="form-control"
                                                            placeholder="Invoice" value="{{ request('invoice') }}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <select name="payment_status" class="form-select">
                                                            <option value="">Payment Status</option>
                                                            <option value="done"
                                                                @selected(request('payment_status') == 'done')>Done</option>
                                                            <option value="partial"
                                                                @selected(request('payment_status') == 'partial')>Partial
                                                            </option>
                                                            <option value="pending"
                                                                @selected(request('payment_status') == 'pending')>Pending
                                                            </option>
                                                            <option value="rejected"
                                                                @selected(request('payment_status') == 'rejected')>Rejected
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <select name="work_status" class="form-select">
                                                            <option value="">Work Status</option>
                                                            <option value="done" @selected(request('work_status') == 'done')>
                                                                Done</option>
                                                            <option value="pending"
                                                                @selected(request('work_status') == 'pending')>Pending
                                                            </option>
                                                            <option value="send to customer"
                                                                @selected(request('work_status') == 'send to customer')>Send
                                                                to Customer</option>
                                                            <option value="send to designer"
                                                                @selected(request('work_status') == 'send to designer')>Send
                                                                to Designer</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <select name="work_type" class="form-select">
                                                            <option value="">Work Type</option>
                                                            @foreach ($work_types as $type)
                                                                @if ($type->order_type == 'designs')
                                                                    <option value="{{ $type->id }}"
                                                                        @selected(request('work_type') == $type->id)>{{ $type->name }}
                                                                    </option>
                                                                @endif

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 d-flex align-items-end">
                                                        <button class="btn btn-primary me-2" type="submit">Search</button>
                                                        <a href="{{ route('admin.orders') }}"
                                                            class="btn btn-secondary">Clear</a>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table
                                                class="table table-hover table-centered table-bordered border-primary mb-0">
                                                <thead class="table-dark table-bordered border-primary">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Slip <br /> Upload <br /> Date</th>
                                                        <th>CC</th>
                                                        <th>CRO</th>
                                                        <th>C/E</th>
                                                        <th>Invoice</th>
                                                        <th>Name<br />Company</th>
                                                        <th>Contact</th>
                                                        <th>Work<br />Type</th>
                                                        <th>Work<br />Status</th>
                                                        <th>Payment</th>
                                                        <th>Designer</th>
                                                        <th>Design</th>
                                                        <th>Amount</th>
                                                        <th>Advance</th>
                                                        <th>Slip</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @include('admin.partials.ad-design-orders')
                                                </tbody>
                                            </table>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            </div>

                            <div class="tab-pane tab-panebtn" id="basictab3" style="display: none;">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="col-12 mb-3">
                                            <div class="input-group">
                                                <form method="GET" action="{{ route('admin.orders') }}" class="row g-3">
                                                    <div class="col-md-2">
                                                        <input type="text" name="id" class="form-control"
                                                            placeholder="Order ID" value="{{ request('id') }}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" name="contact" class="form-control"
                                                            placeholder="Contact" value="{{ request('contact') }}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" name="name" class="form-control"
                                                            placeholder="Name" value="{{ request('name') }}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" name="invoice" class="form-control"
                                                            placeholder="Invoice" value="{{ request('invoice') }}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <select name="payment_status" class="form-select">
                                                            <option value="">Payment Status</option>
                                                            <option value="done"
                                                                @selected(request('payment_status') == 'done')>Done</option>
                                                            <option value="partial"
                                                                @selected(request('payment_status') == 'partial')>Partial
                                                            </option>
                                                            <option value="pending"
                                                                @selected(request('payment_status') == 'pending')>Pending
                                                            </option>
                                                            <option value="rejected"
                                                                @selected(request('payment_status') == 'rejected')>Rejected
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <select name="work_status" class="form-select">
                                                            <option value="">Work Status</option>
                                                            <option value="done" @selected(request('work_status') == 'done')>
                                                                Done</option>
                                                            <option value="pending"
                                                                @selected(request('work_status') == 'pending')>Pending
                                                            </option>
                                                            <option value="send to customer"
                                                                @selected(request('work_status') == 'send to customer')>Send
                                                                to Customer</option>
                                                            <option value="send to designer"
                                                                @selected(request('work_status') == 'send to designer')>Send
                                                                to Designer</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <select name="work_type" class="form-select">
                                                            <option value="">Work Type</option>
                                                            @foreach ($work_types as $type)
                                                                @if ($type->order_type == 'video')
                                                                    <option value="{{ $type->id }}"
                                                                        @selected(request('work_type') == $type->id)>{{ $type->name }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 d-flex align-items-end">
                                                        <button class="btn btn-primary me-2" type="submit">Search</button>
                                                        <a href="{{ route('admin.orders') }}"
                                                            class="btn btn-secondary">Clear</a>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table
                                                class="table table-hover table-centered table-bordered border-primary mb-0">
                                                <thead class="table-dark table-bordered border-primary">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Slip <br /> Upload <br /> Date</th>
                                                        <th>CC</th>
                                                        <th>CRO</th>
                                                        <th>C/E</th>
                                                        <th>Invoice</th>
                                                        <th>Name<br />Company</th>
                                                        <th>Contact</th>
                                                        <th>Amount</th>
                                                        <th>Our<br />Amount</th>
                                                        <th>Style</th>
                                                        <th>Script</th>
                                                        <th>Shoot</th>
                                                        <th>Time</th>
                                                        <th>Work<br />Status</th>
                                                        <th>Payment</th>
                                                        <th>Cash</th>
                                                        <th>Editor</th>
                                                        <th>Advance</th>
                                                        <th>Slip</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @include('admin.partials.ad-video-orders')
                                                </tbody>

                                                <style>
                                                    .display-mode {
                                                        display: inline-block;
                                                    }

                                                    .edit-mode {
                                                        display: none;
                                                    }

                                                    tr.editing .display-mode {
                                                        display: none;
                                                    }

                                                    tr.editing .edit-mode {
                                                        display: block;
                                                    }

                                                    tr.editing .edit-mode.btn {
                                                        display: inline-block;
                                                    }

                                                    .action-buttons {
                                                        white-space: nowrap;
                                                    }
                                                </style>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- tab-content -->
                        </div> <!-- end #basicwizard-->
                    </div>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    @foreach ($orders as $order)
        @if ($order->d_img)
            @include('includes.design-view')
        @endif
    @endforeach
    {{-- <script>
        // Declare globally
        let searchActive = false;
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function activateTab(tabHash) {
                document.querySelectorAll('.nav-link').forEach(link => {
                    link.classList.remove('active');
                });

                document.querySelectorAll('.tab-pane').forEach(pane => {
                    pane.style.display = 'none';
                    pane.classList.remove('active', 'show');
                });

                const activeLink = document.querySelector(`[href="${tabHash}"]`);
                if (activeLink) activeLink.classList.add('active');

                const activePane = document.querySelector(tabHash);
                if (activePane) {
                    activePane.style.display = 'block';
                    activePane.classList.add('active', 'show');
                }
            }

            const storedTab = localStorage.getItem('activeTab');
            const hash = window.location.hash || storedTab || '#basictab1';

            activateTab(hash);

            // Update storage on manual tab click
            document.querySelectorAll('.nav-link').forEach(tab => {
                tab.addEventListener('click', function (e) {
                    const target = this.getAttribute('href');
                    localStorage.setItem('activeTab', target);
                    activateTab(target); // Optional immediate switch
                });
            });
        });

    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let currentlyEditingRow = null;

            // Close edit mode when clicking outside
            document.addEventListener('click', function (e) {
                if (!currentlyEditingRow) return;

                const clickedInside = currentlyEditingRow.contains(e.target) ||
                    e.target.classList.contains('edit-btn');

                if (!clickedInside) {
                    currentlyEditingRow.classList.remove('editing');
                    currentlyEditingRow = null;
                }
            });

            // Edit button handler
            document.addEventListener('click', function (e) {
                if (e.target.classList.contains('edit-btn')) {
                    e.stopPropagation();

                    if (currentlyEditingRow) {
                        currentlyEditingRow.classList.remove('editing');
                    }

                    const row = e.target.closest('tr');
                    row.classList.add('editing');
                    currentlyEditingRow = row;
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.addEventListener('click', function (e) {
                let endpoint = null;

                if (e.target.classList.contains('done-btnb')) endpoint = 'boosting';
                else if (e.target.classList.contains('done-btnd')) endpoint = 'designs';
                else if (e.target.classList.contains('done-btnv')) endpoint = 'video';

                if (endpoint) {
                    const row = e.target.closest('tr');
                    const orderId = row.dataset.orderId;

                    const payload = {};
                    row.querySelectorAll('input, select, textarea').forEach(input => {
                        if (input.name) {
                            payload[input.name] = input.value;
                        }
                    });

                    payload['_method'] = 'PUT'; // Laravel spoofing

                    fetch(`/orders/${endpoint}/update/${orderId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify(payload)
                    })
                        .then(res => {
                            if (!res.ok) throw new Error('Failed to update');
                            return res.json();
                        })
                        .then(data => {
                            showAlert('Updated successfully', 'success');
                            row.classList.remove('editing');
                            setTimeout(() => location.reload(), 800);
                        })
                        .catch(err => {
                            console.error(err);
                            showAlert('Update failed', 'danger');
                        });
                }
            });

            function showAlert(message, type) {
                const alert = document.createElement('div');
                alert.className = `alert alert-${type} alert-dismissible fade show`;
                alert.innerHTML = `
                                                    <strong>${type === 'success' ? 'Success' : 'Error'}:</strong> ${message}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                                `;
                document.body.prepend(alert);
                setTimeout(() => alert.remove(), 3000);
            }
        });
    </script> --}}


    <style>
        /* Fixed height scrollable tables with sticky headers */
        .table-responsive {
            max-height: 70vh;
            /* 70% of viewport height (adjust as needed) */
            overflow: auto;
            position: relative;
            border: 1px solid #dee2e6;
            /* Optional border */
        }

        /* Sticky headers */
        .table-responsive table thead th {
            position: sticky;
            top: 0;
            background: #343a40;
            /* Match your table-dark background */
            z-index: 10;
        }

        /* Prevent text wrapping to maintain column widths */
        .table-responsive table td,
        .table-responsive table th {
            white-space: nowrap;
            vertical-align: middle;
            /* Better alignment for all cells */
        }

        /* Optional: Better scrollbar styling (works in modern browsers) */
        .table-responsive::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: #adb5bd;
            border-radius: 4px;
        }
    </style>

    {{-- <script>
        // jQuery version (if you're already using jQuery)
        $('#updateSheetModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);        // Button that triggered the modal
            var orderId = button.data('id');            // Extract info from data-* attributes
            var modal = $(this);
            modal.find('#order-id-input').val(orderId);
        });

        /* --- OR vanilla JS version --- */
        var updateModal = document.getElementById('updateSheetModal');
        updateModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;           // Element that triggered the modal
            var orderId = button.getAttribute('data-id');
            updateModal.querySelector('#order-id-input').value = orderId;
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Automatically detect if any search filters are active
            const searchParams = new URLSearchParams(window.location.search);
            const filterKeys = [
                'id', 'contact', 'name', 'invoice',
                'payment_status', 'work_status', 'work_type', 'old_new'
            ];

            const searchActive = filterKeys.some(key => {
                const value = searchParams.get(key);
                return value !== null && value.trim() !== '';
            });

            const pages = { boosting: 1, designs: 1, video: 1 };
            const isLoading = { boosting: false, designs: false, video: false };
            const noMoreData = { boosting: false, designs: false, video: false };

            const tabTypeMap = {
                basictab1: 'boosting',
                basictab2: 'designs',
                basictab3: 'video'
            };

            // Auto-load 2 more pages only if no search is active
            if (!searchActive) {
                Object.keys(pages).forEach(type => {
                    const paneId = Object.entries(tabTypeMap).find(([k, v]) => v === type)?.[0];
                    const pane = document.getElementById(paneId);
                    const tbody = pane?.querySelector('tbody');
                    if (tbody) {
                        loadInitialPages(type, tbody, 2);
                        tbody.dataset.loaded = true;
                    }
                });
            }

            // Lazy loading on scroll (disabled if search is active)
            if (!searchActive) {
                document.querySelectorAll('.tab-pane').forEach(pane => {
                    const tableContainer = pane.querySelector('.table-responsive');
                    if (!tableContainer) return;

                    tableContainer.addEventListener('scroll', function () {
                        const tabId = pane.id;
                        const type = tabTypeMap[tabId];

                        if (!type || isLoading[type] || noMoreData[type]) return;

                        const nearBottom = tableContainer.scrollTop + tableContainer.clientHeight >= tableContainer.scrollHeight - 100;
                        if (nearBottom) {
                            const tbody = tableContainer.querySelector('tbody');
                            if (tbody) {
                                loadMore(type, tbody);
                            }
                        }
                    });
                });
            }

            function loadInitialPages(type, tbody, count) {
                if (count <= 0 || noMoreData[type]) return;

                pages[type]++;
                isLoading[type] = true;
                showSpinner(tbody);

                fetch(`?page=${pages[type]}&type=${type}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(res => res.text())
                    .then(html => {
                        hideSpinner(tbody);
                        if (html.trim() === '') {
                            noMoreData[type] = true;
                        } else {
                            tbody.insertAdjacentHTML('beforeend', html);
                            isLoading[type] = false;
                            loadInitialPages(type, tbody, count - 1);
                        }
                    })
                    .catch(err => {
                        console.error(`Failed to preload ${type} data:`, err);
                        hideSpinner(tbody);
                        isLoading[type] = false;
                    });
            }

            function loadMore(type, tbody) {
                pages[type]++;
                isLoading[type] = true;
                showSpinner(tbody);

                fetch(`?page=${pages[type]}&type=${type}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(res => res.text())
                    .then(html => {
                        hideSpinner(tbody);
                        if (html.trim() === '') {
                            noMoreData[type] = true;
                            tbody.insertAdjacentHTML('beforeend', `
                                            <tr class="no-more-data">
                                                <td colspan="100%" class="text-center text-muted">No more records</td>
                                            </tr>
                                        `);
                        } else {
                            tbody.insertAdjacentHTML('beforeend', html);
                        }
                        isLoading[type] = false;
                    })
                    .catch(err => {
                        console.error(`Failed to load ${type} data:`, err);
                        hideSpinner(tbody);
                        isLoading[type] = false;
                    });
            }

            function showSpinner(tbody) {
                if (!tbody.querySelector('.loading-spinner')) {
                    tbody.insertAdjacentHTML('beforeend', `
                                        <tr class="loading-spinner">
                                            <td colspan="100%" class="text-center">
                                                <div class="spinner-border" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </td>
                                        </tr>
                                    `);
                }
            }

            function hideSpinner(tbody) {
                const spinner = tbody.querySelector('.loading-spinner');
                if (spinner) spinner.remove();
            }
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function updateRowCounts() {
            const tabMap = {
                'boosting-count': '#basictab1',
                'designs-count': '#basictab2',
                'video-count': '#basictab3'
            };

            Object.entries(tabMap).forEach(([counterId, tabSelector]) => {
                const table = document.querySelector(`${tabSelector} table`);
                if (!table) return;

                const visibleRows = table.querySelectorAll('tbody tr:not([style*="display: none"])');
                document.getElementById(counterId).textContent = visibleRows.length;
            });
        }

        // Initial run
        updateRowCounts();

        // Re-run after any change that could affect row visibility
        const observer = new MutationObserver(() => updateRowCounts());

        document.querySelectorAll('.tab-pane tbody').forEach(tbody => {
            observer.observe(tbody, { childList: true, subtree: true, attributes: true, attributeFilter: ['style'] });
        });

        // Also run on manual filtering, AJAX injection, tab switch, etc.
        document.querySelectorAll('.search-btn, .search-input').forEach(el => {
            el.addEventListener('input', updateRowCounts);
            el.addEventListener('click', updateRowCounts);
            el.addEventListener('change', updateRowCounts);
        });

        // Run on tab switch
        document.querySelectorAll('.nav-link').forEach(tab => {
            tab.addEventListener('click', function () {
                setTimeout(updateRowCounts, 200);
            });
        });
    });
</script> --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Auto-dismiss alerts
    setTimeout(function () {
        let alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 1000);

    // Tab activation with fallback
    function activateTab(tabHash) {
        document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
        document.querySelectorAll('.tab-pane').forEach(pane => {
            pane.style.display = 'none';
            pane.classList.remove('active', 'show');
        });
        if (!tabHash || tabHash === '#' || !document.querySelector(tabHash)) {
            tabHash = '#basictab1';
        }
        const activeLink = document.querySelector(`[href="${tabHash}"]`);
        const activePane = document.querySelector(tabHash);
        if (activeLink) activeLink.classList.add('active');
        if (activePane) {
            activePane.style.display = 'block';
            activePane.classList.add('active', 'show');
        }
    }

    const storedTab = localStorage.getItem('activeTab');
    let hash = window.location.hash || storedTab || '#basictab1';
    activateTab(hash);

    document.querySelectorAll('.nav-link').forEach(tab => {
        tab.addEventListener('click', function () {
            const target = this.getAttribute('href');
            localStorage.setItem('activeTab', target);
            activateTab(target);
        });
    });

    // Row inline edit
    let currentlyEditingRow = null;
    document.addEventListener('click', function (e) {
        if (currentlyEditingRow && !currentlyEditingRow.contains(e.target) && !e.target.classList.contains('edit-btn')) {
            currentlyEditingRow.classList.remove('editing');
            currentlyEditingRow = null;
        }
        if (e.target.classList.contains('edit-btn')) {
            e.stopPropagation();
            if (currentlyEditingRow) currentlyEditingRow.classList.remove('editing');
            const row = e.target.closest('tr');
            row.classList.add('editing');
            currentlyEditingRow = row;
        }
    });

    // Save row update
    document.addEventListener('click', function (e) {
        let endpoint = null;
        if (e.target.classList.contains('done-btnb')) endpoint = 'boosting';
        else if (e.target.classList.contains('done-btnd')) endpoint = 'designs';
        else if (e.target.classList.contains('done-btnv')) endpoint = 'video';

        if (endpoint) {
            const row = e.target.closest('tr');
            const orderId = row.dataset.orderId;
            const payload = {};
            row.querySelectorAll('input, select, textarea').forEach(input => {
                if (input.name) payload[input.name] = input.value;
            });
            payload['_method'] = 'PUT';

            fetch(`/orders/${endpoint}/update/${orderId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(payload)
            })
            .then(res => {
                if (!res.ok) throw new Error('Failed to update');
                return res.json();
            })
            .then(() => {
                showAlert('Updated successfully', 'success');
                row.classList.remove('editing');
                setTimeout(() => location.reload(), 800);
            })
            .catch(() => showAlert('Update failed', 'danger'));
        }
    });

    function showAlert(message, type) {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show`;
        alert.innerHTML = `
            <strong>${type === 'success' ? 'Success' : 'Error'}:</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.prepend(alert);
        setTimeout(() => alert.remove(), 3000);
    }

    // Modal slip viewer
    const modal = document.getElementById('viewSlipModal');
    const slipContent = document.getElementById('slipContent');
    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const invoice = button.getAttribute('data-invoice');
        slipContent.innerHTML = `<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>`;
        fetch(`/orders/get-slips/${invoice}`)
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    slipContent.innerHTML = '<p>No slips uploaded for this order.</p>';
                    return;
                }
                let content = '';
                data.forEach(slip => {
                    const ext = slip.type.toLowerCase();
                    const slipView = ['jpg','jpeg','png','gif'].includes(ext)
                        ? `<a href="${slip.path}" target="_blank"><img src="${slip.path}" alt="Slip Image" class="img-fluid rounded" style="width: 300px; height: 200px;"></a>`
                        : ext === 'pdf'
                            ? `<iframe src="${slip.path}" width="100%" height="400px" style="border: none;"></iframe>`
                            : '<p>Unsupported file type.</p>';
                    content += `<div class="mb-3"><p><strong>Bank Name:</strong> ${slip.bank}</p>${slipView}</div>`;
                });
                slipContent.innerHTML = content;
            })
            .catch(() => {
                slipContent.innerHTML = '<p>Error loading slips. Please try again.</p>';
            });
    });

    // jQuery and vanilla fallback for modal update
    $('#updateSheetModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var orderId = button.data('id');
        $(this).find('#order-id-input').val(orderId);
    });
    const updateModal = document.getElementById('updateSheetModal');
    if (updateModal) {
        updateModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const orderId = button.getAttribute('data-id');
            updateModal.querySelector('#order-id-input').value = orderId;
        });
    }

    // Row Count after filtering
    function updateRowCounts() {
        const tabMap = {
            'boosting-count': '#basictab1',
            'designs-count': '#basictab2',
            'video-count': '#basictab3'
        };
        Object.entries(tabMap).forEach(([counterId, tabSelector]) => {
            const table = document.querySelector(`${tabSelector} table`);
            if (!table) return;
            const visibleRows = table.querySelectorAll('tbody tr:not([style*="display: none"])');
            document.getElementById(counterId).textContent = visibleRows.length;
        });
    }

    updateRowCounts();
    const observer = new MutationObserver(updateRowCounts);
    document.querySelectorAll('.tab-pane tbody').forEach(tbody => {
        observer.observe(tbody, { childList: true, subtree: true, attributes: true, attributeFilter: ['style'] });
    });
    document.querySelectorAll('.search-btn, .search-input').forEach(el => {
        el.addEventListener('input', updateRowCounts);
        el.addEventListener('click', updateRowCounts);
        el.addEventListener('change', updateRowCounts);
    });
    document.querySelectorAll('.nav-link').forEach(tab => {
        tab.addEventListener('click', () => setTimeout(updateRowCounts, 200));
    });

    // Lazy loading with search awareness
    const searchParams = new URLSearchParams(window.location.search);
    const filterKeys = ['id', 'contact', 'name', 'invoice', 'payment_status', 'work_status', 'work_type', 'old_new'];
    const searchActive = filterKeys.some(key => {
        const value = searchParams.get(key);
        return value !== null && value.trim() !== '';
    });

    const pages = { boosting: 1, designs: 1, video: 1 };
    const isLoading = { boosting: false, designs: false, video: false };
    const noMoreData = { boosting: false, designs: false, video: false };
    const tabTypeMap = {
        basictab1: 'boosting',
        basictab2: 'designs',
        basictab3: 'video'
    };

    if (!searchActive) {
        Object.keys(pages).forEach(type => {
            const paneId = Object.entries(tabTypeMap).find(([k, v]) => v === type)?.[0];
            const pane = document.getElementById(paneId);
            const tbody = pane?.querySelector('tbody');
            if (tbody) {
                loadInitialPages(type, tbody, 2);
                tbody.dataset.loaded = true;
            }
        });

        document.querySelectorAll('.tab-pane').forEach(pane => {
            const tableContainer = pane.querySelector('.table-responsive');
            if (!tableContainer) return;
            tableContainer.addEventListener('scroll', function () {
                const tabId = pane.id;
                const type = tabTypeMap[tabId];
                if (!type || isLoading[type] || noMoreData[type]) return;

                const nearBottom = tableContainer.scrollTop + tableContainer.clientHeight >= tableContainer.scrollHeight - 100;
                if (nearBottom) {
                    const tbody = tableContainer.querySelector('tbody');
                    if (tbody) loadMore(type, tbody);
                }
            });
        });
    }

    function loadInitialPages(type, tbody, count) {
        if (count <= 0 || noMoreData[type]) return;
        pages[type]++;
        isLoading[type] = true;
        showSpinner(tbody);
        fetch(`?page=${pages[type]}&type=${type}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            hideSpinner(tbody);
            if (html.trim() === '') {
                noMoreData[type] = true;
            } else {
                tbody.insertAdjacentHTML('beforeend', html);
                isLoading[type] = false;
                loadInitialPages(type, tbody, count - 1);
            }
        })
        .catch(err => {
            console.error(`Failed to preload ${type} data:`, err);
            hideSpinner(tbody);
            isLoading[type] = false;
        });
    }

    function loadMore(type, tbody) {
        pages[type]++;
        isLoading[type] = true;
        showSpinner(tbody);
        fetch(`?page=${pages[type]}&type=${type}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            hideSpinner(tbody);
            if (html.trim() === '') {
                noMoreData[type] = true;
                tbody.insertAdjacentHTML('beforeend', `
                    <tr class="no-more-data">
                        <td colspan="100%" class="text-center text-muted">No more records</td>
                    </tr>
                `);
            } else {
                tbody.insertAdjacentHTML('beforeend', html);
            }
            isLoading[type] = false;
        })
        .catch(err => {
            console.error(`Failed to load ${type} data:`, err);
            hideSpinner(tbody);
            isLoading[type] = false;
        });
    }

    function showSpinner(tbody) {
        if (!tbody.querySelector('.loading-spinner')) {
            tbody.insertAdjacentHTML('beforeend', `
                <tr class="loading-spinner">
                    <td colspan="100%" class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </td>
                </tr>
            `);
        }
    }

    function hideSpinner(tbody) {
        const spinner = tbody.querySelector('.loading-spinner');
        if (spinner) spinner.remove();
    }
});
</script>



@endsection