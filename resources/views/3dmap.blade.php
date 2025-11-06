@extends('layouts.3dmap')

@section('title', '3D Map - LotMatch')

@section('content')
<div class="tw-flex tw-h-[calc(100vh - 64px)]">
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
@include('partials.side-panel')
@include('partials.ai-status')



{{-- Tooltip --}}
@include('partials.tooltip')
@endsection

@section('scripts')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @vite([
        {{-- 'resources/js/modals/imageModal.js', --}}
        {{-- 'resources/js/modals/addImageModal.js', --}}
    ])
@endsection
