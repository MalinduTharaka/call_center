@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(function () {
                let alert = document.getElementById('success-alert');
                if (alert) {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 300); // remove from DOM after fade out
                }
            }, 2000); // auto close after 3 seconds
        </script>
    @endif


    <!-- Add User Button & Modal -->
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">System Users</h4>
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addUserModal">
                Add User
            </button>

            <!-- Add User Modal -->
            <div class="modal fade" id="addUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addUserLabel">Add User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}">
                                    @error('name')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}">
                                    @error('email')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nic" class="form-label">NIC</label>
                                    <input type="text" id="nic" name="nic" class="form-control" value="{{ old('nic') }}">
                                    @error('nic')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label for="contact" class="form-label">Contact Number</label>
                                    <input type="text" id="contact" name="contact" class="form-control" value="{{ old('contact') }}">
                                    @error('contact')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label for="role" class="form-label">User Role</label>
                                    <select id="role" name="role" class="form-select">
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
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter password">
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
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Users</h4>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>NIC</th>
                        <th>Contact</th>
                        <th>Role</th>
                        <th>Call Center</th>
                        <th>Add Center</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->nic }}</td>
                            <td>{{ $user->contact }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>{{ $user->callCenter->cc_name ?? 'N/A' }}</td>
                            <td>{{ $user->addCenter->name ?? 'N/A' }}</td>
                            <td>
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#assignModal-{{ $user->id }}">Assign</button>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $user->id }}">Edit</button>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">Delete</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Assign Modal -->
                        <div class="modal fade" id="assignModal-{{ $user->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="assignModalLabel-{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="assignModalLabel-{{ $user->id }}">Assign User</h5>
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
                                                    <div class="form-floating mb-3">
                                                        <select class="form-select" name="cc_num">
                                                            <option selected value="{{ $user->cc_num }}">Select Call Center</option>
                                                            @foreach ($call_centers as $call_center)
                                                                <option value="{{ $call_center->id }}">{{ $call_center->cc_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <label>Call Center</label>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-6">
                                                    <div class="form-floating mb-3">
                                                        <select class="form-select" name="ac_num">
                                                            <option selected value="{{ $user->ac_num }}">Select Add Center</option>
                                                            @foreach ($add_centers as $add_center)
                                                                <option value="{{ $add_center->id }}">{{ $add_center->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <label>Add Center</label>
                                                    </div>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Assign</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> <!-- end Assign Modal -->

                        <!-- Edit User Modal -->
                        <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1" aria-labelledby="editLabel-{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editLabel-{{ $user->id }}">Edit User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('users.update', $user) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="name-{{ $user->id }}" class="form-label">Name</label>
                                                <input type="text" id="name-{{ $user->id }}" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                                                @error('name')<div class="text-danger">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="email-{{ $user->id }}" class="form-label">Email</label>
                                                <input type="email" id="email-{{ $user->id }}" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                                                @error('email')<div class="text-danger">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="nic-{{ $user->id }}" class="form-label">NIC</label>
                                                <input type="text" id="nic-{{ $user->id }}" name="nic" class="form-control" value="{{ old('nic', $user->nic) }}">
                                                @error('nic')<div class="text-danger">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="contact-{{ $user->id }}" class="form-label">Contact</label>
                                                <input type="text" id="contact-{{ $user->id }}" name="contact" class="form-control" value="{{ old('contact', $user->contact) }}">
                                                @error('contact')<div class="text-danger">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="role-{{ $user->id }}" class="form-label">Role</label>
                                                <select id="role-{{ $user->id }}" name="role" class="form-select">
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
@endsection
