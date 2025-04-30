@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            @if (Auth::user()->role !== 'act')
            <h4 class="mb-0">Actors Work Entries</h4>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">
                + Add Entry
            </button>
            @endif
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Work Type</th>
                            <th>Note</th>
                            <th>Amount</th>
                            <th>Date</th>
                            @if (Auth::user()->role !== 'act')
                            <th style="width: 140px;">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entries as $i => $entry)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $entry->user->name ?? 'N/A' }}</td>
                            <td>{{ $entry->work_type }}</td>
                            <td>{{ $entry->note }}</td>
                            <td>Rs. {{ number_format($entry->amount, 2) }}</td>
                            <td>{{ $entry->date }}</td>
                            @if (Auth::user()->role !== 'act')
                            <td>
                                <button class="btn btn-info btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $entry->id }}">
                                    Edit
                                </button>

                                <form action="{{ route('actor.work.destroy', $entry->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this entry?')">
                                        Delete
                                    </button>
                                </form>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{ $entry->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $entry->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('actor.work.update', $entry->id) }}" method="POST" class="modal-content">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Actor Work Entry</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label>User</label>
                                                    <select name="user_id" class="form-select" required>
                                                        @foreach($users as $user)
                                                        <option value="{{ $user->id }}" {{ $entry->user_id == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Work Type</label>
                                                    <select name="work_type" class="form-select" required>
                                                        @foreach ($workTypes as $workType)
                                                            <option value="{{ $workType->name }}" {{ $workType->name == $entry->work_type ? 'selected' : '' }}>
                                                                {{ $workType->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Note</label>
                                                    <textarea name="note" class="form-control" required>{{ $entry->note }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Amount</label>
                                                    <input type="number" name="amount" step="0.01" class="form-control" value="{{ $entry->amount }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Date</label>
                                                    <input type="date" name="date" class="form-control" value="{{ $entry->date }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success btn-sm">Update</button>
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
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

        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('actor.work.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add Actor Work Entry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>User</label>
                    <select name="user_id" class="form-select" required>
                        <option value="">Select User</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Work Type</label>
                    <select name="work_type" class="form-select" required>
                        <option value="">Select Work Type</option>
                        @foreach ($workTypes as $workType)
                            <option value="{{ $workType->name }}">{{ $workType->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Note</label>
                    <textarea name="note" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label>Amount</label>
                    <input type="number" name="amount" step="0.01" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Date</label>
                    <input type="date" name="date" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-sm">Create Entry</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection
