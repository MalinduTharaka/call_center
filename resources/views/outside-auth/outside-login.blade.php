<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Log In | WishwaAds</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App css + your styles -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" />
    <style>
      .hidden { display: none !important; }
    </style>
</head>
<body class="authentication-bg position-relative">
  <div class="account-pages pt-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
          <div class="card overflow-hidden">
            <div class="row g-0">
              <div class="col-lg-6 d-none d-lg-block p-2">
                <img src="{{ asset('logos/wishwaads.jpg') }}" class="img-fluid rounded h-100" alt="logo">
              </div>
              <div class="col-lg-6">
                <div class="p-4">
                  <h4 class="mb-3">Sign In</h4>

                  <!-- VERIFY DIV -->
                  <div id="verifyDiv">
                    <div class="alert alert-danger d-none" id="verifyError"></div>
                    <div class="mb-3">
                      <label for="verifyEmail" class="form-label">Email address</label>
                      <input type="email" id="verifyEmail" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <button id="btnVerify" class="btn btn-soft-primary w-100">Verify</button>
                  </div>

                  <!-- LOGIN FORM (hidden initially) -->
                  <form id="loginDiv" action="{{ route('login') }}" method="POST" class="hidden">
                    @csrf
                    <div class="mb-3">
                      <label for="loginEmail" class="form-label">Email address</label>
                      <input type="email" id="loginEmail" name="email"
                             class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                      <a href="{{ route('password.request') }}" class="float-end">
                        <small>Forgot your password?</small>
                      </a>
                      <label for="loginPassword" class="form-label">Password</label>
                      <input type="password" id="loginPassword" name="password"
                             class="form-control" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="btn btn-soft-primary w-100">
                      <i class="ri-login-circle-fill me-1"></i> Log In
                    </button>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div> <!-- end row -->
    </div>
  </div>

  <footer class="footer text-center mt-4">
    <script>document.write(new Date().getFullYear())</script> © WishwaAds
  </footer>

  <!-- include your bundled JS (e.g. app.min.js) -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const verifyDiv = document.getElementById('verifyDiv');
      const loginDiv  = document.getElementById('loginDiv');
      const btnVerify = document.getElementById('btnVerify');
      const verifyEmailInput = document.getElementById('verifyEmail');
      const loginEmailInput  = document.getElementById('loginEmail');
      const verifyError      = document.getElementById('verifyError');
      const csrfToken        = document.querySelector('meta[name="csrf-token"]').content;

      // on Verify click
      btnVerify.addEventListener('click', async (e) => {
        e.preventDefault();
        verifyError.classList.add('d-none');
        const email = verifyEmailInput.value.trim();
        if (! email) {
          verifyError.textContent = 'Please enter an email.';
          verifyError.classList.remove('d-none');
          return;
        }

        try {
          const res = await fetch("{{ route('outside.login.verify') }}", {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrfToken,
              'Accept': 'application/json'
            },
            body: JSON.stringify({ email })
          });

          const body = await res.json();

          if (res.ok && body.status === 'success') {
            // swap forms
            verifyDiv.classList.add('hidden');
            loginDiv.classList.remove('hidden');
            loginEmailInput.value = email;
          } else {
            verifyError.textContent = body.message || 'Verification failed.';
            verifyError.classList.remove('d-none');
          }

        } catch (err) {
          verifyError.textContent = 'Server error—please try again.';
          verifyError.classList.remove('d-none');
        }
      });
    });
  </script>
</body>
</html>
