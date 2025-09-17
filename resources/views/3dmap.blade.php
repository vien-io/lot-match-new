@extends('layouts.3dmap')

@section('title', '3D Map - LotMatch')

@section('content')
<div class="tw-flex tw-h-[calc(100vh - 64px)]">
    {{-- 3D Container --}}
    <div id="threejs-container" 
        class="tw-flex-grow tw-bg-gray-100 tw-rounded-lg tw-shadow-inner tw-overflow-hidden tw-min-w-0">
    </div>

    {{-- Right Sidebar --}}
    <div id="side-panel" class="tw-w-64 tw-bg-white tw-rounded-lg tw-shadow-md tw-p-4 tw-flex-shrink-0 tw-sticky tw-top-16">
        <h4 class="tw-font-semibold tw-mb-2">Select a Block</h4>
        <ul id="block-list" class="tw-space-y-2"></ul>
    </div>
</div>

{{-- Lot Modal --}}
<div id="lot-modal" class="modal tw-fixed tw-inset-0 tw-flex tw-items-center tw-justify-center tw-bg-black/50 tw-z-50 hidden">
    <div class="modal-content tw-bg-white tw-rounded-lg tw-shadow-lg tw-w-11/12 tw-max-w-4xl tw-p-6 tw-relative">
        <span class="close-btn lot-close tw-absolute tw-top-4 tw-right-4 tw-text-2xl tw-cursor-pointer">&times;</span>
        <h2>Lot Details</h2>
        <div class="modal-inner-content tw-flex tw-gap-4">
            <div class="left-column tw-flex-1">
                <div id="lot-details"></div>
                <div class="reviews"></div>
                <div id="review-section"></div>
            </div>
            <div class="right-column tw-flex-1">
                <div id="house-3d-container">
                    <div id="model-container"></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Block Modal --}}
<div id="block-modal" class="modal tw-fixed tw-inset-0 tw-flex tw-items-center tw-justify-center tw-bg-black/50 tw-z-50 hidden">
    <div class="modal-content tw-bg-white tw-rounded-lg tw-shadow-lg tw-w-11/12 tw-max-w-5xl tw-p-6 tw-relative">
        <div class="topTab tw-flex tw-justify-between tw-items-center">
            <h2>Block Details</h2>
            <span class="close-btn block-close tw-text-2xl tw-cursor-pointer">&times;</span>
        </div>
        <div class="modal-inner-content tw-flex tw-gap-4 tw-mt-4">
            <div class="left-outer-column tw-flex-1">
                <div class="top-row tw-flex tw-gap-4">
                    <div class="mid-column tw-flex-1">
                        <div id="block-3d-container"></div>
                    </div>
                    <div class="left-column tw-flex-1">
                        <div id="block-details"></div>
                    </div>
                </div>
                <div class="bottom-row tw-mt-4">
                    <h3>Forecasting Data</h3>
                    <div id="block-summary"></div>
                    @if(auth()->check() && auth()->user()->is_admin)
                    <div id="forecasting-data" class="tw-mt-2">
                        <p><strong>Forecasted Rating:</strong> <span id="forecast-value"></span></p>
                        <canvas id="forecastChart" width="400" height="200"></canvas>
                    </div>
                    @endif
                </div>
            </div>
            <div class="right-column tw-flex-1">
                <div id="block-review-section"></div>
                <div class="reviews"></div>
            </div>
        </div>
    </div>
</div>

{{-- Tooltip --}}
<div id="tooltip" class="tw-fixed tw-z-50 tw-bg-gray-800 tw-text-white tw-text-sm tw-px-2 tw-py-1 tw-rounded hidden">
    <span id="tooltip-text"></span>
</div>
@endsection

@section('scripts')
    {{-- @vite(['resources/js/3dmap.js']) --}}
@endsection
