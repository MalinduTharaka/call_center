<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Log In | Wishwa Ads</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully responsive admin theme..." name="description" />
    <meta content="Techzaa" name="author" />
    <link rel="shortcut icon" href="{{ asset('logos/wishwaads.jpg') }}">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" />
</head>

<body class="authentication-bg position-relative">
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-8 col-lg-10">
                    <div class="card overflow-hidden">
                        <div class="row g-0">
                            <div class="col-lg-6 d-none d-lg-block p-2">
                                <img src="{{ asset('logos/wishwaads.jpg') }}" class="img-fluid rounded h-100" alt="">
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex flex-column h-100">
                                    <div class="p-4 my-auto">
                                        <h4 class="fs-20">Sign In</h4>
                                        <p class="text-muted mb-3">Enter your email and password to access your account.</p>

                                        <!-- Laravel login form -->
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf

                                            <!-- Validation Errors -->
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul class="mb-0">
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            @if(session('status'))
                                                <div class="alert alert-success mb-3">
                                                    {{ session('status') }}
                                                </div>
                                            @endif

                                            <div class="mb-3">
                                                <label for="emailaddress" class="form-label">Email address</label>
                                                <input class="form-control" type="email" name="email" id="emailaddress"
                                                       value="{{ old('email') }}" required autofocus>
                                            </div>

                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password</label>
                                                <input class="form-control" type="password" name="password" id="password" required>
                                            </div>

                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="remember" id="checkbox-signin">
                                                    <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                                </div>
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
                </div> <!-- end row -->
            </div>
        </div>
    </div>

    <footer class="footer footer-alt fw-medium text-center">
        <span class="text-dark">
            <script>document.write(new Date().getFullYear())</script> © WishwaAds - By NMRL
        </span>
    </footer>

    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
</body>

</html>
