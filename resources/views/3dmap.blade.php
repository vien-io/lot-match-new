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
<div id="lot-modal" 
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
            <h2 class="tw-text-xl tw-font-semibold tw-text-[#ffffff]">Lot Details</h2>
            <span class="close-btn lot-close 
                tw-text-2xl tw-cursor-pointer tw-text-[#22C55E]
                [text-shadow:0_0_8px_#22C55E]
                hover:[text-shadow:0_0_18px_#22C55E]
                hover:tw-text-[#84ffb1]
                hover:tw-scale-150
                tw-inline-block tw-transition-transform tw-duration-300 tw-ease-out">
                &times;
            </span>
        </div>

        <!-- Content -->
        <div class="modal-inner-content tw-flex tw-flex-col tw-gap-6">

            <!-- Top Section: Details + Attributes -->
            <div class="top-section tw-flex tw-gap-6">
                
                <!-- Left Column: Lot Details -->
                <div class="left-column gradient-border tw-flex-1 tw-p-4 tw-rounded-xl
                    tw-transition-transform tw-duration-300 hover:tw--translate-y-1 hover:tw-shadow-[0_4px_20px_rgba(255,255,255,0.05)] hover:tw-bg-[#84ffb1]/30">
                    
                    <div id="lot-details"></div>

                    <!-- Lot Attributes Table -->
                    <div class="tw-mt-4">
                        <h3 class="tw-text-[#717171] tw-font-semibold tw-mb-2">Lot Attributes</h3>
                        <table class="tw-w-full tw-text-sm tw-border-collapse">
                            <tbody>
                                <tr class="tw-border-b tw-border-[#414141]"><td class="tw-py-1 tw-pr-4 tw-font-semibol">Lot size</td><td class="tw-py-1" id="lot-size"></td></tr>
                                <tr class="tw-border-b tw-border-[#414141]"><td class="tw-py-1 tw-pr-4 tw-font-semibold">Floor area</td><td class="tw-py-1" id="lot-floor-area"></td></tr>
                                <tr class="tw-border-b tw-border-[#414141]"><td class="tw-py-1 tw-pr-4 tw-font-semibold">Orientation</td><td class="tw-py-1" id="lot-orientation"></td></tr>
                                <tr class="tw-border-b tw-border-[#414141]"><td class="tw-py-1 tw-pr-4 tw-font-semibold">Elevation</td><td class="tw-py-1" id="lot-elevation"></td></tr>
                                <tr class="tw-border-b tw-border-[#414141]"><td class="tw-py-1 tw-pr-4 tw-font-semibold">Sunlight</td><td class="tw-py-1" id="lot-sunlight"></td></tr>
                                <tr class="tw-border-b tw-border-[#414141]"><td class="tw-py-1 tw-pr-4 tw-font-semibold">View</td><td class="tw-py-1" id="lot-view"></td></tr>
                                <tr class="tw-border-b tw-border-[#414141]"><td class="tw-py-1 tw-pr-4 tw-font-semibold">Proximity</td><td class="tw-py-1" id="lot-proximity"></td></tr>
                                <tr><td class="tw-py-1 tw-pr-4 tw-font-semibold">Flood risk</td><td class="tw-py-1" id="lot-flood-risk"></td></tr>
                            </tbody>
                        </table>
                    </div>

                </div>

        <!-- Right Column: Image -->
        <div class="right-column gradient-border tw-flex-1 tw-p-4 tw-rounded-xl tw-overflow-y-auto
            tw-transition-transform tw-duration-300 hover:tw--translate-y-1 hover:tw-shadow-[0_4px_20px_rgba(255,255,255,0.05)] hover:tw-bg-[#84ffb1]/30">

            <!-- Top Controls: Add Image Button -->
            <div class="tw-flex tw-justify-between tw-items-center tw-mb-4">
                <h3 class="tw-text-[#717171] tw-font-semibold">Lot Images</h3>
                <button
                id="add-image-btn"
                title="Add New"
                class="group tw-cursor-pointer tw-outline-none tw-transition-transform tw-duration-300 hover:tw-rotate-90"
                >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="40px"
                    height="40px"
                    viewBox="0 0 24 24"
                    class="tw-stroke-[#22C55E] tw-fill-none group-hover:tw-fill-[#22C55E] group-hover:tw-stroke-white duration-300"
                >
                    <circle cx="12" cy="12" r="10" stroke-width="1.5"></circle>
                    <line x1="8" y1="12" x2="16" y2="12" stroke-width="1.5"></line>
                    <line x1="12" y1="8" x2="12" y2="16" stroke-width="1.5"></line>
                </svg>
                </button>

            </div>

            <!-- Image Viewer -->
            <div id="lot-images-section" class="tw-relative tw-w-full tw-h-80 tw-bg-[#1c1c1c] tw-rounded-xl tw-flex tw-items-center tw-justify-center tw-overflow-hidden tw-mb-4 cursor-pointer">
                <img id="lot-image" src="" alt="Lot Image" 
                    class="tw-max-h-full tw-max-w-full tw-rounded-xl tw-object-contain">
            </div>

      


            <!-- Image Navigation -->
            <div class="tw-flex tw-justify-center tw-items-center tw-gap-4">

                <!-- Previous Button -->
                <div
                    id="prev-image-btn"
                    class="tw-group tw-flex tw-items-center tw-justify-center tw-w-8 tw-h-8 tw-rounded-lg tw-border tw-border-black tw-cursor-pointer
                        tw-transition-all tw-duration-300 tw-ease-in-out
                        hover:tw-bg-[#22C55E]/40 hover:tw-scale-110 hover:tw-shadow-[0_4px_12px_rgba(34,197,94,0.5)]
                        active:tw-scale-90 active:tw-shadow-[0_2px_6px_rgba(34,197,94,0.4)]"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="#22C55E"
                        class="tw-w-4 tw-h-4 tw-transition-all tw-duration-300 tw-ease-in-out group-hover:tw-fill-white group-hover:tw-scale-110">
                        <path fill-rule="evenodd"
                            d="M10.854 1.646a.5.5 0 0 1 0 .708L5.207 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
                    </svg>
                </div>

                <!-- Next Button -->
                <div
                    id="next-image-btn"
                    class="tw-group tw-flex tw-items-center tw-justify-center tw-w-8 tw-h-8 tw-rounded-lg tw-border tw-border-black tw-cursor-pointer
                        tw-transition-all tw-duration-300 tw-ease-in-out
                        hover:tw-bg-[#22C55E]/40 hover:tw-scale-110 hover:tw-shadow-[0_4px_12px_rgba(34,197,94,0.5)]
                        active:tw-scale-90 active:tw-shadow-[0_2px_6px_rgba(34,197,94,0.4)]"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="#22C55E"
                        class="tw-w-4 tw-h-4 tw-transition-all tw-duration-300 tw-ease-in-out group-hover:tw-fill-white group-hover:tw-scale-110">
                        <path fill-rule="evenodd"
                            d="M5.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 5.646 3.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <!-- Fullscreen Modal -->
    <div id="lot-image-modal" class="tw-fixed tw-inset-0 tw-bg-black/80 tw-flex tw-items-center tw-justify-center tw-z-50 tw-hidden">
        <img id="lot-image-full" src="" alt="Full Lot Image" class="tw-max-h-[90vh] tw-max-w-[90vw] tw-rounded-xl tw-object-contain">
    </div>

    <!-- Add Lot Image Modal -->
    <div id="addImageModal" 
        class="modal tw-fixed tw-inset-0 tw-flex tw-items-center tw-justify-center tw-bg-black/50 tw-z-50 tw-hidden tw-animate-[modal-pop_0.25s_ease-out]">
        <div 
            class="modal-content tw-w-11/12 sm:tw-w-[400px] tw-p-6 tw-relative
                tw-rounded-2xl tw-text-white tw-font-sans
                tw-flex tw-flex-col tw-gap-6
                tw-border-2 tw-border-solid
                tw-bg-[#212121]
                tw-shadow-[0_0_20px_rgba(0,0,0,0.6)]">

            <!-- Header -->
            <div class="tw-flex tw-justify-between tw-items-center">
                <h2 class="tw-text-xl tw-font-semibold tw-text-[#ffffff]">Add Lot Image</h2>
                <span 
                    class="close-btn tw-text-2xl tw-cursor-pointer tw-text-[#22C55E]
                    [text-shadow:0_0_8px_#22C55E]
                    hover:[text-shadow:0_0_18px_#22C55E]
                    hover:tw-text-[#84ffb1]
                    hover:tw-scale-150
                    tw-inline-block tw-transition-transform tw-duration-300 tw-ease-out"
                    onclick="closeAddImageModal()">&times;</span>
            </div>

            <!-- Form -->
            <form id="addImageForm" method="POST" enctype="multipart/form-data" class="tw-space-y-4">
                @csrf
                <input type="hidden" name="lot_id" id="lot_id_input">

                <div class="tw-flex tw-flex-col tw-gap-2">
                    <label class="tw-text-sm tw-text-gray-300">Select Image</label>
                    <input type="file" name="image" accept="image/*" id="lotImageInput" 
                        class="tw-w-full tw-bg-[#1c1c1c] tw-border tw-border-[#414141] tw-rounded-lg tw-px-3 tw-py-2 tw-text-white focus:tw-border-[#84ffb1] focus:tw-outline-none">
                    <p id="selectedImageName" class="tw-text-sm tw-text-gray-400 tw-mt-1"></p>
                </div>

                <!-- Buttons -->
                <div class="tw-flex tw-justify-end tw-gap-2">
                    <button type="button" 
                            class="tw-bg-[#333] tw-text-gray-300 tw-px-4 tw-py-2 tw-rounded-lg tw-transition tw-duration-200 hover:tw-bg-[#444]"
                            onclick="closeAddImageModal()">Cancel</button>

                    <button type="submit" 
                            class="tw-bg-emerald-600 tw-text-white tw-px-4 tw-py-2 tw-rounded-lg tw-transition tw-duration-200 hover:tw-bg-emerald-700">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>

    </div>


            <!-- Bottom Section: Lot Summary -->
            <div class="bottom-section tw-w-3/4 tw-mx-auto gradient-border tw-p-4 tw-rounded-xl tw-flex tw-flex-col tw-justify-center
                tw-transition-transform tw-duration-300 hover:tw--translate-y-1 hover:tw-shadow-[0_4px_20px_rgba(255,255,255,0.05)] hover:tw-bg-[#84ffb1]/30">
                
                <div id="lot-summary-container" class="tw-relative tw-flex tw-flex-col tw-gap-2 tw-items-start tw-justify-center tw-w-full">
                    <h3 class="tw-text-xl tw-font-semibold tw-mb-2">Lot Summary</h3>
                    <p class="tw-text-sm tw-text-gray-300">
                        This lot is ideally suited for residential use. It has a total area of 250 sqm with a floor area of 120 sqm, east-facing orientation, and a slightly elevated elevation. It receives morning sunlight and offers views near a park. Proximity to main road and school is convenient. Flood risk is low. 
                    </p>
                    <p class="tw-text-sm tw-text-gray-400 tw-italic">*AI-generated summary placeholder*</p>
                </div>

            </div>


        </div>
    </div>
</div>


<!-- ai modal status popup -->
<div id="ai-status"
  class="tw-absolute tw-top-[100px] tw-right-4 
        tw-hidden tw-opacity-0 tw-translate-x-8   
        tw-max-w-[350px] tw-break-words
        tw-z-[99999]
        tw-transition-all tw-duration-500 tw-ease-out
        tw-text-white tw-text-sm tw-font-sans 
        tw-px-5 tw-py-3 tw-rounded-2xl
        tw-bg-[linear-gradient(#212121,#212121)_padding-box,linear-gradient(145deg,transparent_35%,#e81cff,#40c9ff)_border-box]
        tw-border-2 tw-border-transparent
        tw-shadow-[0_0_20px_rgba(0,0,0,0.6)] 
        tw-flex tw-items-start tw-gap-2 tw-select-none tw-leading-snug">
  <span id="ai-status-emoji">🤖</span>
  <span id="ai-status-text" class="tw-break-words tw-block">AI is thinking...</span>
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
            <span class="close-btn block-close 
                tw-text-2xl tw-cursor-pointer tw-text-[#22C55E]
                [text-shadow:0_0_8px_#22C55E]
                hover:[text-shadow:0_0_18px_#22C55E]
                hover:tw-text-[#84ffb1]
                hover:tw-scale-150
                tw-inline-block tw-transition-transform tw-duration-300 tw-ease-out">
                &times;
            </span>

        </div>

        <!-- Content -->
        <div class="modal-inner-content tw-flex tw-gap-6 tw-text-sm">
            
            <!-- Left Column -->
            <div class="left-outer-column tw-flex-1 tw-space-y-6">
                
                <!-- Top Row -->
                <div class="top-row tw-flex tw-gap-4">


                    <div class="mid-column gradient-border tw-flex-1 tw-p-4
                        tw-transition-transform tw-duration-300 hover:tw--translate-y-1 hover:tw-shadow-[0_4px_20px_rgba(255,255,255,0.05)]
                        hover:tw-bg-[#84ffb1]/30">
                        <div id="block-3d-container" class="tw-relative tw-flex tw-items-center tw-items-center tw-justify-center tw-overflow-visible tw-z-[9999] tw-isolate"></div>
                    </div>


                    
                    <div class="left-column gradient-border tw-flex-1 tw-p-4
                    tw-transition-transform tw-duration-300 hover:tw--translate-y-1 hover:tw-shadow-[0_4px_20px_rgba(255,255,255,0.05)] hover:tw-bg-[#84ffb1]/30">
                        <div id="block-details"></div>
                    </div>
                </div>

                <!-- Bottom Row -->
                <div class="bottom-row gradient-border tw-rounded-xl tw-border tw-border-[#414141] tw-bg-[#1c1c1c] tw-p-4
                tw-transition-transform tw-duration-300 hover:tw--translate-y-1 hover:tw-shadow-[0_4px_20px_rgba(255,255,255,0.05)] hover:tw-bg-[#84ffb1]/30">
                    <h3 class="tw-text-[#717171] tw-font-semibold">Forecasting Data</h3>
                    <div id="block-summary" class="tw-max-h-48 tw-overflow-y-auto tw-mt-2"></div>

                    <div id="forecasting-data" class="tw-mt-4">
                        <p><strong>Forecasted Rating:</strong> <span id="forecast-value"></span></p>
                        <canvas id="forecastChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="right-column gradient-border tw-flex-1 tw-rounded-xl tw-border tw-border-[#414141] tw-bg-[#1c1c1c] tw-p-4 tw-overflow-y-auto
            tw-transition-transform tw-duration-300 hover:tw--translate-y-1 hover:tw-shadow-[0_4px_20px_rgba(255,255,255,0.05)] hover:tw-bg-[#84ffb1]/30">
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
    @vite([
        'resources/js/modals/imageModal.js',
        'resources/js/modals/addImageModal.js',
        ])
@endsection
