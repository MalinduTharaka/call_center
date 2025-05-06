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

        .display-mode {
            display: inline;
        }

        .edit-mode {
            display: none;
        }

        .done-btn {
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

        tr.editing .done-btn {
            display: inline-block !important;
        }
    </style>

    {{-- Flash Messages --}}
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

    {{-- Auto-dismiss alerts --}}
    <script>
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(alert => {
                new bootstrap.Alert(alert).close();
            });
        }, 4000); // Auto-dismiss after 4 seconds
    </script>

    <div class="row mt-3">
        <div class="col-12" id="ordersTableWrapper">
            <div class="col-3 mb-3">
                <div class="input-group">
                    <input type="text" class="form-control search-input" placeholder="Search orders..."
                        data-target-table="#ordersTable">
                    <button class="btn btn-primary search-btn">Search</button>
                </div>
            </div>
            <div class="table-responsive">
                <table id="ordersTable" class="table table-hover table-centered table-bordered border-primary mb-0">
                    <thead class="table-dark table-bordered border-primary">
                        <tr>
                            <th>Id</th>
                            <th>Slip <br> Upload <br> Date</th>
                            <th>CRO</th>
                            <th>Designer Name</th>
                            <th>Date</th>
                            <th>C/E</th>
                            <th>Invoice</th>
                            <th>Name<br>Company</th>
                            <th>Work<br>Type</th>
                            <th>Work<br>Status</th>
                            <th>Payment</th>
                            <th>Designer</th>
                            <th>Upload Design</th>
                            <th>Design</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            @if (Auth::user()->id == $order->designer_id && $order->ps == '1' && $order->order_type == 'designs')
                                <form action="{{ url('/orders/update/designers/' . $order->id) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <tr data-order-id="{{ $order->id }}">
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->date->format('Y-m-d') }}</td>
                                        <td>{{ $order->plUser->name }}</td>
                                        <td>{{ $order->Designer->name }}</td>
                                        <td>{{ $order->date }}</td>
                                        <td>
                                            <span
                                                class="badge fs-5 
                                                                            @if ($order->ce == 'c') bg-primary
                                                                            @elseif($order->ce == 'e') bg-danger @endif">
                                                {{ strtoupper($order->ce) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span>{{ $order->invoice }}</span>
                                            <input type="text" name="inv" class="form-control"
                                                value="{{ $order->invoice }}" hidden>
                                        </td>
                                        <td style="width: 150px; max-width: 150px; white-space: normal; word-wrap: break-word;">
                                            <span>{{ $order->name }}</span>
                                        </td>
                                        <td>
                                            <span class="badge fs-5 @if (optional($order->workType)->name) bg-dark @endif">
                                                {{ optional($order->workType)->name ?? '—' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge fs-5 display-mode
                                                                            @if ($order->work_status == 'done') bg-primary
                                                                            @elseif($order->work_status == 'pending') bg-danger
                                                                            @elseif($order->work_status == 'send to customer') bg-warning
                                                                            @elseif($order->work_status == 'send to designer') bg-dark @endif">
                                                {{ $order->work_status }}
                                            </span>
                                            <select name="work_status" class="form-select edit-mode">
                                                <option value="" disabled>Select</option>
                                                @foreach (['done', 'pending', 'send to customer', 'send to designer'] as $status)
                                                    <option value="{{ $status }}"
                                                        @if ($order->work_status == $status) selected @endif>
                                                        {{ $status }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <span
                                                class="badge fs-5
                                                                            @if ($order->payment_status == 'done') bg-primary
                                                                            @elseif($order->payment_status == 'pending') bg-danger
                                                                            @elseif(in_array($order->payment_status, ['partial', 'rejected'])) bg-warning @endif">
                                                {{ $order->payment_status }}
                                            </span>
                                        </td>
                                        <td>{{ $order->designer_id }}</td>
                                        <!-- Button in the table cell -->
                                        <td>
                                            <button type="button" data-bs-toggle="modal" class="btn btn-info"
                                                data-bs-target="#designUploadModel-{{ $order->id }}">
                                                <i class="ri-arrow-up-line"></i>
                                            </button>
                                        </td>
                                        <td>
                                            @if ($order->d_img)
                                                <!-- Thumbnail with modal trigger -->
                                                <img src="{{ asset($order->d_img) }}" alt="Design Preview"
                                                    class="img-thumbnail" style="width: 50px; cursor: pointer"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#designPreviewModal-{{ $order->id }}">
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-primary edit-btn display-mode">Edit</button>
                                            <button type="submit" class="btn btn-primary done-btn edit-mode">Done</button>
                                        </td>
                                    </tr>
                                </form>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($orders as $order)
        @include('includes.design-upload', ['order' => $order])
    @endforeach

    @foreach ($orders as $order)
        @if ($order->d_img)
            @include('includes.design-view')
        @endif
    @endforeach
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle edit mode
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('tr.editing').forEach(r => r.classList.remove(
                        'editing'));
                    this.closest('tr').classList.add('editing');
                });
            });

            // Click outside to cancel edit
            document.addEventListener('click', function(e) {
                const editingRow = document.querySelector('tr.editing');
                if (editingRow && !editingRow.contains(e.target)) {
                    editingRow.classList.remove('editing');
                }
            });
        });
        // Search functionality
        const searchInput = document.querySelector('.search-input');
        const searchBtn = document.querySelector('.search-btn');
        const table = document.querySelector(searchInput.dataset.targetTable);
        const rows = table.querySelectorAll('tbody tr');

        searchBtn.addEventListener('click', () => {
            const term = searchInput.value.trim().toLowerCase();

            rows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                if (rowText.includes(term)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Optional: Enable real-time search
        searchInput.addEventListener('keyup', () => {
            searchBtn.click();
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
