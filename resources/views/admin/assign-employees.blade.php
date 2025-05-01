@extends('layouts.app')
@section('content')

<div class="col-xl-12 mt-2">
    <div class="card">
        <div class="card-header">
            <h4 class="header-title">Manage Call Centers</h4>
            <p class="text-muted mb-0">
                Create and manage call centers.
            </p>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs nav-justified nav-bordered mb-3" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="#call-center-tab" data-bs-toggle="tab" class="nav-link active" role="tab" aria-selected="true">
                        Call Center
                    </a>
                </li>
                {{-- <li class="nav-item" role="presentation">
                    <a href="#add-center-tab" data-bs-toggle="tab" class="nav-link" role="tab" aria-selected="false">
                        Add Center
                    </a>
                </li> --}}
            </ul>

            <div class="tab-content">
                {{-- Call Center Tab --}}
                <div class="tab-pane active show" id="call-center-tab" role="tabpanel">
                    <form action="/store/cc" method="post">
                        @csrf
                        <div class="mb-2">
                            <label for="cc_name_input" class="form-label">Call Center Name</label>
                            <input type="text" id="cc_name_input" class="form-control" name="cc_name" required>
                        </div>
                        <div class="mb-2">
                            <button type="submit" class="btn btn-primary"><i class="ri-add-fill"></i></button>
                        </div>
                    </form>

                    {{-- Call Center Table --}}
                    <div class="table-responsive-sm">
                        <table class="table table-striped table-centered mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($call_centers as $call_center)
                                    <tr>
                                        <td>{{ $call_center->id }}</td>
                                        <td>{{ $call_center->cc_name }}</td>
                                        <td>
                                            <!-- Edit Button -->
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editCallCenterModal{{ $call_center->id }}">Edit</button>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editCallCenterModal{{ $call_center->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <form action="/edit/cc/{{ $call_center->id }}" method="post">
                                                        @csrf
                                                        @method('put')
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Call Center</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <label class="form-label">Call Center Name</label>
                                                                <input type="text" class="form-control" name="cc_name" value="{{ $call_center->cc_name }}">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Done</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Delete -->
                                            <form action="/delete/cc/{{ $call_center->id }}" method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                {{-- <button type="submit" class="btn btn-warning">Delete</button> --}}
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Add Center Tab --}}
                {{-- <div class="tab-pane" id="add-center-tab" role="tabpanel">
                    <form action="/store/ac" method="post">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Add Center Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="ri-add-fill"></i></button>
                    </form>

                    
                    <div class="table-responsive-sm mt-3">
                        <table class="table table-striped table-centered mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($add_centers as $add_center)
                                    <tr>
                                        <td>{{ $add_center->id }}</td>
                                        <td>{{ $add_center->name }}</td>
                                        <td>
                                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editAddCenterModal{{ $add_center->id }}">Edit</button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="editAddCenterModal{{ $add_center->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <form action="/edit/ac/{{ $add_center->id }}" method="post">
                                                        @csrf
                                                        @method('put')
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Add Center</h5>
                                                                <button class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <label class="form-label">Add Center Name</label>
                                                                <input type="text" class="form-control" name="name" value="{{ $add_center->name }}">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button class="btn btn-primary" type="submit">Done</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Delete -->
                                            <form action="/delete/ac/{{ $add_center->id }}" method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-warning">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> --}}

            </div>  
        </div>
    </div>
</div>

@endsection
