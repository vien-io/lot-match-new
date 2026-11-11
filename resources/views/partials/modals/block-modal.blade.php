<div id="block-modal" class="modal tw-fixed tw-inset-0 tw-z-50 tw-hidden
    tw-flex tw-items-center tw-justify-center
    tw-bg-[#06100D]/60 tw-p-4 tw-backdrop-blur-[2px]">

    <div class="modal-content tw-relative tw-flex tw-flex-col
        tw-w-full tw-max-w-7xl tw-max-h-[92vh]
        tw-overflow-hidden tw-rounded-2xl
        tw-bg-[#F7F9F8] tw-text-[#111111]
        tw-shadow-[0_24px_80px_rgba(0,0,0,0.25)]">

        <!-- HEADER -->
        <div class="tw-flex tw-items-center tw-justify-between
            tw-px-6 tw-py-5 tw-bg-white
            tw-border-b tw-border-[#E5E9E7]">

            <div class="tw-flex tw-items-center tw-gap-3">
                <div class="tw-flex tw-items-center tw-justify-center
                    tw-w-10 tw-h-10 tw-rounded-xl
                    tw-bg-[#E6FAF4] tw-text-[#087C60] tw-mr-2">
                    <i class="fa-solid fa-house tw-w-5 tw-h-5"></i>
                </div>

                <div>
                    <h2 class="tw-text-lg tw-font-bold tw-text-[#111111]">
                        Block Details
                    </h2>
                    <p class="tw-text-xs tw-text-[#777777] tw-mt-0.5">
                        Property overview and market insights
                    </p>
                </div>
            </div>

            <button type="button" class="close-btn block-close
                tw-flex tw-items-center tw-justify-center
                tw-w-9 tw-h-9 tw-rounded-lg
                tw-text-[#666666] hover:tw-bg-[#F0F3F2]
                hover:tw-text-[#111111]
                tw-transition-colors tw-duration-200
                focus-visible:tw-outline-none
                focus-visible:tw-ring-2
                focus-visible:tw-ring-[#06EBB6]" aria-label="Close block details">

                <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-5 tw-h-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path d="m18 6-12 12M6 6l12 12" />
                </svg>
            </button>
        </div>


        <!-- MODAL BODY -->
        <div class="modal-inner-content tw-flex-1
            tw-grid tw-grid-cols-1 lg:tw-grid-cols-12
            tw-gap-5 tw-p-5 lg:tw-p-6
            tw-overflow-y-auto tw-min-h-0">

            <!-- LEFT COLUMN -->
            <div class="left-outer-column
                tw-flex tw-flex-col tw-gap-5
                lg:tw-col-span-7 tw-min-w-0">


                <!-- 3D VISUALIZATION + ATTRIBUTES -->
                <div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-12
                    tw-gap-4">

                    <!-- 3D BLOCK -->
                    <div class="mid-column tw-relative
                    sm:tw-col-span-7 tw-min-h-[240px]
                    tw-bg-white tw-rounded-xl
                    tw-border tw-border-[#E3E8E5]
                    tw-p-4">

                        <div class="tw-flex tw-items-center
                        tw-justify-between tw-mb-3 tw-relative">

                            <h3 class="tw-text-sm tw-font-semibold tw-text-[#222222]">
                                3D Visualization
                            </h3>

                            <span class="tw-text-[10px] tw-font-semibold
                             tw-uppercase tw-tracking-wider tw-text-[#888888]">
                                Interactive View
                            </span>
                        </div>

                        <!-- Grid background -->
                        <div class="tw-absolute tw-inset-x-0 tw-bottom-0 tw-h-2/3
                        tw-pointer-events-none tw-opacity-60" style="
                            background-image:
                                linear-gradient(#E5EAE8 1px, transparent 1px),
                                linear-gradient(90deg, #E5EAE8 1px, transparent 1px);
                            background-size: 24px 24px;
                            mask-image: linear-gradient(to bottom, transparent, black 35%);
                        ">
                        </div>

                        <!-- 3D Model -->
                        <div id="block-3d-container" class="tw-absolute tw-inset-0
                             tw-flex tw-items-center tw-justify-center">
                        </div>

                    </div>


                    <!-- BLOCK ATTRIBUTES -->
                    <div class="left-column sm:tw-col-span-5
                        tw-bg-white tw-rounded-xl
                        tw-border tw-border-[#E3E8E5]
                        tw-p-4">

                        <div class="tw-flex tw-items-center
                            tw-justify-between tw-mb-4
                            tw-pb-3 tw-border-b
                            tw-border-[#EDF0EE]">

                            <h3 class="tw-text-sm
                                tw-font-semibold tw-text-[#222222]">
                                Block Attributes
                            </h3>
                        </div>

                        @include('partials.modals.block-details')
                    </div>
                </div>


                
<!-- BLOCK SUMMARY -->
<div class="bottom-row tw-bg-white
    tw-rounded-xl tw-border
    tw-border-[#E3E8E5] tw-p-5">

    <!-- SECTION HEADER -->
    <div class="tw-flex tw-flex-wrap
        tw-items-center tw-justify-between
        tw-gap-3 tw-mb-5">

        <div class="tw-flex tw-items-center tw-gap-3">

            <div class="tw-flex tw-items-center
                tw-justify-center tw-w-9 tw-h-9
                tw-rounded-lg tw-bg-[#E6FAF4]
                tw-text-[#087C60]">

                <i class="fa-solid fa-circle-check"></i>
            </div>

            <div>
                <h3 class="tw-text-sm tw-font-bold tw-text-[#111111]">
                    Block Summary
                </h3>
                <p class="tw-text-xs tw-text-[#888888]">
                    AI-generated property insights
                </p>
            </div>
        </div>

        <div class="tw-flex tw-items-center tw-gap-2">

            <button id="view-full-report-btn" type="button"
                class="tw-inline-flex tw-items-center tw-justify-center
                tw-gap-2 tw-px-4 tw-py-2
                tw-rounded-lg tw-bg-[#06EBB6]
                tw-text-[#06100D] tw-text-xs
                tw-font-semibold
                hover:tw-bg-[#1ED9D7]
                tw-transition-colors tw-duration-200
                focus-visible:tw-outline-none
                focus-visible:tw-ring-2
                focus-visible:tw-ring-[#06EBB6]
                focus-visible:tw-ring-offset-2
                disabled:tw-opacity-50
                disabled:tw-cursor-not-allowed">

                View Full Report
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
            </button>
        </div>
    </div>

    <!-- FORECAST TIMESTAMP -->
    <div class="tw-flex tw-flex-wrap
        tw-items-center tw-justify-between
        tw-gap-2 tw-mb-3">

        <h4 class="tw-text-xs tw-font-semibold
            tw-uppercase tw-tracking-wider
            tw-text-[#777777]">
            Forecasting Data
        </h4>

        <span id="forecast-timestamp"
            class="tw-text-xs tw-font-medium tw-text-[#087C60]">
        </span>
    </div>

    <!-- AI SUMMARY CONTENT -->
    <div id="block-summary"
        class="tw-max-h-48 tw-overflow-y-auto
        tw-mb-5 tw-p-4
        tw-rounded-lg tw-bg-[#F7F9F8]
        tw-border tw-border-[#EDF0EE]
        tw-text-sm tw-leading-relaxed
        tw-text-[#444444] custom-scrollbar">
    </div>

    <!-- FORECAST CHART -->
    <div id="forecasting-data"
        class="tw-border-t tw-border-[#EDF0EE] tw-pt-4">

        <!-- HEADER -->
        <div class="tw-flex tw-items-center
            tw-justify-between tw-gap-3 tw-mb-3">

            <span class="tw-text-sm tw-font-semibold tw-text-[#333333]">
                Forecasted Rating
            </span>

            <span id="forecast-value"
                class="tw-inline-flex tw-items-center
                tw-justify-center tw-min-w-12
                tw-px-3 tw-py-1.5
                tw-rounded-lg tw-bg-[#E6FAF4]
                tw-text-[#087C60]
                tw-font-bold tw-text-sm">
            </span>
        </div>

        <!-- CHART CONTAINER -->
        <div class="tw-relative tw-w-full tw-h-[190px]">
            <canvas id="forecastChart"></canvas>
        </div>

    </div>
</div>

            </div>


            <!-- RIGHT COLUMN: REVIEWS -->
            <div class="right-column lg:tw-col-span-5
                tw-min-w-0 tw-flex tw-flex-col
                tw-bg-white tw-rounded-xl
                tw-border tw-border-[#E3E8E5]
                tw-overflow-hidden">

                <!-- REVIEWS HEADER -->
                <div class="tw-px-5 tw-py-4
                    tw-border-b tw-border-[#EDF0EE]">

                    <div class="tw-flex tw-items-center
                        tw-justify-between tw-gap-3">

                        <div>
                            <h3 class="tw-text-sm tw-font-bold
                                tw-text-[#111111]">
                                Block Reviews
                            </h3>

                            <p class="tw-text-xs tw-text-[#888888]
                                tw-mt-1">
                                Resident feedback and sentiment
                            </p>
                        </div>

                        <div class="tw-flex tw-items-center
                            tw-justify-center tw-w-9 tw-h-9
                            tw-rounded-lg tw-bg-[#E6FAF4]
                            tw-text-[#087C60]">

                            <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-5 tw-h-5" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M21 11.5a8.4 8.4 0 0 1-.9 3.8
                                    8.5 8.5 0 0 1-7.6 4.7
                                    8.4 8.4 0 0 1-3.8-.9L3 21l1.9-5.7
                                    a8.4 8.4 0 0 1-.9-3.8
                                    8.5 8.5 0 0 1 4.7-7.6
                                    8.4 8.4 0 0 1 3.8-.9h.5
                                    a8.5 8.5 0 0 1 8 8v.5z" />
                            </svg>
                        </div>
                    </div>
                </div>


                <!-- REVIEWS CONTENT -->
                <div class="tw-flex-1 tw-min-h-0
                    tw-overflow-y-auto tw-p-5
                    custom-scrollbar">

                    <div id="block-review-section"></div>

                    <div class="reviews"></div>

                </div>
            </div>

        </div>
    </div>
</div>