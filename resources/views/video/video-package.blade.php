@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Video Packages</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Button trigger modal -->
    <button class="btn btn-primary mb-3" onclick="openCreateModal()">Add New Package</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Amount</th>
                <th>Time</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($packages as $pkg)
                <tr>
                    <td>{{ $pkg->amount }}</td>
                    <td>{{ $pkg->time }}</td>
                    <td>{{ $pkg->type }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="openEditModal({{ $pkg }})">Edit</button>
                        <form action="{{ route('video-packages.destroy', $pkg->id) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Create/Edit Modal -->
    <div class="modal fade" id="pkgModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" id="pkgForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Package Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_id">
                        <div class="mb-3">
                            <label>Amount</label>
                            <input type="number" name="amount" class="form-control" id="amount" required>
                        </div>
                        <div class="mb-3">
                            <label>Time</label>
                            <input type="text" name="time" class="form-control" id="time" required>
                        </div>
                        <div class="mb-3">
                            <label>Type</label>
                            <input type="text" name="type" class="form-control" id="type" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS (make sure this is loaded) -->
<script>
    function openCreateModal() {
        document.getElementById('pkgForm').action = "{{ route('video-packages.store') }}";
        document.getElementById('pkgForm').reset();
        document.getElementById('edit_id').value = '';
        new bootstrap.Modal(document.getElementById('pkgModal')).show();
    }

    function openEditModal(pkg) {
        const form = document.getElementById('pkgForm');
        form.action = "/video-packages/" + pkg.id;
        document.getElementById('amount').value = pkg.amount;
        document.getElementById('time').value = pkg.time;
        document.getElementById('type').value = pkg.type;
        new bootstrap.Modal(document.getElementById('pkgModal')).show();
    }
</script>
@endsection
