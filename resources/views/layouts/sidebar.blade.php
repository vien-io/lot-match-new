{{-- Sidebar --}}
<div class="lm-sidebar-backdrop"></div>
@auth
    <aside x-data="{ scrolled: false }" x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 10)"
        :class="scrolled ? 'lm-sidebar-scrolled' : ''"
        class="sidebar lm-sidebar tw-flex tw-flex-col tw-items-center tw-py-6 tw-z-50" aria-label="Main navigation">

        {{-- Logo --}}
        <a href="{{ route('dashboard') }}" class="lm-sidebar-logo" aria-label="LotMatch dashboard">

            <span class="lm-sidebar-logo-icon">
                <img src="{{ asset('images/logoLM.png') }}" alt="">
            </span>

            <span class="lm-sidebar-logo-text">LOT<span>MATCH</span></span>
        </a>

        {{-- Main navigation --}}
        <nav class="lm-sidebar-nav tw-flex tw-flex-col tw-items-center tw-w-full" aria-label="Primary navigation">

            {{-- Divider --}}
            <div class="lm-sidebar-section-divider"></div>

            <x-sidebar-icon href="{{ route('dashboard') }}" icon="fas fa-home" tooltip="Dashboard"
                :active="request()->routeIs('dashboard')
                ? 'lm-sidebar-link-active'
                : 'lm-sidebar-link'" />

            <x-sidebar-icon href="{{ route('3dmap') }}" icon="fas fa-map" tooltip="3D Map"
                :active="request()->routeIs('3dmap')
                ? 'lm-sidebar-link-active'
                : 'lm-sidebar-link'" />

            <x-sidebar-icon href="{{ route('reviews.index') }}" icon="fas fa-star" tooltip="Reviews & Ratings"
                :active="request()->routeIs('reviews*')
                ? 'lm-sidebar-link-active'
                : 'lm-sidebar-link'" />

            <x-sidebar-icon href="{{ route('forecast') }}" icon="fas fa-robot" tooltip="AI Summary & Forecasting"
                :active="request()->routeIs('forecast')
                ? 'lm-sidebar-link-active'
                : 'lm-sidebar-link'" />

            {{-- Admin navigation --}}
            @if(auth()->user()->role === 'admin')
                <div class="lm-sidebar-section-divider"></div>

                <x-sidebar-icon href="{{ route('properties.index') }}" icon="fas fa-vihara" tooltip="Property Management"
                    :active="request()->routeIs('properties.*')
                        ? 'lm-sidebar-link-active'
                        : 'lm-sidebar-link'" />

                <x-sidebar-icon href="{{ route('analytics.block_ratings') }}" icon="fas fa-chart-line" tooltip="Data Analytics"
                    :active="request()->routeIs('analytics.block_ratings')
                        ? 'lm-sidebar-link-active'
                        : 'lm-sidebar-link'" />

                <x-sidebar-icon href="{{ route('usermanagement.index') }}" icon="fas fa-users" tooltip="User Management"
                    :active="request()->routeIs('usermanagement.index')
                        ? 'lm-sidebar-link-active'
                        : 'lm-sidebar-link'" />

                <x-sidebar-icon href="{{ route('owner-verification.index') }}" icon="fas fa-clipboard-list"
                    tooltip="Owner Requests" :active="request()->routeIs('owner-verification.index')
                        ? 'lm-sidebar-link-active'
                        : 'lm-sidebar-link'" />

                <x-sidebar-icon href="{{ route('activity-logs.index') }}" icon="fas fa-list-alt" tooltip="Activity Logs"
                    :active="request()->routeIs('activity-logs.index')
                        ? 'lm-sidebar-link-active'
                        : 'lm-sidebar-link'" />
            @endif

            {{-- Buyer navigation --}}
            @if(auth()->user()->role === 'buyer')
                <div class="lm-sidebar-section-divider"></div>

                <x-sidebar-icon href="{{ route('owner-verification.create') }}" icon="fas fa-file-upload"
                    tooltip="Request Ownership" :active="request()->routeIs('owner-verification.create')
                        ? 'lm-sidebar-link-active'
                        : 'lm-sidebar-link'" />
            @endif

            {{-- Documentation --}}
            <div class="lm-sidebar-section-divider"></div>

            <x-sidebar-icon href="{{ route('about') }}" icon="fas fa-info-circle" tooltip="Documentation / About"
                :active="request()->routeIs('about')
                ? 'lm-sidebar-link-active'
                : 'lm-sidebar-link'" />
        </nav>

        {{-- Bottom Account Selector --}}
        <div class="lm-sidebar-account" x-data="{ accountMenuOpen: false }">

            <button type="button" {{-- @click="accountMenuOpen = !accountMenuOpen"
                @keydown.escape.window="accountMenuOpen = false" --}} @click="
                    console.log('Account button clicked!');
                    accountMenuOpen = !accountMenuOpen;
                    console.log('Dropdown state:', accountMenuOpen);
                " @keydown.escape.window="accountMenuOpen = false" class="lm-sidebar-account-trigger"
                :aria-expanded="accountMenuOpen.toString()" aria-label="Open account menu">
                {{-- User Avatar --}}
                <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->first_name . ' ' . Auth::user()->last_name) . '&background=06EBB6&color=06100D&rounded=true' }}"
                    alt="User Avatar" class="lm-sidebar-avatar">

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
                <i class="fas fa-chevron-down lm-sidebar-account-chevron" :class="{ 'is-open': accountMenuOpen }"></i>
            </button>

            {{-- Account Dropdown --}}
            <div x-cloak x-show="accountMenuOpen" x-transition:enter="tw-transition tw-ease-out tw-duration-150"
                x-transition:enter-start="tw-opacity-0 tw-translate-y-1"
                x-transition:enter-end="tw-opacity-100 tw-translate-y-0" @click.outside="open = false"
                class="lm-sidebar-account-menu">
                <div class="lm-sidebar-account-menu-header">
                    <span>{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span>
                    <small>{{ ucfirst(Auth::user()->role) }} account</small>
                </div>

                <a href="{{ route('profile') }}" class="lm-sidebar-account-menu-link">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>

                <a href="javascript:void(0);" id="settings-btn" @click="open = false" class="lm-sidebar-account-menu-link">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>

                <div class="lm-sidebar-account-menu-divider"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="lm-sidebar-account-menu-link lm-sidebar-logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>
@endauth