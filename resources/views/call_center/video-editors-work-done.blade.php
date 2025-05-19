@extends('layouts.app')

@section('content')
    <div>
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form method="GET" action="{{ route('video.editors.index') }}" class="row g-2 mb-3">
                    {{-- Month‑Year --}}
                    <div class="col-auto">
                        <label class="form-label">Month‑Year</label>
                        <input type="month" name="month_year" class="form-control form-control-sm"
                            value="{{ old('month_year', $request->month_year) }}">
                    </div>

                    {{-- Exact Date --}}
                    <div class="col-auto">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" class="form-control form-control-sm"
                            value="{{ old('date', $request->date) }}">
                    </div>

                    {{-- User --}}
                    <div class="col-auto">
                        <label class="form-label">User</label>
                        <select name="user_id" class="form-select form-select-sm">
                            <option value="">All</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $request->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Work Status --}}
                    <div class="col-auto">
                        <label class="form-label">Work Status</label>
                        <select name="work_status" class="form-select form-select-sm">
                            <option value="">All</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ $request->work_status == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="col-auto align-self-end">
                        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                        <a href="{{ route('video.editors.index') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
                    </div>
                </form>


                @if($entries->count())
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Order ID</th>
                                    <th>Client Name</th>
                                    <th>Work Status</th>
                                    <th>User</th>
                                    <th>Work Type</th>
                                    <th>Duration</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    @if (Auth::user()->role !== 'vde')
                                        <th style="width: 160px;">Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entries as $index => $entry)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $entry->order_id }}</td>
                                        <td>{{ $entry->Order->name ?? '-' }}</td>
                                        <td>{{ $entry->Order->work_status ?? '-' }}</td>
                                        <td>{{ $entry->user->name ?? '-' }}</td>
                                        <td>{{ $entry->work_type }}</td>
                                        <td>{{ $entry->duration }}</td>
                                        <td>Rs. {{ number_format($entry->amount, 2) }}</td>
                                        <td>{{ $entry->date }}</td>
                                        @if (Auth::user()->role !== 'vde')
                                            <td>
                                                <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $entry->id }}">
                                                    Edit
                                                </button>

                                                <form action="{{ route('video.editors.destroy', $entry->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure?')">
                                                        Delete
                                                    </button>
                                                </form>

                                                <!-- Edit Modal -->
                                                <div class="modal fade" id="editModal{{ $entry->id }}" tabindex="-1"
                                                    aria-labelledby="editModalLabel{{ $entry->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form action="{{ route('video.editors.update', $entry->id) }}" method="POST"
                                                            class="modal-content">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Work Entry</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label class="form-label">User</label>
                                                                    <select name="user_id" class="form-select" required disabled>
                                                                        @foreach ($users as $user)
                                                                            <option value="{{ $user->id }}" {{ $user->id == $entry->user_id ? 'selected' : '' }}>
                                                                                {{ $user->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Work Type</label>
                                                                    <select name="work_type" class="form-select" required disabled>
                                                                        @foreach ($workTypes as $workType)
                                                                            <option value="{{ $workType->name }}" {{ $workType->name == $entry->work_type ? 'selected' : '' }}>
                                                                                {{ $workType->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Duration</label>
                                                                    <input type="text" name="duration" class="form-control"
                                                                        value="{{ $entry->duration }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Amount</label>
                                                                    <input type="number" name="amount" step="0.01" class="form-control"
                                                                        value="{{ $entry->amount }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Date</label>
                                                                    <input type="date" name="date" class="form-control"
                                                                        value="{{ $entry->date }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-success btn-sm">Update</button>
                                                                <button type="button" class="btn btn-secondary btn-sm"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mt-3">No work entries found.</p>
                @endif
            </div>
        </div>
    </div>

@endsection