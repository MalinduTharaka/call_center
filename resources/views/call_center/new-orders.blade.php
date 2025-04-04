@extends('layouts.app')
@section('content')


<div class="d-none">
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
                            <h5 class="card-title mb-0">Boosting</h5>
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
</div>
<!-- end row -->

<style>
    .btn-disabled {
      opacity: 0.5;
      pointer-events: none;
    }

    .bg-light-red {
        background-color:rgb(255, 11, 32) !important;
    }

  </style>
  
<div class="row mt-2">
    <div class="col-sm-3">
    </div> <!-- end col-->
    <div class="col-sm-6">
        <div class="card card-body">
            <button data-bs-toggle="modal" data-bs-target="#combinemodel" class="btn btn-primary">Add Order</button>
        </div> <!-- end card-->
    </div> <!-- end col-->
    <div class="col-sm-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <!-- Static Backdrop modal -->
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#slipupload">
                            Slip Upload
                        </button>
                    </div> <!-- btn list -->

                    <!-- Modal -->
                    <div class="modal fade" id="slipupload" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Payment Slips</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="/slip/update" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="invop" class="form-label">Invoice Number</label>
                                            <select id="invop" class="form-select select2" name="inv">
                                                <option value="" disabled selected>Search Invoice...</option>
                                                @foreach ($invoices as $invoice)
                                                    @if ($invoice->status == 'pending')
                                                    <option value="{{ $invoice->inv }}" 
                                                        data-total="{{ $invoice->total }}" 
                                                        data-paid="{{ $invoice->amt1 + $invoice->amt2 + $invoice->amt3 }}">
                                                        {{ $invoice->inv }} - {{ $invoice->contact }}
                                                    </option>
                                                    @endif
                                                @endforeach

                                            </select>
                                        </div>
                    
                                        <div class="row mb-2">
                                            <div class="col-md-6 mb-2">
                                                <label for="total" class="form-label">Total</label>
                                                <input type="text" class="form-control" id="total" placeholder="Advance" readonly>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label for="total" class="form-label">Paid</label>
                                                <input type="text" class="form-control" id="paid" placeholder="Paid amount display here" readonly>
                                            </div>
                                        </div>
                    
                                        <div class="row mb-2">
                                            <div class="col-md-6 mb-2">
                                                <label for="bank" class="form-label">Bank</label>
                                                <select id="bank" class="form-select" name="bank">
                                                    <option value="com">Commercial Bank</option>
                                                    <option value="boc">BOC</option>
                                                </select>
                                            </div>
                    
                                            <div class="col-md-6 mb-2">
                                                <label for="payment_type" class="form-label">Payment Type</label>
                                                <select id="payment_type" class="form-select" name="payment_type">
                                                    <option value="completed" selected>Complete</option>
                                                    <option value="partial">Installment</option>
                                                </select>
                                            </div>
                                        </div>
                    
                                        <div class="row mb-2">
                                            <label class="form-label">Advance Payment</label>
                                            <div class="col-md-4 mb-2" style="display: none;">
                                                <label class="form-label">Boosting</label>
                                                <input type="text" class="form-control" name="advanceb" placeholder="Boosting">
                                            </div>
                                            <div class="col-md-4 mb-2" style="display: none;">
                                                <label class="form-label">Design</label>
                                                <input type="text" class="form-control" name="advanced" placeholder="Design">
                                            </div>
                                            <div class="col-md-4 mb-2" style="display: none;">
                                                <label class="form-label">Video</label>
                                                <input type="text" class="form-control" name="advancev" placeholder="Video">
                                            </div>
                                        </div>
                    
                                        <div class="mb-2">
                                            <label for="slip" class="form-label">Slip</label>
                                            <input type="file" class="form-control" name="slip" id="slip" placeholder="slippath" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Include jQuery and Select2 -->
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
                    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
                    
                    <script>
                       $(document).ready(function() {
                            $('#slipupload').on('shown.bs.modal', function () {
                                $('#invop').select2({
                                    dropdownParent: $('#slipupload'),
                                    placeholder: "Search Invoice...",
                                    allowClear: true,
                                    width: '100%'
                                });
                            });

                            // Update total and paid amount when an invoice is selected
                            // Update amounts and show proper advance inputs when an invoice is selected
                            $('#invop').on('change', function() {
                                var selectedOption = $(this).find('option:selected');
                                var totalAmount = selectedOption.data('total');
                                var paidAmount = selectedOption.data('paid');
                                var orderTypesStr = selectedOption.data('order-types'); // e.g. "boosting,designs"
                                var orderTypes = orderTypesStr ? orderTypesStr.split(',') : [];

                                // Set total and paid values
                                $('#total').val(totalAmount);
                                $('#paid').val(paidAmount);

                                // Force payment type to 'completed'
                                $('#payment_type').val('completed').trigger('change');

                                // If payment type is partial, show proper advance inputs (won't run now, since we've set to completed)
                                if ($('#payment_type').val() === 'partial') {
                                    // Hide all advance inputs initially
                                    $("input[name='advanceb'], input[name='advanced'], input[name='advancev']").closest('.col-md-4').hide();

                                    // Show related inputs based on order types
                                    if (orderTypes.indexOf('boosting') !== -1) {
                                        $("input[name='advanceb']").closest('.col-md-4').show();
                                    }
                                    if (orderTypes.indexOf('designs') !== -1) {
                                        $("input[name='advanced']").closest('.col-md-4').show();
                                    }
                                    if (orderTypes.indexOf('video') !== -1) {
                                        $("input[name='advancev']").closest('.col-md-4').show();
                                    }
                                }
                            });
                        });

                        // Add this script to handle payment type changes
                        $('#payment_type').on('change', function() {
                            const paymentType = $(this).val();
                            const inv = $('#invop').val();
                            
                            if (paymentType === 'partial' && inv) {
                                fetchOrderTypes(inv);
                            } else {
                                $('[name^="advance"]').closest('.col-md-4').hide();
                            }
                        });

                        // Add this function to fetch order types
                        function fetchOrderTypes(inv) {
                            $.ajax({
                                url: `/orders/get-order-types/${inv}`,
                                method: 'GET',
                                success: function(orderTypes) {
                                    $('[name^="advance"]').closest('.col-md-4').hide();
                                    
                                    orderTypes.forEach(type => {
                                        if (type === 'boosting') $('[name="advanceb"]').closest('.col-md-4').show();
                                        if (type === 'designs') $('[name="advanced"]').closest('.col-md-4').show();
                                        if (type === 'video') $('[name="advancev"]').closest('.col-md-4').show();
                                    });
                                }
                            });
                        }

                        // Update invoice change handler
                        $('#invop').on('change', function() {
                            if ($('#payment_type').val() === 'partial') {
                                fetchOrderTypes($(this).val());
                            }
                        });

                    </script>
                                
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
</div> <!-- end col-->

    <!-- Modal Combine -->
    <div class="modal fade" id="combinemodel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">New Order Combine</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> <!-- end modal header -->
                <div class="modal-body">
                    <form action="/new_invoice" method="post">
                        @csrf
                        <div class="mt-2">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" id="radio1" name="order_type1" class="form-check-input">
                                <label class="form-check-label" for="customRadio3">Boosting</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" id="radio1" name="order_type2" class="form-check-input">
                                <label class="form-check-label" for="customRadio3">Design</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" id="radio1" name="order_type3" class="form-check-input">
                                <label class="form-check-label" for="customRadio3">Video</label>
                            </div>
                        </div>
                        <!-- Form row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row g-2">
                                            <div class="mb-3 col-md-6 all">
                                                <label for="inputEmail4" class="form-label">Name / Company</label>
                                                <input type="text" class="form-control" name="name" id="name" placeholder="Name / Company">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="Contact" class="form-label">Contact</label>
                                                <input type="text" class="form-control" name="contact" id="contact" placeholder="Contact" required>
                                            </div>
                                        </div>
    
                                        <hr>
                                        
    
                                        <hr>
                                        <!-- Button Row -->
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <button type="button" class="btn btn-outline-primary w-100 section-btn" data-target="boosting-section">Boosting</button>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="button" class="btn btn-outline-primary w-100 section-btn" data-target="designs-section">Designs</button>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="button" class="btn btn-outline-warning w-100 section-btn" data-target="video-section">Video</button>
                                            </div>
                                        </div>
    
                                        <!-- Sections (initially hidden) -->
                                        <div id="boosting-section" class="section-content p-4 mb-3 bg-light rounded d-none">
                                            <h5>Boosting Options</h5>
                                            <div class="row g-2">
                                                <div class="mb-3 col-md-12">
                                                    <div class="card-body">
                                                        <div class="row g-2 predefined">
                                                            <div class="mb-3 col-md-12">
                                                                <label for="package" class="form-label">Package</label>
                                                                <select id="package" class="form-select">
                                                                    <option value="">Select Package</option>
                                                                    @foreach ($packages as $package)
                                                                        <option value="{{ $package->id }}" 
                                                                            data-amount="{{ $package->package_amount }}" 
                                                                            data-tax="{{ $package->tax }}" 
                                                                            data-service="{{ $package->service }}">
                                                                            {{$package->full}}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row g-2 all">
                                                            <div class="mb-3 col-md-4">
                                                                <label for="package_amt" class="form-label">Package Amount</label>
                                                                <input type="text" name="package_amt" class="form-control" id="package_amt" >
                                                            </div>
                                                            <div class="mb-3 col-md-4">
                                                                <label for="tax" class="form-label">Tax</label>
                                                                <input type="text" name="tax" class="form-control" id="tax" >
                                                            </div>
                                                            <div class="mb-3 col-md-4">
                                                                <label for="service" class="form-label">Service</label>
                                                                <input type="text" name="service" class="form-control" id="service" >
                                                            </div>
                                                        </div>
                                                        
                                                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                                        <script>
                                                            $(document).ready(function () {
                                                                $('#package').change(function () {
                                                                    var selectedOption = $(this).find(':selected');
                                                        
                                                                    // Get data attributes
                                                                    var packageAmount = selectedOption.data('amount') || '';
                                                                    var tax = selectedOption.data('tax') || '';
                                                                    var service = selectedOption.data('service') || '';
                                                        
                                                                    // Set values to input fields
                                                                    $('#package_amt').val(packageAmount);
                                                                    $('#tax').val(tax);
                                                                    $('#service').val(service);
                                                                });
                                                            });
                                                        </script>
                                                        
                                                
                                                        <hr>
                    
                                                        {{-- <div class="row g-2 all">
                                                            <div class="mb-3 col-md-6">
                                                                <label for="inputAddress" class="form-label">Pay status</label>
                                                                <select id="payment_status" name="payment_statusb" class="form-select">
                                                                    <option value="done">done</option>
                                                                    <option value="partial">partial</option>
                                                                    <option value="pending">pending</option>
                                                                    <option value="completed">completed</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="inputAddress" class="form-label">Pay Method</label>
                                                                <select id="package" name="cashb" class="form-select">
                                                                    <option value="1">Cash Payment</option>
                                                                    <option value="0">None Cash Payment</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row g-2 all">
                                                            <div class="mb-3 col-md-6">
                                                                <label for="advance" class="form-label">Advance</label>
                                                                <input type="text" name="advanceb" class="form-control" id="advance">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="amount" class="form-label">Amount</label>
                                                                <input type="text" name="amountb" class="form-control" id="amount">
                                                            </div>
                                                        </div>
                    
                    
                                                        <div class="row g-2 boosting">
                                                            <div class="mb-3 col-md-6">
                                                                <label for="page" class="form-label">Page</label>
                                                                <select id="page" name="pageb" class="form-select">
                                                                    <option value="existing">Existing Page</option>
                                                                    <option value="new">New Page</option>
                                                                    <option value="our">Our Page</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="details" class="form-label">Details</label>
                                                                <input type="text" name="detailsb" class="form-control" id="details">
                                                            </div>
                                                        </div> --}}
                                                    </div> <!-- end card-body -->
                                                </div>
                                            </div>
                                        </div>
    
                                        <div id="designs-section" class="section-content p-4 mb-3 bg-light rounded d-none">
                                            <h5>Designs Options</h5>
                                            <div class="row g-2">
                                                <div class="mb-3 col-md-12">
                                                    <div class="row g-2 all">
                                                        <div class="mb-3 col-md-12">
                                                            <label for="Amount" class="form-label">Amount</label>
                                                            <input type="text" name="amounta" class="form-control" id="amount">
                                                        </div>
                                                    </div>
            
                                                    <hr>
            
                                                    {{-- <div class="row g-2 all">
                                                        <div class="mb-3 col-md-6">
                                                            <label for="inputAddress" class="form-label">Pay status</label>
                                                            <select id="package" name="payment_statusa" class="form-select">
                                                                <option value="done">done</option>
                                                                <option value="partial">partial</option>
                                                                <option value="pending">pending</option>
                                                                <option value="completed">completed</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label for="inputAddress" class="form-label">Cash</label>
                                                            <select id="package" name="casha" class="form-select">
                                                                <option value="1">Yes</option>
                                                                <option value="2">No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row g-2 all">
                                                        <div class="mb-3 col-md-6">
                                                            <label for="advance" class="form-label">Advance</label>
                                                            <input type="text" name="advancea" class="form-control" id="advance">
                                                        </div>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
    
                                        <div id="video-section" class="section-content p-4 mb-3 bg-light rounded d-none">
                                            <h5>Video Options</h5>
                                            <div class="row g-2">
                                                <div class="mb-3 col-md-12">
                                                    {{-- <div class="row g-2 all mb-2">
                                                        <label for="inputState" class="form-label">Style</label>
                                                            <select id="work_type"  name="work_typev" class="form-select">
                                                                <option>Option 1</option>
                                                                <option>Option 2</option>
                                                                <option>Option 3</option>
                                                            </select>
                                                    </div> --}}
            
                                                    <div class="row g-2 video">
                                                        <div class="mb-3 col-md-6" >
                                                            <label for="amount" class="form-label">Amount</label>
                                                            <input type="text" name="amountv" class="form-control" id="amount">
                                                        </div>
                                                        {{-- <div class="mb-3 col-md-6">
                                                            <label for="amount" class="form-label">Our Amount</label>
                                                            <input type="text" name="our_amountv" class="form-control" id="amount">
                                                        </div> --}}
                                                    </div>
            
                                                    <hr>
            
                                                    {{-- <div class="row g-2 all">
                                                        <div class="mb-3 col-md-6">
                                                            <label for="inputAddress" class="form-label">Pay status</label>
                                                            <select id="package" name="payment_statusv" class="form-select">
                                                                <option value="done">done</option>
                                                                <option value="partial">partial</option>
                                                                <option value="pending">pending</option>
                                                                <option value="completed">completed</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label for="inputAddress" class="form-label">Pay Method</label>
                                                            <select id="cash" name="cashv" class="form-select">
                                                                <option value="1">Yes</option>
                                                                <option value="2">No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row g-2 all">
                                                        <div class="mb-3 col-md-6">
                                                            <label for="advance" class="form-label">Advance</label>
                                                            <input type="text" name="advancev" class="form-control" id="advance">
                                                        </div>
            
                                                        <div class="mb-3 col-md-6">
                                                            <label for="script" class="form-label">Script</label>
                                                            <select id="script"  name="scriptv" class="form-select">
                                                                <option value="done">Done</option>
                                                                <option value="pending">Pending</option>
                                                            </select>
                                                        </div>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
    
                                        <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const buttons = document.querySelectorAll('.section-btn');
                                            const sections = document.querySelectorAll('.section-content');
                                            
                                            buttons.forEach(button => {
                                                button.addEventListener('click', function(e) {
                                                    e.preventDefault(); // Prevent default form submission
                                                    const targetId = this.getAttribute('data-target');
                                                    
                                                    // Toggle the targeted section
                                                    const targetSection = document.getElementById(targetId);
                                                    targetSection.classList.toggle('d-none');
                                                    
                                                    // Hide other sections (optional - remove if you want multiple sections open)
                                                    sections.forEach(section => {
                                                        if(section.id !== targetId) {
                                                            section.classList.add('d-none');
                                                        }
                                                    });
                                                });
                                            });
                                        });
                                        </script>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                // Get all order type checkboxes
                                                const checkboxes = document.querySelectorAll('input[name^="order_type"]');
                                                // Get the section buttons
                                                const buttons = document.querySelectorAll('.section-btn');
                                            
                                                // Map checkbox names to their corresponding section data-target
                                                const mapping = {
                                                    'order_type1': 'boosting-section',
                                                    'order_type2': 'designs-section',
                                                    'order_type3': 'video-section'
                                                };
                                            
                                                // Function to update button state based on selected checkboxes
                                                function updateButtonsState() {
                                                    // Create an array for targets that are active (checkbox is checked)
                                                    let activeTargets = [];
                                                    checkboxes.forEach(chk => {
                                                        if (chk.checked) {
                                                            activeTargets.push(mapping[chk.getAttribute('name')]);
                                                        }
                                                    });
                                            
                                                    // Loop over each button and enable/disable based on active targets
                                                    buttons.forEach(btn => {
                                                        if (activeTargets.includes(btn.getAttribute('data-target'))) {
                                                            btn.disabled = false;
                                                            btn.classList.remove('btn-disabled');
                                                        } else {
                                                            btn.disabled = true;
                                                            btn.classList.add('btn-disabled');
                                                        }
                                                    });
                                                }
                                            
                                                // Attach change event listeners to checkboxes to update state when toggled
                                                checkboxes.forEach(chk => {
                                                    chk.addEventListener('change', updateButtonsState);
                                                });
                                            
                                                // Initialize button state on page load
                                                updateButtonsState();
                                            
                                                // Enforce at least one checkbox selection on form submission
                                                const form = document.querySelector('form');
                                                form.addEventListener('submit', function(e) {
                                                    let atLeastOne = false;
                                                    checkboxes.forEach(chk => {
                                                        if (chk.checked) atLeastOne = true;
                                                    });
                                                    if (!atLeastOne) {
                                                        e.preventDefault();
                                                        alert('Please select at least one order type.');
                                                    }
                                                });
                                            });
                                        </script>
                                        
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                </div> <!-- end modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Place Order</button>
                </div> <!-- end modal footer -->
                </form>
            </div> <!-- end modal content-->
        </div> <!-- end modal dialog-->
    </div> <!-- end modal--> <!-- end modal-->
