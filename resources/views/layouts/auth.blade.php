<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Authentication') - LotMatch</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="tw-min-h-screen tw-bg-[#F5F6F6] tw-text-[#111111]">
    <main class="tw-min-h-screen tw-flex tw-flex-col tw-items-center tw-justify-center tw-p-6">
        <!-- Brand -->
        <div class="tw-flex tw-items-center justify-center tw-gap-3 tw-mb-10">
            <img
                src="{{ asset('images/logoLM.png') }}"
                alt="LotMatch"
                class="tw-h-10 tw-w-auto tw-object-contain"
            >
            <span class="tw-text-2xl tw-font-bold tw-tracking-tight tw-text-[#06100D]">
                LOTMATCH
            </span>
        </div>

        @yield('content')
    </main>
</body>
</html>
