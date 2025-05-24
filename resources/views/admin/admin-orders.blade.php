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
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#basictab2" class="nav-link rounded-0 py-2">
                                    <span class="d-none d-sm-inline">Designs</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#basictab3" class="nav-link rounded-0 py-2">
                                    <span class="d-none d-sm-inline">Video</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content b-0 mb-0">
                            <div class="tab-pane tab-panebtn" id="basictab1">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="col-3 mb-3">
                                            <div class="input-group">
                                                <input type="text" class="form-control search-input"
                                                    placeholder="Search orders..." data-target-table="#basictab1 table">
                                                <button class="btn btn-primary search-btn">Search</button>
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
                            <script>
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
                            </script>

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

                            <div class="tab-pane tab-panebtn" id="basictab2">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="col-3 mb-3">
                                            <div class="input-group">
                                                <input type="text" class="form-control search-input"
                                                    placeholder="Search orders..." data-target-table="#basictab2 table">
                                                <button class="btn btn-primary search-btn">Search</button>
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

                            <div class="tab-pane tab-panebtn" id="basictab3">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="col-3 mb-3">
                                            <div class="input-group">
                                                <input type="text" class="form-control search-input"
                                                    placeholder="Search orders..." data-target-table="#basictab3 table">
                                                <button class="btn btn-primary search-btn">Search</button>
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
    <script>
        // Declare globally
        let searchActive = false;
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Function to activate tabs
            function activateTab(tabHash) {
                // Remove active classes from all tabs and panes
                document.querySelectorAll('.nav-link, .tab-panebtn').forEach(el => {
                    el.classList.remove('active', 'show');
                });

                // Activate matching tab
                const tabLink = document.querySelector(`[href="${tabHash}"]`);
                if (tabLink) {
                    tabLink.classList.add('active');
                    // Activate corresponding pane
                    const pane = document.querySelector(tabHash);
                    if (pane) pane.classList.add('active', 'show');
                }
            }

            // Set default tab if no hash exists
            if (!window.location.hash) {
                window.location.hash = '#basictab1';
            } else {
                activateTab(window.location.hash);
            }

            // Update tabs when hash changes
            window.addEventListener('hashchange', () => {
                activateTab(window.location.hash);
            });

            // Handle manual tab clicks
            document.querySelectorAll('.nav-link[data-bs-toggle="tab"]').forEach(tab => {
                tab.addEventListener('click', function (e) {
                    window.location.hash = this.getAttribute('href');
                });
            });
        });
    </script>
    <script>
        // Search functionality
        // Search functionality
        document.addEventListener("DOMContentLoaded", function () {
            // Handle search button clicks
            document.querySelectorAll('.search-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const input = this.closest('.input-group').querySelector('.search-input');
                    performSearch(input);
                });
            });

            // Handle Enter key in search inputs
            document.querySelectorAll('.search-input').forEach(input => {
                input.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter') {
                        performSearch(this);
                    }
                });
            });

            function performSearch(inputElement) {
                const searchTerm = inputElement.value.trim().toLowerCase();
                const targetTable = document.querySelector(inputElement.dataset.targetTable);
                searchActive = !!searchTerm;

                if (targetTable) {
                    const rows = targetTable.querySelectorAll('tbody tr');
                    rows.forEach(row => {
                        const cells = row.querySelectorAll('td');
                        const found = Array.from(cells).some(cell =>
                            cell.textContent.toLowerCase().includes(searchTerm)
                        );
                        row.style.display = found ? '' : 'none';
                    });
                }
            }

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
    </script>


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

    <script>
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
            const pages = { boosting: 1, designs: 1, video: 1 };
            const isLoading = { boosting: false, designs: false, video: false };
            const noMoreData = { boosting: false, designs: false, video: false };

            const tabTypeMap = {
                basictab1: 'boosting',
                basictab2: 'designs',
                basictab3: 'video'
            };

            document.querySelectorAll('.tab-pane').forEach(pane => {
                const tableContainer = pane.querySelector('.table-responsive');
                if (!tableContainer) return;

                tableContainer.addEventListener('scroll', function () {
                    const tabId = pane.id;
                    const type = tabTypeMap[tabId];

                    if (searchActive || !type || isLoading[type] || noMoreData[type]) return;

                    const nearBottom = tableContainer.scrollTop + tableContainer.clientHeight >= tableContainer.scrollHeight - 100;
                    if (nearBottom) {
                        const tbody = tableContainer.querySelector('tbody');
                        if (tbody) {
                            loadMore(type, tbody);
                        }
                    }
                });
            });

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

            function loadMore(type, tbody) {
                isLoading[type] = true;
                pages[type]++;
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
                            isLoading[type] = false;
                        }
                    })
                    .catch(err => {
                        console.error(`Failed to load ${type} data:`, err);
                        hideSpinner(tbody);
                        isLoading[type] = false;
                    });
            }
        });
    </script>

@endsection