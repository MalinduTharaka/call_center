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
                            <th>Name<br />Company</th>
                            <th>O/N</th>
                            <th>Contact</th>
                            <th>Work<br />Type</th>
                            <th>Page</th>
                            <th>Work<br />Status</th>
                            <th>Payment</th>
                            <th>Cash</th>
                            <th>Advertiser</th>
                            <th>Full Package</th>
                            <th>FB Fee</th>
                            <th>Service</th>
                            <th>Tax</th>
                            <th>Available Fee</th>
                            <th>Advance</th>
                            <th>Details</th>
                            <th>Add<br />Link</th>
                            <th>slip</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            @if ($order->ps == '1' && $order->order_type == 'boosting')

                                <tr class="fw-semibold" data-o+lhrder-id="{{ $order->id }}">
                                    <form action="/advertisers/update/{{ $order->id }}" method="post">
                                        @csrf
                                        @method('put')
                                        <td>{{ $order->date }}</td>
                                        <td>
                                            <span class="badge fs-5 display-mode
                                                @if($order->ce == 'c') bg-primary
                                                @elseif($order->ce == 'e') bg-danger
                                                @endif">
                                                {{ $order->ce}}
                                            </span>
                                        </td>
                                        <td>
                                            <span>{{ $order->invoice }}</span>
                                        </td>
                                        <td>
                                            <span>{{$order->name}}</span>
                                        </td>
                                        <td>
                                            <span class="badge fs-5
                                                @if($order->old_new == 'old') bg-primary
                                                @elseif($order->old_new == 'new') bg-warning
                                                @endif">
                                                {{ $order->old_new}}
                                            </span>
                                        </td>
                                        <td>
                                            <span>{{$order->contact}}</span>
                                        </td>
                                        <td>
                                            <span class="badge fs-5 display-mode
                                                @if(!$order->workType->name == '') bg-dark
                                                @endif">
                                                {{ $order->workType->name ?? '-' }}
                                            </span>
                                            <select name="work_type_id" class="form-select edit-mode">
                                                <option value="" selected>Select</option>
                                                @foreach ($work_types as $work_type)
                                                    @if ($work_type->order_type == 'boosting')
                                                        <option value="{{$work_type->id}}" @if($order->work_type_id == $work_type->id)
                                                        selected @endif>{{$work_type->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>

                                        <td>
                                            <span class="badge fs-5 bg-dark">{{ $order->page }}</span>
                                            <select name="page" class="form-select edit-mode">
                                                <option value="" selected>Select</option>
                                                <option value="new" @if($order->ce == 'new') selected @endif>new</option>
                                                <option value="our" @if($order->ce == 'our') selected @endif>our</option>
                                                <option value="existing" @if($order->ce == 'existing') selected @endif>existing
                                                </option>
                                            </select>
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
                                            <span class="badge fs-5
                                                @if($order->cash == 1.00) bg-warning bg-gradient
                                                @elseif ($order->cash == 0.00) text-dark
                                                @endif">
                                                {{ $order->cash == 1.00 ? 'Cash' : 'None Cash' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-dark fs-5 display-mode">
                                                {{ $order->advertiser->name ?? 'N/A' }}
                                            </span>
                                            <select name="advertiser_id" class="form-select edit-mode">
                                                <option value="" selected>Select</option>
                                                @foreach ($users as $user)
                                                    @if($user->role == 'adv' || $user->role == 'admin')
                                                        <option value="{{ $user->id }}" @if($order->advertiser_id == $user->id) selected
                                                        @endif>{{ $user->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>{{ $order->package_amt+$order->service+$order->tax }}</td>
                                        <td>{{ $order->package_amt }}</td>
                                        <td>{{ $order->service }}</td>
                                        <td>{{ $order->tax }}</td>
                                        <td>
                                            @if($order->payment_status == 'partial')
                                                {{ $order->advance - ($order->tax + $order->service) }}
                                            @elseif($order->payment_status == 'done')
                                                {{ $order->package_amt }}
                                            @endif
                                        </td>
                                        <td>
                                            <span">{{$order->advance}}</span>
                                        </td>
                                        <td>
                                            <span class="display-mode">{{ $order->details }}</span>
                                            <input type="text" name="details" class="form-control edit-mode"
                                                value="{{ $order->details }}">
                                        </td>
                                        <td>
                                            <a href="{{ $order->add_acc_id }}" target="_blank" class="display-mode">
                                                {{ $order->add_acc_id }}
                                            </a>
                                            <input type="text" name="add_acc_id" class="form-control edit-mode"
                                                value="{{ $order->add_acc_id }}">
                                        </td>

                                        <td>
                                            @include('includes.slip-view')
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
        // Search functionality
        document.querySelectorAll('.search-btn').forEach(button => {
            button.addEventListener('click', function () {
                const input = this.closest('.input-group').querySelector('.search-input');
                performSearch(input);
            });
        });

        document.querySelectorAll('.search-input').forEach(input => {
            input.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    performSearch(this);
                }
            });
        });

        function performSearch(input) {
            const searchTerm = input.value.toLowerCase();
            const tableSelector = input.dataset.targetTable;
            const table = document.querySelector(tableSelector);
            if (!table) return;

            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let matches = false;

                cells.forEach(cell => {
                    // Check both display and edit values
                    const displayValue = cell.querySelector('.display-mode')?.textContent?.toLowerCase() || '';
                    const editValue = cell.querySelector('.edit-mode')?.value?.toLowerCase() || '';

                    if (displayValue.includes(searchTerm) || editValue.includes(searchTerm)) {
                        matches = true;
                    }
                });

                row.style.display = matches ? '' : 'none';
            });
        }
    </script>
@endsection