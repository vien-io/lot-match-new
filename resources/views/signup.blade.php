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


            <!-- validation Errors -->
            @if ($errors->any())
                <div class="tw-bg-red-100 tw-text-red-600 tw-p-2 tw-rounded tw-mb-4 tw-text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

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
                <div class="tw-mb-4">
                    <div class="tw-relative tw-flex tw-items-center">
                        <input type="password" name="password" id="password" placeholder="Password"
                            class="tw-w-full tw-pl-4 tw-pr-3 tw-py-2 tw-rounded-full tw-bg-gray-100 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-purple-500">
                            <button type="button" id="togglePassword"
                                    class="tw-absolute tw-right-3 tw-top-1/2 tw--translate-y-1/2 tw-text-gray-500 
                                        hover:tw-text-[#9b30ff] hover:tw-drop-shadow-[0_0_8px_#9b30ff]">
                                <svg id="eyeOpened" xmlns="http://www.w3.org/2000/svg" class="tw-h-5 tw-w-5 tw-hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7z"/>
                                    <circle cx="12" cy="12" r="3" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2 2l20 20"/>
                                </svg>
                            </button>
                    </div>
                    <div id="passwordStrengthWrapper" class="tw-mt-2 tw-relative tw-h-2 tw-w-full tw-rounded-full tw-overflow-hidden tw-hidden">
                        <div id="passwordStrengthBar" class="tw-h-2 tw-rounded-full tw-w-0 tw-transition-all tw-duration-300"></div>
                    </div>
                    <div id="passwordStrengthText" class="tw-text-sm tw-mt-1 tw-text-gray-600 tw-hidden"></div>
                </div>

                <!-- Confirm Password -->
                <div class="tw-mb-4 tw-relative">
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password"
                           class="tw-w-full tw-pl-4 tw-pr-3 tw-py-2 tw-rounded-full tw-bg-gray-100 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-purple-500">
                           <button type="button" id="togglePasswordConfirm"
                                    class="tw-absolute tw-right-3 tw-top-1/2 tw--translate-y-1/2 tw-text-gray-500 
                                        hover:tw-text-[#9b30ff] hover:tw-drop-shadow-[0_0_8px_#9b30ff]">
                                <svg id="eyeOpenedConf" xmlns="http://www.w3.org/2000/svg" class="tw-h-5 tw-w-5 tw-hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eyeClosedConf" xmlns="http://www.w3.org/2000/svg" class="tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7z"/>
                                    <circle cx="12" cy="12" r="3" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2 2l20 20"/>
                                </svg>
                            </button>
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

                <div id="privacyModal"
                    class="tw-hidden tw-fixed tw-inset-0 tw-bg-black/50 tw-flex tw-items-center tw-justify-center tw-z-50">
                    <div class="tw-bg-white tw-rounded-2xl tw-max-w-2xl tw-w-full tw-p-6 tw-shadow-xl tw-relative">
                        <button class="tw-absolute tw-top-3 tw-right-4 tw-text-gray-500 hover:tw-text-purple-600"
                                data-modal-close>✕</button>
                        <h2 class="tw-text-2xl tw-font-semibold tw-mb-4 tw-text-purple-600">Privacy Policy</h2>
                        <div class="tw-max-h-[70vh] tw-overflow-y-auto tw-text-gray-700 tw-space-y-3 tw-pr-2">
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
                            @include('legal.terms')
                        </div>
                    </div>
                </div>

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
    @vite('resources/js/signup.js')
</body>
</html>
