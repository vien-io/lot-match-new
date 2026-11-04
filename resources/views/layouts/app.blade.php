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
    @stack('styles')
</head>

<body class="tw-bg-gray-50 {{ request()->is('3dmap') ? 'tw-overflow-hidden' : '' }}">
    <div id="app" class="tw-flex {{ request()->is('3dmap') ? 'tw-h-screen tw-overflow-hidden' : '' }}">

        @include('layouts.sidebar')

        {{-- Main content --}}
        <div class="lm-app-content tw-flex-1 tw-flex tw-flex-col tw-min-w-0 tw-min-h-0 {{ request()->is('3dmap') ? 'lm-app-content-map' : '' }}">

            @include('components.notification')

            <main class="{{ request()->is('3dmap') ? 'tw-flex-1 tw-flex tw-flex-col tw-min-h-0 tw-p-0' : 'tw-p-10' }}">
                @yield('content')
                @yield('scripts')
            </main>
        </div>
    </div>

    @include('components.modals.settings')

    @stack('scripts')
</body>

</html>