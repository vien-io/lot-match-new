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
        'resources/js/settings.js',
        'resources/css/dashboard.css',
        'resources/css/sidebar.css',
        'resources/css/notification.css'
    ])
    
</head>
<body class="tw-bg-gray-50">
    <div id="app" class="tw-flex">
        <div class="lm-sidebar-backdrop"></div>
        {{-- Sidebar --}}
        @auth
        <aside
            x-data="{ scrolled: false }"
            x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 10)"
            :class="scrolled ? 'lm-sidebar-scrolled' : ''"
            class="sidebar lm-sidebar tw-flex tw-flex-col tw-items-center tw-py-6 tw-z-50"
            aria-label="Main navigation"
        >
            
            {{-- Logo --}}
            <a href="{{ route('dashboard') }}"
            class="lm-sidebar-logo"
            aria-label="LotMatch dashboard">

                <span class="lm-sidebar-logo-icon">
                    <img src="{{ asset('images/logoLM.png') }}"
                        alt="">
                </span>

                <span class="lm-sidebar-logo-text">LOT<span>MATCH</span></span>
            </a>

            {{-- Main navigation --}}
            <nav class="lm-sidebar-nav tw-flex tw-flex-col tw-items-center tw-w-full"
                aria-label="Primary navigation">

                {{-- Divider --}}
                <div class="lm-sidebar-section-divider"></div>

                <x-sidebar-icon
                    href="{{ route('dashboard') }}"
                    icon="fas fa-home"
                    tooltip="Dashboard"
                    :active="request()->routeIs('dashboard')
                        ? 'lm-sidebar-link-active'
                        : 'lm-sidebar-link'"
                />

                <x-sidebar-icon
                    href="{{ route('3dmap') }}"
                    icon="fas fa-map"
                    tooltip="3D Map"
                    :active="request()->routeIs('3dmap')
                        ? 'lm-sidebar-link-active'
                        : 'lm-sidebar-link'"
                />

                <x-sidebar-icon
                    href="{{ route('reviews.index') }}"
                    icon="fas fa-star"
                    tooltip="Reviews & Ratings"
                    :active="request()->routeIs('reviews*')
                        ? 'lm-sidebar-link-active'
                        : 'lm-sidebar-link'"
                />

                <x-sidebar-icon
                    href="{{ route('forecast') }}"
                    icon="fas fa-robot"
                    tooltip="AI Summary & Forecasting"
                    :active="request()->routeIs('forecast')
                        ? 'lm-sidebar-link-active'
                        : 'lm-sidebar-link'"
                />

                {{-- Admin navigation --}}
                @if(auth()->user()->role === 'admin')
                    <div class="lm-sidebar-section-divider"></div>

                    <x-sidebar-icon
                        href="{{ route('properties.index') }}"
                        icon="fas fa-vihara"
                        tooltip="Property Management"
                        :active="request()->routeIs('properties.*')
                            ? 'lm-sidebar-link-active'
                            : 'lm-sidebar-link'"
                    />

                    <x-sidebar-icon
                        href="{{ route('analytics.block_ratings') }}"
                        icon="fas fa-chart-line"
                        tooltip="Data Analytics"
                        :active="request()->routeIs('analytics.block_ratings')
                            ? 'lm-sidebar-link-active'
                            : 'lm-sidebar-link'"
                    />

                    <x-sidebar-icon
                        href="{{ route('usermanagement.index') }}"
                        icon="fas fa-users"
                        tooltip="User Management"
                        :active="request()->routeIs('usermanagement.index')
                            ? 'lm-sidebar-link-active'
                            : 'lm-sidebar-link'"
                    />

                    <x-sidebar-icon
                        href="{{ route('owner-verification.index') }}"
                        icon="fas fa-clipboard-list"
                        tooltip="Owner Requests"
                        :active="request()->routeIs('owner-verification.index')
                            ? 'lm-sidebar-link-active'
                            : 'lm-sidebar-link'"
                    />

                    <x-sidebar-icon
                        href="{{ route('activity-logs.index') }}"
                        icon="fas fa-list-alt"
                        tooltip="Activity Logs"
                        :active="request()->routeIs('activity-logs.index')
                            ? 'lm-sidebar-link-active'
                            : 'lm-sidebar-link'"
                    />
                @endif

                {{-- Buyer navigation --}}
                @if(auth()->user()->role === 'buyer')
                    <div class="lm-sidebar-section-divider"></div>

                    <x-sidebar-icon
                        href="{{ route('owner-verification.create') }}"
                        icon="fas fa-file-upload"
                        tooltip="Request Ownership"
                        :active="request()->routeIs('owner-verification.create')
                            ? 'lm-sidebar-link-active'
                            : 'lm-sidebar-link'"
                    />
                @endif

                {{-- Documentation --}}
                <div class="lm-sidebar-section-divider"></div>

                <x-sidebar-icon
                    href="{{ route('about') }}"
                    icon="fas fa-info-circle"
                    tooltip="Documentation / About"
                    :active="request()->routeIs('about')
                        ? 'lm-sidebar-link-active'
                        : 'lm-sidebar-link'"
                />
            </nav>

            {{-- Bottom Account Selector --}}
            <div class="lm-sidebar-account" x-data="{ open: false }">

                <button
                    type="button"
                    @click="open = !open"
                    @keydown.escape.window="open = false"
                    class="lm-sidebar-account-trigger"
                    :aria-expanded="open.toString()"
                    aria-label="Open account menu"
                >
                    {{-- User Avatar --}}
                    <img
                        src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->first_name . ' ' . Auth::user()->last_name) . '&background=06EBB6&color=06100D&rounded=true' }}"
                        alt="User Avatar"
                        class="lm-sidebar-avatar"
                    >

                    {{-- Account Details: revealed when sidebar expands --}}
                    <div class="lm-sidebar-account-details">
                        <span class="lm-sidebar-account-name">
                            {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                        </span>

                        <span class="lm-sidebar-account-role">
                            {{ ucfirst(Auth::user()->role) }}
                        </span>
                    </div>

                    {{-- Dropdown Chevron --}}
                    <i
                        class="fas fa-chevron-down lm-sidebar-account-chevron"
                        :class="{ 'is-open': open }"
                    ></i>
                </button>

                {{-- Account Dropdown --}}
                <div
                    x-cloak
                    x-show="open"
                    x-transition:enter="tw-transition tw-ease-out tw-duration-150"
                    x-transition:enter-start="tw-opacity-0 tw-translate-y-1"
                    x-transition:enter-end="tw-opacity-100 tw-translate-y-0"
                    @click.outside="open = false"
                    class="lm-sidebar-account-menu"
                >
                    <div class="lm-sidebar-account-menu-header">
                        <span>{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span>
                        <small>{{ ucfirst(Auth::user()->role) }} account</small>
                    </div>

                    <a href="{{ route('profile') }}" class="lm-sidebar-account-menu-link">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>

                    <a
                        href="javascript:void(0);"
                        id="settings-btn"
                        @click="open = false"
                        class="lm-sidebar-account-menu-link"
                    >
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>

                    <div class="lm-sidebar-account-menu-divider"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="lm-sidebar-account-menu-link lm-sidebar-logout">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>
        @endauth

        {{-- Main content --}}
        <div class="lm-app-content tw-flex-1 tw-flex tw-flex-col">
            {{-- Navbar --}}
                    {{-- Right Actions --}}
                    <div class="tw-flex tw-items-center tw-gap-4">
                        {{-- Notification Icon --}}
                        <div
                            class="lm-notification-widget"
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
                    </div>



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