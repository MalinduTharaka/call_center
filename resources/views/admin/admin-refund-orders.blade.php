@extends('layouts.app')
@section('content')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title mb-0"> Refunded Orders</h4>
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
                                                        <th>ID</th>
                                                        <th>Refund <br /> Date</th>
                                                        <th>CRO</th>
                                                        <th>Invoice</th>
                                                        <th>Name<br />Company</th>
                                                        <th>Contact</th>
                                                        <th>Work<br />Type</th>
                                                        <th>FB Fee</th>
                                                        <th>Service</th>
                                                        <th>Tax</th>
                                                        <th>Advance</th>
                                                        <th>Slip</th>
                                                        <th>Reason</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($orders as $order)
                                                        @if ($order->order_type == 'boosting')
                                                            <tr class="fw-semibold">
                                                                    <td>{{ $order->id }}</td>
                                                                    <td>{{ $order->date->format('Y-m-d') }}</td>
                                                                    <td>{{ $order->plUser->name ?? '-' }}</td>
                                                                    <td>
                                                                        <span>{{ $order->invoice_id }}</span>
                                                                    </td>
                                                                    <td
                                                                        style="width: 150px; max-width: 150px; white-space: normal; word-wrap: break-word;">
                                                                        <span>{{ $order->name }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span>{{ $order->contact }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge fs-5
                                                                            @if ($order->workType && $order->workType->name != '') bg-dark @endif">
                                                                            {{ $order->workType?->name ?? '-' }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="display-mode">{{ $order->pkg_amt }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="display-mode">{{ $order->service }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="display-mode">{{ $order->tax }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span>{{ $order->advance }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-success view-slip-btn"
                                                                            data-invoice="{{ $order->invoice_id }}"
                                                                            data-bs-toggle="modal" data-bs-target="#viewSlipModal">
                                                                            <i class="ri-eye-line"></i>
                                                                        </button>
                                                                    </td>
                                                                    <td style="width: 150px; max-width: 150px; white-space: normal; word-wrap: break-word;">
                                                                        <span>{{ $order->reason }}</span>
                                                                    </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            </div>

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
                                                        <th>Refund<br /> Date</th>
                                                        <th>CRO</th>
                                                        <th>Invoice</th>
                                                        <th>Name<br />Company</th>
                                                        <th>Contact</th>
                                                        <th>Work<br />Type</th>
                                                        <th>Amount</th>
                                                        <th>Advance</th>
                                                        <th>Slip</th>
                                                        <th>Reason</th>
                                                </thead>
                                                <tbody>
                                                    @foreach ($orders as $order)
                                                        @if ($order->order_type == 'designs')
                                                            <tr data-order-id="{{ $order->id }}">
                                                                    <td>{{ $order->id }}</td>
                                                                    <td>{{ $order->date->format('Y-m-d') }}</td>
                                                                    <td>{{ $order->plUser->name ?? '-' }}</td>
                                                                    <td>
                                                                        <span>{{ $order->invoice_id }}</span>
                                                                    </td>
                                                                    <td
                                                                        style="width: 150px; max-width: 150px; white-space: normal; word-wrap: break-word;">
                                                                        <span>{{ $order->name }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span>{{ $order->contact }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge fs-5
                                                                            @if ($order->workType && $order->workType->name != '') bg-dark @endif">
                                                                            {{ $order->workType?->name ?? '-' }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <span>{{ $order->amount }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span>{{ $order->advance }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-success view-slip-btn"
                                                                            data-invoice="{{ $order->invoice_id }}"
                                                                            data-bs-toggle="modal" data-bs-target="#viewSlipModal">
                                                                            <i class="ri-eye-line"></i>
                                                                        </button>
                                                                    </td>
                                                                    <td style="width: 150px; max-width: 150px; white-space: normal; word-wrap: break-word;">
                                                                        <span>{{ $order->reason }}</span>
                                                                    </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
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
                                                        <th>Refund<br /> Date</th>
                                                        <th>CRO</th>
                                                        <th>Invoice</th>
                                                        <th>Name<br />Company</th>
                                                        <th>Contact</th>
                                                        <th>Amount</th>
                                                        <th>Style</th>
                                                        <th>Advance</th>
                                                        <th>Slip</th>
                                                        <th>Reason</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($orders as $order)
                                                        @if ($order->order_type == 'video')
                                                            <tr data-order-id="{{ $order->id }}">
                                                                    <td>{{ $order->id }}</td>
                                                                    <td>
                                                                        <span>{{ $order->date->format('Y-m-d') }}</span>
                                                                    </td>
                                                                    <td>{{ $order->plUser->name ?? '-' }}</td>
                                                                    <td>
                                                                        <span>{{ $order->invoice_id }}</span>
                                                                    </td>
                                                                    <td
                                                                        style="width: 150px; max-width: 150px; white-space: normal; word-wrap: break-word;">
                                                                        <span>{{ $order->name }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span >{{ $order->contact }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span>{{ $order->amount }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge fs-5
                                                                            @if ($order->workType && $order->workType->name != '') bg-dark @endif">
                                                                            {{ $order->workType?->name ?? '-' }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <span>{{ $order->advance }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-success view-slip-btn"
                                                                            data-invoice="{{ $order->invoice_id }}"
                                                                            data-bs-toggle="modal" data-bs-target="#viewSlipModal">
                                                                            <i class="ri-eye-line"></i>
                                                                        </button>
                                                                    </td>
                                                                    <td style="width: 150px; max-width: 150px; white-space: normal; word-wrap: break-word;">
                                                                        <span>{{ $order->reason }}</span>
                                                                    </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>

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

                if (targetTable) {
                    const rows = targetTable.querySelectorAll('tbody tr');

                    rows.forEach(row => {
                        const cells = row.querySelectorAll('td');
                        let found = false;

                        cells.forEach(cell => {
                            const cellText = cell.textContent.toLowerCase();
                            if (cellText.includes(searchTerm)) {
                                found = true;
                            }
                        });

                        row.style.display = found ? '' : 'none';
                    });
                }
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
@endsection