<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body class="tw-bg-[#D9D9D9] tw-flex tw-items-center tw-justify-center tw-min-h-screen tw-p-4">

    <div class="tw-bg-white tw-rounded-2xl tw-shadow-xl tw-overflow-hidden tw-w-full tw-max-w-5xl tw-flex">

        <!-- Left Side: Login Form -->
        <div class="tw-w-full lg:tw-w-3/5 tw-p-6 sm:tw-p-10 lg:tw-p-12">

            <!-- Heading -->
            <div class="tw-mb-8">
                <h1 class="tw-text-3xl tw-font-bold tw-tracking-tight tw-text-[#111111] tw-mb-2">
                    Sign in
                </h1>
                <p class="tw-text-sm tw-text-[#666666]">
                    Enter your credentials to access your account.
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

            <!-- Login Form -->
            <form method="POST" action="{{ route('signin') }}" class="tw-space-y-5">
                @csrf

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
                            placeholder="Enter your username"
                            autocomplete="username"
                            required
                            class="tw-w-full tw-bg-white tw-border tw-border-[#C4C4C4] tw-rounded-xl tw-py-3 tw-pl-11 tw-pr-4 tw-text-sm tw-text-[#111111] placeholder:tw-text-[#888888] tw-transition-colors focus:tw-outline-none focus:tw-border-[#06EBB6] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20"
                        >
                    </div>
                </div>

                
                <!-- Password -->
                <div>
                    <label for="password"
                        class="tw-block tw-text-sm tw-font-semibold tw-text-[#111111] tw-mb-2">
                        Password
                    </label>

                    <div class="tw-relative">
                        <!-- Lock Icon -->
                        <i class="fas fa-lock tw-absolute tw-left-4 tw-top-1/2 -tw-translate-y-1/2 tw-text-[#666666]"></i>

                        <!-- Password Input -->
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                            class="tw-w-full tw-bg-white tw-border tw-border-[#C4C4C4] tw-rounded-xl tw-py-3 tw-pl-11 tw-pr-12 tw-text-sm tw-text-[#111111] placeholder:tw-text-[#888888] tw-transition-colors focus:tw-outline-none focus:tw-border-[#06EBB6] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20"
                        >

                        <!-- Toggle Password Visibility -->
                        <button
                            type="button"
                            data-password-toggle="password"
                            aria-label="Show password"
                            aria-pressed="false"
                            class="tw-absolute tw-right-4 tw-top-1/2 -tw-translate-y-1/2 tw-text-[#666666] hover:tw-text-[#087F68] tw-transition-colors focus:tw-outline-none"
                        >
                            <i id="passwordEyeIcon" class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>


                <!-- Remember Me and Forgot Password -->
                <div class="tw-flex tw-flex-wrap tw-items-center tw-justify-between tw-gap-3 tw-text-sm">

                    <label for="remember"
                           class="tw-flex tw-items-center tw-gap-2 tw-text-[#666666] tw-cursor-pointer">
                        <input
                            type="checkbox"
                            id="remember"
                            name="remember"
                            value="1"
                            class="tw-h-4 tw-w-4 tw-rounded tw-border-[#C4C4C4] tw-accent-[#06EBB6] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/30"
                        >
                        Remember me
                    </label>

                    <a href="{{ route('password.request') }}"
                       class="tw-font-medium tw-text-[#111111] hover:tw-text-[#087F68] tw-transition-colors">
                        Forgot password?
                    </a>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="tw-w-full tw-flex tw-items-center tw-justify-center tw-gap-2 tw-bg-[#06EBB6] hover:tw-bg-[#1ED9D7] tw-text-[#06100D] tw-font-semibold tw-text-sm tw-rounded-xl tw-py-3.5 tw-px-4 tw-transition-colors focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6] focus:tw-ring-offset-2 active:tw-scale-[0.99]"
                >
                    Sign in
                    <i class="fas fa-arrow-right tw-text-xs"></i>
                </button>

                <!-- Registration -->
                <p class="tw-text-sm tw-text-center tw-text-[#666666] tw-pt-3">
                    Don't have an account?
                    <a href="{{ route('register') }}"
                       class="tw-font-semibold tw-text-[#111111] hover:tw-text-[#087F68] tw-transition-colors">
                        Create account
                    </a>
                </p>

            </form>

            <!-- Footer -->
            <p class="tw-text-xs tw-text-center tw-text-[#888888] tw-mt-10">
                &copy; {{ date('Y') }} LotMatch. All rights reserved.
            </p>
        </div>

        <!-- Right Side: Welcome Panel -->
        <div class="tw-hidden lg:tw-flex lg:tw-w-2/5 tw-bg-[#06100D] tw-text-white tw-flex-col tw-justify-between tw-p-10 tw-relative">

            <!-- Brand -->
            <div class="tw-flex tw-items-center tw-gap-3">
                <!-- Brand -->
                <img
                    src="{{ asset('images/logoLM.png') }}"
                    alt="LotMatch"
                    class="tw-h-7 tw-w-auto tw-object-contain"
                    style="filter: brightness(0) saturate(100%) invert(77%) sepia(69%) saturate(563%) hue-rotate(104deg) brightness(101%) contrast(101%);"
                >
                <span class="tw-text-sm tw-font-semibold tw-tracking-wide tw-text-white/90">
                    LOTMATCH
                </span>
            </div>

            <!-- Welcome Content -->
            <div class="tw-py-10">
                <div class="tw-w-12 tw-h-1 tw-rounded-full tw-bg-[#06EBB6] tw-mb-6"></div>

                <h2 class="tw-text-3xl tw-font-bold tw-tracking-tighter tw-leading-tight tw-mb-4">
                    See beyond the lot.
                </h2>

                <p class="tw-text-sm tw-leading-7 tw-text-white/60 tw-max-w-xs">
                    Explore subdivision properties in 3D and uncover valuable insights through AI-powered reviews and predictive property ratings.
                </p>
            </div>

            <!-- Bottom Accent -->
            <div class="tw-border-t tw-border-white/10 tw-pt-5">
                <p class="tw-text-xs tw-text-white/40">
                    Smarter insights for every subdivision.
                </p>
            </div>
        </div>
    </div>

    <!-- Right side (Render Demo / Accounts) -->
    @if (config('app.render'))
        <div class="tw-absolute tw-top-3 tw-right-3 tw-w-full lg:tw-w-1/5 tw-bg-white tw-rounded-2xl tw-shadow-lg tw-p-6 ">
            <h3 class="tw-text-xl tw-font-bold tw-mb-2 tw-text-center tw-text-green-600">Render Demo Accounts</h3>
            <p class="tw-text-gray-600 tw-text-center tw-text-sm mb-4">
                Use one of these accounts to log in during demo
            </p>

            <div class="tw-overflow-x-auto">
                <table class="tw-w-full tw-table-auto tw-text-sm tw-border-collapse">
                    <thead>
                        <tr class="tw-bg-green-100 tw-text-green-800">
                            <th class="tw-px-3 tw-py-2 tw-text-left tw-font-semibold">Username</th>
                            <th class="tw-px-3 tw-py-2 tw-text-left tw-font-semibold">Role</th>
                            <th class="tw-px-3 tw-py-2 tw-text-left tw-font-semibold">Password</th>
                        </tr>
                    </thead>
                    <tbody class="tw-text-gray-700">
                        <tr class="tw-border-b hover:tw-bg-gray-50 tw-cursor-pointer" onclick="fillDemo('admin@example.com', 'Password123')">
                            <td class="tw-px-3 tw-py-2">admin</td>
                            <td class="tw-px-3 tw-py-2">admin</td>
                            <td class="tw-px-3 tw-py-2">Password123</td>
                        </tr>
                        <tr class="tw-border-b hover:tw-bg-gray-50 tw-cursor-pointer" onclick="fillDemo('buyer@example.com', 'Password123')">
                            <td class="tw-px-3 tw-py-2">buyer</td>
                            <td class="tw-px-3 tw-py-2">buyer</td>
                            <td class="tw-px-3 tw-py-2">Password123</td>
                        </tr>
                        <tr class="tw-border-b hover:tw-bg-gray-50 tw-cursor-pointer" onclick="fillDemo('owner1@example.com', 'Password123')">
                            <td class="tw-px-3 tw-py-2">owner1</td>
                            <td class="tw-px-3 tw-py-2">owner</td>
                            <td class="tw-px-3 tw-py-2">Password123</td>
                        </tr>
                        <tr class="tw-border-b hover:tw-bg-gray-50 tw-cursor-pointer" onclick="fillDemo('owner2@example.com', 'Password123')">
                            <td class="tw-px-3 tw-py-2">owner2</td>
                            <td class="tw-px-3 tw-py-2">owner</td>
                            <td class="tw-px-3 tw-py-2">Password123</td>
                        </tr>
                        <tr class="tw-border-b hover:tw-bg-gray-50 tw-cursor-pointer" onclick="fillDemo('owner3@example.com', 'Password123')">
                            <td class="tw-px-3 tw-py-2">owner3</td>
                            <td class="tw-px-3 tw-py-2">owner</td>
                            <td class="tw-px-3 tw-py-2">Password123</td>
                        </tr>
                        <tr class="hover:tw-bg-gray-50 tw-cursor-pointer" onclick="fillDemo('owner4@example.com', 'Password123')">
                            <td class="tw-px-3 tw-py-2">owner4</td>
                            <td class="tw-px-3 tw-py-2">owner</td>
                            <td class="tw-px-3 tw-py-2">Password123</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endif


    {{-- Font Awesome for icons --}}
    <script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script>
    @vite('resources/js/app.js')
</body>
</html>
