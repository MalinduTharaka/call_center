@extends('layouts.app')

@section('content')
<div class="col-xl-12 mt-2">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="header-title mb-0">Manage Time Slots</h4>
                <small class="text-muted">Create and manage time slots.</small>
            </div>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                + Add Time Slot
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Duration</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($timeSlots as $timeSlot)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $timeSlot->time_value }} {{ strtoupper($timeSlot->time_unit) }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" 
                                        data-bs-target="#editModal{{ $timeSlot->id }}">
                                        Edit
                                    </button>
                                    <form action="{{ route('time-slots.destroy', $timeSlot) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        {{-- <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Delete this time slot?')">
                                            Delete
                                        </button> --}}
                                    </form>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" data-bs-backdrop="static" id="editModal{{ $timeSlot->id }}" tabindex="-1"
                                aria-labelledby="editModalLabel{{ $timeSlot->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Time Slot</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('time-slots.update', $timeSlot) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Time</label>
                                                    <input type="number" name="time_value" class="form-control" 
                                                        value="{{ old('time_value', $timeSlot->time_value) }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Time Unit</label>
                                                    <select name="time_unit" class="form-select" required>
                                                        <option value="m" {{ old('time_unit', $timeSlot->time_unit) == 'm' ? 'selected' : '' }}>Minutes</option>
                                                        <option value="s" {{ old('time_unit', $timeSlot->time_unit) == 's' ? 'selected' : '' }}>Seconds</option>
                                                        <option value="h" {{ old('time_unit', $timeSlot->time_unit) == 'h' ? 'selected' : '' }}>Hours</option>
                                                    </select>
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

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Time Slot</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('time-slots.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Time</label>
                            <input type="number" name="time_value" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Time Unit</label>
                            <select name="time_unit" class="form-select" required>
                                <option value="" selected>Select Unit</option>
                                <option value="m">Minutes</option>
                                <option value="s">Seconds</option>
                                <option value="h">Hours</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Reset create modal
        const createModal = document.getElementById('createModal');
        createModal.addEventListener('hidden.bs.modal', function() {
            this.querySelector('form').reset();
            // Reset select to default option
            this.querySelector('select[name="time_unit"]').value = '';
        });

        // Reset edit modals
        document.querySelectorAll('[id^="editModal"]').forEach(modal => {
            modal.addEventListener('hidden.bs.modal', function() {
                const form = this.querySelector('form');
                const originalTime = "{{ old('time', $timeSlot->time) }}"; // Will need adjustment
                const originalUnit = "{{ old('time_unit', $timeSlot->time_unit) }}";
                
                // Reset to original values
                form.querySelector('input[name="time"]').value = originalTime;
                form.querySelector('select[name="time_unit"]').value = originalUnit;
            });
        });

        // Reset create form on successful submission
        document.getElementById('createModal').querySelector('form').addEventListener('submit', function() {
            setTimeout(() => {
                this.reset();
                this.querySelector('select[name="time_unit"]').value = '';
            }, 1000);
        });

        // Reset edit forms on successful submission
        document.querySelectorAll('[id^="editModal"]').forEach(modal => {
            modal.querySelector('form').addEventListener('submit', function() {
                setTimeout(() => {
                    const originalTime = "{{ $timeSlot->time }}";
                    const originalUnit = "{{ $timeSlot->time_unit }}";
                    this.querySelector('input[name="time"]').value = originalTime;
                    this.querySelector('select[name="time_unit"]').value = originalUnit;
                }, 1000);
            });
        });
    });
</script>

@endsection