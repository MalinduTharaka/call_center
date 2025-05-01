@extends('layouts.app')

@section('content')
    <div class="col-xl-12 mt-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="header-title mb-0">Manage Targets</h4>
                    <small class="text-muted">Create and manage different user's targets.</small>
                </div>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                    + Add Target
                </button>
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Target</th>
                                <th>User Role</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($targets as $index => $target)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $target->target }}</td>
                                    <td>{{ ucfirst($target->user_role) }}</td>
                                    <td>{{ ucfirst($target->target_type) }}</td>
                                    <td>{{ ucfirst($target->target_category) }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $target->id }}">
                                            Edit
                                        </button>

                                        <form action="{{ route('target.destroy', $target->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            {{-- <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete this target?')">
                                                Delete
                                            </button> --}}
                                        </form>
                                    </td>
                                </tr>


                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{ $target->id }}" tabindex="-1"
                                    aria-labelledby="editModalLabel{{ $target->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('target.update', $target->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Target</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label>Target</label>
                                                        <input type="number" name="target" class="form-control"
                                                            value="{{ $target->target }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label>User Role</label>
                                                        <select name="user_role" class="form-select" required>
                                                            <option value="">Select Role</option>
                                                            @foreach (['cro', 'video editor', 'admin', 'actor', 'advertiser'] as $role)
                                                                <option value="{{ $role }}"
                                                                    {{ $target->user_role == $role ? 'selected' : '' }}>
                                                                    {{ ucfirst($role) }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label>Target Type</label>
                                                        <select name="target_type" class="form-select" required>
                                                            <option value="">Select Type</option>
                                                            <option value="daily"
                                                                {{ $target->target_type == 'daily' ? 'selected' : '' }}>
                                                                Daily</option>
                                                            <option value="monthly"
                                                                {{ $target->target_type == 'monthly' ? 'selected' : '' }}>
                                                                Monthly</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label>Target Category</label>
                                                        <select name="target_category" class="form-select" required>
                                                            <option value="">Select Category</option>
                                                            @foreach (['video', 'boosting', 'design'] as $category)
                                                                <option value="{{ $category }}"
                                                                    {{ $target->target_category == $category ? 'selected' : '' }}>
                                                                    {{ ucfirst($category) }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
                            @foreach (['cro', 'video editor', 'admin', 'actor', 'advertiser'] as $role)
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
                            <option value="monthly" {{ old('target_type') == 'monthly' ? 'selected' : '' }}>Monthly
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Target Category</label>
                        <select name="target_category" class="form-select" required>
                            <option value="">Select Category</option>
                            @foreach (['video', 'boosting', 'design'] as $category)
                                <option value="{{ $category }}"
                                    {{ old('target_category') == $category ? 'selected' : '' }}>
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
@endsection
