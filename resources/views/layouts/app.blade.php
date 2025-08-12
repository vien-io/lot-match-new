<!doctype html>
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

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="tw-bg-gray-50">
    <div id="app" class="tw-flex">
        {{-- Sidebar --}}
        @auth
        <div class="sidebar tw-bg-white tw-shadow-lg tw-w-20 tw-flex tw-flex-col tw-items-center tw-py-6">

         {{-- Logo --}}
        <div class="tw-mb-6">
            <img src="#" alt="LotM" class="tw-w-10 tw-h-10">
        </div>
        {{-- dashboard --}}
        <a href="{{ route('dashboard') }}"
            class="tw-flex tw-items-center tw-justify-center tw-w-12 tw-h-12 tw-my-3 tw-text-gray-400 tw-rounded-xl tw-transition-colors 
            {{ request()->routeIs('dashboard') 
                ? 'tw-bg-green-500 tw-text-white'
                : 'tw-text-gray-400 hover:tw-bg-green-100 hover:tw-text-green-500' }}">
            <i class="fas fa-home tw-text-2xl"></i>
        </a>

        {{-- 3d map --}}
        <a href="{{ route('3dmap') }}"
            class="tw-flex tw-items-center tw-justify-center tw-w-12 tw-h-12 tw-my-3 tw-text-gray-400 tw-rounded-xl tw-transition-colors
            {{ request()->routeIs('3dmap')
                ? 'tw-bg-green-500 tw-text-white'
                : 'tw-text-gray-400 hover:tw-bg-green-100 hover:tw-text-green-500' }}">
            <i class="fas fa-map tw-text-2xl"></i>
        </a>

        {{-- property management --}}
        <a href="{{ route('properties.index') }}" 
            class="tw-flex tw-items-center tw-justify-center tw-w-12 tw-h-12 tw-my-3 tw-text-gray-400 tw-rounded-xl tw-transition-colors
            {{ request()->routeIs('properties.*') 
                ? 'tw-bg-green-500 tw-text-white' 
                : 'tw-text-gray-400 hover:tw-bg-green-100 hover:tw-text-green-500' }}">
            <i class="fas fa-vihara tw-text-2xl"></i>
        </a>

        {{-- reviews and ratings --}}
        <a href="#"
            class="tw-flex tw-items-center tw-justify-center tw-w-12 tw-h-12 tw-my-3 tw-text-gray-400 tw-rounded-xl tw-transition-colors
            {{ request()->routeIs('reviews')
                ? 'tw-bg-green-500 tw-text-white'
                : 'tw-text-gray-400 hover:tw-bg-green-100 hover:tw-text-green-500'}}">
                <i class="fas fa-star tw-text-2xl"></i>
        </a>

        {{-- AI Summary & Forecasting --}}
        <a href="#"
            class="tw-flex tw-items-center tw-justify-center tw-w-12 tw-h-12 tw-my-3 tw-rounded-xl tw-transition-colors
            {{ request()->routeIs('#') 
                ? 'tw-bg-green-500 tw-text-white'
                : 'tw-text-gray-400 hover:tw-bg-green-100 hover:tw-text-green-500' }}">
            <i class="fas fa-robot tw-text-2xl"></i>
        </a>

        {{-- Data Analytics --}}
        <a href="#"
            class="tw-flex tw-items-center tw-justify-center tw-w-12 tw-h-12 tw-my-3 tw-rounded-xl tw-transition-colors
            {{ request()->routeIs('#') 
                ? 'tw-bg-green-500 tw-text-white'
                : 'tw-text-gray-400 hover:tw-bg-green-100 hover:tw-text-green-500' }}">
            <i class="fas fa-chart-line tw-text-2xl"></i>
        </a>

        {{-- User Management --}}
        <a href="#"
            class="tw-flex tw-items-center tw-justify-center tw-w-12 tw-h-12 tw-my-3 tw-rounded-xl tw-transition-colors
            {{ request()->routeIs('#') 
                ? 'tw-bg-green-500 tw-text-white'
                : 'tw-text-gray-400 hover:tw-bg-green-100 hover:tw-text-green-500' }}">
            <i class="fas fa-users tw-text-2xl"></i>
        </a>

        {{-- Technical Documentation / About --}}
        <a href="#"
            class="tw-flex tw-items-center tw-justify-center tw-w-12 tw-h-12 tw-my-3 tw-rounded-xl tw-transition-colors
            {{ request()->routeIs('#') 
                ? 'tw-bg-green-500 tw-text-white'
                : 'tw-text-gray-400 hover:tw-bg-green-100 hover:tw-text-green-500' }}">
            <i class="fas fa-info-circle tw-text-2xl"></i>
        </a>


        {{-- more here --}}
        </div>
        @endauth

        {{-- Main content --}}
        <div class="tw-flex-1 tw-flex tw-flex-col">
            {{-- Navbar --}}
            <nav class="tw-bg-white tw-shadow-lg tw-px-6 tw-py-3">
                <div class="tw-flex tw-items-center tw-justify-between">
                    {{-- Logo --}}
                    <a href="{{ url('/homepage') }}" 
                    class="tw-flex tw-items-center tw-gap-2 tw-text-gray-500 hover:tw-text-green-500 tw-transition-colors">
                        <i class="fas fa-leaf tw-text-xl"></i>
                        <span class="tw-font-bold tw-text-lg">{{ config('app.name', 'LotMatch') }}</span>
                    </a>

                    {{-- Right Actions --}}
                    <div class="tw-flex tw-items-center tw-gap-4">
                        @guest
                            <a href="{{ route('login') }}" 
                            class="tw-flex tw-items-center tw-justify-center tw-px-3 tw-py-1 tw-rounded-lg tw-text-gray-500 hover:tw-bg-green-100 hover:tw-text-green-500 tw-transition-colors">
                                Login
                            </a>
                            <a href="{{ route('register') }}" 
                            class="tw-flex tw-items-center tw-justify-center tw-px-3 tw-py-1 tw-rounded-lg tw-bg-green-500 tw-text-white hover:tw-bg-green-600 tw-transition-colors">
                                Sign Up
                            </a>
                        @else

                        {{-- dropdown --}}
                        <div class="tw-relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                class="tw-flex tw-items-center tw-gap-2 tw-px-3 tw-py-1 tw-rounded-lg tw-text-gray-700 hover:tw-bg-green-100 hover:tw-text-green-500 tw-transition-colors">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="tw-w-4 tw-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            {{-- dropdown menu --}}
                            <div x-show="open" @click.away="open = false" 
                                class="tw-absolute tw-right-0 tw-mt-2 tw-w-40 tw-bg-white tw-rounded-lg tw-shadow-lg tw-border tw-border-gray-200 tw-z-50">
                                <a href="#" 
                                    class="tw-block tw-px-4 tw-py-2 tw-text-gray-700 hover:tw-bg-green-100">
                                    Profile
                                </a>
                                <a href="#" 
                                    class="tw-block tw-px-4 tw-py-2 tw-text-gray-700 hover:tw-bg-green-100">
                                    Settings
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="tw-w-full tw-text-left tw-px-4 tw-py-2 tw-text-gray-700 hover:tw-bg-red-100">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endguest
                    </div>
                </div>
            </nav>

            <main class="tw-p-4">
                @yield('content')
                @yield('scripts')
            </main>
        </div>
    </div>
</body>
</html>