@extends('layouts.app')
@section('content')

    <div class="d-flex flex-wrap gap-2 mb-3 mt-2">
        <!-- Static Backdrop modal -->
        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#rateaccmodel">
            Add Rate
        </button>
    </div> <!-- btn list -->

    <!-- Modal -->
    <div class="modal fade" id="rateaccmodel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Rates</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> <!-- end modal header -->
                <div class="modal-body">
                    <form action="/salary-rates/store" method="post">
                        @csrf
                        <div class="mb-3">
                            <label>Role</label>
                            <select name="role" class="form-control">
                                <option disabled selected value="">Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="cro">Call Center Agent</option>
                                <option value="uca">Update Center Agent</option>
                                <option value="adv">Advertiser</option>
                                <option value="dsg">Designer</option>
                                <option value="vde">Video Editor</option>
                                <option value="acc">Accountant</option>
                                <option value="act">Actor</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label>Basic</label>
                                <input type="number" name="basic" class="form-control" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label>Allowance</label>
                                <input type="number" name="allowance" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label>Boosting Bonus</label>
                                <input type="number" name="b_bonus" class="form-control">
                            </div>
                            <div class="col-6 mb-3">
                                <label>Video Bonus</label>
                                <input type="number" name="v_bonus" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label>Advertiser Bonus</label>
                                <input type="number" name="ad_bonus" class="form-control">
                            </div>
                            <div class="col-6 mb-3">
                                <label>Attendence Bonus</label>
                                <input type="number" name="at_bonus" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label>OT</label>
                                <input type="number" name="ot" class="form-control">
                            </div>
                            <div class="col-6 mb-3">
                                <label>Transport</label>
                                <input type="number" name="transport" class="form-control" required>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div> <!-- end modal footer -->
                </form>
            </div> <!-- end modal content-->
        </div> <!-- end modal dialog-->
    </div> <!-- end modal-->
    </div> <!-- end card-body -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Salary Rates</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Role</th>
                                    <th scope="col">Basic</th>
                                    <th scope="col">Allowance</th>
                                    <th scope="col">Boosting Bonus</th>
                                    <th scope="col">Video Bonus</th>
                                    <th scope="col">Advertiser Bonus</th>
                                    <th scope="col">Attendence Bonus</th>
                                    <th scope="col">OT</th>
                                    <th scope="col">Transport</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rates as $rate)
                                    <tr>
                                        <td>{{ $rate->role }}</td>
                                        <td>{{ $rate->basic }}</td>
                                        <td>{{ $rate->allowance }}</td>
                                        <td>{{ $rate->b_bonus }}</td>
                                        <td>{{ $rate->v_bonus }}</td>
                                        <td>{{ $rate->ad_bonus }}</td>
                                        <td>{{ $rate->at_bonus }}</td>
                                        <td>{{ $rate->ot }}</td>
                                        <td>{{ $rate->transport }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#rateeditmodel">
                                                Edit
                                            </button>
                                            <form action="/salary-rates/delete/{{ $rate->id }}" method="post"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    {{-- Rate Edit model --}}
                                    <div class="modal fade" id="rateeditmodel" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                        style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Edit Rates</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div> <!-- end modal header -->
                                                <div class="modal-body">
                                                    <form action="/salary-rates/update/{{ $rate->id }}" method="post">
                                                        @csrf
                                                        @method('put')
                                                        <div class="mb-3">
                                                            <label>Role</label>
                                                            <input type="text" name="basic" class="form-control" name="role"
                                                                value="{{ $rate->role }}" readonly>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6 mb-3">
                                                                <label>Basic</label>
                                                                <input type="number" name="basic" class="form-control"
                                                                    value="{{ $rate->basic }}">
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <label>Allowance</label>
                                                                <input type="number" name="allowance" class="form-control"
                                                                    value="{{ $rate->allowance }}" name="allowance">
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-6 mb-3">
                                                                <label>Boosting Bonus</label>
                                                                <input type="number" name="b_bonus" class="form-control"
                                                                    value="{{ $rate->b_bonus }}" name="b_bonus">
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <label>Video Bonus</label>
                                                                <input type="number" name="v_bonus" class="form-control"
                                                                    value="{{ $rate->v_bonus }}" name="v_bonus">
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-6 mb-3">
                                                                <label>Advertiser Bonus</label>
                                                                <input type="number" name="ad_bonus" class="form-control"
                                                                    value="{{ $rate->ad_bonus }}" name="ad_bonus">
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <label>Attendence Bonus</label>
                                                                <input type="number" name="at_bonus" class="form-control"
                                                                    value="{{ $rate->at_bonus }}" name="at_bonus">
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-6 mb-3">
                                                                <label>OT</label>
                                                                <input type="number" name="ot" class="form-control"
                                                                    value="{{ $rate->ot }}" name="ot">
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <label>Transport</label>
                                                                <input type="number" name="transport" class="form-control"
                                                                    value="{{ $rate->transport }}" name="transport">
                                                            </div>
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
    <!-- end row-->
@endsection