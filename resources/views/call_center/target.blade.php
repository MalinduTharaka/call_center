@extends('layouts.app')

@section('content')
    <div class="container">
        <h4 class="mb-3">Targets</h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Create Button -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">
            + Add Target
        </button>

        <!-- Targets Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Target</th>
                        <th>User Role</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($targets as $index => $target)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $target->target }}</td>
                            <td>{{ $target->user_role }}</td>
                            <td>{{ $target->target_type }}</td>
                            <td>{{ $target->target_category }}</td>
                            <td>
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
                                                        <option value="cro" {{ $target->user_role == 'cro' ? 'selected' : '' }}>CRO</option>
                                                        <option value="video editor" {{ $target->user_role == 'video editor' ? 'selected' : '' }}>Video Editor</option>
                                                        <option value="admin" {{ $target->user_role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                        <option value="actor" {{ $target->user_role == 'actor' ? 'selected' : '' }}>Actor</option>
                                                        <option value="advertiser" {{ $target->user_role == 'advertiser' ? 'selected' : '' }}>Advertiser</option>
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
                                                        <option value="video" {{ $target->target_category == 'video' ? 'selected' : '' }}>Video</option>
                                                        <option value="boosting" {{ $target->target_category == 'boosting' ? 'selected' : '' }}>Boosting</option>
                                                        <option value="design" {{ $target->target_category == 'design' ? 'selected' : '' }}>Design</option>
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
                                <option value="cro"
                                    {{ old('user_role', $target->user_role ?? '') == 'cro' ? 'selected' : '' }}>CRO
                                </option>
                                <option value="video editor"
                                    {{ old('user_role', $target->user_role ?? '') == 'video editor' ? 'selected' : '' }}>
                                    Video Editor</option>
                                <option value="admin"
                                    {{ old('user_role', $target->user_role ?? '') == 'admin' ? 'selected' : '' }}>Admin
                                </option>
                                <option value="actor"
                                    {{ old('user_role', $target->user_role ?? '') == 'actor' ? 'selected' : '' }}>Actor
                                </option>
                                <option value="advertiser"
                                    {{ old('user_role', $target->user_role ?? '') == 'advertiser' ? 'selected' : '' }}>
                                    Advertiser</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Target Type</label>
                            <select name="target_type" class="form-select" required>
                                <option value="">Select Type</option>
                                <option value="daily"
                                    {{ old('target_type', $target->target_type ?? '') == 'daily' ? 'selected' : '' }}>Daily
                                </option>
                                <option value="monthly"
                                    {{ old('target_type', $target->target_type ?? '') == 'monthly' ? 'selected' : '' }}>
                                    Monthly</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Target Category</label>
                            <select name="target_category" class="form-select" required>
                                <option value="">Select Category</option>
                                <option value="video"
                                    {{ old('target_category', $target->target_category ?? '') == 'video' ? 'selected' : '' }}>
                                    Video</option>
                                <option value="boosting"
                                    {{ old('target_category', $target->target_category ?? '') == 'boosting' ? 'selected' : '' }}>
                                    Boosting</option>
                                <option value="design"
                                    {{ old('target_category', $target->target_category ?? '') == 'design' ? 'selected' : '' }}>
                                    Design</option>
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
