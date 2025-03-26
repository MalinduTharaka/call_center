@extends('layouts.app')
@section('content')

<div class="row mt-3">
    <div class="col-lg-4">
        <div class="card">
            <div class="row g-0 align-items-center">
                <div class="col-md-4">
                    <img src="assets/images/small/small-4.jpg" class="img-fluid rounded-start" alt="...">
                </div>
                
                <div class="col-md-8">
                    <div class="card-body p-0">
                        <button class="btn w-100 h-100 text-start p-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            <h5 class="card-title mb-0">New Order</h5>
                            {{-- <p class="card-text">This is a wider card with supporting text below as a
                                natural lead-in to additional content. This content is a little bit
                                longer.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins
                                    ago</small></p> --}}
                        </button>
                    </div> <!-- end card-body-->
                </div> <!-- end col -->
            </div> <!-- end row-->
        </div> <!-- end card-->
    </div> <!-- end col-->
    <div class="col-lg-4">
        <div class="card">
            <div class="row g-0 align-items-center">
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Today Remarks</h5>
                        <p class="card-text"><small class="text-muted">no of notifications</small></p>
                    </div> <!-- end card-body -->
                </div> <!-- end col -->
                <div class="col-md-4">
                    <img src="assets/images/small/small-1.jpg" class="img-fluid rounded-end"
                        alt="...">
                </div> <!-- end col -->
            </div> <!-- end row-->
        </div> <!-- end card -->
    </div> <!-- end col-->
    <div class="col-lg-4">
        <div class="card">
            <div class="row g-0 align-items-center">
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Profile</h5>
                    </div> <!-- end card-body -->
                </div> <!-- end col -->
                <div class="col-md-4">
                    <img src="assets/images/small/small-1.jpg" class="img-fluid rounded-end"
                        alt="...">
                </div> <!-- end col -->
            </div> <!-- end row-->
        </div> <!-- end card -->
    </div> <!-- end col-->
</div>
<!-- end row -->

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">New Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> <!-- end modal header -->
            <div class="modal-body">
                <form action="">
                    <div class="mt-2 ">
                        <div class="form-check form-check-inline">
                            <input type="radio" id="radio1" name="customRadio1" class="form-check-input" checked>
                            <label class="form-check-label" for="customRadio3">Boosting</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="radio2" name="customRadio1" class="form-check-input">
                            <label class="form-check-label" for="customRadio4">Ads</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="radio3" name="customRadio1" class="form-check-input">
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
                                                <input type="text" class="form-control" id="name" placeholder="Name / Company">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="Contact" class="form-label">Contact</label>
                                                <input type="text" class="form-control" id="contact" placeholder="Contact">
                                            </div>
                                        </div>

                                        <div class="row g-2 all">
                                            <label for="inputState" class="form-label">Work Type</label>
                                                <select id="work_type" class="form-select">
                                                    <option>Choose</option>
                                                    <option>Option 1</option>
                                                    <option>Option 2</option>
                                                    <option>Option 3</option>
                                                </select>
                                        </div>

                                        <div class="row g-2 mt-2 mb-2 boosting">
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" id="customSwitch1">
                                                <label class="form-check-label" for="customSwitch1">Switch on for custome package</label>
                                            </div>
                                        </div>

                                        <div class="row g-2 boosting">
                                            <div class="mb-3 col-md-12">
                                                <label for="package" class="form-label">Package</label>
                                                <select id="package" class="form-select">
                                                    <option>Choose</option>
                                                    <option>Option 1</option>
                                                    <option>Option 2</option>
                                                    <option>Option 3</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row g-2 boosting">
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


                                        <div class="row g-2 video">
                                            <div class="mb-3 col-md-6" >
                                                <label for="amount" class="form-label">Amount</label>
                                                <input type="text" class="form-control" id="amount">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="amount" class="form-label">Our Amount</label>
                                                <input type="text" class="form-control" id="amount">
                                            </div>
                                        </div>

                                        <div class="row g-2 add">
                                            <div class="mb-3 col-md-6">
                                                <label for="Amount" class="form-label">Amount</label>
                                                <input type="text" class="form-control" id="amount">
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row g-2 all">
                                            <div class="mb-3 col-md-6">
                                                <label for="inputAddress" class="form-label">Pay status</label>
                                                <select id="package" class="form-select">
                                                    <option>Choose</option>
                                                    <option>Option 1</option>
                                                    <option>Option 2</option>
                                                    <option>Option 3</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="inputAddress" class="form-label">Pay Method</label>
                                                <select id="package" class="form-select">
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
                                                <input type="text" class="form-control" id="advance">
                                            </div>
                                        </div>


                                        <div class="row g-2 boosting">
                                            <div class="mb-3 col-md-6">
                                                <label for="page" class="form-label">Page</label>
                                                <select id="page" class="form-select">
                                                    <option>Choose</option>
                                                    <option>Option 1</option>
                                                    <option>Option 2</option>
                                                    <option>Option 3</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row g-2 boosting">
                                            <div class="mb-3 col-md-6">
                                                <label for="amount" class="form-label">Amount</label>
                                                <input type="text" class="form-control" id="amount">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="details" class="form-label">Details</label>
                                                <input type="text" class="form-control" id="details">
                                            </div>
                                        </div>

                                        <div class="row g-2 video">
                                            <div class="mb-3 col-md-6">
                                                <label for="script" class="form-label">Script</label>
                                                <input type="text" class="form-control" id="script">
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


<script>
    document.addEventListener("DOMContentLoaded", function () {
    const radios = document.querySelectorAll('input[name="customRadio1"]');
    
    radios.forEach(function (radio) {
        radio.addEventListener("change", function () {
            let videoSections = document.querySelectorAll('.video');
            let boostingSections = document.querySelectorAll('.boosting');
            let addSections = document.querySelectorAll('.add');

            if (document.getElementById("radio3").checked) {
                videoSections.forEach(el => el.style.display = 'block');
                boostingSections.forEach(el => el.style.display = 'none');
                addSections.forEach(el => el.style.display = 'none');
            } else if (document.getElementById("radio1").checked) {
                videoSections.forEach(el => el.style.display = 'none');
                boostingSections.forEach(el => el.style.display = 'block');
                addSections.forEach(el => el.style.display = 'none');
            } else if (document.getElementById("radio2").checked) {
                videoSections.forEach(el => el.style.display = 'none');
                boostingSections.forEach(el => el.style.display = 'none');
                addSections.forEach(el => el.style.display = 'block');
            }
        });
    });
});

</script>

@endsection