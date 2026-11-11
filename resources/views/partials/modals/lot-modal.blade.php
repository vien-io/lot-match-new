<div id="lot-modal"
    class="modal tw-fixed tw-inset-0 tw-z-50 tw-hidden
    tw-flex tw-items-center tw-justify-center
    tw-bg-[#06100D]/60 tw-backdrop-blur-[2px]
    tw-p-4 tw-overflow-y-auto">

    <div class="modal-content tw-relative tw-w-full tw-max-w-5xl
        tw-max-h-[calc(100vh-2rem)] tw-overflow-y-auto
        tw-rounded-2xl tw-bg-white tw-text-[#111111]
        tw-font-sans tw-shadow-[0_20px_60px_rgba(0,0,0,0.20)]
        tw-border tw-border-[#C4C4C4]/60">

        <!-- Header -->
        <div class="topTab tw-flex tw-items-center tw-justify-between
            tw-px-6 sm:tw-px-8 tw-py-5
            tw-border-b tw-border-[#C4C4C4]/60
            tw-bg-white tw-sticky tw-top-0 tw-z-20">

            <div class="tw-flex tw-flex-col tw-gap-1">
                <h2 class="tw-text-lg tw-font-semibold tw-text-[#111111]">
                    Lot Details
                </h2>
                <p class="tw-text-xs tw-text-[#666666]">
                    Property information and specifications
                </p>
            </div>

            <button type="button"
                aria-label="Close lot details"
                class="close-btn lot-close
                tw-flex tw-items-center tw-justify-center
                tw-w-9 tw-h-9 tw-rounded-lg
                tw-text-[#666666] tw-text-2xl
                hover:tw-bg-[#D9D9D9]/60 hover:tw-text-[#111111]
                tw-transition-colors tw-duration-200">
                &times;
            </button>
        </div>

        <!-- Modal Content -->
        <div class="modal-inner-content tw-p-6 sm:tw-p-8
            tw-flex tw-flex-col tw-gap-6">

            <!-- Top Section: Details + Images -->
            <div class="top-section tw-grid
                tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-6">

                <!-- Left Column: Lot Details -->
                <div class="left-column tw-min-w-0
                    tw-p-5 tw-rounded-xl
                    tw-bg-white tw-border tw-border-[#C4C4C4]/70">

                    <!-- Dynamic Lot Information -->
                    <div id="lot-details" class="tw-space-y-3">
                    </div>

                    <!-- Lot Attributes -->
                    <div class="tw-mt-6">

                        <div class="tw-flex tw-items-center
                            tw-justify-between tw-mb-3">

                            <h3 class="tw-text-sm tw-font-semibold
                                tw-text-[#111111]">
                                Lot Attributes
                            </h3>

                            <span class="tw-text-xs tw-text-[#666666]">
                                Specifications
                            </span>
                        </div>

                        <div class="tw-overflow-hidden
                            tw-rounded-lg tw-border
                            tw-border-[#C4C4C4]/70">

                            <table class="tw-w-full tw-text-sm
                                tw-border-collapse">

                                <tbody class="tw-divide-y
                                    tw-divide-[#D9D9D9]">

                                    <tr class="hover:tw-bg-[#D9D9D9]/20
                                        tw-transition-colors">
                                        <td class="tw-w-2/5 tw-px-4 tw-py-3
                                            tw-font-medium tw-text-[#666666]">
                                            Price
                                        </td>
                                        <td id="lot-price"
                                            class="tw-px-4 tw-py-3
                                            tw-font-semibold tw-text-[#111111]">
                                        </td>
                                    </tr>

                                    <tr class="hover:tw-bg-[#D9D9D9]/20
                                        tw-transition-colors">
                                        <td class="tw-px-4 tw-py-3
                                            tw-font-medium tw-text-[#666666]">
                                            Status
                                        </td>
                                        <td id="lot-status"
                                            class="tw-px-4 tw-py-3
                                            tw-font-medium tw-text-[#111111]">
                                        </td>
                                    </tr>

                                    <tr class="hover:tw-bg-[#D9D9D9]/20
                                        tw-transition-colors">
                                        <td class="tw-px-4 tw-py-3
                                            tw-font-medium tw-text-[#666666]">
                                            Lot Area
                                        </td>
                                        <td id="lot-lot-area"
                                            class="tw-px-4 tw-py-3 tw-text-[#111111]">
                                        </td>
                                    </tr>

                                    <tr class="hover:tw-bg-[#D9D9D9]/20
                                        tw-transition-colors">
                                        <td class="tw-px-4 tw-py-3
                                            tw-font-medium tw-text-[#666666]">
                                            Floor Area
                                        </td>
                                        <td id="lot-floor-area"
                                            class="tw-px-4 tw-py-3 tw-text-[#111111]">
                                        </td>
                                    </tr>

                                    <tr class="hover:tw-bg-[#D9D9D9]/20
                                        tw-transition-colors">
                                        <td class="tw-px-4 tw-py-3
                                            tw-font-medium tw-text-[#666666]">
                                            Orientation
                                        </td>
                                        <td id="lot-orientation"
                                            class="tw-px-4 tw-py-3 tw-text-[#111111]">
                                        </td>
                                    </tr>

                                    <tr class="hover:tw-bg-[#D9D9D9]/20
                                        tw-transition-colors">
                                        <td class="tw-px-4 tw-py-3
                                            tw-font-medium tw-text-[#666666]">
                                            Sunlight
                                        </td>
                                        <td id="lot-sunlight"
                                            class="tw-px-4 tw-py-3 tw-text-[#111111]">
                                        </td>
                                    </tr>

                                    <tr class="hover:tw-bg-[#D9D9D9]/20
                                        tw-transition-colors">
                                        <td class="tw-px-4 tw-py-3
                                            tw-font-medium tw-text-[#666666]">
                                            Flood Risk
                                        </td>
                                        <td id="lot-flood-risk"
                                            class="tw-px-4 tw-py-3 tw-text-[#111111]">
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Lot Images -->
                <div class="right-column tw-min-w-0
                    tw-flex tw-flex-col tw-p-5
                    tw-rounded-xl tw-bg-white
                    tw-border tw-border-[#C4C4C4]/70">

                    <!-- Image Header -->
                    <div class="tw-flex tw-items-center
                        tw-justify-between tw-mb-4">

                        <div>
                            <h3 class="tw-text-sm tw-font-semibold
                                tw-text-[#111111]">
                                Lot Images
                            </h3>
                            <p class="tw-text-xs tw-text-[#666666] tw-mt-1">
                                Property photos and visual references
                            </p>
                        </div>

                        <button id="add-image-btn"
                            type="button"
                            title="Add New"
                            aria-label="Add new lot image"
                            class="tw-flex tw-items-center
                            tw-justify-center tw-gap-2
                            tw-w-9 tw-h-9 tw-rounded-lg
                            tw-bg-[#06EBB6] tw-text-[#06100D]
                            hover:tw-bg-[#1ED9D7]
                            tw-transition-colors tw-duration-200
                            focus-visible:tw-outline-none
                            focus-visible:tw-ring-2
                            focus-visible:tw-ring-[#1ED9D7]
                            focus-visible:tw-ring-offset-2">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                class="tw-w-5 tw-h-5">

                                <path d="M12 5v14M5 12h14"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Image Viewer -->
                    <div id="lot-images-section"
                        class="tw-relative tw-w-full tw-h-64 sm:tw-h-80
                        tw-bg-[#D9D9D9]/40 tw-rounded-xl
                        tw-border tw-border-[#C4C4C4]/60
                        tw-flex tw-items-center tw-justify-center
                        tw-overflow-hidden tw-mb-4 tw-cursor-pointer">

                        <img id="lot-image"
                            src=""
                            alt="Lot Image"
                            class="tw-max-h-full tw-max-w-full
                            tw-object-contain tw-rounded-lg">
                    </div>

                    <!-- Image Navigation -->
                    <div class="tw-flex tw-items-center
                        tw-justify-center tw-gap-4">

                        <button id="prev-image-btn"
                            type="button"
                            aria-label="Previous image"
                            class="tw-flex tw-items-center
                            tw-justify-center tw-w-9 tw-h-9
                            tw-rounded-lg tw-border
                            tw-border-[#C4C4C4]
                            tw-text-[#111111]
                            hover:tw-bg-[#06EBB6]
                            hover:tw-border-[#06EBB6]
                            tw-transition-colors tw-duration-200
                            focus-visible:tw-outline-none
                            focus-visible:tw-ring-2
                            focus-visible:tw-ring-[#1ED9D7]">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                class="tw-w-4 tw-h-4">

                                <path d="m15 18-6-6 6-6"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"/>
                            </svg>
                        </button>

                        <span class="tw-text-xs tw-text-[#666666]">
                            Navigate images
                        </span>

                        <button id="next-image-btn"
                            type="button"
                            aria-label="Next image"
                            class="tw-flex tw-items-center
                            tw-justify-center tw-w-9 tw-h-9
                            tw-rounded-lg tw-border
                            tw-border-[#C4C4C4]
                            tw-text-[#111111]
                            hover:tw-bg-[#06EBB6]
                            hover:tw-border-[#06EBB6]
                            tw-transition-colors tw-duration-200
                            focus-visible:tw-outline-none
                            focus-visible:tw-ring-2
                            focus-visible:tw-ring-[#1ED9D7]">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                class="tw-w-4 tw-h-4">

                                <path d="m9 18 6-6-6-6"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Bottom Section: Lot Summary -->
            <div class="bottom-section tw-hidden tw-w-full
                tw-p-5 sm:tw-p-6 tw-rounded-xl
                tw-bg-[#D9D9D9]/30
                tw-border tw-border-[#C4C4C4]/70">

                <div id="lot-summary-container"
                    class="tw-flex tw-flex-col tw-gap-3">

                    <!-- Summary Header -->
                    <div class="tw-flex tw-items-center tw-gap-3">

                        <div class="tw-flex tw-items-center
                            tw-justify-center tw-w-9 tw-h-9
                            tw-rounded-lg tw-bg-[#06EBB6]/20">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                class="tw-w-5 tw-h-5 tw-text-[#06100D]">

                                <path d="M12 3v2m0 14v2M3 12h2m14 0h2
                                    M5.64 5.64l1.42 1.42m9.88 9.88
                                    1.42 1.42m0-12.72-1.42 1.42
                                    m-9.88 9.88-1.42 1.42"/>

                                <circle cx="12" cy="12" r="4"/>
                            </svg>
                        </div>

                        <div>
                            <h3 class="tw-text-sm tw-font-semibold
                                tw-text-[#111111]">
                                Lot Summary
                            </h3>
                            <p class="tw-text-xs tw-text-[#666666]">
                                AI-generated property insights
                            </p>
                        </div>
                    </div>

                    <!-- Summary Content -->
                    <div class="tw-pl-0 sm:tw-pl-12">
                        <p id="lot-summary-text"
                            class="tw-text-sm tw-leading-7
                            tw-text-[#666666]">
                            *AI-generated summary is empty for now*
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<template id="lot-status-template">
    <span data-field="status"
        class="tw-inline-flex tw-items-center tw-rounded-full
        tw-px-3 tw-py-1 tw-text-xs tw-font-semibold
        tw-bg-green-50 tw-text-green-700">
    </span>
</template>