<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LotMatch') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    {{-- logo --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    @include('partials.app-config')

    @vite([
        'resources/sass/app.scss',
        'resources/js/app.js',
        'resources/js/settings.js',
        'resources/css/dashboard.css',
        'resources/css/sidebar.css',
        'resources/css/notification.css',
        'resources/css/header.css',
        'resources/css/components/forecast-loading.css',
        'resources/css/pages/forecasting.css',
    ])

</head>

<body class="tw-bg-gray-50">
    <div id="app" class="tw-flex">

        @include('layouts.sidebar')

        {{-- Main content --}}
        <div class="lm-app-content tw-flex-1 tw-flex tw-flex-col">

            @include('components.notification')

            <main class="tw-p-10">
                @yield('content')
                @yield('scripts')
            </main>
        </div>
    </div>

    @include('components.modals.settings')

    {{-- Page-specific JavaScript --}}
    @stack('scripts')
</body>

</html>