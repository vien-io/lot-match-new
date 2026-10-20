
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#06100D">

    <title>Create Account | LotMatch</title>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite('resources/css/app.css')
</head>

<body class="tw-min-h-screen tw-bg-[#D9D9D9] tw-flex tw-items-center tw-justify-center tw-p-4 sm:tw-p-6 lg:tw-py-10">

    <main class="tw-w-full tw-max-w-2xl tw-bg-white tw-rounded-2xl tw-shadow-xl tw-border tw-border-[#C4C4C4]/50 tw-overflow-hidden">

        <!-- Registration Form -->
        <section class="tw-w-full tw-p-6 sm:tw-p-10 lg:tw-p-12">

            <!-- Heading -->
            <div class="tw-mb-7">
                <h1 class="tw-text-3xl tw-font-bold tw-tracking-tight tw-text-[#111111] tw-mb-2">
                    Create account
                </h1>

                <p class="tw-text-sm tw-leading-6 tw-text-[#666666]">
                    Create your LotMatch account to explore properties and discover valuable insights.
                </p>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div role="status"
                     class="tw-flex tw-items-start tw-gap-3 tw-bg-emerald-50 tw-text-emerald-800 tw-border tw-border-emerald-200 tw-rounded-xl tw-p-4 tw-mb-5">
                    <i class="fas fa-check-circle tw-mt-0.5"></i>
                    <p class="tw-text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Session Error -->
            @if (session('error'))
                <div role="alert"
                     class="tw-flex tw-items-start tw-gap-3 tw-bg-red-50 tw-text-red-700 tw-border tw-border-red-200 tw-rounded-xl tw-p-4 tw-mb-5">
                    <i class="fas fa-exclamation-circle tw-mt-0.5"></i>
                    <p class="tw-text-sm">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div role="alert"
                     class="tw-bg-red-50 tw-text-red-700 tw-border tw-border-red-200 tw-rounded-xl tw-p-4 tw-mb-5">
                    <p class="tw-font-semibold tw-text-sm tw-mb-2">
                        Please check the following:
                    </p>

                    <ul class="tw-list-disc tw-pl-5 tw-space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="tw-text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Registration Form -->
            <form method="POST" action="{{ route('signup.submit') }}" class="tw-space-y-5">
                @csrf

                <!-- First Name and Last Name -->
                <div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 tw-gap-5">

                    <!-- First Name -->
                    <div>
                        <label for="first_name"
                               class="tw-block tw-text-sm tw-font-semibold tw-text-[#111111] tw-mb-2">
                            First name
                        </label>

                        <input
                            type="text"
                            id="first_name"
                            name="first_name"
                            value="{{ old('first_name') }}"
                            placeholder="Enter your first name"
                            autocomplete="given-name"
                            required
                            class="tw-w-full tw-bg-white tw-border tw-border-[#C4C4C4] tw-rounded-xl tw-py-3 tw-px-4 tw-text-sm tw-text-[#111111] placeholder:tw-text-[#888888] tw-transition-colors focus:tw-outline-none focus:tw-border-[#06EBB6] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20"
                        >
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name"
                               class="tw-block tw-text-sm tw-font-semibold tw-text-[#111111] tw-mb-2">
                            Last name
                        </label>

                        <input
                            type="text"
                            id="last_name"
                            name="last_name"
                            value="{{ old('last_name') }}"
                            placeholder="Enter your last name"
                            autocomplete="family-name"
                            required
                            class="tw-w-full tw-bg-white tw-border tw-border-[#C4C4C4] tw-rounded-xl tw-py-3 tw-px-4 tw-text-sm tw-text-[#111111] placeholder:tw-text-[#888888] tw-transition-colors focus:tw-outline-none focus:tw-border-[#06EBB6] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20"
                        >
                    </div>

                </div>

                <!-- Username and Email -->
                <div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 tw-gap-5">

                    <!-- Username -->
                    <div>
                        <label for="username"
                               class="tw-block tw-text-sm tw-font-semibold tw-text-[#111111] tw-mb-2">
                            Username
                        </label>

                        <div class="tw-relative">
                            <i class="fas fa-user tw-absolute tw-left-4 tw-top-1/2 -tw-translate-y-1/2 tw-text-[#666666]"></i>

                            <input
                                type="text"
                                id="username"
                                name="username"
                                value="{{ old('username') }}"
                                placeholder="Choose a username"
                                autocomplete="username"
                                required
                                class="tw-w-full tw-bg-white tw-border tw-border-[#C4C4C4] tw-rounded-xl tw-py-3 tw-pl-11 tw-pr-4 tw-text-sm tw-text-[#111111] placeholder:tw-text-[#888888] tw-transition-colors focus:tw-outline-none focus:tw-border-[#06EBB6] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20"
                            >
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email"
                               class="tw-block tw-text-sm tw-font-semibold tw-text-[#111111] tw-mb-2">
                            Email address
                        </label>

                        <div class="tw-relative">
                            <i class="fas fa-envelope tw-absolute tw-left-4 tw-top-1/2 -tw-translate-y-1/2 tw-text-[#666666]"></i>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="you@example.com"
                                autocomplete="email"
                                required
                                class="tw-w-full tw-bg-white tw-border tw-border-[#C4C4C4] tw-rounded-xl tw-py-3 tw-pl-11 tw-pr-4 tw-text-sm tw-text-[#111111] placeholder:tw-text-[#888888] tw-transition-colors focus:tw-outline-none focus:tw-border-[#06EBB6] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20"
                            >
                        </div>
                    </div>

                </div>

            
                <!-- Password and Confirmation -->
                <div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 tw-gap-5">

                    <!-- Password -->
                    <div>
                        <label for="password"
                               class="tw-block tw-text-sm tw-font-semibold tw-text-[#111111] tw-mb-2">
                            Password
                        </label>

                        <div class="tw-relative">
                            <i class="fas fa-lock tw-absolute tw-left-4 tw-top-1/2 -tw-translate-y-1/2 tw-text-[#666666]"></i>

                            <input
                                type="password"
                                name="password"
                                id="password"
                                placeholder="Create a password"
                                autocomplete="new-password"
                                required
                                class="tw-w-full tw-bg-white tw-border tw-border-[#C4C4C4] tw-rounded-xl tw-py-3 tw-pl-11 tw-pr-11 tw-text-sm tw-text-[#111111] placeholder:tw-text-[#888888] tw-transition-colors focus:tw-outline-none focus:tw-border-[#06EBB6] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20"
                            >

                            <button
                                type="button"
                                id="togglePassword"
                                aria-label="Show password"
                                aria-controls="password"
                                aria-pressed="false"
                                class="tw-absolute tw-right-3 tw-top-1/2 -tw-translate-y-1/2 tw-text-[#666666] hover:tw-text-[#087F68] tw-transition-colors focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6] tw-rounded-md tw-p-1"
                            >
                                <svg id="eyeOpened"
                                     xmlns="http://www.w3.org/2000/svg"
                                     class="tw-h-5 tw-w-5 tw-hidden"
                                     fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>

                                <svg id="eyeClosed"
                                     xmlns="http://www.w3.org/2000/svg"
                                     class="tw-h-5 tw-w-5"
                                     fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7z"/>
                                    <circle cx="12" cy="12" r="3"
                                            stroke-linecap="round" stroke-linejoin="round"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2 2l20 20"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Password Strength -->
                        <div id="passwordStrengthWrapper"
                             class="tw-mt-3 tw-relative tw-h-1.5 tw-w-full tw-rounded-full tw-overflow-hidden tw-bg-[#E5E7EB] tw-hidden">
                            <div id="passwordStrengthBar"
                                 class="tw-h-full tw-rounded-full tw-w-0 tw-transition-all tw-duration-300">
                            </div>
                        </div>

                        <div id="passwordStrengthText"
                             class="tw-text-xs tw-mt-2 tw-text-[#666666] tw-hidden">
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation"
                               class="tw-block tw-text-sm tw-font-semibold tw-text-[#111111] tw-mb-2">
                            Confirm password
                        </label>

                        <div class="tw-relative">
                            <i class="fas fa-lock tw-absolute tw-left-4 tw-top-1/2 -tw-translate-y-1/2 tw-text-[#666666]"></i>

                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                placeholder="Repeat your password"
                                autocomplete="new-password"
                                required
                                class="tw-w-full tw-bg-white tw-border tw-border-[#C4C4C4] tw-rounded-xl tw-py-3 tw-pl-11 tw-pr-11 tw-text-sm tw-text-[#111111] placeholder:tw-text-[#888888] tw-transition-colors focus:tw-outline-none focus:tw-border-[#06EBB6] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20"
                            >

                            <button
                                type="button"
                                id="togglePasswordConfirm"
                                aria-label="Show confirm password"
                                aria-controls="password_confirmation"
                                aria-pressed="false"
                                class="tw-absolute tw-right-3 tw-top-1/2 -tw-translate-y-1/2 tw-text-[#666666] hover:tw-text-[#087F68] tw-transition-colors focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6] tw-rounded-md tw-p-1"
                            >
                                <svg id="eyeOpenedConf"
                                     xmlns="http://www.w3.org/2000/svg"
                                     class="tw-h-5 tw-w-5 tw-hidden"
                                     fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>

                                <svg id="eyeClosedConf"
                                     xmlns="http://www.w3.org/2000/svg"
                                     class="tw-h-5 tw-w-5"
                                     fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7z"/>
                                    <circle cx="12" cy="12" r="3"
                                            stroke-linecap="round" stroke-linejoin="round"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2 2l20 20"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Confirm Password Indicator -->
                        <div id="confirmPasswordStrengthWrapper"
                            class="tw-mt-3 tw-relative tw-h-1.5 tw-w-full tw-rounded-full tw-overflow-hidden tw-bg-[#E5E7EB] tw-hidden">
                            <div id="confirmPasswordStrengthBar"
                                class="tw-h-full tw-rounded-full tw-w-0 tw-transition-all tw-duration-300">
                            </div>
                        </div>

                        <div id="confirmPasswordStrengthText"
                            class="tw-text-xs tw-mt-2 tw-text-[#666666] tw-hidden">
                        </div>

                    </div>

                </div>

                <!-- Terms and Privacy -->
                <div class="tw-pt-1">
                    <label for="agreeTerms"
                           class="tw-flex tw-items-start tw-gap-3 tw-text-sm tw-leading-6 tw-text-[#666666] tw-cursor-pointer">

                        <input
                            type="checkbox"
                            id="agreeTerms"
                            name="agree_terms"
                            value="1"
                            required
                            class="tw-mt-1 tw-h-4 tw-w-4 tw-shrink-0 tw-rounded tw-border-[#C4C4C4] tw-accent-[#06EBB6] focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6]/30"
                        >

                        <span>
                            By creating an account, you agree to our
                            <a href="#"
                               class="tw-font-semibold tw-text-[#111111] hover:tw-text-[#087F68] hover:tw-underline tw-transition-colors"
                               data-modal-target="privacyModal">
                                Privacy Policy
                            </a>
                            and
                            <a href="#"
                               class="tw-font-semibold tw-text-[#111111] hover:tw-text-[#087F68] hover:tw-underline tw-transition-colors"
                               data-modal-target="termsModal">
                                Terms of Service
                            </a>.
                        </span>
                    </label>
                </div>

                <!-- Privacy Policy Modal -->
                <div id="privacyModal"
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="privacyModalTitle"
                    class="tw-hidden tw-fixed tw-inset-0 tw-z-50 tw-items-center tw-justify-center tw-bg-[#06100D]/60 tw-p-4">

                    <div class="tw-relative tw-flex tw-w-full tw-max-w-2xl tw-max-h-[85vh] tw-flex-col tw-overflow-hidden tw-rounded-2xl tw-border tw-border-[#C4C4C4]/60 tw-bg-white tw-shadow-2xl">

                        <!-- Modal Header -->
                        <div class="tw-flex tw-items-center tw-justify-between tw-gap-4 tw-border-b tw-border-[#C4C4C4]/60 tw-bg-white tw-px-6 tw-py-5">

                            <div class="tw-min-w-0">
                                <p class="tw-mb-1 tw-text-xs tw-font-semibold tw-uppercase tw-tracking-widest tw-text-[#666666]">
                                    LOTMATCH LEGAL
                                </p>

                                <h2 id="privacyModalTitle"
                                    class="tw-text-xl tw-font-bold tw-tracking-tight tw-text-[#111111]">
                                    Privacy Policy
                                </h2>
                            </div>

                            <button type="button"
                                    aria-label="Close privacy policy"
                                    data-modal-close
                                    class="tw-flex tw-h-10 tw-w-10 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-xl tw-text-[#666666] tw-transition-colors hover:tw-bg-[#D9D9D9]/40 hover:tw-text-[#111111] focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6]">
                                <i class="fas fa-times" aria-hidden="true"></i>
                            </button>

                        </div>

                        <!-- Modal Content -->
                        <div class="tw-overflow-y-auto tw-px-6 tw-py-6 tw-text-sm tw-leading-7 tw-text-[#666666]">
                            @include('legal.privacy')
                        </div>

                        <!-- Modal Footer -->
                        <div class="tw-flex tw-items-center tw-justify-between tw-gap-4 tw-border-t tw-border-[#C4C4C4]/60 tw-bg-[#D9D9D9]/20 tw-px-6 tw-py-4">
                            <span class="tw-text-xs tw-text-[#666666]">
                                LotMatch · Privacy & Data Protection
                            </span>

                            <button type="button"
                                    data-modal-close
                                    class="tw-rounded-xl tw-bg-[#06100D] tw-px-4 tw-py-2.5 tw-text-sm tw-font-semibold tw-text-white tw-transition-colors hover:tw-bg-[#1ED9D7] hover:tw-text-[#06100D] focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6]">
                                Close
                            </button>
                        </div>

                    </div>
                </div>


                <!-- Terms of Service Modal -->
                <div id="termsModal"
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="termsModalTitle"
                    class="tw-hidden tw-fixed tw-inset-0 tw-z-50 tw-items-center tw-justify-center tw-bg-[#06100D]/60 tw-p-4">

                    <div class="tw-relative tw-flex tw-w-full tw-max-w-2xl tw-max-h-[85vh] tw-flex-col tw-overflow-hidden tw-rounded-2xl tw-border tw-border-[#C4C4C4]/60 tw-bg-white tw-shadow-2xl">

                        <!-- Modal Header -->
                        <div class="tw-flex tw-items-center tw-justify-between tw-gap-4 tw-border-b tw-border-[#C4C4C4]/60 tw-bg-white tw-px-6 tw-py-5">

                            <div class="tw-min-w-0">
                                <p class="tw-mb-1 tw-text-xs tw-font-semibold tw-uppercase tw-tracking-widest tw-text-[#666666]">
                                    LOTMATCH LEGAL
                                </p>

                                <h2 id="termsModalTitle"
                                    class="tw-text-xl tw-font-bold tw-tracking-tight tw-text-[#111111]">
                                    Terms of Service
                                </h2>
                            </div>

                            <button type="button"
                                    aria-label="Close terms of service"
                                    data-modal-close
                                    class="tw-flex tw-h-10 tw-w-10 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-xl tw-text-[#666666] tw-transition-colors hover:tw-bg-[#D9D9D9]/40 hover:tw-text-[#111111] focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6]">
                                <i class="fas fa-times" aria-hidden="true"></i>
                            </button>

                        </div>

                        <!-- Modal Content -->
                        <div class="tw-overflow-y-auto tw-px-6 tw-py-6 tw-text-sm tw-leading-7 tw-text-[#666666]">
                            @include('legal.terms')
                        </div>

                        <!-- Modal Footer -->
                        <div class="tw-flex tw-items-center tw-justify-between tw-gap-4 tw-border-t tw-border-[#C4C4C4]/60 tw-bg-[#D9D9D9]/20 tw-px-6 tw-py-4">
                            <span class="tw-text-xs tw-text-[#666666]">
                                LotMatch · Terms & Conditions
                            </span>

                            <button type="button"
                                    data-modal-close
                                    class="tw-rounded-xl tw-bg-[#06100D] tw-px-4 tw-py-2.5 tw-text-sm tw-font-semibold tw-text-white tw-transition-colors hover:tw-bg-[#1ED9D7] hover:tw-text-[#06100D] focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6]">
                                Close
                            </button>
                        </div>

                    </div>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    id="signupBtn"
                    class="tw-w-full tw-flex tw-items-center tw-justify-center tw-gap-2 tw-bg-[#06EBB6] hover:tw-bg-[#1ED9D7] tw-text-[#06100D] tw-font-semibold tw-text-sm tw-rounded-xl tw-py-3.5 tw-px-4 tw-transition-colors focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6] focus:tw-ring-offset-2 active:tw-scale-[0.99]"
                >
                    Create account
                    <i class="fas fa-arrow-right tw-text-xs"></i>
                </button>

                <!-- Sign In -->
                <p class="tw-text-sm tw-text-center tw-text-[#666666] tw-pt-1">
                    Already have an account?
                    <a href="{{ route('login') }}"
                       class="tw-font-semibold tw-text-[#111111] hover:tw-text-[#087F68] tw-transition-colors">
                        Sign in
                    </a>
                </p>

            </form>

            <!-- Footer -->
            <p class="tw-text-xs tw-text-center tw-text-[#888888] tw-mt-8">
                &copy; {{ date('Y') }} LotMatch. All rights reserved.
            </p>

        </section>
    </main>

    @vite('resources/js/signup.js')

</body>
</html>
