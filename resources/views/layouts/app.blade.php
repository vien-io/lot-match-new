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
    {{-- <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    /> --}}

    {{-- logo --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
</head>
<body class="tw-bg-gray-50">
    <div id="app" class="tw-flex">
    
        {{-- Sidebar --}}
        @auth
        <div 
            x-data="{ scrolled: false }"
            x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 10)"
            :class="scrolled ? 'tw-shadow-md' : 'tw-shadow-none'"
            class="sidebar tw-bg-white tw-shadow-lg tw-w-20 tw-flex tw-flex-col tw-items-center tw-py-6 tw-sticky tw-top-0 tw-h-screen tw-transition-shadow tw-duration-300 tw-z-50"
        >

            {{-- Logo --}}
            <div class="tw-mb-3 tw-mt-0">
                <img src="/images/logoLM.png" alt="LotM" class="tw-w-12 tw-h-12">
            </div>

            {{-- Divider --}}
            <div 
                :class="scrolled 
                    ? 'tw-w-14 tw-opacity-100' 
                    : 'tw-w-0 tw-opacity-0'"
                class="tw-border-t tw-border-gray-300 tw-mx-auto tw-mb-4 tw-transition-all tw-duration-700 tw-ease-in-out">
            </div>

            {{-- Dashboard --}}
            <x-sidebar-icon 
                href="{{ route('dashboard') }}"
                icon="fas fa-home"
                tooltip="Dashboard"
                :active="request()->routeIs('dashboard') ? 'tw-bg-green-500 tw-text-white' : 'tw-text-gray-400 hover:tw-bg-green-100 hover:tw-text-green-500'"
            />

            {{-- 3D Map --}}
            <x-sidebar-icon 
                href="{{ route('3dmap') }}"
                icon="fas fa-map"
                tooltip="3D Map"
                :active="request()->routeIs('3dmap') ? 'tw-bg-green-500 tw-text-white' : 'tw-text-gray-400 hover:tw-bg-green-100 hover:tw-text-green-500'"
            />

            {{-- Reviews & Ratings --}}
            <x-sidebar-icon 
                href="{{ route('reviews.index') }}"
                icon="fas fa-star"
                tooltip="Reviews & Ratings"
                :active="request()->routeIs('reviews*') ? 'tw-bg-green-500 tw-text-white' : 'tw-text-gray-400 hover:tw-bg-green-100 hover:tw-text-green-500'"
            />

            {{-- AI Summary & Forecasting --}}
            <x-sidebar-icon 
                href="{{ route('forecast') }}"
                icon="fas fa-robot"
                tooltip="AI Summary & Forecasting"
                :active="request()->routeIs('forecast') ? 'tw-bg-green-500 tw-text-white' : 'tw-text-gray-400 hover:tw-bg-green-100 hover:tw-text-green-500'"
            />

            {{-- Role-specific --}}
            @if(auth()->user()->role === 'admin')
                {{-- Property Management --}}
                <x-sidebar-icon 
                    href="{{ route('properties.index') }}" 
                    icon="fas fa-vihara" 
                    tooltip="Property Management"
                    :active="request()->routeIs('properties.*') ? 'tw-bg-green-500 tw-text-white' : 'tw-text-gray-400 hover:tw-bg-green-100 hover:tw-text-green-500'"
                />

                {{-- Data Analytics --}}
                <x-sidebar-icon 
                    href="{{ route('analytics.block_ratings') }}" 
                    icon="fas fa-chart-line" 
                    tooltip="Data Analytics"
                    :active="request()->routeIs('analytics.block_ratings') ? 'tw-bg-green-500 tw-text-white' : 'tw-text-gray-400 hover:tw-bg-green-100 hover:tw-text-green-500'"
                />

                {{-- User Management --}}
                <x-sidebar-icon 
                    href="{{ route('usermanagement.index') }}"
                    icon="fas fa-users" 
                    tooltip="User Management"
                    :active="request()->routeIs('usermanagement.index') ? 'tw-bg-green-500 tw-text-white' : 'tw-text-gray-400 hover:tw-bg-green-100 hover:tw-text-green-500'"
                />

                {{-- Owner Verification Requests --}}
                <x-sidebar-icon
                    href="{{ route('owner-verification.index') }}"
                    icon="fas fa-clipboard-list"
                    tooltip="Owner Requests"
                    :active="request()->routeIs('owner-verification.index') ? 'tw-bg-green-500 tw-text-white' : 'tw-text-gray-400 hover:tw-bg-green-100 hover:tw-text-green-500'"
                />
            @endif

            @if(auth()->user()->role === 'buyer')
                {{-- Request Ownership --}}
                <x-sidebar-icon
                    href="{{ route('owner-verification.create') }}"
                    icon="fas fa-file-upload"
                    tooltip="Request Ownership"
                    :active="request()->routeIs('owner-verification.create') ? 'tw-bg-green-500 tw-text-white' : 'tw-text-gray-400 hover:tw-bg-green-100 hover:tw-text-green-500'"
                />
            @endif

            @if(auth()->user()->role === 'owner')
                {{-- Owners do not manage properties globally, only their assigned ones --}}
                {{-- We can add owner-specific property management here --}}
            @endif

            {{-- Documentation / About --}}
            <x-sidebar-icon 
                href="{{ route('about') }}"
                icon="fas fa-info-circle"
                tooltip="Documentation / About"
                :active="request()->routeIs('about') ? 'tw-bg-green-500 tw-text-white' : 'tw-text-gray-400 hover:tw-bg-green-100 hover:tw-text-green-500'"
            />

        </div>
        @endauth


        {{-- Main content --}}
        <div class="tw-flex-1 tw-flex tw-flex-col">
            {{-- Navbar --}}
            <nav class="tw-bg-white tw-shadow-lg tw-px-6 tw-py-3">
                <div class="tw-flex tw-items-center tw-justify-between">
                    {{-- Logo --}}
                    <a href="{{ route('dashboard') }}" 
                    class="tw-flex tw-items-center tw-gap-2 tw-text-gray-500 hover:tw-text-green-500 tw-transition-colors">
                        {{-- <i class="fas fa-leaf tw-text-xl"></i> --}}
                        <span class="tw-font-bold tw-text-lg">{{ config('app.name', 'LotMatch') }}</span>
                    </a>

                    {{-- search bar --}}
                    {{-- <div class="tw-relative tw-flex-grow tw-mx-4" x-data="searchPlaceholderCycle()">
                        <span class="tw-absolute tw-left-3 tw-top-1/2 tw-transform tw--translate-y-1/2 tw-text-gray-400">
                            <i class="fas fa-magnifying-glass"></i>
                        </span>
                        <form action="{{ route('search') }}" method="GET">
                            <input 
                                type="search" 
                                name="q"
                                :placeholder="placeholders[current]"
                                class="tw-w-full tw-pl-10 tw-pr-4 tw-py-2 tw-border tw-border-gray-300 tw-rounded-lg focus:tw-ring-2 focus:tw-ring-green-400 focus:tw-outline-none"
                            />
                        </form>
                    </div> --}}

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

                                {{-- user avatar --}}
                                <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=34d399&color=fff&rounded=true' }}" 
                                    alt="User Avatar"
                                    class="tw-w-8 tw-h-8 tw-rounded-full tw-object-cover">

                                {{-- username --}}
                                <span>{{ Auth::user()->name }}</span>

                                {{-- role tag --}}
                                @if(Auth::user()->role === 'admin')
                                    <span class="tw-bg-blue-500 tw-text-white tw-text-xs tw-px-2 tw-py-0.5 tw-rounded-full">
                                        Admin
                                    </span>
                                @elseif(Auth::user()->role === 'owner')
                                    <span class="tw-bg-green-500 tw-text-white tw-text-xs tw-px-2 tw-py-0.5 tw-rounded-full">
                                        Owner
                                    </span>
                                @endif

                                <svg
                                    :class="{'tw-rotate-180': !open}" 
                                    class="tw-w-4 tw-h-4 tw-transition-transform tw-duration-300" 
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
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