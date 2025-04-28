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

    {{-- Auto-dismiss alerts --}}
    <script>
        setTimeout(function () {
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

            <table id="ordersTable" class="table table-hover table-centered table-bordered border-primary mb-0">
                <thead class="table-dark">
                <tr>
                    <th>Id</th>
                    <th>Date</th>
                    <th>C/E</th>
                    <th>Invoice</th>
                    <th>Name<br>Company</th>
                    <th>Contact</th>
                    <th>Work<br>Type</th>
                    <th>Work<br>Status</th>
                    <th>Payment</th>
                    <th>Designer</th>
                    <th>Amount</th>
                    <th>Advance</th>
                    <th>Slip</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders as $order)
                    @if (Auth::user()->cc_num == $order->cro && $order->ps == '1' && $order->order_type == 'designs')
                        <form action="{{ url('/orders/update/designers/' . $order->id) }}" method="post">
                            @csrf
                            @method('put')
                            <tr data-order-id="{{ $order->id }}">
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->date }}</td>
                                <td>
                                    <span class="badge fs-5 display-mode 
                                        @if($order->ce == 'c') bg-primary
                                        @elseif($order->ce == 'e') bg-danger
                                        @endif">
                                        {{ strtoupper($order->ce) }}
                                    </span>
                                    <select name="ce" class="form-select edit-mode">
                                        <option value="" disabled>Select</option>
                                        <option value="c" @if($order->ce == 'c') selected @endif>c</option>
                                        <option value="e" @if($order->ce == 'e') selected @endif>e</option>
                                    </select>
                                </td>
                                <td>
                                    <span class="display-mode">{{ $order->invoice }}</span>
                                    <input type="text" name="inv" class="form-control edit-mode"
                                           value="{{ $order->invoice }}">
                                </td>
                                <td>
                                    <span class="display-mode">{{ $order->name }}</span>
                                    <input type="text" name="name" class="form-control edit-mode"
                                           value="{{ $order->name }}">
                                </td>
                                <td>
                                    <span class="display-mode">{{ $order->contact }}</span>
                                    <input type="text" name="contact" class="form-control edit-mode"
                                           value="{{ $order->contact }}">
                                </td>
                                <td>
                                    <span class="badge fs-5 display-mode @if(optional($order->workType)->name) bg-dark @endif">
                                        {{ optional($order->workType)->name ?? '—' }}
                                    </span>
                                    <select name="work_type_id" class="form-select edit-mode">
                                        <option value="" disabled>Select</option>
                                        @foreach ($work_types as $wt)
                                            @if ($wt->order_type == 'designs')
                                                <option value="{{ $wt->id }}"
                                                    @if($order->work_type_id == $wt->id) selected @endif>
                                                    {{ $wt->name }}
                                                </option>
                                            @endif
                                        @endforeach
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
                                        <option value="" disabled>Select</option>
                                        @foreach(['done','pending','send to customer','send to designer'] as $status)
                                            <option value="{{ $status }}"
                                                @if($order->work_status == $status) selected @endif>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <span class="badge fs-5 display-mode
                                        @if($order->payment_status == 'done') bg-primary
                                        @elseif($order->payment_status == 'pending') bg-danger
                                        @elseif(in_array($order->payment_status, ['partial','rejected'])) bg-warning
                                        @endif">
                                        {{ $order->payment_status }}
                                    </span>
                                    <select name="payment_status" class="form-select edit-mode">
                                        <option value="" disabled>Select</option>
                                        @foreach(['done','partial','pending','rejected'] as $pay)
                                            <option value="{{ $pay }}"
                                                @if($order->payment_status == $pay) selected @endif>
                                                {{ $pay }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>{{ $order->designer_id }}</td>
                                <td>{{ $order->amount }}</td>
                                <td>{{ $order->advance }}</td>
                                <td>@include('includes.slip-view')</td>
                                <td>
                                    <button type="button" class="btn btn-primary edit-btn display-mode">Edit</button>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Toggle edit mode
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('tr.editing').forEach(r => r.classList.remove('editing'));
                    this.closest('tr').classList.add('editing');
                });
            });

            // Click outside to cancel edit
            document.addEventListener('click', function (e) {
                const editingRow = document.querySelector('tr.editing');
                if (editingRow && !editingRow.contains(e.target)) {
                    editingRow.classList.remove('editing');
                }
            });

            // Search handlers
            document.querySelectorAll('.search-btn').forEach(button => {
                button.addEventListener('click', function () {
                    performSearch(this.closest('.input-group').querySelector('.search-input'));
                });
            });
            document.querySelectorAll('.search-input').forEach(input => {
                input.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter') {
                        performSearch(this);
                    }
                });
            });
        });

        function performSearch(input) {
            const term = input.value.toLowerCase();
            const table = document.querySelector(input.dataset.targetTable);
            if (!table) return;
            table.querySelectorAll('tbody tr').forEach(row => {
                const match = Array.from(row.querySelectorAll('td')).some(cell => {
                    const d = cell.querySelector('.display-mode')?.textContent.toLowerCase() || '';
                    const v = cell.querySelector('.edit-mode')?.value.toLowerCase() || '';
                    return d.includes(term) || v.includes(term);
                });
                row.style.display = match ? '' : 'none';
            });
        }
    </script>

@endsection
