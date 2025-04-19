@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Video Editors Work Entries</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Create Button -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">
        + Add Work Entry
    </button>

    <!-- Work Entries Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Work Type</th>
                    <th>Duration</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entries as $index => $entry)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $entry->user->name ?? 'N/A' }}</td>
                    <td>{{ $entry->work_type }}</td>
                    <td>{{ $entry->duration }}</td>
                    <td>Rs. {{ number_format($entry->amount, 2) }}</td>
                    <td>{{ $entry->date }}</td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editModal{{ $entry->id }}">
                            Edit
                        </button>

                        <!-- Delete Form -->
                        <form action="{{ route('video.editors.destroy', $entry->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $entry->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $entry->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('video.editors.update', $entry->id) }}" method="POST" class="modal-content">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Work Entry</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>User</label>
                                            <select name="user_id" class="form-select" required>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}" {{ $user->id == $entry->user_id ? 'selected' : '' }}>
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
                                            <label>Duration</label>
                                            <input type="text" name="duration" class="form-control" value="{{ $entry->duration }}" required>
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
                                        <button type="submit" class="btn btn-success">Update</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('video.editors.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Work Entry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>User</label>
                        <select name="user_id" class="form-select" required>
                            <option value="">Select User</option>
                            @foreach ($users as $user)
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
                        <label>Duration</label>
                        <input type="text" name="duration" class="form-control" required>
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
                    <button type="submit" class="btn btn-primary">Create Entry</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection