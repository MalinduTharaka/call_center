@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h4 class="mb-4">Design Payments</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Create Button -->
    @if (Auth::user()->role !== 'dsg' && Auth::user()->role !== 'acc')
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">
        + Add Payment
    </button>
    @endif

    <!-- Payments Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Work Type</th>
                            <th class="text-center">Amount (Rs.)</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $i => $payment)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $payment->workType->name }}</td>
                                <td class="text-center">₹{{ number_format($payment->amount, 2) }}</td>
                                <td class="text-center">
                                    <!-- Edit -->
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $payment->id }}">
                                        Edit
                                    </button>
                                    <!-- Delete -->
                                    <form action="{{ route('design.payments.destroy', $payment) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Sure to delete?')">
                                            Delete
                                        </button>
                                    </form>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $payment->id }}" tabindex="-1"
                                         aria-labelledby="editModalLabel{{ $payment->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('design.payments.update', $payment) }}"
                                                  method="POST" class="modal-content">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Payment</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label>Work Type</label>
                                                        <select name="work_type_id" class="form-select" required>
                                                            <option value="">Select</option>
                                                            @foreach($workTypes as $wt)
                                                                <option value="{{ $wt->id }}"
                                                                        {{ $wt->id == $payment->work_type_id ? 'selected' : '' }}>
                                                                    {{ $wt->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Amount</label>
                                                        <input type="number" name="amount" step="0.01"
                                                               class="form-control"
                                                               value="{{ $payment->amount }}" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Update</button>
                                                    <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
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
    <div class="modal fade" id="createModal" tabindex="-1"
         aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('design.payments.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Work Type</label>
                        <select name="work_type_id" class="form-select" required>
                            <option value="">Select</option>
                            @foreach($workTypes as $wt)
                                <option value="{{ $wt->id }}">{{ $wt->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Amount</label>
                        <input type="number" name="amount" step="0.01"
                               class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
