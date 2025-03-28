@extends('layouts.app')
@section('content')

<div class="row mt-3">
    <div class="col-lg-4">
        <div class="card">
            <div class="row g-0 align-items-center">
                <div class="col-md-4">
                    <img src="{{ asset('assets/images/small/small-4.jpg')}}" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body p-0">
                        <button class="btn w-100 h-100 text-start p-3" data-bs-toggle="modal" data-bs-target="#boostingmodel">
                            <h5 class="card-title mb-0">Bgoosting</h5>
                        </button>
                    </div> <!-- end card-body-->
                </div> <!-- end col -->
            </div> <!-- end row-->
        </div> <!-- end card-->
    </div> <!-- end col-->
    <div class="col-lg-4">
        <div class="card">
            <div class="row g-0 align-items-center">
                <div class="col-md-4">
                    <img src="{{ asset('assets/images/small/small-4.jpg')}}" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body p-0">
                        <button class="btn w-100 h-100 text-start p-3" data-bs-toggle="modal" data-bs-target="#adsmodel">
                            <h5 class="card-title mb-0">Designs</h5>
                        </button>
                    </div> <!-- end card-body-->
                </div> <!-- end col -->
            </div> <!-- end row-->
        </div> <!-- end card-->
    </div> <!-- end col-->
    <div class="col-lg-4">
        <div class="card">
            <div class="row g-0 align-items-center">
                <div class="col-md-4">
                    <img src="{{ asset('assets/images/small/small-4.jpg')}}" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body p-0">
                        <button class="btn w-100 h-100 text-start p-3" data-bs-toggle="modal" data-bs-target="#videomodel">
                            <h5 class="card-title mb-0">Video</h5>
                        </button>
                    </div> <!-- end card-body-->
                </div> <!-- end col -->
            </div> <!-- end row-->
        </div> <!-- end card-->
    </div> <!-- end col-->
</div>
<!-- end row -->

<!-- Modal Boosting -->
<div class="modal fade" id="boostingmodel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">New Order Boosting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> <!-- end modal header -->
            <div class="modal-body">
                <form action="/store/boosting" method="post">
                    @csrf
                    <div class="mt-2 d-none">
                        <div class="form-check form-check-inline">
                            <input type="radio" id="radio1" name="order_type" class="form-check-input" checked>
                            <label class="form-check-label" for="customRadio3">Boosting</label>
                        </div>
                    </div>
                    <!-- Form row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                {{-- <div class="card-header">
                                    <h4 class="header-title">Form Row</h4>
                                    <p class="text-muted mb-0">
                                        By adding <code>.row</code> & <code>.g-2</code>, you can have control over the
                                        gutter width in as well the inline as block direction.
                                    </p>
                                </div> --}}
                                <div class="card-body">
                                        <div class="row g-2">
                                            <div class="mb-3 col-md-6 all" >
                                                <label for="inputEmail4" class="form-label">Name / Company</label>
                                                <input type="text" class="form-control" name="name" id="name" placeholder="Name / Company">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="Contact" class="form-label">Contact</label>
                                                <input type="text" class="form-control" name="contact" id="contact" placeholder="Contact" required>
                                            </div>
                                        </div>

                                        <div class="row g-2 all">
                                            <label for="inputState" class="form-label">Work Type</label>
                                                <select id="work_type" name="work_type" class="form-select">
                                                    <option>Choose</option>
                                                    <option>Option 1</option>
                                                    <option>Option 2</option>
                                                    <option>Option 3</option>
                                                </select>
                                        </div>

                                        <div class="row g-2 mt-2 mb-2 boosting">
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" id="customSwitch1">
                                                <label class="form-check-label" for="customSwitch1">Switch on for custom package</label>
                                            </div>
                                        </div>
                                        
                                        <div class="row g-2 predefined">
                                            <div class="mb-3 col-md-12">
                                                <label for="package" class="form-label">Package</label>
                                                <select id="package" name="package_id" class="form-select">
                                                    <option>Choose</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="row g-2 custom" style="display: none;">
                                            <div class="mb-3 col-md-4">
                                                <label for="amount" class="form-label">Amount</label>
                                                <input type="text" class="form-control" id="amount">
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label for="tax" class="form-label">Tax</label>
                                                <input type="text" class="form-control" id="tax">
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label for="service" class="form-label">Service</label>
                                                <input type="text" class="form-control" id="service">
                                            </div>
                                        </div>
                                        
                                        <script>
                                            document.getElementById('customSwitch1').addEventListener('change', function () {
                                                if (this.checked) {
                                                    // Hide predefined, show custom
                                                    document.querySelector('.predefined').style.display = 'none';
                                                    document.querySelector('.custom').style.display = 'flex';
                                        
                                                    // Disable predefined input
                                                    document.getElementById('package').disabled = true;
                                        
                                                    // Enable custom inputs
                                                    document.querySelectorAll('.custom-input').forEach(input => input.disabled = false);
                                                } else {
                                                    // Show predefined, hide custom
                                                    document.querySelector('.predefined').style.display = 'flex';
                                                    document.querySelector('.custom').style.display = 'none';
                                        
                                                    // Enable predefined input
                                                    document.getElementById('package').disabled = false;
                                        
                                                    // Disable custom inputs
                                                    document.querySelectorAll('.custom-input').forEach(input => input.disabled = true);
                                                }
                                            });
                                        </script>
                                        
                                        

                                        <hr>

                                        <div class="row g-2 all">
                                            <div class="mb-3 col-md-6">
                                                <label for="inputAddress" class="form-label">Pay status</label>
                                                <select id="payment_status" name="payment_status" class="form-select">
                                                    <option value="done">Done</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="Partial">Partial</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="inputAddress" class="form-label">Pay Method</label>
                                                <select id="package" name="cash" class="form-select">
                                                    <option value="1">Cash Payment</option>
                                                    <option value="0">None Cash Payment</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row g-2 all">
                                            <div class="mb-3 col-md-6">
                                                <label for="advance" class="form-label">Advance</label>
                                                <input type="text" name="advance" class="form-control" id="advance">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="amount" class="form-label">Amount</label>
                                                <input type="text" name="amount" class="form-control" id="amount">
                                            </div>
                                        </div>


                                        <div class="row g-2 boosting">
                                            <div class="mb-3 col-md-6">
                                                <label for="page" class="form-label">Page</label>
                                                <select id="page" name="page" class="form-select">
                                                    <option value="existing">Existing Page</option>
                                                    <option value="new">New Page</option>
                                                    <option value="our">Our Page</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="details" class="form-label">Details</label>
                                                <input type="text" name="details" class="form-control" id="details">
                                            </div>
                                        </div>
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Place Order</button>
            </form>
            </div> <!-- end modal footer -->
        </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
