<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    @vite('resources/css/app.css')
</head>
<body class="tw-bg-gray-100 tw-flex tw-items-center tw-justify-center tw-min-h-screen">

    <div class="tw-bg-white tw-rounded-2xl tw-shadow-lg tw-overflow-hidden tw-w-full tw-max-w-4xl tw-flex">
        <!-- Left side (Form) -->
        <div class="tw-w-1/2 tw-p-8">
            <h2 class="tw-text-2xl tw-font-bold tw-mb-2">Create Account</h2>
            <p class="tw-text-gray-500 tw-mb-6">Fill in the details to sign up</p>

            <form method="POST" action="{{ route('signup') }}">
                @csrf
                <!-- Username -->
                <div class="tw-mb-4 tw-relative">
                    <input type="text" name="username" placeholder="Your Username"
                           value="{{ old('username') }}"
                           class="tw-w-full tw-pl-4 tw-pr-3 tw-py-2 tw-rounded-full tw-bg-gray-100 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-purple-500">
                </div>
                
                <!-- First Name -->
                <div class="tw-mb-4 tw-relative">
                    <input type="text" name="first_name" placeholder="Your First Name"
                           value="{{ old('first_name') }}"
                           class="tw-w-full tw-pl-4 tw-pr-3 tw-py-2 tw-rounded-full tw-bg-gray-100 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-purple-500">
                </div>
                
                <!-- Last Name -->
                <div class="tw-mb-4 tw-relative">
                    <input type="text" name="last_name" placeholder="Your Last Name"
                           value="{{ old('last_name') }}"
                           class="tw-w-full tw-pl-4 tw-pr-3 tw-py-2 tw-rounded-full tw-bg-gray-100 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-purple-500">
                </div>

                <!-- Email -->
                <div class="tw-mb-4 tw-relative">
                    <input type="email" name="email" placeholder="Your Email"
                           value="{{ old('email') }}"
                           class="tw-w-full tw-pl-4 tw-pr-3 tw-py-2 tw-rounded-full tw-bg-gray-100 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-purple-500">
                </div>

                <!-- Password -->
                <div class="tw-mb-4 tw-relative">
                    <input type="password" name="password" placeholder="Password"
                           class="tw-w-full tw-pl-4 tw-pr-3 tw-py-2 tw-rounded-full tw-bg-gray-100 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-purple-500">
                </div>

                <!-- Confirm Password -->
                <div class="tw-mb-4 tw-relative">
                    <input type="password" name="password_confirmation" placeholder="Confirm Password"
                           class="tw-w-full tw-pl-4 tw-pr-3 tw-py-2 tw-rounded-full tw-bg-gray-100 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-purple-500">
                </div>

                <!-- terrms and privacy checkbox -->
                <div class="tw-flex tw-items-center tw-mb-6 tw-text-sm">
                    <input type="checkbox" id="agreeTerms" required
                        class="tw-mr-2 tw-rounded tw-border-gray-300 tw-text-purple-600 focus:tw-ring-purple-500">
                    <label for="agreeTerms" class="tw-text-gray-600">
                        By signing up, you agree to our 
                        <a href="#" class="tw-text-purple-500 hover:tw-underline" data-modal-target="privacyModal">Privacy Policy</a> and 
                        <a href="#" class="tw-text-purple-500 hover:tw-underline" data-modal-target="termsModal">Terms of Service</a>.
                    </label>
                </div>

                <!-- validation Errors -->
                @if ($errors->any())
                    <div class="tw-mb-4 tw-text-red-500 tw-text-sm">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div id="privacyModal"
                    class="tw-hidden tw-fixed tw-inset-0 tw-bg-black/50 tw-flex tw-items-center tw-justify-center tw-z-50">
                    <div class="tw-bg-white tw-rounded-2xl tw-max-w-2xl tw-w-full tw-p-6 tw-shadow-xl tw-relative">
                        <button class="tw-absolute tw-top-3 tw-right-4 tw-text-gray-500 hover:tw-text-purple-600"
                                data-modal-close>✕</button>
                        <h2 class="tw-text-2xl tw-font-semibold tw-mb-4 tw-text-purple-600">Privacy Policy</h2>
                        <div class="tw-max-h-[70vh] tw-overflow-y-auto tw-text-gray-700 tw-space-y-3 tw-pr-2">
                            {{-- 👇 Paste your Privacy Policy content below --}}
                            @include('legal.privacy')
                        </div>
                    </div>
                </div>

                <div id="termsModal"
                    class="tw-hidden tw-fixed tw-inset-0 tw-bg-black/50 tw-flex tw-items-center tw-justify-center tw-z-50">
                    <div class="tw-bg-white tw-rounded-2xl tw-max-w-2xl tw-w-full tw-p-6 tw-shadow-xl tw-relative">
                        <button class="tw-absolute tw-top-3 tw-right-4 tw-text-gray-500 hover:tw-text-purple-600"
                                data-modal-close>✕</button>
                        <h2 class="tw-text-2xl tw-font-semibold tw-mb-4 tw-text-purple-600">Terms of Service</h2>
                        <div class="tw-max-h-[70vh] tw-overflow-y-auto tw-text-gray-700 tw-space-y-3 tw-pr-2">
                            {{-- 👇 Paste your Terms of Service content below --}}
                            @include('legal.terms')
                        </div>
                    </div>
                </div>

                <script>
                document.querySelectorAll('[data-modal-target]').forEach(link => {
                    link.addEventListener('click', e => {
                        e.preventDefault();
                        const modal = document.getElementById(link.dataset.modalTarget);
                        if (modal) modal.classList.remove('tw-hidden');
                    });
                });

                document.querySelectorAll('[data-modal-close]').forEach(btn => {
                    btn.addEventListener('click', () => {
                        btn.closest('div[id$="Modal"]').classList.add('tw-hidden');
                    });
                });

                document.querySelectorAll('div[id$="Modal"]').forEach(modal => {
                    modal.addEventListener('click', e => {
                        if (e.target === modal) modal.classList.add('tw-hidden');
                    });
                });
                </script>

                <!-- Button -->
                <button type="submit" id="signupBtn"
                        class="tw-w-full tw-py-2 tw-rounded-full tw-bg-gradient-to-r tw-from-purple-500 tw-to-indigo-500 tw-text-white tw-font-semibold hover:tw-opacity-90">
                    SIGN UP
                </button>

                <!-- Already have account -->
                <p class="tw-text-sm tw-text-center tw-mt-6 tw-text-gray-500">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="tw-text-purple-500 hover:tw-underline">Sign In</a>
                </p>
            </form>
        </div>

        <!-- Right side (Welcome panel) -->
        <div class="tw-w-1/2 tw-bg-gradient-to-r tw-from-indigo-500 tw-to-purple-600 tw-text-white tw-flex tw-flex-col tw-justify-center tw-items-center tw-p-8">
            <h2 class="tw-text-2xl tw-font-bold tw-mb-4">Join Us Today!</h2>
            <p class="tw-text-center tw-text-white/80">
                “Create an account and start exploring your subdivision in 3D.
                Unlock forecasting tools, data analytics, and interactive insights designed for you.”
            </p>
        </div>
    </div>

</body>
</html>
