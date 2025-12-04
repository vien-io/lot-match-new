@extends('layouts.3dmap')

@section('title', '3D Map - LotMatch')

@section('content')
<div class="tw-relative tw-flex tw-h-[calc(100vh - 64px)]">
    {{-- Loading Overlay --}}
    <div id="threejs-loading"
    class="tw-absolute tw-inset-0 tw-bg-black/70 tw-flex tw-items-center tw-justify-center tw-z-[9999] tw-gap-4">
        <svg class="tw-h-14 tw-w-14 tw-animate-spin" viewBox="0 0 50 50">
            <circle cx="25" cy="25" r="20" stroke="rgba(255,255,255,0.2)" stroke-width="5" fill="none"></circle>
            <circle cx="25" cy="25" r="20" stroke="url(#gradient)" stroke-width="5" stroke-linecap="round" fill="none"
                    stroke-dasharray="31.4 94.2" stroke-dashoffset="0"></circle>
            <defs>
                <linearGradient id="gradient" x1="1" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#4ade80"/>
                    <stop offset="100%" stop-color="#33ee22ff"/>
                </linearGradient>
            </defs>
        </svg>

        <div class="tw-text-white tw-text-xl tw-font-bold tw-animate-bounce">
            Loading 3D map…
        </div>
    </div>

    {{-- 3D Container --}}
    <div id="threejs-container" class="tw-flex-grow tw-bg-gray-100 tw-rounded-lg tw-shadow-inner tw-overflow-hidden tw-min-w-0"></div>

    {{-- Right Sidebar --}}
    @include('partials.side-panel')
</div>

{{-- Modals --}}
@include('partials.modals.lot-modal')
@include('partials.modals.block-modal')
@include('partials.modals.add-image-modal')
@include('partials.modals.full-report-modal')
@include('partials.modals.lot-sold-modal')
@include('partials.modals.lot-image-fullscreen')
@include('partials.modals.quick-guide-modal')
@include('partials.ai-status')

{{-- Tooltip --}}
@include('partials.tooltip')
@endsection