</div> <!-- end modal-->

{{-- Model Ads --}}
<div class="modal fade" id="adsmodel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">New Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> <!-- end modal header -->
            <div class="modal-body">
                <form action="/store/designs" method="post">
                    @csrf
                    <div class="mt-2 ">
                        <div class="form-check form-check-inline">
                            <input type="radio" id="radio2" name="designs" class="form-check-input" checked>
                            <label class="form-check-label" for="customRadio4">Designs</label>
                        </div>
                    </div>

                    <!-- Form row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                {{-- <div class="card-header">
                                    <h4 class="header-title">Form Row</h4>
                                    <p class="text-muted mb-0">
                                        By adding <code>.row</code> & <code>.g-2</code>, you can have control over the
                                        gutter width in as well the inline as block direction.
                                    </p>
                                </div> --}}
                                <div class="card-body">
                                        <div class="row g-2">
                                            <div class="mb-3 col-md-6 all" >
                                                <label for="inputEmail4" class="form-label">Name / Company</label>
                                                <input type="text" class="form-control" name="name" id="name" placeholder="Name / Company">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="Contact" class="form-label">Contact</label>
                                                <input type="text" class="form-control" name="contact" id="contact" placeholder="Contact">
                                            </div>
                                        </div>

                                        <div class="row g-2 all">
                                            <div class="mb-3 col-md-6">
                                                <label for="inputState" class="form-label">Work Type</label>
                                                <select id="work_type" name="work_type" class="form-select">
                                                    <option>Choose</option>
                                                    <option>Option 1</option>
                                                    <option>Option 2</option>
                                                    <option>Option 3</option>
                                                </select>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="Amount" class="form-label">Amount</label>
                                                <input type="text" name="amount" class="form-control" id="amount">
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row g-2 all">
                                            <div class="mb-3 col-md-6">
                                                <label for="inputAddress" class="form-label">Pay status</label>
                                                <select id="package" name="payment_status" class="form-select">
                                                    <option>Choose</option>
                                                    <option>Option 1</option>
                                                    <option>Option 2</option>
                                                    <option>Option 3</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="inputAddress" class="form-label">Pay Method</label>
                                                <select id="package" name="cash" class="form-select">
                                                    <option>Choose</option>
                                                    <option>Option 1</option>
                                                    <option>Option 2</option>
                                                    <option>Option 3</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row g-2 all">
                                            <div class="mb-3 col-md-6">
                                                <label for="advance" class="form-label">Advance</label>
                                                <input type="text" name="advance" class="form-control" id="advance">
                                            </div>
                                        </div>
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Place Order</button>
            </form>
            </div> <!-- end modal footer -->
        </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
</div> <!-- end modal-->

{{-- Model Video --}}
<div class="modal fade" id="videomodel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">New Order Video</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> <!-- end modal header -->
            <div class="modal-body">
                <form action="/store/video" method="post">
                    @csrf
                    <div class="mt-2">
                        <div class="form-check form-check-inline">
                            <input type="radio" id="radio3" name="video" class="form-check-input" checked>
                            <label class="form-check-label" for="customRadio5">Video</label>
                        </div>
                    </div>

                    <!-- Form row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                {{-- <div class="card-header">
                                    <h4 class="header-title">Form Row</h4>
                                    <p class="text-muted mb-0">
                                        By adding <code>.row</code> & <code>.g-2</code>, you can have control over the
                                        gutter width in as well the inline as block direction.
                                    </p>
                                </div> --}}
                                <div class="card-body">
                                        <div class="row g-2">
                                            <div class="mb-3 col-md-6 all" >
                                                <label for="inputEmail4" class="form-label">Name / Company</label>
                                                <input type="text" class="form-control" name="name" id="name" placeholder="Name / Company">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="Contact" class="form-label">Contact</label>
                                                <input type="text" class="form-control" name="contact" id="contact" placeholder="Contact">
                                            </div>
                                        </div>

                                        <div class="row g-2 all mb-2">
                                            <label for="inputState" class="form-label">Style</label>
                                                <select id="work_type"  name="work_type" class="form-select">
                                                    <option>Option 1</option>
                                                    <option>Option 2</option>
                                                    <option>Option 3</option>
                                                </select>
                                        </div>

                                        <div class="row g-2 video">
                                            <div class="mb-3 col-md-6" >
                                                <label for="amount" class="form-label">Amount</label>
                                                <input type="text" name="amount" class="form-control" id="amount">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="amount" class="form-label">Our Amount</label>
                                                <input type="text" name="our_amount" class="form-control" id="amount">
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row g-2 all">
                                            <div class="mb-3 col-md-6">
                                                <label for="inputAddress" class="form-label">Pay status</label>
                                                <select id="package" name="payment_status" class="form-select">
                                                    <option value="done">Done</option>
                                                    <option value="partial">Partial</option>
                                                    <option value="pending">Pending</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="inputAddress" class="form-label">Pay Method</label>
                                                <select id="cash" name="cash" class="form-select">
                                                    <option value="1">Cash Payment</option>
                                                    <option value="0">None Cash Payment</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row g-2 all">
                                            <div class="mb-3 col-md-6">
                                                <label for="advance" class="form-label">Advance</label>
                                                <input type="text" name="advance" class="form-control" id="advance">
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="script" class="form-label">Script</label>
                                                <select id="script"  name="script" class="form-select">
                                                    <option value="done">Done</option>
                                                    <option value="pending">Pending</option>
                                                </select>
                                            </div>
                                        </div>
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Place Order</button>
            </form>
            </div> <!-- end modal footer -->
        </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