</div>



<div class="d-none">
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
</div> 
<!-- end modal-->

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

</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="color: #155724; background-color: #d4edda; border-color: #c3e6cb;">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="color: #721c24; background-color: #f8d7da; border-color: #f5c6cb;">
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


<script>
    setTimeout(function () {
        let alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 4000); // Auto-dismiss after 4 seconds
</script>

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
                                <a href="#basictab1" class="nav-link rounded-0 py-2"> 
                                    <i class="ri-account-circle-line fw-normal fs-20 align-middle me-1"></i>
                                    <span class="d-none d-sm-inline">Boosting</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#basictab2" class="nav-link rounded-0 py-2">
                                    <i class="ri-profile-line fw-normal fs-20 align-middle me-1"></i>
                                    <span class="d-none d-sm-inline">Designs</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#basictab3" class="nav-link rounded-0 py-2">
                                    <i class="ri-check-double-line fw-normal fs-20 align-middle me-1"></i>
                                    <span class="d-none d-sm-inline">Video</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content b-0 mb-0">
                            <div class="tab-pane tab-panebtn" id="basictab1">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive" style="height: 600px; overflow-y: auto;">
                                            <table class="table table-hover table-centered table-bordered border-primary mb-0">
                                                <thead class="table-dark sticky-top">
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>C/E</th>
                                                        <th>Invoice</th>
                                                        <th>Name<br/>Company</th>
                                                        <th>O/N</th>
                                                        <th>Contact</th>
                                                        <th>Work<br/>Type</th>
                                                        <th>Page</th>
                                                        <th>Work<br/>Status</th>
                                                        <th>Payment</th>
                                                        <th>Cash</th>
                                                        <th>Advertiser</th>
                                                        <th>Package Amount</th>
                                                        <th>Service</th>
                                                        <th>Tax</th>
                                                        <th>FB Fee</th>
                                                        <th>Advance</th>
                                                        <th>Details</th>
                                                        <th>Add<br/>Link</th>
                                                        <th>slip</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($orders as $order)
                                                        @if (Auth::user()->cc_num == $order->cro && $order->order_type == 'boosting')
                                                            <tr class="fw-semibold">
                                                                <td>{{ $order->date }}</td>
                                                                <td>
                                                                    <span class="badge fs-5 
                                                                        @if($order->ce == 'c') bg-primary
                                                                        @elseif($order->ce == 'e') bg-danger
                                                                        @endif">
                                                                        {{ $order->ce}}
                                                                    </span>
                                                                </td>
                                                                <td>{{ $order->invoice }}</td>
                                                                <td>{{ $order->name }}</td>
                                                                <td>
                                                                    <span class="badge fs-5 
                                                                        @if($order->old_new == 'old') bg-primary
                                                                        @elseif($order->old_new == 'new') bg-warning
                                                                        @endif">
                                                                        {{ $order->old_new}}
                                                                    </span>
                                                                </td>
                                                                <td>{{ $order->contact }}</td>
                                                                <td>
                                                                    <span class="badge fs-5
                                                                        @if($order->work_type == 'boost' || $order->work_type == 'tiktok') bg-dark
                                                                        @elseif($order->work_type == 'boost & post') bg-primary
                                                                        @elseif($order->work_type == 'page like') bg-purple
                                                                        @elseif($order->work_type == 'post like' || $order->work_type == 'post comment') bg-secondary
                                                                        @elseif($order->work_type == 'create page') bg-warning
                                                                        @endif">
                                                                        {{ $order->work_type }}
                                                                    </span>
                                                                </td>
                                                                
                                                                <td><span class="badge fs-5 bg-dark">{{ $order->page }}</span></td>
                                                                <td>
                                                                    <span class="badge fs-5 
                                                                        @if($order->work_status == 'done') bg-primary
                                                                        @elseif($order->work_status == 'pending') bg-danger
                                                                        @elseif($order->work_status == 'add stopped') bg-dark
                                                                        @elseif($order->work_status == 'error') bg-light-red
                                                                        @elseif($order->work_status == 'rejected') bg-purple
                                                                        @endif">
                                                                        {{ $order->work_status }}
                                                                    </span>
                                                                </td>
                                                                
                                                                <td>
                                                                    <span class="badge fs-5 
                                                                        @if($order->payment_status == 'done') bg-primary
                                                                        @elseif($order->payment_status == 'pending') bg-danger
                                                                        @elseif($order->payment_status == 'rejected') bg-warning
                                                                        @elseif($order->payment_status == 'partial') bg-warning
                                                                        @endif">
                                                                        {{ $order->payment_status }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <span class="badge fs-5 
                                                                        @if($order->cash == 1.00) bg-warning bg-gradient
                                                                        @elseif ($order->cash == 0.00) text-dark
                                                                        @endif">
                                                                        {{ $order->cash == 1.00 ? 'Cash' : 'None Cash' }}
                                                                    </span>
                                                                </td>
                                                                <td>{{ $order->advertiser_id }}</td>
                                                                <td>{{ $order->package_amt }}</td>
                                                                <td>{{ $order->service }}</td>
                                                                <td>{{ $order->tax }}</td>
                                                                <td>
                                                                    @if($order->payment_status == 'partial')
                                                                        {{ $order->advance - ($order->tax + $order->service) }}
                                                                    @elseif($order->payment_status == 'done')
                                                                        {{ $order->package_amt }}
                                                                    @endif
                                                                </td>
                                                                <td>{{ $order->advance }}</td>
                                                                <td>{{ $order->details }}</td>
                                                                <td>
                                                                    <a href="{{ $order->add_acc_id }}" target="_blank">
                                                                        {{ $order->add_acc_id }}
                                                                    </a>
                                                                </td>
                                                                
                                                                <td>
                                    
                                                                    <!-- Button to open View Slips Modal -->
                                                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#viewSlipModal{{ $order->id }}">
                                                                        <i class="  ri-eye-line  "></i>
                                                                    </button>

                                                                    <!-- Modal for Viewing Slips -->
                                                                    <div class="modal fade" id="viewSlipModal{{ $order->id }}" data-bs-backdrop="static" tabindex="-1" aria-labelledby="viewSlipLabel{{ $order->id }}" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">Uploaded Slips</h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    @php
                                                                                        $slips = \App\Models\Slip::where('order_id', $order->invoice)->get();
                                                                                    @endphp
                                                                    
                                                                                    @if($slips->isNotEmpty())
                                                                                        @foreach($slips as $slip)
                                                                                            <div class="mb-3">
                                                                                                <p><strong>Bank Name:</strong> {{ $slip->bank ?? 'N/A' }}</p>
                                                                                                <a href="{{ asset('storage/' . $slip->slip_path) }}" target="_blank">
                                                                                                    <img src="{{ asset('storage/' . $slip->slip_path) }}" alt="Slip Image" class="img-fluid rounded" style="width: 300px; height: 200px;">
                                                                                                </a>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    @else
                                                                                        <p>No slips uploaded for this order.</p>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </td>
                                                                
                                                                <td>
                                                                    <!-- Update Button triggering the modal -->
                                                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#updateModalboosting{{ $order->id }}">
                                                                        <i class="ri-edit-fill "></i>
                                                                    </button>
                                                                    <a href="/invoice-solo/{{ $order->id }}">invoice</a>
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

                                                                                <input type="text" name="inv" value="{{ $order->invoice }}" hidden>

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
                                                                                                <option value="boost">boost</option>
                                                                                                <option value="boost & post">boost & post</option>
                                                                                                <option value="page like">page like</option>
                                                                                                <option value="post like">post like</option>
                                                                                                <option value="post comment">post comment</option>
                                                                                                <option value="create page">create page</option>
                                                                                                <option value="tiktok">tiktok</option>
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
                                                                                                <option value="add stopped">add stopped</option>
                                                                                                <option value="error">error</option>
                                                                                                <option value="rejected">rejected</option>
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
                                                                                                <option value="rejected">rejected</option>
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
                                                                                        <!-- Advance Field -->
                                                                                        <div class="mb-3">
                                                                                            <label for="advance{{ $order->id }}" class="form-label">Advance</label>
                                                                                            <input type="number" step="0.01" class="form-control" id="advance{{ $order->id }}" name="advance" value="{{ $order->advance }}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="mb-3 col-md-6" >
                                                                                            <!-- Add Acc Field -->
                                                                                            <div class="mb-3">
                                                                                                <label for="add_acc_id{{ $order->id }}" class="form-label">Add Link</label>
                                                                                                <input type="link" class="form-control" value="{{$order->add_acc_id}}"  name="add_acc_id"/>
                                                                                            </div>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <div class="row g-2 video">
                                                                                    <div class="mb-3 col-md-12" >
                                                                                        <!-- Details Field -->
                                                                                        <div class="mb-3">
                                                                                            <label for="details{{ $order->id }}" class="form-label">Details</label>
                                                                                            <textarea class="form-control" id="details{{ $order->id }}" name="details" rows="3">{{ $order->details }}</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
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

                            <div class="tab-pane tab-panebtn" id="basictab2">
                                <div class="row">
                                    <div class="col-12">
                                            <table class="table table-hover table-centered table-bordered border-primary mb-0">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>C/E</th>
                                                        <th>Invoice</th>
                                                        <th>Name<br/>Company</th>
                                                        <th>Contact</th>
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
                                                @if (Auth::user()->cc_num == $order->cro && $order->order_type == 'designs')
                                                        <tr>
                                                            <td>{{$order->date}}</td>
                                                            <td>
                                                                <span class="badge fs-5 
                                                                    @if($order->ce == 'c') bg-primary
                                                                    @elseif($order->ce == 'e') bg-danger
                                                                    @endif">
                                                                    {{ $order->ce}}
                                                                </span>
                                                            </td>
                                                            <td>{{ $order->invoice }}</td>
                                                            <td>{{$order->name}}</td>
                                                            <td>{{$order->contact}}</td>
                                                            <td>
                                                                <span class="badge fs-5 bg-dark">
                                                                    {{ $order->work_type }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="badge fs-5 
                                                                    @if($order->work_status == 'done') bg-primary
                                                                    @elseif($order->work_status == 'pending') bg-danger
                                                                    @elseif($order->work_status == 'send to customer') bg-warning
                                                                    @elseif($order->work_status == 'send to designer') bg-dark
                                                                    @endif">
                                                                    {{ $order->work_status }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="badge fs-5 
                                                                    @if($order->payment_status == 'done') bg-primary
                                                                    @elseif($order->payment_status == 'pending') bg-danger
                                                                    @elseif($order->payment_status == 'rejected') bg-warning
                                                                    @elseif($order->payment_status == 'cash') bg-warning bg-gradient
                                                                    @endif">
                                                                    {{ $order->payment_status }}
                                                                </span>
                                                            </td>
                                                            <td>{{$order->designer_id}}</td>
                                                            <td>{{$order->amount}}</td>
                                                            <td>{{$order->advance}}</td>
                                                            <td>
                                                                <!-- Button to open View Slips Modal -->
                                                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#viewSlipModal{{ $order->id }}">
                                                                    <i class="  ri-eye-line  "></i>
                                                                </button>

                                                                <!-- Modal for Viewing Slips -->
                                                                <div class="modal fade" id="viewSlipModal{{ $order->id }}" data-bs-backdrop="static" tabindex="-1" aria-labelledby="viewSlipLabel{{ $order->id }}" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Uploaded Slips</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                @php
                                                                                    $slips = \App\Models\Slip::where('order_id', $order->invoice)->get();
                                                                                @endphp
                                                                
                                                                                @if($slips->isNotEmpty())
                                                                                    @foreach($slips as $slip)
                                                                                        <div class="mb-3">
                                                                                            <p><strong>Bank Name:</strong> {{ $slip->bank ?? 'N/A' }}</p>
                                                                                            <a href="{{ asset('storage/' . $slip->slip_path) }}" target="_blank">
                                                                                                <img src="{{ asset('storage/' . $slip->slip_path) }}" alt="Slip Image" class="img-fluid rounded" style="width: 300px; height: 200px;">
                                                                                            </a>
                                                                                        </div>
                                                                                    @endforeach
                                                                                @else
                                                                                    <p>No slips uploaded for this order.</p>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <!-- Update Button triggering the modal -->
                                                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#updateModaldesigns{{ $order->id }}">
                                                                    <i class="ri-edit-fill "></i>
                                                                </button>
                                                                <a href="/invoice-solo/{{ $order->id }}">invoice</a>
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

                                                                            <input type="text" name="inv" value="{{ $order->invoice }}" hidden>

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
                                                                                            <option value="post">post</option>
                                                                                            <option value="logo">logo</option>
                                                                                            <option value="label">label</option>
                                                                                            <option value="profile photo">profile photo</option>
                                                                                            <option value="leaflet">leaflet</option>
                                                                                            <option value="fb cover">fb cover</option>
                                                                                            <option value="cv">cv</option>
                                                                                            <option value="banner">banner</option>
                                                                                            <option value="certificate">certificate</option>
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
                                                                                            <option value="send to customer">send to customer</option>
                                                                                            <option value="send to designer">send to designer</option>
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
                                                                                            <option value="rejected">rejected</option>
                                                                                            <option value="cash">cash</option>
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

                            <div class="tab-pane tab-panebtn" id="basictab3">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                        <table class="table table-hover table-centered table-bordered border-primary mb-0">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>C/E</th>
                                                    <th>Invoice</th>
                                                    <th>Name<br/>Company</th>
                                                    <th>Contact</th>
                                                    <th>Amount</th>
                                                    <th>Our<br/>Amount</th>
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
                                                @if (Auth::user()->cc_num == $order->cro && $order->order_type == 'video')
                                                    <tr>
                                                        <td>{{$order->date}}</td>
                                                        <td>
                                                            <span class="badge fs-5 
                                                                @if($order->ce == 'c') bg-primary
                                                                @elseif($order->ce == 'e') bg-danger
                                                                @endif">
                                                                {{ $order->ce}}
                                                            </span>
                                                        </td>
                                                        <td>{{ $order->invoice }}</td>
                                                        <td>{{$order->name}}</td>
                                                        <td>{{$order->contact}}</td>
                                                        <td>{{$order->amount}}</td>
                                                        <td>{{$order->our_amount}}</td>
                                                        <td>
                                                            <span class="badge fs-5 bg-dark">
                                                                {{ $order->work_type }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge fs-5 
                                                                @if($order->script == 'done') bg-primary
                                                                @elseif($order->script == 'pending') bg-danger
                                                                @elseif($order->script == 'send to customer') bg-warning
                                                                @elseif($order->script == 'send to designer') bg-dark
                                                                @endif">
                                                                {{ $order->script }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge fs-5 
                                                                @if($order->shoot == 'done') bg-primary
                                                                @elseif($order->shoot == 'pending') bg-danger
                                                                @elseif($order->shoot == 'send to customer') bg-warning
                                                                @elseif($order->shoot == 'send to designer') bg-dark
                                                                @endif">
                                                                {{ $order->shoot }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge fs-5 
                                                                @if($order->work_status == 'done') bg-primary
                                                                @elseif($order->work_status == 'pending') bg-danger
                                                                @elseif($order->work_status == 'send to customer') bg-warning
                                                                @elseif($order->work_status == 'send to designer') bg-dark
                                                                @endif">
                                                                {{ $order->work_status }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge fs-5 
                                                                @if($order->payment_status == 'done') bg-primary
                                                                @elseif($order->payment_status == 'pending') bg-danger
                                                                @elseif($order->payment_status == 'rejected') bg-warning
                                                                @elseif($order->payment_status == 'partial') bg-warning
                                                                @endif">
                                                                {{ $order->payment_status }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge fs-5 
                                                                @if($order->cash == 1.00) bg-warning bg-gradient
                                                                @elseif ($order->cash == 0.00) text-dark
                                                                @endif">
                                                                {{ $order->cash == 1.00 ? 'Cash' : 'None Cash' }}
                                                            </span>
                                                        </td>
                                                        <td>{{$order->designer_id}}</td>
                                                        <td>{{$order->advance}}</td>
                                                        <td>
                                                            <!-- Button to open View Slips Modal -->
                                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#viewSlipModal{{ $order->id }}">
                                                                <i class="ri-eye-line"></i>
                                                            </button>
                                                        
                                                            <!-- Modal for Viewing Slips -->
                                                            <div class="modal fade" id="viewSlipModal{{ $order->id }}" data-bs-backdrop="static" tabindex="-1" aria-labelledby="viewSlipLabel{{ $order->id }}" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Uploaded Slips</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            @php
                                                                                $slips = \App\Models\Slip::where('order_id', $order->invoice)->get();
                                                                            @endphp
                                                            
                                                                            @if($slips->isNotEmpty())
                                                                                @foreach($slips as $slip)
                                                                                    <div class="mb-3">
                                                                                        <p><strong>Bank Name:</strong> {{ $slip->bank ?? 'N/A' }}</p>
                                                                                        <a href="{{ asset('storage/' . $slip->slip_path) }}" target="_blank">
                                                                                            <img src="{{ asset('storage/' . $slip->slip_path) }}" alt="Slip Image" class="img-fluid rounded" style="width: 300px; height: 200px;">
                                                                                        </a>
                                                                                    </div>
                                                                                @endforeach
                                                                            @else
                                                                                <p>No slips uploaded for this order.</p>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        
                                                        <td>
                                                            <!-- Update Button triggering the modal -->
                                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#updateModalvideo{{ $order->id }}">
                                                                <i class="ri-edit-fill "></i>
                                                            </button>
                                                            <a href="/invoice-solo/{{ $order->id }}">invoice</a>
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

                                                                        <input type="text" name="inv" value="{{ $order->invoice }}" hidden>

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
                                                                                        <option value="live">live</option>
                                                                                        <option value="animation">animation</option>
                                                                                        <option value="L & A">L & A</option>
                                                                                        <option value="new year package">new year package</option>
                                                                                        <option value="voice">voice</option>
                                                                                        <option value="video editing">video editing</option>
                                                                                        <option value="update">update</option>
                                                                                        <option value="edit">edit</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 col-md-6" >
                                                                                <!-- Work Type Field -->
                                                                                <div class="mb-3">
                                                                                    <label for="work_type{{ $order->id }}" class="form-label">Script</label>
                                                                                    <select id="work_type"  name="script" class="form-select">
                                                                                        <option value="{{$order->script}}" selected>{{$order->script}}</option>
                                                                                        <option value="done">done</option>
                                                                                        <option value="pending">pending</option>
                                                                                        <option value="send to customer">send to customer</option>
                                                                                        <option value="send to designer">send to designer</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row g-2 video">
                                                                            <div class="mb-3 col-md-6" >
                                                                                <!-- Work Type Field -->
                                                                                <div class="mb-3">
                                                                                    <label for="work_type{{ $order->id }}" class="form-label">Shoot</label>
                                                                                    <select id="shoot"  name="shoot" class="form-select">
                                                                                        <option value="{{$order->shoot}}" selected>{{$order->shoot}}</option>
                                                                                        <option value="done">done</option>
                                                                                        <option value="pending">pending</option>
                                                                                        <option value="send to customer">send to customer</option>
                                                                                        <option value="send to designer">send to designer</option>
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
                                                                                        <option value="send to customer">send to customer</option>
                                                                                        <option value="send to designer">send to designer</option>
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
                                                                                        <option value="rejected">rejected</option>
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
                                                                                    <label for="designer_id{{ $order->id }}" class="form-label">Designer</label>
                                                                                    <select id="designer_id"  name="designer_id" class="form-select">
                                                                                        <option value="{{$order->designer_id}}" selected>{{$order->designer_id}}</option>
                                                                                        <option value="1">cash payment</option>
                                                                                        <option value="0">none cash payment</option>
                                                                                    </select>
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
                            </div>
                        </div> <!-- tab-content -->
                    </div> <!-- end #basicwizard-->
                </form>

            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Function to activate tabs
        function activateTab(tabHash) {
            // Remove active classes from all tabs and panes
            document.querySelectorAll('.nav-link, .tab-panebtn').forEach(el => {
                el.classList.remove('active', 'show');
            });
    
            // Activate matching tab
            const tabLink = document.querySelector(`[href="${tabHash}"]`);
            if(tabLink) {
                tabLink.classList.add('active');
                // Activate corresponding pane
                const pane = document.querySelector(tabHash);
                if(pane) pane.classList.add('active', 'show');
            }
        }
    
        // Set default tab if no hash exists
        if(!window.location.hash) {
            window.location.hash = '#basictab1';
        } else {
            activateTab(window.location.hash);
        }
    
        // Update tabs when hash changes
        window.addEventListener('hashchange', () => {
            activateTab(window.location.hash);
        });
    
        // Handle manual tab clicks
        document.querySelectorAll('.nav-link[data-bs-toggle="tab"]').forEach(tab => {
            tab.addEventListener('click', function(e) {
                window.location.hash = this.getAttribute('href');
            });
        });
    });
    </script>

@endsection