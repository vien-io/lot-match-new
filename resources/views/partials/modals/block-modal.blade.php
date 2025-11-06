<div id="block-modal" 
    class="modal tw-fixed tw-inset-0 tw-flex tw-items-center tw-justify-center tw-bg-black/50 tw-z-50 tw-hidden tw-animate-[modal-pop_0.25s_ease-out]">

    <div class="modal-content tw-w-11/12 tw-max-w-5xl tw-p-8 tw-relative
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

        <!-- Inner Content -->
        <div class="modal-inner-content tw-flex tw-gap-6 tw-text-sm">

            <!-- Left Column: 3D Block + Attributes -->
            <div class="left-outer-column tw-flex-1 tw-space-y-6">

                <!-- Top Row: 3D Block + Attributes -->
                <div class="top-row tw-flex tw-gap-4 tw-items-end">

                    <!-- 3D Block Container -->
                    <div class="mid-column gradient-border tw-flex-1 tw-p-4
                        tw-transition-transform tw-duration-300 hover:tw--translate-y-1 hover:tw-shadow-[0_4px_20px_rgba(255,255,255,0.05)]
                        hover:tw-bg-[#84ffb1]/30">
                        <div id="block-3d-container" class="tw-relative tw-flex tw-items-center tw-justify-center tw-overflow-visible tw-z-[9999] tw-isolate"></div>
                    </div>

                    <!-- Block Attributes -->
                    <div class="left-column gradient-border tw-p-4 tw-w-[230px]
                        tw-transition-transform tw-duration-300 hover:tw--translate-y-1 hover:tw-shadow-[0_4px_20px_rgba(255,255,255,0.05)] hover:tw-bg-[#84ffb1]/30">
                        <h2 class="tw-text-l tw-font-semibold tw-text-[#ffffff] tw-border-b tw-border-white/20 tw-pb-2 tw-mb-2">Block Attributes</h2>
                        <div id="block-details"></div>
                    </div>

                </div>

                <!-- Bottom Row: Forecast / Summary -->
                <div class="bottom-row gradient-border tw-rounded-xl tw-border tw-border-[#414141] tw-bg-[#1c1c1c] tw-p-4
                    tw-transition-transform tw-duration-300 hover:tw--translate-y-1 hover:tw-shadow-[0_4px_20px_rgba(255,255,255,0.05)] hover:tw-bg-[#84ffb1]/30">

                    <div class="topTab tw-flex tw-justify-between tw-items-center">
                        <h2 class="tw-text-xl tw-font-semibold tw-text-[#ffffff]">Block Summary</h2>
                        <div class="tw-flex tw-gap-2 tw-items-center">
                            <button id="view-full-report-btn" 
                                class="tw-bg-gray-600 hover:tw-bg-[#22C55E] tw-text-white hover:tw-text-black tw-font-semibold tw-px-2 tw-py-1 tw-text-xs tw-rounded-md tw-transition-colors tw-duration-200">
                                View Full Forecast Report
                            </button>
                        </div>
                    </div>

                    <h3 class="tw-text-[#717171] tw-font-semibold">
                        Forecasting Data
                        <span id="forecast-timestamp" class="tw-ml-2 tw-text-sm tw-text-green-400"></span>
                    </h3>
                    <div id="block-summary" class="tw-max-h-48 tw-overflow-y-auto tw-mt-2 custom-scrollbar"></div>

                    <div id="forecasting-data" class="tw-mt-4">
                        <p><strong>Forecasted Rating:</strong> <span id="forecast-value"></span></p>
                        <canvas id="forecastChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Right Column: Block Reviews -->
            <div class="right-column gradient-border tw-flex-1 tw-rounded-xl tw-border tw-border-[#414141] tw-bg-[#1c1c1c] tw-p-4 tw-overflow-y-auto
                tw-transition-transform tw-duration-300 hover:tw--translate-y-1 hover:tw-shadow-[0_4px_20px_rgba(255,255,255,0.05)] hover:tw-bg-[#84ffb1]/30">
                <div id="block-review-section"></div>
                <div class="reviews"></div>
            </div>

        </div>
    </div>
</div>
