<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    @vite('resources/css/app.css')
</head>
<body class="tw-bg-gray-100 tw-flex tw-items-center tw-justify-center tw-min-h-screen">

    <div class="tw-bg-white tw-rounded-2xl tw-shadow-lg tw-overflow-hidden tw-w-full tw-max-w-4xl tw-flex">
        <!-- Left side (Form) -->
        <div class="tw-w-full lg:tw-w-1/2 tw-p-8">
            <h2 class="tw-text-2xl tw-font-bold tw-mb-2">Hello!</h2>
            <p class="tw-text-gray-500 tw-mb-6">Sign in to your account</p>

            {{-- Success message --}}
            @if (session('success'))
                <div class="tw-bg-green-100 tw-text-green-600 tw-p-2 tw-rounded tw-mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error message --}}
            @if (session('error'))
                <div class="tw-bg-red-100 tw-text-red-600 tw-p-2 tw-rounded tw-mb-4">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="tw-bg-red-100 tw-text-red-600 tw-p-2 tw-rounded tw-mb-4">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('signin') }}">
                @csrf

                <!-- Name -->
                <div class="tw-mb-4 tw-relative">
                    <span class="tw-absolute tw-left-3 tw-top-3 tw-text-green-500">
                        <i class="fas fa-user"></i>
                    </span>
                    <input type="text" name="name" placeholder="Your Name"
                           class="tw-w-full tw-pl-10 tw-pr-3 tw-py-2 tw-rounded-full tw-bg-gray-100 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-green-500"
                           required>
                </div>

                <!-- Password -->
                <div class="tw-mb-4 tw-relative">
                    <span class="tw-absolute tw-left-3 tw-top-3 tw-text-green-500">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" name="password" placeholder="Your Password"
                           class="tw-w-full tw-pl-10 tw-pr-10 tw-py-2 tw-rounded-full tw-bg-gray-100 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-green-500"
                           required>
                </div>

                <!-- Remember + Forgot -->
                <div class="tw-flex tw-items-center tw-justify-between tw-mb-6 tw-text-sm">
                    <label class="tw-flex tw-items-center">
                        <input type="checkbox" class="tw-mr-2 tw-rounded tw-border-gray-300 tw-text-green-600 focus:tw-ring-green-500">
                        Remember me
                    </label>
                    <a href="{{ route('password.request') }}" class="tw-text-green-500 hover:tw-underline">Forgot password?</a>
                </div>

                <!-- Button -->
                <button type="submit"
                        class="tw-w-full tw-py-2 tw-rounded-full tw-bg-gradient-to-r tw-from-green-500 tw-to-emerald-600 tw-text-white tw-font-semibold hover:tw-opacity-90">
                    SIGN IN
                </button>

                <!-- Create account -->
                <p class="tw-text-sm tw-text-center tw-mt-6 tw-text-gray-500">
                    Don’t have an account? 
                    <a href="{{ route('register') }}" class="tw-text-green-500 hover:tw-underline">Create</a>
                </p>
            </form>
        </div>

        <!-- Right side (Welcome panel) -->
        <div class="tw-hidden lg:tw-flex tw-w-1/2 tw-bg-gradient-to-r tw-from-green-500 tw-to-emerald-600 tw-text-white tw-flex-col tw-justify-center tw-items-center tw-p-8">
            <h2 class="tw-text-2xl tw-font-bold tw-mb-4">Welcome Back!</h2>
            <p class="tw-text-center tw-text-white/80">
                “Sign in to explore your interactive 3D subdivision dashboard.
                Gain insights with forecasting, analytics, and smarter data-driven decisions.”
            </p>
        </div>
    </div>

    {{-- Font Awesome for icons --}}
    <script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script>
</body>
</html>
