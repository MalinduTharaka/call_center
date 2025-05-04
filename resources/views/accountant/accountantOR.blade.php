@extends('layouts.app')
@section('content')
    <style>
        .btn-disabled {
            opacity: 0.5;
            pointer-events: none;
        }

        .bg-light-red {
            background-color: rgb(255, 11, 32) !important;
        }
    </style>

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
        setTimeout(function() {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 2000); // Auto-dismiss after 4 seconds
    </script>

    <div class="row mt-3">
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
                            <th>C/E</th>
                            <th>Invoice</th>
                            <th>CC</th>
                            <th>CRO</th>
                            <th>Name<br />Company</th>
                            <th>Contact</th>
                            <th>Work<br />Type</th>
                            <th>Work Status</th>
                            <th>Payment</th>
                            <th>Cash</th>
                            <th>Amount</th>
                            <th>Advance</th>
                            <th>Note</th>
                            <th>slip</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($other_orders as $order)
                            @if ($order->ps == '1')
                                <tr class="fw-semibold" data-o+lhrder-id="{{ $order->id }}">
                                    <form action="/accountant/other_order/update/{{ $order->id }}" method="post">
                                        @csrf
                                        @method('put')
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->date }}</td>
                                        <td>
                                            <span
                                                class="badge fs-5 display-mode
                                                @if ($order->ce == 'c') bg-primary
                                                @elseif($order->ce == 'e') bg-danger @endif"
                                                data-field="ce">
                                                {{ $order->ce }}
                                            </span>
                                            <select name="ce" class="form-select edit-mode">
                                                <option value="" selected>Select</option>
                                                <option value="c" @if ($order->ce == 'c') selected @endif>c
                                                </option>
                                                <option value="e" @if ($order->ce == 'e') selected @endif>e
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <span>{{ $order->invoice_id }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $order->callCenter->cc_name }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $order->user->name }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $order->name }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $order->contact }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge fs-5
                                                @if (!$order->work_type == '') bg-dark @endif">
                                                {{ $order->work_type }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge fs-5
                                                @if ($order->work_status == 'done') bg-primary
                                                @elseif($order->work_status == 'pending') bg-danger
                                                @elseif($order->work_status == 'send to customer') bg-warning
                                                @elseif($order->work_status == 'send to designer') bg-dark @endif">
                                                {{ $order->work_status }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge fs-5
                                                @if ($order->payment_status == 'done') bg-primary
                                                @elseif($order->payment_status == 'pending') bg-danger
                                                @elseif($order->payment_status == 'rejected') bg-warning
                                                @elseif($order->payment_status == 'partial') bg-warning @endif">
                                                {{ $order->payment_status }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge fs-5
                                                @if ($order->cash == 1.0) bg-warning bg-gradient
                                                @elseif ($order->cash == 0.0) text-dark @endif">
                                                {{ $order->cash == 1.0 ? 'Cash' : 'None Cash' }}
                                            </span>
                                        </td>
                                        <td>{{ $order->amount }}</td>
                                        <td>
                                            <span>{{ $order->advance }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $order->note }}</span>
                                        </td>

                                        <td>
                                            @include('includes.slip-view-or')
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary edit-btn">Edit</button>
                                            <button type="submit" class="btn btn-primary done-btnb">Done</button>
                                        </td>
                                    </form>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    </div>

    <style>
        /* Add these styles */
        .display-mode {
            display: inline;
        }

        .edit-mode {
            display: none;
        }

        .done-btnb {
            display: none;
        }

        tr.editing .display-mode {
            display: none !important;
        }

        tr.editing .edit-mode {
            display: block !important;
        }

        tr.editing .edit-btn {
            display: none !important;
        }

        tr.editing .done-btnb {
            display: inline-block !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Edit button click handler
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    const row = this.closest('tr');
                    enterEditMode(row);
                });
            });

            // Click anywhere handler
            document.addEventListener('click', function(e) {
                const editingRow = document.querySelector('tr.editing');
                if (editingRow && !editingRow.contains(e.target)) {
                    exitEditMode(editingRow);
                }
            });
        });

        function enterEditMode(row) {
            // Exit any other editing rows
            document.querySelectorAll('tr.editing').forEach(exitEditMode);
            row.classList.add('editing');
        }

        function exitEditMode(row) {
            row.classList.remove('editing');
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('.search-input');
            const searchBtn = document.querySelector('.search-btn');
            const targetTable = document.querySelector(searchInput.getAttribute('data-target-table'));
            const allRows = Array.from(targetTable.querySelectorAll('tbody tr'));

            // Main filter function
            function performSearch() {
                const term = searchInput.value.trim().toLowerCase();
                allRows.forEach(row => {
                    // you can tweak this to search only specific columns if needed
                    const text = row.textContent.trim().toLowerCase();
                    row.style.display = text.includes(term) ? '' : 'none';
                });
            }

            // Click on Search button
            searchBtn.addEventListener('click', performSearch);

            // Press Enter in the input
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // avoid accidental form submissions
                    performSearch();
                }
            });
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
    document.addEventListener('DOMContentLoaded', function() {
        // Existing edit mode and search code...

        // AJAX Form Submission
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(form);
                const row = form.closest('tr');
                const url = form.action;

                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (!response.ok) throw new Error(data.message || 'Failed to update order');

                    // Update table row with new data
                    updateRow(row, data.order);
                    exitEditMode(row);
                    
                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert"
                        style="color: #155724; background-color: #d4edda; border-color: #c3e6cb;">
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                } catch (error) {
                    console.error('Error:', error);
                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert"
                        style="color: #155724; background-color: #d4edda; border-color: #c3e6cb;">
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                }
            });
        });

        function updateRow(row, order) {
            // Update CE
            row.querySelector('.display-mode.badge').textContent = order.ce;
            row.querySelector('.display-mode.badge').className = 
                `badge fs-5 display-mode ${order.ce === 'c' ? 'bg-primary' : 'bg-danger'}`;
        }

        function getStatusClass(status, type) {
            const classes = {
                work: {
                    'done': 'bg-primary',
                    'pending': 'bg-danger',
                    'send to customer': 'bg-warning',
                    'send to designer': 'bg-dark'
                },
                payment: {
                    'done': 'bg-primary',
                    'pending': 'bg-danger',
                    'rejected': 'bg-warning',
                    'partial': 'bg-warning'
                }
            };
            return classes[type][status] || '';
        }
    });
</script>

@endsection
