<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if(session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="loginForm" style="display: none;">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>

    <!-- Popup for Device Verification -->
    <div id="codePopup" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <h2 class="text-lg font-semibold mb-3">Enter Access Code</h2>
            <input type="password" id="accessCode" class="border p-2 w-full rounded-md" placeholder="Enter code">
            <button onclick="verifyCode()" class="bg-blue-500 px-4 py-2 mt-3 rounded-md">OK</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            axios.get('/check-device')
                .then(response => {
                    if (response.data.verified) {
                        document.getElementById("loginForm").style.display = "block";
                    } else {
                        document.getElementById("codePopup").style.display = "flex";
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        });

        function verifyCode() {
            let code = document.getElementById("accessCode").value;

            // Make sure the code is not empty before submitting
            if (!code.trim()) {
                alert("Please enter the code!");
                return;
            }

            axios.post('/verify-device', { code })
                .then(response => {
                    if (response.data.success) {
                        alert("Access granted!");
                        document.getElementById("codePopup").style.display = "none";
                        document.getElementById("loginForm").style.display = "block";
                    }
                })
                .catch(error => {
                    alert("Invalid code!");
                    console.error(error);
                });
        }
    </script>
</x-guest-layout>
