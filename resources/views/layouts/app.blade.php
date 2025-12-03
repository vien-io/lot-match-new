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


    @vite([
        'resources/sass/app.scss', 
        'resources/js/app.js',
        'resources/js/settings.js'
    ])



    
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

                {{-- Activity Logs --}}
                <x-sidebar-icon 
                    href="{{ route('activity-logs.index') }}" 
                    icon="fas fa-list-alt" 
                    tooltip="Activity Logs"
                    :active="request()->routeIs('activity-logs.index') ? 'tw-bg-green-500 tw-text-white' : 'tw-text-gray-400 hover:tw-bg-green-100 hover:tw-text-green-500'"
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
            <nav class="tw-bg-white tw-shadow-lg tw-px-6 tw-py-3 tw-h-16 tw-inline-block">
                <div class="tw-flex tw-justify-end tw-items-center tw-w-auto">

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





                        {{-- Notification Icon --}}
                        <div 
                            class="tw-relative tw-mr-4" 
                            x-data="{
                                openNotif: false, 
                                notifications: JSON.parse(localStorage.getItem('notifications') || '[]'), 
                                unreadCount: JSON.parse(localStorage.getItem('unreadCount') || '0'),
                                maxNotifs: 7,
                                addNotification(notif) {
                                    this.notifications.unshift(notif);
                                    if (this.notifications.length > this.maxNotifs) this.notifications.pop();
                                    this.unreadCount++;
                                    localStorage.setItem('notifications', JSON.stringify(this.notifications));
                                    localStorage.setItem('unreadCount', JSON.stringify(this.unreadCount));
                                },
                                clearUnread() {
                                    this.unreadCount = 0;
                                    localStorage.setItem('unreadCount', JSON.stringify(this.unreadCount));
                                },
                                clearAll() {
                                    this.notifications = [];
                                    this.unreadCount = 0;
                                    localStorage.removeItem('notifications');
                                    localStorage.removeItem('unreadCount');
                                }
                            }"
                            x-init="
                                window.addEventListener('new-notification', e => addNotification(e.detail));
                            "
                        >
                            <!-- Bell Button -->
                            <button 
                                @click="openNotif = !openNotif; if (openNotif) clearUnread();" 
                                class="tw-relative tw-p-2 tw-rounded-full hover:tw-bg-green-100 tw-transition"
                            >
                                <!-- Bell Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="tw-w-7 tw-h-7 tw-text-green-600 tw-drop-shadow-[0_0_6px_rgba(66,204,122,0.3)]"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 3a6 6 0 0 0-6 6v3.5l-1.5 2A1 1 0 0 0 5 16h14a1 1 0 0 0 .5-1.5l-1.5-2V9a6 6 0 0 0-6-6z"/>
                                    <path d="M10 19a2 2 0 0 0 4 0"/>
                                </svg>

                                <!-- Notification Count -->
                                <span x-show="unreadCount" x-text="unreadCount"
                                    class="tw-absolute tw-top-1 tw-right-1 tw-bg-red-500 tw-text-white tw-text-xs tw-rounded-full tw-px-1.5">
                                </span>
                            </button>

                            <!-- Notification Dropdown -->
                           <div x-show="openNotif" @click.away="openNotif = false"
                            x-transition
                            class="tw-absolute tw-left-0 tw-mt-2 tw-bg-white tw-rounded-xl tw-shadow-lg tw-border tw-border-gray-200 tw-z-50 tw-overflow-hidden tw-min-w-[280px] tw-max-w-xs">

                                <!-- Clear All Button -->
                                <div class="tw-flex tw-justify-end tw-p-2 tw-border-b tw-border-gray-100">
                                    <button @click="clearAll()" class="tw-text-xs tw-text-gray-500 hover:tw-text-gray-700 tw-transition">Clear All</button>
                                </div>

                                <!-- Notification List -->
                                <template x-if="notifications.length > 0">
                                    <ul>
                                        <template x-for="(notif, index) in notifications" :key="index">
                                            <li class="tw-flex tw-items-start tw-gap-2 tw-p-3 tw-border-b tw-border-gray-100 hover:tw-bg-green-50 tw-transition">
                                                <!-- Icon -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-5 tw-h-5 tw-text-green-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8z" />
                                                </svg>
                                                <!-- Text -->
                                                <div class="tw-flex-1">
                                                    <p class="tw-text-sm tw-text-gray-800" x-text="notif.message"></p>
                                                    <p class="tw-text-xs tw-text-gray-500" x-text="notif.time"></p>
                                                </div>
                                            </li>
                                        </template>
                                    </ul>
                                </template>

                                <!-- Empty State -->
                                <div x-show="notifications.length === 0" class="tw-p-3 tw-text-gray-500 tw-text-sm tw-text-center">
                                    No notifications yet.
                                </div>
                            </div>
                        </div>


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
                                <a href="{{ route('profile') }}" 
                                    class="tw-block tw-px-4 tw-py-2 tw-text-gray-700 hover:tw-bg-green-100">
                                    Profile
                                </a>
                                <a href="javascript:void(0);"
                                    id="settings-btn" 
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


    <!-- Settings Modal -->
    <div id="settings-modal"
        class="modal tw-fixed tw-inset-0 tw-flex tw-items-center tw-justify-center tw-bg-black/30 tw-z-50 tw-hidden tw-animate-[modal-pop_0.25s_ease-out]">

        <div class="modal-content tw-w-11/12 tw-max-w-lg tw-p-6 tw-relative tw-rounded-2xl tw-bg-white tw-text-gray-900 tw-shadow-lg">

            <div class="tw-flex tw-justify-between tw-items-center tw-mb-4">
                <h2 class="tw-text-xl tw-font-semibold">Settings</h2>
                <span id="settings-close" class="tw-text-2xl tw-cursor-pointer tw-text-green-600">&times;</span>
            </div>

            <div class="tw-flex tw-items-center tw-gap-2">
                <label class="tw-flex tw-items-center tw-gap-2 tw-cursor-pointer">
                    <input type="checkbox" id="toggle-owner-tags-global" class="tw-form-checkbox tw-text-green-600">
                    Show Owner Tags on Reviews
                </label>
            </div>

        </div>
    </div>


    <script>
        window.App = {
            userId: {{ Auth::check() ? Auth::id() : 'null' }}
        };
    </script>
</body>
</html>