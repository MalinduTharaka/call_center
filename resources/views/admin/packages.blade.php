@extends('layouts.app')
@section('content')

    <h2 class="mb-4">Package List</h2>

    <div class="col-12 mb-3">
        <!-- Add Package Button -->
        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addModal">
            Add Package
        </button>
    </div>

    <!-- Add Package Modal -->
    <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Package</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('packages.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="package_amount" class="form-label">Package Amount</label>
                            <input type="number" step="0.01" name="package_amount" id="package_amount" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="tax" class="form-label">Tax</label>
                            <input type="number" step="0.01" name="tax" id="tax" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="service" class="form-label">Service</label>
                            <input type="text" name="service" id="service" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Package Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Package</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('packages.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="pkg_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="update_package_amount" class="form-label">Package Amount</label>
                            <input type="number" step="0.01" name="package_amount" id="update_package_amount" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="update_tax" class="form-label">Tax</label>
                            <input type="number" step="0.01" name="tax" id="update_tax" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="update_service" class="form-label">Service</label>
                            <input type="text" name="service" id="update_service" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($packages->count())
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Package Amount</th>
                        <th>Tax</th>
                        <th>Service</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($packages as $package)
                        <tr>
                            <td>Rs{{ number_format($package->package_amount, 2) }}</td>
                            <td>Rs{{ number_format($package->tax, 2) }}</td>
                            <td>{{ $package->service }}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm editBtn"
                                        data-id="{{ $package->id }}"
                                        data-amount="{{ $package->package_amount }}"
                                        data-tax="{{ $package->tax }}"
                                        data-service="{{ $package->service }}">
                                    Edit
                                </button>
                                <form id="delete-form-{{ $package->id }}" action="{{ route('packages.delete', $package->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Are you sure you want to delete this package?')) document.getElementById('delete-form-{{ $package->id }}').submit();">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No packages available.</p>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Edit button handler
            document.querySelectorAll('.editBtn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.getElementById('pkg_id').value = this.dataset.id;
                    document.getElementById('update_package_amount').value = this.dataset.amount;
                    document.getElementById('update_tax').value = this.dataset.tax;
                    document.getElementById('update_service').value = this.dataset.service;
                    new bootstrap.Modal(document.getElementById('updateModal')).show();
                });
            });
        });
    </script>

@endsection
