@extends('layouts.app')

@section('content')
    <div class="col-xl-12 mt-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="header-title mb-0">Manage Video Packages</h4>
                    <small class="text-muted">Create and manage video packages.</small>
                </div>
                <button class="btn btn-primary" onclick="openCreateModal()">+ Add Package</button>
            </div>
            <div class="card-body">

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Amount</th>
                                <th>Time</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $pkg)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pkg->amount }}</td>
                                    <td>{{ $pkg->timeSlot->time_value }} {{ strtoupper($pkg->timeSlot->time_unit) }}</td>
                                    <td>{{ $pkg->type }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning"
                                            onclick="openEditModal({{ $pkg }})">Edit</button>
                                        <form action="{{ route('video-packages.destroy', $pkg->id) }}" method="POST"
                                            style="display:inline-block">
                                            @csrf
                                            @method('DELETE')
                                            {{-- <button onclick="return confirm('Are you sure?')"
                                                class="btn btn-sm btn-danger">Delete</button> --}}
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

    <!-- Create Modal -->
    <div class="modal fade" id="createPkgModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('video-packages.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create New Package</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Amount</label>
                            <input type="number" name="amount" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Time</label>
                            <select name="time" class="form-select" required>
                                <option value="">Select time</option>
                                @foreach($timeSlots as $slot)
                                    <option value="{{ $slot->id }}">
                                        {{ $slot->time_value }} {{ strtoupper($slot->time_unit) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Type</label>
                            <input type="text" name="type" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Create</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editPkgModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" id="editForm">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Package</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label>Amount</label>
                            <input type="number" name="amount" class="form-control" id="edit_amount" required>
                        </div>
                        <div class="mb-3">
                            <label>Time</label>
                            <select name="time" class="form-select" id="edit_time" required>
                                @foreach($timeSlots as $slot)
                                    <option value="{{ $slot->id }}">
                                        {{ $slot->time_value }} {{ strtoupper($slot->time_unit) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Type</label>
                            <input type="text" name="type" class="form-control" id="edit_type" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openCreateModal() {
            const modal = new bootstrap.Modal(document.getElementById('createPkgModal'));
            modal.show();
        }

        function openEditModal(pkg) {
            // Set form action
            const form = document.getElementById('editForm');
            form.action = `/video-packages/${pkg.id}`;
            
            // Populate fields
            document.getElementById('edit_id').value = pkg.id;
            document.getElementById('edit_amount').value = pkg.amount;
            document.getElementById('edit_time').value = pkg.time;
            document.getElementById('edit_type').value = pkg.type;

            const modal = new bootstrap.Modal(document.getElementById('editPkgModal'));
            modal.show();
        }
    </script>
@endsection