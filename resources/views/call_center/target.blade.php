@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Targets</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Create Button -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">
        + Add Target
    </button>

    <!-- Targets Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Target</th>
                            <th class="text-center">User Role</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($targets as $index => $target)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $target->target }}</td>
                                <td>{{ ucfirst($target->user_role) }}</td>
                                <td>{{ ucfirst($target->target_type) }}</td>
                                <td>{{ ucfirst($target->target_category) }}</td>
                                <td class="text-center">
                                    <!-- Edit Button -->
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $target->id }}">
                                        Edit
                                    </button>

                                    <!-- Delete Form -->
                                    <form action="{{ route('target.destroy', $target->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this target?')">
                                            Delete
                                        </button>
                                    </form>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $target->id }}" tabindex="-1"
                                        aria-labelledby="editModalLabel{{ $target->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('target.update', $target->id) }}" method="POST" class="modal-content">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Target</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label>Target</label>
                                                        <input type="number" name="target" class="form-control" value="{{ $target->target }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label>User Role</label>
                                                        <select name="user_role" class="form-select" required>
                                                            <option value="">Select Role</option>
                                                            @foreach(['cro', 'video editor', 'admin', 'actor', 'advertiser'] as $role)
                                                                <option value="{{ $role }}" {{ $target->user_role == $role ? 'selected' : '' }}>
                                                                    {{ ucfirst($role) }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label>Target Type</label>
                                                        <select name="target_type" class="form-select" required>
                                                            <option value="">Select Type</option>
                                                            <option value="daily" {{ $target->target_type == 'daily' ? 'selected' : '' }}>Daily</option>
                                                            <option value="monthly" {{ $target->target_type == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label>Target Category</label>
                                                        <select name="target_category" class="form-select" required>
                                                            <option value="">Select Category</option>
                                                            @foreach(['video', 'boosting', 'design'] as $category)
                                                                <option value="{{ $category }}" {{ $target->target_category == $category ? 'selected' : '' }}>
                                                                    {{ ucfirst($category) }}
                                                                </option>
                                                            @endforeach
                                                        </select>
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
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('target.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Target</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Target</label>
                        <input type="number" name="target" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>User Role</label>
                        <select name="user_role" class="form-select" required>
                            <option value="">Select Role</option>
                            @foreach(['cro', 'video editor', 'admin', 'actor', 'advertiser'] as $role)
                                <option value="{{ $role }}" {{ old('user_role') == $role ? 'selected' : '' }}>
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Target Type</label>
                        <select name="target_type" class="form-select" required>
                            <option value="">Select Type</option>
                            <option value="daily" {{ old('target_type') == 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="monthly" {{ old('target_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Target Category</label>
                        <select name="target_category" class="form-select" required>
                            <option value="">Select Category</option>
                            @foreach(['video', 'boosting', 'design'] as $category)
                                <option value="{{ $category }}" {{ old('target_category') == $category ? 'selected' : '' }}>
                                    {{ ucfirst($category) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
