<div class="navbar-custom">
    <div class="topbar container-fluid">
        <div class="d-flex align-items-center gap-1">

            <!-- Topbar Brand Logo -->
            <div class="logo-topbar">
                <!-- Logo light -->
                <a class="logo-light">
                    <span class="logo-lg">
                        <img src="{{ asset('logos/wishwaads.jpg')}}" alt="logo" style="height: 60px; width: auto;">
                    </span>
                    <span class="logo-sm">
                        <img src="{{ asset('logos/wishwaads.jpg')}}" alt="small logo">
                    </span>
                </a>

                <!-- Logo Dark -->
                <a class="logo-dark">
                    <span class="logo-lg">
                        <img src="{{ asset('logos/wishwaads.jpg')}}" alt="dark logo" style="height: 60px; width: auto;">
                    </span>
                    <span class="logo-sm">
                        <img src="{{ asset('logos/wishwaads.jpg')}}" alt="small logo">
                    </span>
                </a>
            </div>

            <!-- Sidebar Menu Toggle Button -->
            <button class="button-toggle-menu">
                <i class="ri-menu-line"></i>
            </button>

            <!-- Horizontal Menu Toggle Button -->
            <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <div class="lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>

            <!-- Topbar Search Form -->
            <div class=" d-none d-lg-block">
                <form action="/update/date/range/{{ Auth::user()->id }}" method="post" class="row g-2 align-items-center">
                    @csrf
                    @method('put')
            
                    <!-- From Date -->
                    <div class="col-auto">
                        <input type="date" name="from_date" class="form-control" style="width: 200px;" value="{{ Auth::user()->from_date }}">
                    </div>

                    <div class="col-auto">
                        To
                    </div>
            
                    <!-- To Date -->
                    <div class="col-auto">
                        <input type="date" name="to_date" class="form-control" style="width: 200px;" value="{{ Auth::user()->to_date }}">
                    </div>
            
                    <!-- Submit Button -->
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Set</button>
                    </div>
                </form>
            </div>
            
        </div>

        <ul class="topbar-menu d-flex align-items-center gap-3">
            <li class="dropdown d-lg-none">
                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <i class="ri-search-line fs-22"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                    <form class="p-3">
                        <input type="search" class="form-control" placeholder="Search ..."
                            aria-label="Recipient's username">
                    </form>
                </div>
            </li>

            @php
                $unreadInvoicesCount = $invoices->filter(function ($invoice) {
                    return $invoice->user_id == Auth::id()
                        && $invoice->status == 'pending'
                        && $invoice->notifi_status == 'unread'
                        && $invoice->due_date == \Carbon\Carbon::today()->toDateString();
                })->count();
            @endphp

            @php
                $user = Auth::user(); // Get the authenticated user

                // If the user is an admin, count all invoices that match the conditions
                $totalInvoices = $invoices->filter(function ($invoice) use ($user) {
                    return ($user->role == 'admin' || $invoice->user_id == $user->id) &&
                        $invoice->status == 'pending' &&
                        $invoice->notifi_status == 'unread' &&
                        $invoice->due_date == \Carbon\Carbon::today()->toDateString();
                })->count();
            @endphp


            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <i class="ri-notification-3-line fs-22"></i>
                    <span class="noti-icon-badge badge text-bg-pink">
                        @if (Auth::user()->role == 'admin')
                            {{ $totalInvoices }}
                        @else
                            {{ $unreadInvoicesCount }}
                        @endif
                    </span>
                </a>

                <style>
                    .custom-dropdown-width {
                        width: 400px;
                        /* Adjust this value to your desired width */
                    }

                    .reduced-height {
                        padding: 4px 12px; 
                        height: 40px;
                    }
                </style>
                <div
                    class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg py-0 custom-dropdown-width">
                    <div class="p-2 border-top-0 border-start-0 border-end-0 border-dashed border">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0 fs-16 fw-semibold"> Notification</h6>
                            </div>

                        </div>
                    </div>

                    <div style="max-height: 500px;" data-simplebar>

                        @foreach ($invoices as $invoice)
                            @if (Auth::user()->role == 'admin')
                                @if ($invoice->status == 'pending' && $invoice->notifi_status == 'unread' && $invoice->due_date == \Carbon\Carbon::today()->toDateString())
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item" id="invoice-{{ $invoice->id }}">
                                        <div class="d-flex justify-content-between w-100">
                                            <div class="d-flex">
                                                <div class="notify-icon bg-pink-subtle">
                                                    <i class="mdi mdi-comment-account-outline text-pink"></i>
                                                </div>
                                                <p class="notify-details mb-0 ml-2">
                                                    Invoice ID : {{ $invoice->inv }}
                                                    <small class="noti-time">Onvoice placed date : {{ $invoice->date }}</small>
                                                    <small class="noti-time">Contact : {{ $invoice->contact }}</small>
                                                    <small class="noti-time">Total : Rs.{{ $invoice->total }}</small>
                                                    <small class="noti-time">Paid :
                                                        Rs.{{ ($invoice->amt1 + $invoice->amt2 + $invoice->amt3) }}</small>
                                                    <small class="noti-time">Balance :
                                                        Rs.{{ $invoice->total - ($invoice->amt1 + $invoice->amt2 + $invoice->amt3) }}
                                                    </small>
                                                </p>
                                            </div>
                                            <!-- Mark as Read Button -->
                                            {{-- <button class="mark-as-read btn btn-success btn-sm tooltips reduced-height"
                                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Mark as read"
                                                data-id="{{ $invoice->id }}">
                                                <i class="ri-check-double-fill"></i>
                                            </button> --}}
                                        </div>
                                    </a>
                                    <hr>
                                @endif
                            @elseif($invoice->user_id == Auth::user()->id)
                                @if ($invoice->status == 'pending' && $invoice->notifi_status == 'unread' && $invoice->due_date == \Carbon\Carbon::today()->toDateString())
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item" id="invoice-{{ $invoice->id }}">
                                        <div class="d-flex justify-content-between w-100">
                                            <div class="d-flex">
                                                <div class="notify-icon bg-pink-subtle">
                                                    <i class="mdi mdi-comment-account-outline text-pink"></i>
                                                </div>
                                                <p class="notify-details mb-0 ml-2">
                                                    Invoice ID : {{ $invoice->inv }}
                                                    <small class="noti-time">Onvoice placed date : {{ $invoice->date }}</small>
                                                    <small class="noti-time">Contact : {{ $invoice->contact }}</small>
                                                    <small class="noti-time">Total : Rs.{{ $invoice->total }}</small>
                                                    <small class="noti-time">Paid :
                                                        Rs.{{ ($invoice->amt1 + $invoice->amt2 + $invoice->amt3) }}</small>
                                                    <small class="noti-time">Balance :
                                                        Rs.{{ $invoice->total - ($invoice->amt1 + $invoice->amt2 + $invoice->amt3) }}
                                                    </small>
                                                </p>
                                            </div>
                                            <!-- Mark as Read Button -->
                                            <button class="mark-as-read btn btn-success btn-sm tooltips reduced-height"
                                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Mark as read"
                                                data-id="{{ $invoice->id }}">
                                                <i class="ri-check-double-fill"></i>
                                            </button>
                                        </div>
                                    </a>

                                    <hr>
                                @endif
                            @endif
                        @endforeach

                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                            $(document).ready(function () {
                                // Mark as Read button click handler
                                $('.mark-as-read').click(function () {
                                    var invoiceId = $(this).data('id');

                                    // Send AJAX request to update the notify_status
                                    $.ajax({
                                        url: '{{ route("invoice.markRead") }}', // Define this route
                                        method: 'POST',
                                        data: {
                                            _token: '{{ csrf_token() }}', // Include CSRF token for security
                                            invoice_id: invoiceId,
                                        },
                                        success: function (response) {
                                            if (response.success) {
                                                // Find the invoice item by ID and update the UI
                                                var invoiceItem = $('#invoice-' + invoiceId);
                                                invoiceItem.find('.notify-details').append(' (Read)');
                                                invoiceItem.find('.mark-as-read').prop('disabled', true);
                                                invoiceItem.find('.notify-icon').css('background-color', '#f0f0f0');

                                                // Update the counter: get the current counter value, decrement it, and update the UI
                                                var counterElement = $('.noti-icon-badge');
                                                var currentCount = parseInt(counterElement.text());
                                                if (currentCount > 0) {
                                                    counterElement.text(currentCount - 1);
                                                }

                                                // Optionally, hide the notification after a short delay
                                                setTimeout(function () {
                                                    invoiceItem.fadeOut();
                                                }, 1000);
                                            } else {
                                                alert('Error marking as read');
                                            }
                                        },

                                        error: function () {
                                            alert('There was an error. Please try again.');
                                        }
                                    });
                                });
                            });
                        </script>

                </div>
            </li>

            <li class="d-none d-sm-inline-block">
                <a class="nav-link" data-bs-toggle="offcanvas" href="#theme-settings-offcanvas">
                    <i class="ri-settings-3-line fs-22"></i>
                </a>
            </li>

            <li class="d-none d-sm-inline-block">
                <div class="nav-link" id="light-dark-mode">
                    <i class="ri-moon-line fs-22"></i>
                </div>
            </li>

            <li class="dropdown">
                <a class="nav-link dropdown-toggle arrow-none nav-user" data-bs-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <span class="account-user-avatar">
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" width="32"
                                class="rounded-circle">
                        </span>
                    @endif
                    <span class="d-lg-block d-none">
                        <h5 class="my-0 fw-normal">{{ Auth::user()->name }}<i
                                class="ri-arrow-down-s-line d-none d-sm-inline-block align-middle"></i></h5>
                    </span>

                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                    <!-- item-->
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>

                    <!-- item-->
                    <a href="/profile" class="dropdown-item">
                        <i class="ri-account-circle-line fs-18 align-middle me-1"></i>
                        <span>Profile</span>
                    </a>
                    <!-- item-->
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <a href="#" class="dropdown-item"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="ri-logout-box-line fs-18 align-middle me-1"></i>
                            <span>Logout</span>
                        </a>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</div>