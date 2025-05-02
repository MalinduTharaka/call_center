@extends('layouts.app')

@section('content')
<div class="col-xl-12 mt-2">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Users Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="header-title mb-0">Manage Users</h4>
                <small class="text-muted">Manage all system users and their permissions here.</small>
            </div>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                + Add User
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>NIC</th>
                            <th>Contact</th>
                            <th>Role</th>
                            <th>Call Center</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->nic }}</td>
                                <td>{{ $user->contact }}</td>
                                <td>{{ ucfirst($user->role) }}</td>
                                <td>{{ $user->callCenter->cc_name ?? 'N/A' }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" 
                                        data-bs-target="#assignModal-{{ $user->id }}">
                                        Assign
                                    </button>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" 
                                        data-bs-target="#editUserModal-{{ $user->id }}">
                                        Edit
                                    </button>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        {{-- <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Delete this user?')">
                                            Delete
                                        </button> --}}
                                    </form>
                                </td>
                            </tr>

                            <!-- Assign Modal -->
                            <div class="modal fade" id="assignModal-{{ $user->id }}" tabindex="-1"
                                aria-labelledby="assignModalLabel-{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Assign User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="/assign/user/{{ $user->id }}" method="post">
                                            @csrf
                                            @method('put')
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Name</label>
                                                            <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Role</label>
                                                            <input type="text" class="form-control" value="{{ $user->role }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label>Call Center</label>
                                                            <select class="form-select" name="cc_num">
                                                                <option selected value="{{ $user->cc_num }}">Select Call Center</option>
                                                                @foreach ($call_centers as $call_center)
                                                                    <option value="{{ $call_center->id }}">{{ $call_center->cc_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Assign</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit User Modal -->
                            <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1"
                                aria-labelledby="editUserModalLabel-{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('users.update', $user) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                                                    @error('name')<div class="text-danger">{{ $message }}</div>@enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                                                    @error('email')<div class="text-danger">{{ $message }}</div>@enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">NIC</label>
                                                    <input type="text" name="nic" class="form-control" value="{{ old('nic', $user->nic) }}">
                                                    @error('nic')<div class="text-danger">{{ $message }}</div>@enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Contact</label>
                                                    <input type="text" name="contact" class="form-control" value="{{ old('contact', $user->contact) }}">
                                                    @error('contact')<div class="text-danger">{{ $message }}</div>@enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Role</label>
                                                    <select name="role" class="form-select">
                                                        <option disabled>Select Role</option>
                                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                                        <option value="cro" {{ old('role', $user->role) == 'cro' ? 'selected' : '' }}>Call Center Agent</option>
                                                        <option value="uca" {{ old('role', $user->role) == 'uca' ? 'selected' : '' }}>Update Center Agent</option>
                                                        <option value="adv" {{ old('role', $user->role) == 'adv' ? 'selected' : '' }}>Advertiser</option>
                                                        <option value="dsg" {{ old('role', $user->role) == 'dsg' ? 'selected' : '' }}>Designer</option>
                                                        <option value="vde" {{ old('role', $user->role) == 'vde' ? 'selected' : '' }}>Video Editor</option>
                                                        <option value="acc" {{ old('role', $user->role) == 'acc' ? 'selected' : '' }}>Accountant</option>
                                                        <option value="act" {{ old('role', $user->role) == 'act' ? 'selected' : '' }}>Actor</option>
                                                    </select>
                                                    @error('role')<div class="text-danger">{{ $message }}</div>@enderror
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">Update</button>
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

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            @error('email')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIC</label>
                            <input type="text" name="nic" class="form-control" value="{{ old('nic') }}">
                            @error('nic')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact" class="form-control" value="{{ old('contact') }}">
                            @error('contact')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">User Role</label>
                            <select name="role" class="form-select">
                                <option disabled selected value="">Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="cro">Call Center Agent</option>
                                <option value="uca">Update Center Agent</option>
                                <option value="adv">Advertiser</option>
                                <option value="dsg">Designer</option>
                                <option value="vde">Video Editor</option>
                                <option value="acc">Accountant</option>
                                <option value="act">Actor</option>
                            </select>
                            @error('role')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" name="password" class="form-control" placeholder="Enter password">
                                <span class="input-group-text" data-password="false">
                                    <i class="password-eye"></i>
                                </span>
                            </div>
                            @error('password')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection