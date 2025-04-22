<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Log In | WishwaAds</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully responsive admin theme which can be used to build CRM, CMS, ERP etc." name="description" />
    <meta content="Techzaa" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('logos/wishwaads.jpg') }}">

    <!-- Theme Config Js -->
    <script src="{{ asset('assets/js/config.js') }}"></script>

    <!-- App css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .hidden {
            display: none !important;
        }
    </style>


</head>

<body class="authentication-bg position-relative">
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-8 col-lg-10">
                    <div class="card overflow-hidden">
                        <div class="row g-0">
                            <!-- Left Image -->
                            <div class="col-lg-6 d-none d-lg-block p-2">
                                <img src="{{ asset('logos/wishwaads.jpg') }}" alt="" class="img-fluid rounded h-100">
                            </div>

                            <!-- Right Form -->
                            <div class="col-lg-6">
                                <div class="d-flex flex-column h-100">

                                    <div class="p-4 my-auto">
                                        <h4 class="fs-20">Sign In</h4>
                                        <p class="text-muted mb-3">Enter your email and password to access your account.
                                        </p>

                                        <!-- Validation Errors -->
                                        <x-validation-errors class="mb-3 alert alert-danger" />

                                        @if(session('status'))
                                            <div class="mb-3 alert alert-success">
                                                {{ session('status') }}
                                            </div>
                                        @endif

                                        <form method="POST" action="{{ route('login') }}" id="loginForm"
                                            style="display: none;">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email address</label>
                                                <input class="form-control" type="email" name="email" id="email"
                                                    value="{{ old('email') }}" required autofocus
                                                    placeholder="Enter your email">
                                            </div>

                                            <div class="mb-3">
                                                <a href="{{ route('password.request') }}" class="text-muted float-end">
                                                    <small>Forgot your password?</small>
                                                </a>
                                                <label for="password" class="form-label">Password</label>
                                                <input class="form-control" type="password" name="password"
                                                    id="password" required placeholder="Enter your password">
                                            </div>

                                            <div class="mb-0 text-start">
                                                <button class="btn btn-soft-primary w-100" type="submit">
                                                    <i class="ri-login-circle-fill me-1"></i> <span class="fw-bold">Log In</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer footer-alt fw-medium text-center">
        <span class="text-dark">
            <script>document.write(new Date().getFullYear())</script> © WishwaAds | by NMRL
        </span>
    </footer>

    <!-- Access Code Popup -->
    <div id="codePopup" class="modal d-flex align-items-center justify-content-center" tabindex="-1"
        style="background-color: rgba(0, 0, 0, 0.75); display: none;">
        <div class="bg-white p-4 rounded shadow text-center" style="min-width: 300px;">

            <h5 class="mb-3">Enter Access Code</h5>
            <input type="password" id="accessCode" class="form-control mb-3" placeholder="Enter code">
            <button onclick="verifyCode()" class="btn btn-primary w-100">OK</button>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            axios.get('/check-device')  // Get device verification status from server
                .then(response => {
                    if (response.data.verified) {
                        document.getElementById("codePopup").classList.add("hidden");
                        document.getElementById("loginForm").style.display = "block";
                    } else {
                        // If not verified, show the popup
                        document.getElementById("codePopup").style.display = "flex";
                    }
                }).catch(error => {
                    console.error(error);
                });
        });


        function verifyCode() {
            let code = document.getElementById("accessCode").value.trim();

            if (!code) {
                alert("Please enter the code!");
                return;
            }

            axios.post('/verify-device', { code: code })
                .then(response => {
                    console.log("Response from verify-device:", response.data);
                    if (response.data.success) {
                        alert("Access granted!");
                        document.getElementById("codePopup").classList.add("hidden");
                        document.getElementById("loginForm").style.display = "block";

                    } else {
                        alert("Invalid code!");
                    }
                }).catch(error => {
                    alert("Verification failed!");
                    console.error(error);
                });
        }

    </script>
</body>

</html>