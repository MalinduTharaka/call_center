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

    <div class="row mt-3">
                <div class="card-header">
                    <h4 class="header-title mb-0"> Update Sheet</h4>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="col-3 mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control search-input" placeholder="Search orders..."
                                    data-target-table="table">
                                <button class="btn btn-primary search-btn">Search</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-centered table-bordered border-primary mb-0">
                                <thead class="table-dark table-bordered border-primary">
                                    <tr>
                                        <th>ID</th>
                                        <th>Slip <br /> Upload <br /> Date</th>
                                        <th>CRO</th>
                                        <th>Invoice</th>
                                        <th>Name<br />Company</th>
                                        <th>Contact</th>
                                        <th>Page</th>
                                        <th>Work<br />Status</th>
                                        <th>Advertiser</th>
                                        <th>Work<br />Type</th>
                                        <th>Add<br />Link</th>
                                        <th>Update</th>
                                        @if (Auth::user()->role == 'admin')
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr class="fw-semibold" data-order-id="{{ $order->id }}"
                                            data-add-acc="{{ $order->add_acc }}">
                                            <form action="/update/sheet/update/{{ $order->id }}" method="post">
                                                @csrf
                                                @method('put')
                                                <td>{{ $order->order_id }}</td>
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
                                                    <span class="badge fs-5 bg-dark">{{ $order->page }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge fs-5
                                                                                                        @if ($order->work_status == 'done') bg-primary
                                                                                                        @elseif($order->work_status == 'pending') bg-danger
                                                                                                        @elseif($order->work_status == 'send to customer') bg-warning
                                                                                                        @elseif($order->work_status == 'send to designer') bg-dark
                                                                                                        @elseif($order->work_status == 'error') bg-danger @elseif($order->work_status == '')
                                                                                                        @else
                                                                                                        bg-info @endif">
                                                        {{ $order->work_status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-dark fs-5">
                                                        {{ $order->advertiser->name ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge fs-5
                                                                                                        @if (!$order->workType->name == '') bg-dark @endif">
                                                        {{ $order->workType->name ?? '-' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if (empty($order->add_acc_id))
                                                        <span>Not Added</span>
                                                    @else
                                                        <a href="{{ $order->add_acc_id }}" target="_blank" class="btn btn-info">
                                                            <i class="ri-arrow-up-circle-line "></i>
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="display-mode">{{ $order->update }}</span>
                                                    <textarea class="form-control edit-mode" id="order-id-update" name="update"
                                                        rows="4">{{ $order->update }}</textarea>
                                                </td>
                                                @if (Auth::user()->role == 'admin')
                                                    <td>
                                                    <button type="button"
                                                        class="btn btn-primary edit-btn display-mode">Edit</button>
                                                    <button type="submit"
                                                        class="btn btn-primary done-btnb edit-mode">Done</button>
                                                </td>
                                                @endif
                                            </form>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
    </div>
    <style>
        tr .edit-mode {
            display: none;
        }

        tr.editing .edit-mode {
            display: block;
        }

        tr.editing .display-mode {
            display: none;
        }
    </style>

    <script>
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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let currentlyEditing = null;

            // Edit button functionality for all tabs
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function (e) {
                    e
                        .stopPropagation(); // Prevent this click from triggering the document click handler

                    // If another row is being edited, revert it first
                    if (currentlyEditing && currentlyEditing !== this.closest('tr')) {
                        currentlyEditing.classList.remove('editing');
                    }

                    const row = this.closest('tr');
                    row.classList.add('editing');
                    currentlyEditing = row;
                });
            });

            // Click anywhere to cancel edit mode
            document.addEventListener('click', function (e) {
                if (currentlyEditing && !currentlyEditing.contains(e.target)) {
                    currentlyEditing.classList.remove('editing');
                    currentlyEditing = null;
                }
            });

            // Prevent clicks inside edit forms from bubbling up
            document.querySelectorAll('.edit-mode').forEach(element => {
                element.addEventListener('click', function (e) {
                    e.stopPropagation();
                });
            });

            // Rest of your existing JavaScript...
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