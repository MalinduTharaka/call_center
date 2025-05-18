@extends('layouts.app')
@section('content')

    <div class="mt-3 mb-3">
        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#attendenceAddModal">
            Add Attendance
        </button>
    </div>

    <div class="modal fade" id="attendenceAddModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Attendance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> <!-- end modal header -->
                <form action="/addAttendance/add" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="Employee" class="form-label">Employee Name</label>
                            <select class="form-control" id="Employee" name="user_id">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" value="{{ date('Y-m-d') }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="arrival_time" class="form-label">Arrival Time</label>
                            <input type="time" class="form-control" id="arrival_time" name="arr_time">
                        </div>
                        <div class="mb-3">
                            <label for="leave_time" class="form-label">Leave Time</label>
                            <input type="time" class="form-control" id="leave_time" name="leave_time">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div> <!-- end modal footer -->
                </form>
            </div> <!-- end modal content-->
        </div> <!-- end modal dialog-->
    </div> <!-- end modal-->


    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Today attendances</h4>.
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table table-striped table-centered mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Employee Name</th>
                                    <th>Arrival Time</th>
                                    <th>Leave Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendances as $attendance)
                                    <tr>
                                        <td>{{ $attendance->date }}</td>
                                        <td>{{ $attendance->User->name }}</td>
                                        <td>{{ $attendance->arr_time }}</td>
                                        <td>{{ $attendance->leave_time }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#attendenceEditModal{{ $attendance->id }}">
                                                Edit
                                            </button>
                                            <form action="/attendance/today/delete/{{ $attendance->id }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="attendenceEditModal{{ $attendance->id }}"
                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Edit Attendance</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div> <!-- end modal header -->
                                                <form action="/attendance/today/update/{{ $attendance->id }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="Employee" class="form-label">Employee Name</label>
                                                            <input type="text" class="form-control" id="Employee"
                                                                value="{{ $attendance->User->name }}" disabled>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="date" class="form-label">Date</label>
                                                            <input type="date" class="form-control" id="date" name="date"
                                                                value="{{ $attendance->date }}" disabled>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="arrival_time" class="form-label">Arrival Time</label>
                                                            <input type="time" class="form-control" id="arrival_time"
                                                                name="arr_time" value="{{ $attendance->arr_time }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="leave_time" class="form-label">Leave Time</label>
                                                            <input type="time" class="form-control" id="leave_time"
                                                                name="leave_time" value="{{ $attendance->leave_time }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Edit</button>
                                                    </div> <!-- end modal footer -->
                                                </form>
                                            </div> <!-- end modal content-->
                                        </div> <!-- end modal dialog-->
                                    </div> <!-- end modal-->
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- end table-responsive-->

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

@endsection