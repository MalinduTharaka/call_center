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
                        data-target-table="table">
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
                            @if ($order->ps == '1')

                                <tr class="fw-semibold" data-o+lhrder-id="{{ $order->id }}">
                                    <form action="/accountant/other_order/update/{{ $order->id }}" method="post">
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
                                            <select name="ce" class="form-select edit-mode">
                                                <option value="" selected>Select</option>
                                                <option value="c" @if($order->ce == 'c') selected @endif>c</option>
                                                <option value="e" @if($order->ce == 'e') selected @endif>e</option>
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
                                            <span>{{$order->name}}</span>
                                        </td>
                                        <td>
                                            <span>{{$order->contact}}</span>
                                        </td>
                                        <td>
                                            <span class="badge fs-5
                                                @if(!$order->work_type == '') bg-dark
                                                @endif">
                                                {{ $order->work_type }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge fs-5
                                                @if($order->work_status == 'done') bg-primary
                                                @elseif($order->work_status == 'pending') bg-danger
                                                @elseif($order->work_status == 'send to customer') bg-warning
                                                @elseif($order->work_status == 'send to designer') bg-dark
                                                @endif">
                                                {{ $order->work_status }}
                                            </span>
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
                                        <td>{{ $order->amount }}</td>
                                        <td>
                                            <span>{{$order->advance}}</span>
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
      const targetTable = document.querySelector(searchInput.getAttribute('data-target-table'));
      const allRows     = Array.from(targetTable.querySelectorAll('tbody tr'));
    
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
      searchInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
          e.preventDefault(); // avoid accidental form submissions
          performSearch();
        }
      });
    });
    </script>
    
    
@endsection