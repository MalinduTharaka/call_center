@extends('layouts.app')
@section('content')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title mb-0"> Refunded Other Orders</h4>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="col-3 mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control search-input" placeholder="Search orders..."
                                    data-target-table="#basictab2 table">
                                <button class="btn btn-primary search-btn">Search</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-centered table-bordered border-primary mb-0">
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
                                        <th>Reason</th>
                                </thead>
                                <tbody>
                                    @foreach ($other_orders as $order)
                                        @if ($order->order_type == null)
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
                                                    <span
                                                        class="badge fs-5 bg-dark">
                                                        {{ $order->work_type }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>{{ $order->amount }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $order->advance }}</span>
                                                </td>
                                                <td
                                                    style="width: 150px; max-width: 150px; white-space: normal; word-wrap: break-word;">
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
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
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