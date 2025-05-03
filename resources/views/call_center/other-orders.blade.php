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

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert"
            style="color: #155724; background-color: #d4edda; border-color: #c3e6cb;">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
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
        }, 2000); // Auto-dismiss after 4 seconds
    </script>

    <div class="row mt-3">
        <div class="col-12">
            <div class="col-3 mb-3">
                <div class="input-group">
                    <input type="text" class="form-control search-input" placeholder="Search orders..."
                        data-target-table="#basictab1 table">
                    <button class="btn btn-primary search-btn">Search</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-centered table-bordered border-primary mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Date</th>
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
                            @if ($order->ps == '1' && Auth::user()->cc_num == $order->cc_id)

                                <tr class="fw-semibold" data-o+lhrder-id="{{ $order->id }}">
                                    <form action="/other_order/update/{{ $order->id }}" method="post">
                                        @csrf
                                        @method('put')
                                        <td>{{ $order->date }}</td>
                                        <td>
                                            <span class="badge fs-5
                                                @if($order->ce == 'c') bg-primary
                                                @elseif($order->ce == 'e') bg-danger
                                                @endif">
                                                {{ $order->ce}}
                                            </span>
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
                                            <span >{{$order->name}}</span>
                                        </td>
                                        <td>
                                            <span >{{$order->contact}}</span>
                                        </td>
                                        <td>
                                            <span class="badge fs-5 
                                                @if(!$order->work_type == '') bg-dark
                                                @endif">
                                                {{ $order->work_type }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge fs-5 display-mode
                                                @if($order->work_status == 'done') bg-primary
                                                @elseif($order->work_status == 'pending') bg-danger
                                                @elseif($order->work_status == 'send to customer') bg-warning
                                                @elseif($order->work_status == 'send to designer') bg-dark
                                                @endif">
                                                {{ $order->work_status }}
                                            </span>
                                            <select name="work_status" class="form-select edit-mode">
                                                <option value="" selected>Select</option>
                                                <option value="done" @if($order->work_status == 'done') selected @endif>done</option>
                                                <option value="pending" @if($order->work_status == 'pending') selected @endif>pending
                                                </option>
                                                <option value="send to customer" @if($order->work_status == 'send to customer')
                                                selected @endif>send to customer</option>
                                                <option value="send to designer" @if($order->work_status == 'send to designer')
                                                selected @endif>send to designer</option>
                                            </select>
                                        </td>
                                        <td>
                                            <span class="badge fs-5
                                                @if($order->payment_status == 'done') bg-primary
                                                @elseif($order->payment_status == 'pending') bg-danger
                                                @elseif($order->payment_status == 'rejected') bg-warning
                                                @elseif($order->payment_status == 'partial') bg-warning
                                                @endif">
                                                {{ $order->payment_status }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge fs-5  display-mode
                                                @if($order->cash == 1.00) bg-warning bg-gradient
                                                @elseif ($order->cash == 0.00) text-dark
                                                @endif">
                                                {{ $order->cash == 1.00 ? 'Cash' : 'None Cash' }}
                                            </span>
                                            <select name="cash" class="form-select edit-mode">
                                                <option value="1" @if($order->cash == 1) selected @endif>cash payment</option>
                                                <option value="0" @if($order->cash == 0) selected @endif>none cash payment</option>
                                            </select>
                                        </td>
                                        <td>{{ $order->amount }}</td>
                                        <td>
                                            <span>{{$order->advance}}</span>
                                        </td>
                                        <td>
                                            <span class="display-mode">{{ $order->note }}</span>
                                            <input type="text" name="details" class="form-control edit-mode"
                                                value="{{ $order->note }}">
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
        document.addEventListener('DOMContentLoaded', function () {
            // Edit button click handler
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function (e) {
                    const row = this.closest('tr');
                    enterEditMode(row);
                });
            });

            // Click anywhere handler
            document.addEventListener('click', function (e) {
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
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.querySelector('.search-input');
        const searchBtn   = document.querySelector('.search-btn');
        const table       = document.querySelector(searchInput.dataset.targetTable);
        const rows        = table.querySelectorAll('tbody tr');

        // Filter rows based on search term
        function filterRows() {
            const term = searchInput.value.trim().toLowerCase();
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(term) ? '' : 'none';
            });
        }

        // On click
        searchBtn.addEventListener('click', filterRows);

        // On Enter key
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') filterRows();
            else filterRows(); // optional: live-update on every keystroke
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

@endsection