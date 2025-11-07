<div id="lot-modal" 
    class="modal tw-fixed tw-inset-0 tw-flex tw-items-center tw-justify-center tw-bg-black/50 tw-z-50 tw-hidden tw-animate-[modal-pop_0.25s_ease-out]">

    <div class="modal-content tw-w-11/12 tw-max-w-5xl tw-p-8 tw-relative
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

        <!-- Inner Content -->
        <div class="modal-inner-content tw-flex tw-flex-col tw-gap-6">

            <!-- Top Section: Details + Images -->
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
                                <tr class="tw-border-b tw-border-[#414141]">
                                    <td class="tw-py-1 tw-pr-4 tw-font-semibold">Price</td>
                                    <td class="tw-py-1" id="lot-price"></td>
                                </tr>
                                <tr class="tw-border-b tw-border-[#414141]">
                                    <td class="tw-py-1 tw-pr-4 tw-font-semibold">Status</td>
                                    <td class="tw-py-1" id="lot-status"></td>
                                </tr>
                                <tr class="tw-border-b tw-border-[#414141]">
                                    <td class="tw-py-1 tw-pr-4 tw-font-semibold">Lot Area</td>
                                    <td class="tw-py-1" id="lot-lot-area"></td>
                                </tr>
                                <tr class="tw-border-b tw-border-[#414141]">
                                    <td class="tw-py-1 tw-pr-4 tw-font-semibold">Floor Area</td>
                                    <td class="tw-py-1" id="lot-floor-area"></td>
                                </tr>
                                <tr class="tw-border-b tw-border-[#414141]">
                                    <td class="tw-py-1 tw-pr-4 tw-font-semibold">Orientation</td>
                                    <td class="tw-py-1" id="lot-orientation"></td>
                                </tr>
                                <tr class="tw-border-b tw-border-[#414141]">
                                    <td class="tw-py-1 tw-pr-4 tw-font-semibold">Sunlight</td>
                                    <td class="tw-py-1" id="lot-sunlight"></td>
                                </tr>
                                <tr>
                                    <td class="tw-py-1 tw-pr-4 tw-font-semibold">Flood Risk</td>
                                    <td class="tw-py-1" id="lot-flood-risk"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Right Column: Lot Images -->
                <div class="right-column gradient-border tw-flex-1 tw-p-4 tw-rounded-xl tw-overflow-y-auto
                    tw-transition-transform tw-duration-300 hover:tw--translate-y-1 hover:tw-shadow-[0_4px_20px_rgba(255,255,255,0.05)] hover:tw-bg-[#84ffb1]/30">

                    <!-- Top Controls: Add Image Button -->
                    <div class="tw-flex tw-justify-between tw-items-center tw-mb-4">
                        <h3 class="tw-text-[#717171] tw-font-semibold">Lot Images</h3>
                        <button id="add-image-btn" title="Add New"
                            class="group tw-cursor-pointer tw-outline-none tw-transition-transform tw-duration-300 hover:tw-rotate-90">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 24 24"
                                class="tw-stroke-[#22C55E] tw-fill-none group-hover:tw-fill-[#22C55E] group-hover:tw-stroke-white duration-300">
                                <circle cx="12" cy="12" r="10" stroke-width="1.5"></circle>
                                <line x1="8" y1="12" x2="16" y2="12" stroke-width="1.5"></line>
                                <line x1="12" y1="8" x2="12" y2="16" stroke-width="1.5"></line>
                            </svg>
                        </button>
                    </div>

                    <!-- Image Viewer -->
                    <div id="lot-images-section" class="tw-relative tw-w-full tw-h-80 tw-bg-[#1c1c1c] tw-rounded-xl tw-flex tw-items-center tw-justify-center tw-overflow-hidden tw-mb-4 cursor-pointer">
                        <img id="lot-image" src="" alt="Lot Image" class="tw-max-h-full tw-max-w-full tw-rounded-xl tw-object-contain">
                    </div>

                    <!-- Image Navigation -->
                    <div class="tw-flex tw-justify-center tw-items-center tw-gap-4">
                        <div id="prev-image-btn" class="tw-group tw-flex tw-items-center tw-justify-center tw-w-8 tw-h-8 tw-rounded-lg tw-border tw-border-[#22C55E] tw-cursor-pointer hover:tw-bg-[#22C55E] hover:tw-scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="#22C55E"
                                class="tw-w-4 tw-h-4 tw-transition-all tw-duration-150 tw-ease-out group-hover:tw-fill-white">
                                <path fill-rule="evenodd" d="M10.854 1.646a.5.5 0 0 1 0 .708L5.207 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
                            </svg>
                        </div>

                        <div id="next-image-btn" class="tw-group tw-flex tw-items-center tw-justify-center tw-w-8 tw-h-8 tw-rounded-lg tw-border tw-border-[#22C55E] tw-cursor-pointer hover:tw-bg-[#22C55E] hover:tw-scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="#22C55E"
                                class="tw-w-4 tw-h-4 tw-transition-all tw-duration-150 tw-ease-out group-hover:tw-fill-white">
                                <path fill-rule="evenodd" d="M5.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 5.646 3.354a.5.5 0 0 1 0-.708z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Section: Lot Summary -->
            <div class="bottom-section tw-w-3/4 tw-mx-auto gradient-border tw-p-4 tw-rounded-2xl tw-flex tw-flex-col tw-justify-center tw-transition-transform tw-duration-300 hover:tw--translate-y-1 hover:tw-shadow-[0_4px_20px_rgba(132,255,177,0.2)] hover:tw-bg-[#84ffb1]/10 tw-backdrop-blur-sm tw-border tw-border-[#84ffb1]/20 tw-mt-6">
                <div id="lot-summary-container" class="tw-relative tw-flex tw-flex-col tw-gap-2 tw-items-start tw-justify-center tw-w-full">
                    <h3 class="tw-text-xl tw-font-semibold tw-mb-2">Lot Summary</h3>
                    <p class="tw-text-sm tw-text-gray-300" id="lot-summary-text">
                        *AI-generated summary is empty for now*
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
