@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Design Payments</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Create Button -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">
        + Add Payment
    </button>

    <!-- Payments Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
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
