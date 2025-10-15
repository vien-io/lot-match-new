@extends('layouts.3dmap')

@section('title', '3D Map - LotMatch')

@section('content')
<div class="tw-flex tw-h-[calc(100vh - 64px)]">
    {{-- 3D Container --}}
    <div id="threejs-container" 
        class="tw-flex-grow tw-bg-gray-100 tw-rounded-lg tw-shadow-inner tw-overflow-hidden tw-min-w-0">
    </div>

    {{-- Right Sidebar --}}
    <div id="side-panel" class="tw-w-64 tw-bg-white tw-rounded-lg tw-shadow-md tw-p-4 tw-flex-shrink-0 tw-sticky tw-top-16 tw-hidden">
        <h4 class="tw-font-semibold tw-mb-2">Select a Block</h4>
        <ul id="block-list" class="tw-space-y-2"></ul>
    </div>
</div>

{{-- Lot Modal --}}
<div id="lot-modal" class="modal tw-fixed tw-inset-0 tw-flex tw-items-center tw-justify-center tw-bg-black/50 tw-z-50 tw-hidden">
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
<div id="block-modal" 
    class="modal tw-fixed tw-inset-0 tw-flex tw-items-center tw-justify-center tw-bg-black/50 tw-z-50 tw-hidden tw-animate-[modal-pop_0.25s_ease-out]">

    <div 
        class="modal-content tw-w-11/12 tw-max-w-5xl tw-p-8 tw-relative
               tw-rounded-2xl tw-text-white tw-font-sans
               tw-flex tw-flex-col tw-gap-6
               tw-border-2 tw-border-transparent
               tw-bg-[linear-gradient(#212121,#212121)_padding-box,linear-gradient(145deg,transparent_35%,#e81cff,#40c9ff)_border-box]
               tw-shadow-[0_0_20px_rgba(0,0,0,0.6)]">

        <!-- Header -->
        <div class="topTab tw-flex tw-justify-between tw-items-center">
            <h2 class="tw-text-xl tw-font-semibold tw-text-[#ffffff]">Block Details</h2>
            <span class="close-btn block-close tw-text-2xl tw-cursor-pointer tw-text-[#22C55E] hover:tw-scale-110 tw-transition-transform">&times;</span>
        </div>

        <!-- Content -->
        <div class="modal-inner-content tw-flex tw-gap-6 tw-text-sm">
            
            <!-- Left Column -->
            <div class="left-outer-column tw-flex-1 tw-space-y-6">
                
                <!-- Top Row -->
                <div class="top-row tw-flex tw-gap-4">
                    <div class="mid-column gradient-border tw-flex-1 tw-p-4">
                        <div id="block-3d-container"></div>
                    </div>
                    <div class="left-column gradient-border tw-flex-1 tw-p-4">
                        <div id="block-details"></div>
                    </div>
                </div>

                <!-- Bottom Row -->
                <div class="bottom-row gradient-border tw-rounded-xl tw-border tw-border-[#414141] tw-bg-[#1c1c1c] tw-p-4">
                    <h3 class="tw-text-[#717171] tw-font-semibold">Forecasting Data</h3>
                    <div id="block-summary" class="tw-max-h-48 tw-overflow-y-auto tw-mt-2"></div>

                    <div id="forecasting-data" class="tw-mt-4">
                        <p><strong>Forecasted Rating:</strong> <span id="forecast-value"></span></p>
                        <canvas id="forecastChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="right-column gradient-border tw-flex-1 tw-rounded-xl tw-border tw-border-[#414141] tw-bg-[#1c1c1c] tw-p-4 tw-overflow-y-auto">
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
