@extends('layouts.app')
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert"
             style="color: #155724; background-color: #d4edda; border-color: #c3e6cb;">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert"
             style="color: #721c24; background-color: #f8d7da; border-color: #f5c6cb;">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <script>
        setTimeout(() => document.querySelectorAll('.alert')
            .forEach(a => new bootstrap.Alert(a).close()), 1000);
    </script>

    <style>
        /* tr[data-add-acc="1"] { background-color: #f8d7da; }
        tr[data-add-acc="2"] { background-color: rgb(146, 217, 247); }
        tr[data-add-acc="3"] { background-color: rgb(245, 247, 129); } */

        tr .edit-mode { display: none; }
        tr.editing .edit-mode { display: block; }
        tr.editing .display-mode { display: none; }

        .table-responsive { max-height: 70vh; overflow: auto; border: 1px solid #dee2e6; }
        .table-responsive table thead th {
            position: sticky; top: 0; background: #343a40; z-index: 10;
        }
        .table-responsive table td, .table-responsive table th {
            white-space: nowrap; vertical-align: middle;
        }
        .table-responsive::-webkit-scrollbar { width:8px; height:8px; }
        .table-responsive::-webkit-scrollbar-thumb {
            background: #adb5bd; border-radius:4px;
        }
    </style>

    <div class="row mt-3">
        <div class="card-header">
            <h4 class="header-title mb-0">Update Sheet</h4>
        </div>
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
                    <thead class="table-dark border-primary">
                        <tr>
                            <th>ID</th><th>Slip<br>Upload<br>Date</th><th>CRO</th><th>Invoice</th>
                            <th>Name<br>Company</th><th>Contact</th><th>Page</th><th>Work<br>Status</th>
                            <th>Advertiser</th><th>U. Advertiser</th><th>Work<br>Type</th>
                            <th>Add<br>Link</th><th>Update<br>Add<br>Link</th><th>Update</th><th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                   @if (Auth::user()->role != 'cro' || Auth::user()->id == $order->cro)
                        <tr class="fw-semibold"
                            data-order-id="{{ $order->id }}"
                            data-add-acc="{{ $order->add_acc }}">
                            <form action="{{ url('update/sheet/update', $order->id) }}" method="post">
                                @csrf @method('put')

                                <td>{{ $order->order_id }}</td>
                                <td>{{ $order->date->format('Y-m-d') }}</td>
                                <td>{{ $order->plUser->name ?? '-' }}</td>
                                <td>{{ $order->invoice_id }}</td>
                                <td style="max-width:150px; word-wrap:break-word;">
                                    {{ $order->name }}
                                </td>
                                <td>{{ $order->contact }}</td>

                                {{-- Page --}}
                                <td>
                                    <span class="badge fs-5 bg-dark display-mode">
                                        {{ $order->page ?: '-' }}
                                    </span>
                                    <select name="page" class="form-select edit-mode">
                                        <option value="" disabled {{ old('page', $order->page) == '' ? 'selected' : '' }}>
                                            Select
                                        </option>
                                        <option value="new"      {{ old('page', $order->page) == 'new' ? 'selected' : '' }}>new</option>
                                        <option value="our"      {{ old('page', $order->page) == 'our' ? 'selected' : '' }}>our</option>
                                        <option value="existing" {{ old('page', $order->page) == 'existing' ? 'selected' : '' }}>existing</option>
                                    </select>
                                </td>

                                {{-- Work Status --}}
                                <td>
                                    <span class="badge fs-5 display-mode
                                        @if($order->work_status == 'done') bg-primary
                                        @elseif($order->work_status == 'pending') bg-danger
                                        @elseif($order->work_status == 'send to customer') bg-warning
                                        @elseif($order->work_status == 'send to designer') bg-dark
                                        @elseif($order->work_status == 'error') bg-danger
                                        @else bg-info @endif">
                                        {{ $order->work_status ?: '-' }}
                                    </span>
                                    <select name="work_status" class="form-select edit-mode">
                                        <option value="" disabled {{ old('work_status', $order->work_status) == '' ? 'selected' : '' }}>
                                            Select
                                        </option>
                                        @foreach(['done', 'pending', 'send to customer', 'send to designer', 'error'] as $status)
                                            <option value="{{ $status }}"
                                                {{ old('work_status', $order->work_status) == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                {{-- Advertiser (read-only) --}}
                                <td>
                                    <span class="badge bg-dark fs-5">
                                        {{ $order->advertiser->name ?? 'N/A' }}
                                    </span>
                                </td>

                                {{-- Updated Advertiser --}}
                                <td>
                                    <span class="badge bg-dark fs-5 display-mode">
                                        {{ $order->advertiserNew->name ?? 'N/A' }}
                                    </span>
                                    <select name="advertiser_id_new" class="form-select edit-mode">
                                        <option value="" disabled {{ old('advertiser_id_new', $order->advertiser_id_new) == '' ? 'selected' : '' }}>
                                            Select
                                        </option>
                                        @foreach($users as $user)
                                            @if(in_array($user->role, ['adv', 'admin']))
                                                <option value="{{ $user->id }}"
                                                    {{ old('advertiser_id_new', $order->advertiser_id_new) == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>

                                {{-- Work Type --}}
                                <td>
                                    <span class="badge fs-5 display-mode {{ $order->workType ? 'bg-dark' : '' }}">
                                        {{ $order->workType?->name ?? '-' }}
                                    </span>
                                    <select name="work_type" class="form-select edit-mode">
                                        <option value="" disabled {{ old('work_type', $order->workType?->id) == '' ? 'selected' : '' }}>
                                            Select
                                        </option>
                                        @foreach($work_types->where('order_type', 'boosting') as $wt)
                                            <option value="{{ $wt->id }}"
                                                {{ old('work_type', $order->workType?->id) == $wt->id ? 'selected' : '' }}>
                                                {{ $wt->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                {{-- Original Add Link --}}
                                <td>
                                    @if(!$order->add_acc_id)
                                        Not Added
                                    @else
                                        <a href="{{ $order->add_acc_id }}" target="_blank" class="btn btn-info">
                                            <i class="ri-arrow-up-circle-line"></i>
                                        </a>
                                    @endif
                                </td>

                                {{-- Updated Add Link --}}
                                <td>
                                    <span class="display-mode">
                                        @if(!$order->add_acc_id_new) Not Added
                                        @else
                                            <a href="{{ $order->add_acc_id_new }}" target="_blank" class="btn btn-info">
                                                <i class="ri-arrow-up-circle-line"></i>
                                            </a>
                                        @endif
                                    </span>
                                    <input type="text"
                                           name="add_acc_id_new"
                                           class="form-control edit-mode"
                                           value="{{ old('add_acc_id_new', $order->add_acc_id_new) }}">
                                </td>

                                {{-- Update Notes --}}
                                <td>
                                    @if (Auth::user()->role != 'adv')
                                        <span class="display-mode">{{ $order->update }}</span>
                                        <textarea name="update" class="form-control edit-mode" rows="3">{{ old('update', $order->update) }}</textarea>
                                    @else
                                    <span">{{ $order->update }}</span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td>
                                    <button type="button" class="btn btn-primary edit-btn display-mode">Edit</button>
                                    <button type="submit" class="btn btn-success edit-mode">Save</button>
                                </td>
                            </form>
                        </tr>
                    @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Search & Edit JS --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Search
            document.querySelectorAll('.search-btn').forEach(btn =>
                btn.addEventListener('click', () => {
                    const inp = btn.closest('.input-group').querySelector('.search-input'),
                        term = inp.value.trim().toLowerCase();
                    document.querySelectorAll(inp.dataset.targetTable + ' tbody tr')
                        .forEach(r => r.style.display =
                            [...r.cells].some(c => c.textContent.toLowerCase().includes(term))
                                ? '' : 'none'
                        );
                })
            );
            document.querySelectorAll('.search-input').forEach(inp =>
                inp.addEventListener('keypress', e => {
                    if (e.key === 'Enter') inp.closest('.input-group')
                        .querySelector('.search-btn').click();
                })
            );

            // Edit toggling
            let current = null;
            document.querySelectorAll('.edit-btn').forEach(btn =>
                btn.addEventListener('click', e => {
                    e.stopPropagation();
                    if (current && current !== btn.closest('tr')) current.classList.remove('editing');
                    current = btn.closest('tr');
                    current.classList.add('editing');
                })
            );
            document.addEventListener('click', e => {
                if (current && !current.contains(e.target)) {
                    current.classList.remove('editing');
                    current = null;
                }
            });
            document.querySelectorAll('.edit-mode').forEach(el =>
                el.addEventListener('click', e => e.stopPropagation())
            );
        });
    </script>
@endsection
