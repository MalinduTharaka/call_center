@extends('layouts.app')

@section('content')
<div class="col-xl-12 mt-2">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="header-title mb-0">Manage Boosting Packages</h4>
                <small class="text-muted">Create and manage boosting packages.</small>
            </div>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                + Add Package
            </button>
        </div>        

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Package Amount</th>
                            <th>Tax</th>
                            <th>Service Charge</th>
                            <th>Full Amount</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($packages as $i => $package)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ number_format($package->package_amount, 2) }}</td>
                                <td>{{ number_format($package->tax, 2) }}</td>
                                <td>{{ number_format($package->service, 2) }}</td>
                                <td>{{ number_format($package->full, 2) }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning edit-btn" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#updateModal"
                                            data-id="{{ $package->id }}"
                                            data-amount="{{ $package->package_amount }}"
                                            data-tax="{{ $package->tax }}"
                                            data-service="{{ $package->service }}"
                                            data-full="{{ $package->full }}">
                                        Edit
                                    </button>

                                    <form action="{{ route('packages.delete', $package->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        {{-- <button type="button" class="btn btn-sm btn-danger" onclick="if(confirm('Are you sure you want to delete this package?')) this.closest('form').submit();">
                                            Delete
                                        </button> --}}
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

<!-- Add Package Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('packages.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add New Package</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
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
                        <label for="service" class="form-label">Service Charge</label>
                        <input type="number" name="service" id="service" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="full" class="form-label">Full Amount</label>
                        <input type="number" step="0.01" name="full" id="full" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-sm">Add Package</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Update Package Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="updateForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="update_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Package</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
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
                        <label for="update_service" class="form-label">Service Charge</label>
                        <input type="number" name="service" id="update_service" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="update_full" class="form-label">Full Amount</label>
                        <input type="number" step="0.01" name="full" id="update_full" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-sm">Update Package</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle edit button clicks
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Get the package data from data attributes
                const id = this.dataset.id;
                const amount = this.dataset.amount;
                const tax = this.dataset.tax;
                const service = this.dataset.service;
                const full = this.dataset.full;
                
                // Set the form action
                document.getElementById('updateForm').action = "{{ route('packages.update') }}";
                
                // Populate the form fields
                document.getElementById('update_id').value = id;
                document.getElementById('update_package_amount').value = amount;
                document.getElementById('update_tax').value = tax;
                document.getElementById('update_service').value = service;
                document.getElementById('update_full').value = full;
            });
        });

        // Calculate full amount for add form
        ['package_amount', 'tax', 'service'].forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.addEventListener('input', () => calculateFullAmount(true));
            }
        });

        // Calculate full amount for update form
        ['update_package_amount', 'update_tax', 'update_service'].forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.addEventListener('input', () => calculateFullAmount(false));
            }
        });

        // Initialize calculations on page load
        calculateFullAmount(true);
        calculateFullAmount(false);
    });

    function calculateFullAmount(addMode = true) {
        const prefix = addMode ? '' : 'update_';
        const amount = parseFloat(document.getElementById(prefix + 'package_amount')?.value) || 0;
        const tax = parseFloat(document.getElementById(prefix + 'tax')?.value) || 0;
        const service = parseFloat(document.getElementById(prefix + 'service')?.value) || 0;
        const fullField = document.getElementById(prefix + 'full');
        
        if (fullField) {
            fullField.value = (amount + tax + service).toFixed(2);
        }
    }
</script>
@endsection