@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mt-2">
                <div class="card-body">
                  
                        <div id="basicwizard">

                            <ul class="nav nav-pills nav-justified form-wizard-header mb-4">
                                <li class="nav-item">
                                    <a href="#basictab1" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link rounded-0 py-2">
                                        <i class="ri-account-circle-line fw-normal fs-20 align-middle me-1"></i>
                                        <span class="d-none d-sm-inline">Add Accounts</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#basictab2" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link rounded-0 py-2">
                                        <i class="ri-profile-line fw-normal fs-20 align-middle me-1"></i>
                                        <span class="d-none d-sm-inline">Work Types</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#basictab3" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link rounded-0 py-2">
                                        <i class="ri-check-double-line fw-normal fs-20 align-middle me-1"></i>
                                        <span class="d-none d-sm-inline">Packages</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content b-0 mb-0">
                                <div class="tab-pane" id="basictab1">
                                    <div class="row">
                                        <div class="col-12">

                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h1>Add Accounts</h1>
                                                <!-- Create button triggers the modal -->
                                                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAccountModal">Create</a>
                                            </div>
                                        
                                            <!-- Display success message -->
                                            @if (session('success'))
                                                <div class="alert alert-success">
                                                    {{ session('success') }}
                                                </div>
                                            @endif
                                        
                                            <!-- Your existing table or listing for accounts goes here -->
                                            <!-- ... -->
                                        
                                            <!-- Create Account Modal -->
                                            <div class="modal fade" id="createAccountModal" tabindex="-1" aria-labelledby="createAccountModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="createAccountModalLabel">Create Account</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="/store/add-account" method="POST">
                                                            <div class="modal-body">
                                                                @csrf
                                                                <div class="form-group mb-3">
                                                                    <label for="name">Name</label>
                                                                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter name" required>
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label for="code">Code</label>
                                                                    <input type="text" name="code" class="form-control" id="code" placeholder="Enter code" required>
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label for="email">Email</label>
                                                                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required>
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label for="phone">Phone</label>
                                                                    <input type="text" name="phone" class="form-control" id="phone" placeholder="Enter phone" required>
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label for="password">Password</label>
                                                                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="table-responsive">
                                                <!-- Table listing the records -->
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Name</th>
                                                            <th>Code</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($addAccounts as $account)
                                                            <tr>
                                                                <td>{{ $account->id }}</td>
                                                                <td>{{ $account->name }}</td>
                                                                <td>{{ $account->code }}</td>
                                                                <td>{{ $account->email }}</td>
                                                                <td>{{ $account->phone }}</td>
                                                                <td>
                                                                    <!-- Edit Button -->
                                                                    <a href="{{ url('/add-account/' . $account->id . '/edit') }}"
                                                                        class="btn btn-sm btn-warning">Edit</a>

                                                                    <!-- Delete Button -->
                                                                    <form action="{{ url('/add-account/' . $account->id) }}"
                                                                        method="POST" style="display:inline-block;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                                            onclick="return confirm('Are you sure you want to delete this account?')">
                                                                            Delete
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                </div>
            </div>
        </div>
    </div>
@endsection