</div> <!-- end modal-->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="header-title mb-0"> Orders</h4>
            </div>
            <div class="card-body">
                <form>
                    <div id="basicwizard">

                        <ul class="nav nav-pills nav-justified form-wizard-header mb-4">
                            <li class="nav-item">
                                <a href="#basictab1" data-bs-toggle="tab" data-toggle="tab"  class="nav-link rounded-0 py-2"> 
                                    <i class="ri-account-circle-line fw-normal fs-20 align-middle me-1"></i>
                                    <span class="d-none d-sm-inline">Boosting</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#basictab2" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                    <i class="ri-profile-line fw-normal fs-20 align-middle me-1"></i>
                                    <span class="d-none d-sm-inline">Designs</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#basictab3" data-bs-toggle="tab" data-toggle="tab" class="nav-link rounded-0 py-2">
                                    <i class="ri-check-double-line fw-normal fs-20 align-middle me-1"></i>
                                    <span class="d-none d-sm-inline">Video</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content b-0 mb-0">
                            <div class="tab-pane" id="basictab1">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-centered table-bordered border-primary mb-0">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>C/E</th>
                                                        <th>Name<br/>Company</th>
                                                        <th>O/N</th>
                                                        <th>Contact</th>
                                                        <th>Work<br/>Type</th>
                                                        <th>Page</th>
                                                        <th>Work<br/>Status</th>
                                                        <th>Payment</th>
                                                        <th>Cash</th>
                                                        <th>Advertiser</th>
                                                        <th>Package</th>
                                                        <th>Amount</th>
                                                        <th>Advance</th>
                                                        <th>Details</th>
                                                        <th>Add<br/>Acc</th>
                                                        <th>slip</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($orders as $order)
                                                        @if (Auth::user()->role == 'cro' && $order->order_type == 'boosting')
                                                            <tr class="fw-semibold">
                                                                <td>{{ $order->date }}</td>
                                                                <td>{{ $order->ce }}</td>
                                                                <td>{{ $order->name }}</td>
                                                                <td>{{ $order->old_new }}</td>
                                                                <td>{{ $order->contact }}</td>
                                                                <td>{{ $order->work_type }}</td>
                                                                <td>{{ $order->page }}</td>
                                                                <td>{{ $order->work_status }}</td>
                                                                <td>{{ $order->payment_status }}</td>
                                                                <td>{{ $order->cash }}</td>
                                                                <td>{{ $order->advertiser_id }}</td>
                                                                <td>{{ $order->package_id }}</td>
                                                                <td>{{ $order->amount }}</td>
                                                                <td>{{ $order->advance }}</td>
                                                                <td>{{ $order->details }}</td>
                                                                <td>{{ $order->add_acc_id }}</td>
                                                                <td>
                                                                    <!-- Button to open modal -->
                                                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#uploadalipsModal{{ $order->id }}">
                                                                        <i class=" ri-arrow-up-circle-line "></i>
                                                                    </button>

                                                                    <!-- Modal -->
                                                                    <div class="modal fade" id="uploadalipsModal{{ $order->id }}" tabindex="-1" aria-labelledby="uploadSlipLabel{{ $order->id }}" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">Upload Payment Slip</h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <form action="{{ route('upload.slip', $order->id) }}" method="POST" enctype="multipart/form-data">
                                                                                        @csrf
                                                                                        <div class="mb-3">
                                                                                            <label for="slip" class="form-label">Select Slip Image</label>
                                                                                            <input type="file" name="slip" class="form-control" required>
                                                                                        </div>
                                                                                        <button type="submit" class="btn btn-primary">Upload</button>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Button to open View Slips Modal -->
                                                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#viewSlipModal{{ $order->id }}">
                                                                        View
                                                                    </button>

                                                                    <!-- Modal for Viewing Slips -->
                                                                    <div class="modal fade" id="viewSlipModal{{ $order->id }}" tabindex="-1" aria-labelledby="viewSlipLabel{{ $order->id }}" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">Uploaded Slips</h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    @php
                                                                                        $slips = \App\Models\Slip::where('order_id', $order->id)->get();
                                                                                    @endphp

                                                                                    @if($slips->count() > 0)
                                                                                    @foreach($slips as $slip)
                                                                                        <a href="{{ url('storage/' . $slip->slip_path) }}" target="_blank">
                                                                                            <img src="{{ url('storage/' . $slip->slip_path) }}" alt="Slip Image" width="100">
                                                                                        </a>
                                                                                    @endforeach
                                                                                    @else
                                                                                        <p>No slips uploaded for this order.</p>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    
                                                                </td>
                                                                
                                                                <td>
                                                                    <!-- Update Button triggering the modal -->
                                                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#updateModalboosting{{ $order->id }}">
                                                                        <i class="ri-edit-fill "></i>
                                                                    </button>
                                                                    <a href="/invoice-ads/{{ $order->id }}">invoice</a>
                                                                </td>
                                                            </tr>
                                        
                                                            <!-- Modal for updating order boosting -->
                                                            <div class="modal fade" id="updateModalboosting{{ $order->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateModalLabel{{ $order->id }}" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="updateModalLabel{{ $order->id }}">Update Order Boosting</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div> <!-- end modal header -->
                                                                        <div class="modal-body">
                                                                            <form action="{{ route('orders.update', $order->id) }}" method="POST">
                                                                                @csrf
                                                                                @method('PUT')
                                        
                                                                                <!-- Date Field -->
                                                                                {{-- <div class="mb-3">
                                                                                    <label for="date{{ $order->id }}" class="form-label">Date</label>
                                                                                    <input type="date" class="form-control" id="date{{ $order->id }}" name="date" value="{{ $order->date }}">
                                                                                </div> --}}
                                                                                <div class="row g-2 video">
                                                                                    <div class="mb-3 col-md-6" >
                                                                                        <!-- C/E Field -->
                                                                                        <div class="mb-3">
                                                                                            <label for="ce{{ $order->id }}" class="form-label">C/E</label>
                                                                                            <select id="ce"  name="ce" class="form-select">
                                                                                                <option value="{{$order->ce}}" selected>{{$order->ce}}</option>
                                                                                                <option value="c">c</option>
                                                                                                <option value="e">e</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="mb-3 col-md-6" >
                                                                                        <!-- Old/New Field -->
                                                                                        <div class="mb-3">
                                                                                            <label for="old_new{{ $order->id }}" class="form-label">O/N</label>
                                                                                            <select id="old_new"  name="old_new" class="form-select">
                                                                                                <option value="{{$order->old_new}}" selected>{{$order->old_new}}</option>
                                                                                                <option value="old">old</option>
                                                                                                <option value="new">new</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row g-2 video">
                                                                                    <div class="mb-3 col-md-6" >
                                                                                        <!-- Name Field -->
                                                                                        <div class="mb-3">
                                                                                            <label for="name{{ $order->id }}" class="form-label">Name</label>
                                                                                            <input type="text" class="form-control" id="name{{ $order->id }}" name="name" value="{{ $order->name }}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="mb-3 col-md-6" >
                                                                                        <!-- Contact Field -->
                                                                                        <div class="mb-3">
                                                                                            <label for="contact{{ $order->id }}" class="form-label">Contact</label>
                                                                                            <input type="text" class="form-control" id="contact{{ $order->id }}" name="contact" value="{{ $order->contact }}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row g-2 video">
                                                                                    <div class="mb-3 col-md-12" >
                                                                                        <!-- Work Type Field -->
                                                                                        <div class="mb-3">
                                                                                            <label for="work_type{{ $order->id }}" class="form-label">Work Type</label>
                                                                                            <select id="work_type"  name="work_type" class="form-select">
                                                                                                <option value="{{$order->work_type}}" selected>{{$order->work_type}}</option>
                                                                                                <option value="wt">wt</option>
                                                                                                <option value="wt">wt</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row g-2 video">
                                                                                    <div class="mb-3 col-md-6" >
                                                                                        <!-- Page Field -->
                                                                                        <div class="mb-3">
                                                                                            <label for="page{{ $order->id }}" class="form-label">Page</label>
                                                                                            <select id="page"  name="page" class="form-select">
                                                                                                <option value="{{$order->page}}" selected>{{$order->page}}</option>
                                                                                                <option value="new">new</option>
                                                                                                <option value="existing">existing</option>
                                                                                                <option value="our">our</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="mb-3 col-md-6" >
                                                                                        <!-- Work Status Field -->
                                                                                        <div class="mb-3">
                                                                                            <label for="work_status{{ $order->id }}" class="form-label">Work Status</label>
                                                                                            <select id="work_status"  name="work_status" class="form-select">
                                                                                                <option value="{{$order->work_status}}" selected>{{$order->work_status}}</option>
                                                                                                <option value="done">done</option>
                                                                                                <option value="pending">pending</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row g-2 video">
                                                                                    <div class="mb-3 col-md-6" >
                                                                                        <!-- Payment Status Field -->
                                                                                        <div class="mb-3">
                                                                                            <label for="payment_status{{ $order->id }}" class="form-label">Payment Status</label>
                                                                                            <select id="payment_status"  name="payment_status" class="form-select">
                                                                                                <option value="{{$order->payment_status}}" selected>{{$order->payment_status}}</option>
                                                                                                <option value="done">done</option>
                                                                                                <option value="partial">partial</option>
                                                                                                <option value="pending">pending</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="mb-3 col-md-6" >
                                                                                        <!-- Cash Field -->
                                                                                        <div class="mb-3">
                                                                                            <label for="cash{{ $order->id }}" class="form-label">Cash</label>
                                                                                            <select id="cash"  name="cash" class="form-select">
                                                                                                <option value="{{$order->cash}}" selected>{{$order->cash}}</option>
                                                                                                <option value="1">cash payment</option>
                                                                                                <option value="0">none cash payment</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row g-2 video">
                                                                                    <div class="mb-3 col-md-6" >
                                                                                        <!-- Advertiser Field -->
                                                                                        <div class="mb-3">
                                                                                            <label for="advertiser_id{{ $order->id }}" class="form-label">Advertiser</label>
                                                                                            <select id="advertiser_id"  name="advertiser_id" class="form-select">
                                                                                                <option value="{{$order->advertiser_id}}" selected>{{$order->advertiser_id}}</option>
                                                                                                <option value="1">cash payment</option>
                                                                                                <option value="0">none cash payment</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="mb-3 col-md-6" >
                                                                                        <!-- Package Field -->
                                                                                        <div class="mb-3">
                                                                                            <label for="package_id{{ $order->id }}" class="form-label">Package</label>
                                                                                            <select id="package_id"  name="package_id" class="form-select">
                                                                                                <option value="{{$order->package_id}}" selected>{{$order->package_id}}</option>
                                                                                                <option value="1">cash payment</option>
                                                                                                <option value="0">none cash payment</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row g-2 video">
                                                                                    <div class="mb-3 col-md-6" >
                                                                                        <!-- Amount Field -->
                                                                                        <div class="mb-3">
                                                                                            <label for="amount{{ $order->id }}" class="form-label">Amount</label>
                                                                                            <input type="number" step="0.01" class="form-control" id="amount{{ $order->id }}" name="amount" value="{{ $order->amount }}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="mb-3 col-md-6" >
                                                                                        <!-- Advance Field -->
                                                                                        <div class="mb-3">
                                                                                            <label for="advance{{ $order->id }}" class="form-label">Advance</label>
                                                                                            <input type="number" step="0.01" class="form-control" id="advance{{ $order->id }}" name="advance" value="{{ $order->advance }}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <div class="row g-2 video">
                                                                                    <div class="mb-3 col-md-6" >
                                                                                        <!-- Details Field -->
                                                                                        <div class="mb-3">
                                                                                            <label for="details{{ $order->id }}" class="form-label">Details</label>
                                                                                            <textarea class="form-control" id="details{{ $order->id }}" name="details" rows="3">{{ $order->details }}</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="mb-3 col-md-6" >
                                                                                        <!-- Add Acc Field -->
                                                                                        <div class="mb-3">
                                                                                            <label for="add_acc_id{{ $order->id }}" class="form-label">Add Acc</label>
                                                                                            <select id="add_acc_id"  name="add_acc_id" class="form-select">
                                                                                                <option value="{{$order->add_acc_id}}" selected>{{$order->add_acc_id}}</option>
                                                                                                <option value="1">cash payment</option>
                                                                                                <option value="0">none cash payment</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Order Type Field -->
                                                                                {{-- <div class="mb-3">
                                                                                    <label for="order_type{{ $order->id }}" class="form-label">Order Type</label>
                                                                                    <input type="text" class="form-control" id="order_type{{ $order->id }}" name="order_type" value="{{ $order->order_type }}">
                                                                                </div> --}}
                                        
                                                                                <!-- Submit Button -->
                                                                                <button type="submit" class="btn btn-primary">Update Order</button>
                                                                            </form>
                                                                        </div> <!-- end modal body -->
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        </div> <!-- end modal footer -->
                                                                    </div> <!-- end modal content-->
                                                                </div> <!-- end modal dialog-->
                                                            </div> <!-- end modal-->
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            </div>

                            <div class="tab-pane" id="basictab2">
                                <div class="row">
                                    <div class="col-12">
                                            <table class="table table-hover table-centered table-bordered border-primary mb-0">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>C/E</th>
                                                        <th>Name<br/>Company</th>
                                                        <th>Contact</th>
                                                        <th>CRO</th>
                                                        <th>Work<br/>Type</th>
                                                        <th>Work<br/>Status</th>
                                                        <th>Payment</th>
                                                        <th>Designer</th>
                                                        <th>Amount</th>
                                                        <th>Advance</th>
                                                        <th>Slip</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                @foreach ($orders as $order)
                                                @if (Auth::user()->role == 'cro' && $order->order_type == 'designs')
                                                        <tr>
                                                            <td>{{$order->date}}</td>
                                                            <td>{{$order->ce}}</td>
                                                            <td>{{$order->name}}</td>
                                                            <td>{{$order->contact}}</td>
                                                            <td>{{$order->cro}}</td>
                                                            <td>{{$order->work_type}}</td>
                                                            <td>{{$order->work_status}}</td>
                                                            <td>{{$order->payment_status}}</td>
                                                            <td>{{$order->designer_id}}</td>
                                                            <td>{{$order->amount}}</td>
                                                            <td>{{$order->advance}}</td>
                                                            <td>
                                                                <!-- Button to open modal -->
                                                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#uploadalipsModal{{ $order->id }}">
                                                                    <i class=" ri-arrow-up-circle-line "></i>
                                                                </button>

                                                                <!-- Modal -->
                                                                <div class="modal fade" id="uploadalipsModal{{ $order->id }}" tabindex="-1" aria-labelledby="uploadSlipLabel{{ $order->id }}" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Upload Payment Slip</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form action="{{ route('upload.slip', $order->id) }}" method="POST" enctype="multipart/form-data">
                                                                                    @csrf
                                                                                    <div class="mb-3">
                                                                                        <label for="slip" class="form-label">Select Slip Image</label>
                                                                                        <input type="file" name="slip" class="form-control" required>
                                                                                    </div>
                                                                                    <button type="submit" class="btn btn-primary">Upload</button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Button to open View Slips Modal -->
                                                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#viewSlipModal{{ $order->id }}">
                                                                    View
                                                                </button>

                                                                <!-- Modal for Viewing Slips -->
                                                                <div class="modal fade" id="viewSlipModal{{ $order->id }}" tabindex="-1" aria-labelledby="viewSlipLabel{{ $order->id }}" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Uploaded Slips</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                @php
                                                                                    $slips = \App\Models\Slip::where('order_id', $order->id)->get();
                                                                                @endphp

                                                                                @if($slips->count() > 0)
                                                                                @foreach($slips as $slip)
                                                                                    <a href="{{ url('storage/' . $slip->slip_path) }}" target="_blank">
                                                                                        <img src="{{ url('storage/' . $slip->slip_path) }}" alt="Slip Image" width="100">
                                                                                    </a>
                                                                                @endforeach
                                                                                @else
                                                                                    <p>No slips uploaded for this order.</p>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                
                                                            </td>
                                                            <td>
                                                                <!-- Update Button triggering the modal -->
                                                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#updateModaldesigns{{ $order->id }}">
                                                                    <i class="ri-edit-fill "></i>
                                                                </button>
                                                                <a href="/invoice-ads/{{ $order->id }}">invoice</a>
                                                            </td>
                                                        </tr>
                                    
                                                        <!-- Modal for updating order -->
                                                        <div class="modal fade" id="updateModaldesigns{{ $order->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateModalLabel{{ $order->id }}" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="updateModalLabel{{ $order->id }}">Update Order Designs</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div> <!-- end modal header -->
                                                                    <div class="modal-body">
                                                                        <form action="{{ route('orders.update.designs', $order->id) }}" method="POST">
                                                                            @csrf
                                                                            @method('PUT')
                                    
                                                                            <!-- Date Field -->
                                                                            {{-- <div class="mb-3">
                                                                                <label for="date{{ $order->id }}" class="form-label">Date</label>
                                                                                <input type="date" class="form-control" id="date{{ $order->id }}" name="date" value="{{ $order->date }}">
                                                                            </div> --}}
                                                                            <div class="row g-2 video">
                                                                                <div class="mb-3 col-md-6" >
                                                                                    <!-- C/E Field -->
                                                                                    <div class="mb-3">
                                                                                        <label for="ce{{ $order->id }}" class="form-label">C/E</label>
                                                                                        <select id="ce"  name="ce" class="form-select">
                                                                                            <option value="{{$order->ce}}" selected>{{$order->ce}}</option>
                                                                                            <option value="c">c</option>
                                                                                            <option value="e">e</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row g-2 video">
                                                                                <div class="mb-3 col-md-6" >
                                                                                    <!-- Name Field -->
                                                                                    <div class="mb-3">
                                                                                        <label for="name{{ $order->id }}" class="form-label">Name</label>
                                                                                        <input type="text" class="form-control" id="name{{ $order->id }}" name="name" value="{{ $order->name }}">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="mb-3 col-md-6" >
                                                                                    <!-- Contact Field -->
                                                                                    <div class="mb-3">
                                                                                        <label for="contact{{ $order->id }}" class="form-label">Contact</label>
                                                                                        <input type="text" class="form-control" id="contact{{ $order->id }}" name="contact" value="{{ $order->contact }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row g-2 video">
                                                                                <div class="mb-3 col-md-12" >
                                                                                    <!-- Work Type Field -->
                                                                                    <div class="mb-3">
                                                                                        <label for="work_type{{ $order->id }}" class="form-label">Work Type</label>
                                                                                        <select id="work_type"  name="work_type" class="form-select">
                                                                                            <option value="{{$order->work_type}}" selected>{{$order->work_type}}</option>
                                                                                            <option value="wt">wt</option>
                                                                                            <option value="wt">wt</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row g-2 video">
                                                                                <div class="mb-3 col-md-6" >
                                                                                    <!-- Work Status Field -->
                                                                                    <div class="mb-3">
                                                                                        <label for="work_status{{ $order->id }}" class="form-label">Work Status</label>
                                                                                        <select id="work_status"  name="work_status" class="form-select">
                                                                                            <option value="{{$order->work_status}}" selected>{{$order->work_status}}</option>
                                                                                            <option value="done">done</option>
                                                                                            <option value="pending">pending</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row g-2 video">
                                                                                <div class="mb-3 col-md-6" >
                                                                                    <!-- Payment Status Field -->
                                                                                    <div class="mb-3">
                                                                                        <label for="payment_status{{ $order->id }}" class="form-label">Payment Status</label>
                                                                                        <select id="payment_status"  name="payment_status" class="form-select">
                                                                                            <option value="{{$order->payment_status}}" selected>{{$order->payment_status}}</option>
                                                                                            <option value="done">done</option>
                                                                                            <option value="partial">partial</option>
                                                                                            <option value="pending">pending</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="mb-3 col-md-6" >
                                                                                    <!-- Advertiser Field -->
                                                                                    <div class="mb-3">
                                                                                        <label for="designer_id{{ $order->id }}" class="form-label">Designer</label>
                                                                                        <select id="designer_id"  name="designer_id" class="form-select">
                                                                                            <option value="{{$order->designer_id}}" selected>{{$order->designer_id}}</option>
                                                                                            <option value="1">cash payment</option>
                                                                                            <option value="0">none cash payment</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row g-2 video">
                                                                                <div class="mb-3 col-md-6" >
                                                                                    <!-- Amount Field -->
                                                                                    <div class="mb-3">
                                                                                        <label for="amount{{ $order->id }}" class="form-label">Amount</label>
                                                                                        <input type="number" step="0.01" class="form-control" id="amount{{ $order->id }}" name="amount" value="{{ $order->amount }}">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="mb-3 col-md-6" >
                                                                                    <!-- Advance Field -->
                                                                                    <div class="mb-3">
                                                                                        <label for="advance{{ $order->id }}" class="form-label">Advance</label>
                                                                                        <input type="number" step="0.01" class="form-control" id="advance{{ $order->id }}" name="advance" value="{{ $order->advance }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!-- Order Type Field -->
                                                                            {{-- <div class="mb-3">
                                                                                <label for="order_type{{ $order->id }}" class="form-label">Order Type</label>
                                                                                <input type="text" class="form-control" id="order_type{{ $order->id }}" name="order_type" value="{{ $order->order_type }}">
                                                                            </div> --}}
                                    
                                                                            <!-- Submit Button -->
                                                                            <button type="submit" class="btn btn-primary">Update Order</button>
                                                                        </form>
                                                                    </div> <!-- end modal body -->
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    </div> <!-- end modal footer -->
                                                                </div> <!-- end modal content-->
                                                            </div> <!-- end modal dialog-->
                                                        </div> <!-- end modal-->
                                                    @endif                      
                                                    @endforeach
                                                <tbody>
                            
                                                </tbody>
                                            </table>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            </div>

                            <div class="tab-pane" id="basictab3">
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table table-hover table-centered table-bordered border-primary mb-0">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>C/E</th>
                                                    <th>Name<br/>Company</th>
                                                    <th>Contact</th>
                                                    <th>Amount</th>
                                                    <th>Our<br/>Amount</th>
                                                    <th>CRO</th>
                                                    <th>Style</th>
                                                    <th>Script</th>
                                                    <th>Shoot</th>
                                                    <th>Work<br/>Status</th>
                                                    <th>Payment</th>
                                                    <th>Cash</th>
                                                    <th>Designer</th>
                                                    <th>Advance</th>
                                                    <th>Slip</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orders as $order)
                                                @if (Auth::user()->role == 'cro' && $order->order_type == 'video')
                                                    <tr>
                                                        <td>{{$order->date}}</td>
                                                        <td>{{$order->ce}}</td>
                                                        <td>{{$order->name}}</td>
                                                        <td>{{$order->contact}}</td>
                                                        <td>{{$order->amount}}</td>
                                                        <td>{{$order->our_amount}}</td>
                                                        <td>{{$order->cro}}</td>
                                                        <td>{{$order->work_type}}</td>
                                                        <td>{{$order->script}}</td>
                                                        <td>{{$order->shoot}}</td>
                                                        <td>{{$order->work_status}}</td>
                                                        <td>{{$order->payment_status}}</td>
                                                        <td>{{$order->cash}}</td>
                                                        <td>{{$order->designer_id}}</td>
                                                        <td>{{$order->advance}}</td>
                                                        <td>
                                                            <!-- Button to open modal -->
                                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#uploadalipsModal{{ $order->id }}">
                                                                <i class=" ri-arrow-up-circle-line "></i>
                                                            </button>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="uploadalipsModal{{ $order->id }}" tabindex="-1" aria-labelledby="uploadSlipLabel{{ $order->id }}" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Upload Payment Slip</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="{{ route('upload.slip', $order->id) }}" method="POST" enctype="multipart/form-data">
                                                                                @csrf
                                                                                <div class="mb-3">
                                                                                    <label for="slip" class="form-label">Select Slip Image</label>
                                                                                    <input type="file" name="slip" class="form-control" required>
                                                                                </div>
                                                                                <button type="submit" class="btn btn-primary">Upload</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Button to open View Slips Modal -->
                                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#viewSlipModal{{ $order->id }}">
                                                                View
                                                            </button>

                                                            <!-- Modal for Viewing Slips -->
                                                            <div class="modal fade" id="viewSlipModal{{ $order->id }}" tabindex="-1" aria-labelledby="viewSlipLabel{{ $order->id }}" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Uploaded Slips</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            @php
                                                                                $slips = \App\Models\Slip::where('order_id', $order->id)->get();
                                                                            @endphp

                                                                            @if($slips->count() > 0)
                                                                            @foreach($slips as $slip)
                                                                                <a href="{{ url('storage/' . $slip->slip_path) }}" target="_blank">
                                                                                    <img src="{{ url('storage/' . $slip->slip_path) }}" alt="Slip Image" width="100">
                                                                                </a>
                                                                            @endforeach
                                                                            @else
                                                                                <p>No slips uploaded for this order.</p>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            
                                                        </td>
                                                        <td>
                                                            <!-- Update Button triggering the modal -->
                                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#updateModalvideo{{ $order->id }}">
                                                                <i class="ri-edit-fill "></i>
                                                            </button>
                                                            <a href="/invoice-video/{{ $order->id }}">invoice</a>
                                                        </td>
                                                    </tr>
                                
                                                    <!-- Modal for updating order -->
                                                    <div class="modal fade" id="updateModalvideo{{ $order->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateModalLabel{{ $order->id }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="updateModalLabel{{ $order->id }}">Update Order Video</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div> <!-- end modal header -->
                                                                <div class="modal-body">
                                                                    <form action="{{ route('orders.update.video', $order->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                
                                                                        <!-- Date Field -->
                                                                        {{-- <div class="mb-3">
                                                                            <label for="date{{ $order->id }}" class="form-label">Date</label>
                                                                            <input type="date" class="form-control" id="date{{ $order->id }}" name="date" value="{{ $order->date }}">
                                                                        </div> --}}
                                                                        <div class="row g-2 video">
                                                                            <div class="mb-3 col-md-6" >
                                                                                <!-- C/E Field -->
                                                                                <div class="mb-3">
                                                                                    <label for="ce{{ $order->id }}" class="form-label">C/E</label>
                                                                                    <select id="ce"  name="ce" class="form-select">
                                                                                        <option value="{{$order->ce}}" selected>{{$order->ce}}</option>
                                                                                        <option value="c">c</option>
                                                                                        <option value="e">e</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row g-2 video">
                                                                            <div class="mb-3 col-md-6" >
                                                                                <!-- Name Field -->
                                                                                <div class="mb-3">
                                                                                    <label for="name{{ $order->id }}" class="form-label">Name</label>
                                                                                    <input type="text" class="form-control" id="name{{ $order->id }}" name="name" value="{{ $order->name }}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-md-6" >
                                                                                <!-- Contact Field -->
                                                                                <div class="mb-3">
                                                                                    <label for="contact{{ $order->id }}" class="form-label">Contact</label>
                                                                                    <input type="text" class="form-control" id="contact{{ $order->id }}" name="contact" value="{{ $order->contact }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                        <div class="row g-2 video">
                                                                            <div class="mb-3 col-md-6" >
                                                                                <!-- Amount Field -->
                                                                                <div class="mb-3">
                                                                                    <label for="amount{{ $order->id }}" class="form-label">Amount</label>
                                                                                    <input type="number" step="0.01" class="form-control" id="amount{{ $order->id }}" name="amount" value="{{ $order->amount }}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-md-6" >
                                                                                <!-- Amount Field -->
                                                                                <div class="mb-3">
                                                                                    <label for="our_amount{{ $order->id }}" class="form-label">Our Amount</label>
                                                                                    <input type="number" step="0.01" class="form-control" id="our_amount{{ $order->id }}" name="our_amount" value="{{ $order->amount }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row g-2 video">
                                                                            <div class="mb-3 col-md-6" >
                                                                                <!-- Work Type Field -->
                                                                                <div class="mb-3">
                                                                                    <label for="work_type{{ $order->id }}" class="form-label">Style</label>
                                                                                    <select id="work_type"  name="work_type" class="form-select">
                                                                                        <option value="{{$order->work_type}}" selected>{{$order->work_type}}</option>
                                                                                        <option value="wt">wt</option>
                                                                                        <option value="wt">wt</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-md-6" >
                                                                                <!-- Work Type Field -->
                                                                                <div class="mb-3">
                                                                                    <label for="work_type{{ $order->id }}" class="form-label">Shoot</label>
                                                                                    <select id="shoot"  name="shoot" class="form-select">
                                                                                        <option value="{{$order->shoot}}" selected>{{$order->shoot}}</option>
                                                                                        <option value="done">done</option>
                                                                                        <option value="pending">pending</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row g-2 video">
                                                                            <div class="mb-3 col-md-6" >
                                                                                <!-- Work Status Field -->
                                                                                <div class="mb-3">
                                                                                    <label for="work_status{{ $order->id }}" class="form-label">Work Status</label>
                                                                                    <select id="work_status"  name="work_status" class="form-select">
                                                                                        <option value="{{$order->work_status}}" selected>{{$order->work_status}}</option>
                                                                                        <option value="done">done</option>
                                                                                        <option value="pending">pending</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-md-6" >
                                                                                <!-- Payment Status Field -->
                                                                                <div class="mb-3">
                                                                                    <label for="payment_status{{ $order->id }}" class="form-label">Payment Status</label>
                                                                                    <select id="payment_status"  name="payment_status" class="form-select">
                                                                                        <option value="{{$order->payment_status}}" selected>{{$order->payment_status}}</option>
                                                                                        <option value="done">done</option>
                                                                                        <option value="partial">partial</option>
                                                                                        <option value="pending">pending</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row g-2 video">
                                                                            <div class="mb-3 col-md-6" >
                                                                                <!-- Cash Field -->
                                                                                <div class="mb-3">
                                                                                    <label for="cash{{ $order->id }}" class="form-label">Cash</label>
                                                                                    <select id="cash"  name="cash" class="form-select">
                                                                                        <option value="{{$order->cash}}" selected>{{$order->cash}}</option>
                                                                                        <option value="1">cash payment</option>
                                                                                        <option value="0">none cash payment</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-md-6" >
                                                                                <!-- Advertiser Field -->
                                                                                <div class="mb-3">
                                                                                    <label for="designer_id{{ $order->id }}" class="form-label">Designer</label>
                                                                                    <select id="designer_id"  name="designer_id" class="form-select">
                                                                                        <option value="{{$order->designer_id}}" selected>{{$order->designer_id}}</option>
                                                                                        <option value="1">cash payment</option>
                                                                                        <option value="0">none cash payment</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row g-2 video">
                                                                            <div class="mb-3 col-md-12" >
                                                                                <!-- Advance Field -->
                                                                                <div class="mb-3">
                                                                                    <label for="advance{{ $order->id }}" class="form-label">Advance</label>
                                                                                    <input type="number" step="0.01" class="form-control" id="advance{{ $order->id }}" name="advance" value="{{ $order->advance }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Order Type Field -->
                                                                        {{-- <div class="mb-3">
                                                                            <label for="order_type{{ $order->id }}" class="form-label">Order Type</label>
                                                                            <input type="text" class="form-control" id="order_type{{ $order->id }}" name="order_type" value="{{ $order->order_type }}">
                                                                        </div> --}}
                                
                                                                        <!-- Submit Button -->
                                                                        <button type="submit" class="btn btn-primary">Update Order</button>
                                                                    </form>
                                                                </div> <!-- end modal body -->
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                </div> <!-- end modal footer -->
                                                            </div> <!-- end modal content-->
                                                        </div> <!-- end modal dialog-->
                                                    </div> <!-- end modal-->
                                                @endif                      
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- tab-content -->
                    </div> <!-- end #basicwizard-->
                </form>

            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    let savedTab = localStorage.getItem("selectedTab") || "#basictab1"; // Default to Boosting
    let defaultTab = document.querySelector(`a[href="${savedTab}"]`);

    if (defaultTab) {
        defaultTab.classList.add("active");
        document.querySelector(savedTab).classList.add("active", "show");
    }

    // Store selected tab on click
    document.querySelectorAll('.nav-link').forEach(tab => {
        tab.addEventListener("click", function () {
            localStorage.setItem("selectedTab", this.getAttribute("href"));
        });
    });
});
</script>


@endsection