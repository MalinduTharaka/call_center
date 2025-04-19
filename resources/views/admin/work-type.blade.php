@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show position-fixed top-1 end-0 m-3" role="alert"
                    style="z-index: 1050;">
                    {{ session('success') }}
                </div>

                <script>
                    setTimeout(() => {
                        const alert = document.querySelector('.alert');
                        if (alert) {
                            alert.classList.remove('show');
                            alert.classList.add('fade');
                        }
                    }, 3000);
                </script>
            @endif


            {{-- Page Header --}}
            <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
                <h1>Work Types</h1>
                <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#createWorkTypeModal">Create</a>
            </div>

            {{-- Create Work Type Modal --}}
            <div class="modal fade" id="createWorkTypeModal" tabindex="-1" aria-labelledby="createWorkTypeModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('work-types.store') }}" method="POST" class="modal-content">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createWorkTypeModalLabel">Create Work Type</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="name">Work Type Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="order_type">Category</label>
                                <select class="form-control" name="order_type" required>
                                    <option value="">Select Category</option>
                                    <option value="boosting">Boosting</option>
                                    <option value="video">Video</option>
                                    <option value="designs">Design</option>

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

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table  table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Order Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($worktypes as $worktype)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $worktype->name }}</td>
                                <td>{{ $worktype->order_type }}</td>
                                <td>
                                    {{-- Edit Button --}}
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $worktype->id }}">Edit</button>

                                    {{-- Delete Button --}}
                                    <form action="{{ route('work-types.destroy', $worktype->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this work type?')">Delete</button>
                                    </form>

                                    {{-- Edit Modal --}}
                                    <div class="modal fade" id="editModal{{ $worktype->id }}" tabindex="-1"
                                        aria-labelledby="editModalLabel{{ $worktype->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('work-types.update', $worktype->id) }}" method="POST"
                                                class="modal-content">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel{{ $worktype->id }}">Edit
                                                        Work Type</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group mb-3">
                                                        <label for="name">Work Type Name</label>
                                                        <input type="text" class="form-control" name="name"
                                                            value="{{ $worktype->name }}" required>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="order_type">Order Type</label>
                                                        <select class="form-control" name="order_type" required>
                                                            <option value="">Select Category</option>
                                                            <option value="boosting"
                                                                {{ $worktype->order_type == 'boosting' ? 'selected' : '' }}>
                                                                Boosting</option>
                                                            <option value="video"
                                                                {{ $worktype->order_type == 'video' ? 'selected' : '' }}>
                                                                Video</option>
                                                            <option value="design"
                                                                {{ $worktype->order_type == 'design' ? 'selected' : '' }}>
                                                                Design</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Update</button>
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
@endsection
