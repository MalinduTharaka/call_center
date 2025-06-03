@extends('layouts.app')

@section('content')
<div class="col-xl-12 mt-2">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="header-title mb-0">Advertiser Work Summary</h4>
                <small class="text-muted">Edit and view advertiser work records.</small>
            </div>
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
                            <th>User</th>
                            <th>Add Count</th>
                            <th>Add Count at 7 PM</th>
                            <th>Target</th>
                            <th>Target Complete Time</th>
                            <th>Off Time</th>
                            <th>OT Hours</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($works as $work)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $work->user->name ?? 'N/A' }}</td>
                                <td>{{ $work->add_count }}</td>
                                <td>{{ $work->wte_add_count }}</td>
                                <td>{{ $work->target }}</td>
                                <td>{{ $work->complete_time }}</td>
                                <td>{{ $work->off_time }}</td>
                                <td>{{ $work->ot/60 }}</td>
                                <td>{{ $work->date }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $work->id }}">Edit</button>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{ $work->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $work->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('advertiser-works.update', $work->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Work Record</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label>Add Count</label>
                                                    <input type="number" name="add_count" class="form-control" value="{{ $work->add_count }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>WTE Add Count</label>
                                                    <input type="number" name="wte_add_count" class="form-control" value="{{ $work->wte_add_count }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label>Target</label>
                                                    <input type="number" name="target" class="form-control" value="{{ $work->target }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label>Complete Time</label>
                                                    <input type="time" name="complete_time" class="form-control" value="{{ $work->complete_time }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label>Off Time</label>
                                                    <input type="time" name="off_time" class="form-control" value="{{ $work->off_time }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label>OT</label>
                                                    <input type="text" name="ot" class="form-control" value="{{ $work->ot }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label>Date</label>
                                                    <input type="date" name="date" class="form-control" value="{{ $work->date }}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
@endsection
