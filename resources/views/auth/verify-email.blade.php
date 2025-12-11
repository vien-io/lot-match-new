<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-50 to-white min-h-screen flex items-center justify-center">

    <div class="bg-white rounded-2xl shadow-lg px-10 py-12 text-center max-w-md border border-gray-100 transition-all duration-300 hover:shadow-xl">

        {{-- Icon --}}
        <div class="bg-blue-100 rounded-full p-4 inline-flex items-center justify-center mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 12a4 4 0 11-8 0 4 4 0 018 0zM12 2v2m6.364 1.636l-1.414 1.414M22 12h-2M4 12H2m3.636-6.364L4.222 7.05M12 22v-2m6.364-1.636l-1.414-1.414" />
            </svg>
        </div>

        {{-- Title & Message --}}
        <h1 class="text-3xl font-bold text-gray-800">Verify Your Email</h1>
        <p class="text-gray-600 mt-3">
            Before continuing, please check your inbox for a verification link.  
            Didn’t receive it? You can request another below.
        </p>

        {{-- Success Message --}}
        @if (session('message'))
            <p class="text-green-600 font-semibold mt-4">{{ session('message') }}</p>
        @endif

        {{-- Resend Form --}}
        <form method="POST" action="{{ route('verification.send') }}" class="mt-8">
            @csrf
            <button type="submit"
                class="bg-blue-500 text-white px-8 py-2.5 rounded-full font-semibold transition-all duration-300 hover:bg-blue-600 hover:scale-105">
                Resend Verification Email
            </button>
        </form>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit" class="text-gray-500 underline hover:text-gray-700 transition">
                Log Out
            </button>
        </form>

    </div>

</body>
</html>
