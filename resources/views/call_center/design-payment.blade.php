@extends('layouts.app')

@section('content')
<div class="col-xl-12 mt-2">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="header-title mb-0">Manage Design Payments</h4>
                <small class="text-muted">Create and manage payments related to design work types.</small>
            </div>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createPaymentModal">
                + Add Payment
            </button>
        </div>
        
        <div class="card-body">

            {{-- Create Payment Modal --}}
            <div class="modal fade" id="createPaymentModal" tabindex="-1" aria-labelledby="createPaymentModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('design.payments.store') }}" method="POST" class="modal-content">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createPaymentModalLabel">Add Payment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="work_type">Work Type</label>
                                <select name="work_type_id" class="form-select" required>
                                    <option value="">Select Work Type</option>
                                    @foreach($workTypes as $wt)
                                        <option value="{{ $wt->id }}">{{ $wt->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="amount">Amount (Rs.)</label>
                                <input type="number" name="amount" step="0.01" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Design Payments Table --}}
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Work Type</th>
                            <th>Amount (Rs.)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $i => $payment)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $payment->workType->name }}</td>
                                <td>{{ number_format($payment->amount, 2) }}</td>
                                <td>
                                    <!-- Edit Button -->
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $payment->id }}">Edit</button>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $payment->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $payment->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('design.payments.update', $payment) }}" method="POST" class="modal-content">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel{{ $payment->id }}">Edit Payment</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group mb-3">
                                                        <label for="work_type">Work Type</label>
                                                        <select name="work_type_id" class="form-select" required>
                                                            <option value="">Select Work Type</option>
                                                            @foreach($workTypes as $wt)
                                                                <option value="{{ $wt->id }}" {{ $wt->id == $payment->work_type_id ? 'selected' : '' }}>{{ $wt->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="amount">Amount (Rs.)</label>
                                                        <input type="number" name="amount" step="0.01" class="form-control" value="{{ $payment->amount }}" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Delete Button -->
                                    <form action="{{ route('design.payments.destroy', $payment) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        {{-- <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this payment?')">Delete</button> --}}
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
@endsection
