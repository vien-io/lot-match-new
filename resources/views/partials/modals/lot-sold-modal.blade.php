{{-- Sold Lot Details Modal --}}
<div id="lot-sold-modal" class="modal tw-fixed tw-inset-0 tw-z-50 tw-hidden
    tw-items-center tw-justify-center
    tw-bg-[#06100D]/30 tw-backdrop-blur-[2px]
    tw-p-4 tw-overflow-y-auto">

    <div class="modal-content tw-relative tw-w-full tw-max-w-2xl
        tw-max-h-[90vh] tw-flex tw-flex-col
        tw-overflow-hidden tw-rounded-xl
        tw-bg-white tw-text-[#111111]
        tw-font-sans
        tw-border tw-border-[#C4C4C4]/70
        tw-shadow-[0_20px_60px_rgba(0,0,0,0.16)]" role="dialog" aria-modal="true"
        aria-labelledby="lot-sold-modal-title" aria-describedby="lot-sold-modal-description">

        {{-- Header --}}
        <div class="topTab tw-relative tw-flex tw-items-start
            tw-justify-between tw-gap-4
            tw-px-6 sm:tw-px-7 tw-pt-6 tw-pb-5
            tw-bg-white tw-flex-shrink-0">

            <div class="tw-min-w-0 tw-flex tw-flex-col tw-gap-1.5">

                <h2 id="lot-sold-modal-title" class="tw-text-xl tw-font-semibold
                    tw-tracking-tight tw-text-[#111111]">
                    Lot Details
                </h2>

                <p id="lot-sold-modal-description" class="tw-text-sm tw-leading-5
                    tw-text-[#666666]">
                    Property information and specifications.
                </p>

            </div>

            <button type="button" aria-label="Close lot details" class="close-btn lot-close
                tw-flex tw-items-center tw-justify-center
                tw-w-8 tw-h-8 tw-flex-shrink-0
                tw-rounded-lg
                tw-text-[#666666] tw-text-xl
                hover:tw-bg-[#D9D9D9]/50
                hover:tw-text-[#111111]
                focus-visible:tw-outline-none
                focus-visible:tw-ring-2
                focus-visible:tw-ring-[#06EBB6]
                tw-transition-colors tw-duration-200">
                &times;
            </button>

        </div>

        {{-- Scrollable Content --}}
        <div class="modal-inner-content tw-flex tw-flex-col
            tw-gap-5 tw-px-6 sm:tw-px-7 tw-pb-6
            tw-overflow-y-auto">

            {{-- Property Overview --}}
            <section class="top-section tw-w-full
                tw-overflow-hidden
                tw-rounded-lg
                tw-border tw-border-[#C4C4C4]/70">

                {{-- Section Header --}}
                <div class="tw-flex tw-items-center
                    tw-justify-between tw-gap-3
                    tw-px-5 tw-py-4
                    tw-bg-white">

                    <div class="tw-flex tw-flex-col tw-gap-1">

                        <h3 class="tw-text-sm tw-font-semibold
                            tw-text-[#111111]">
                            Property Overview
                        </h3>

                        <p class="tw-text-xs tw-text-[#666666]">
                            Recorded property information
                        </p>

                    </div>
                </div>

                {{-- Dynamic Property Information --}}
                <div class="tw-px-5 tw-pb-5">

                    <div id="lot-details-sold" class="tw-space-y-3">
                    </div>

                </div>

                {{-- Divider --}}
                <div class="tw-border-t tw-border-[#D9D9D9]"></div>

                {{-- Lot Attributes --}}
                <div class="tw-p-5">

                    <div class="tw-flex tw-flex-col tw-gap-1
                        tw-mb-4">

                        <h3 class="tw-text-sm tw-font-semibold
                            tw-text-[#111111]">
                            Lot Attributes
                        </h3>

                        <p class="tw-text-xs tw-text-[#666666]">
                            Property specifications and details
                        </p>

                    </div>

                    {{-- Specifications Table --}}
                    <div class="tw-overflow-hidden
                        tw-rounded-lg
                        tw-border tw-border-[#C4C4C4]/70">

                        <table class="tw-w-full tw-text-sm
                            tw-border-collapse">

                            <tbody class="tw-divide-y
                                tw-divide-[#D9D9D9]">

                                {{-- Price --}}
                                <tr class="hover:tw-bg-[#D9D9D9]/20
                                    tw-transition-colors">

                                    <td class="tw-w-2/5
                                        tw-px-4 tw-py-3
                                        tw-font-medium
                                        tw-text-[#666666]">
                                        Price
                                    </td>

                                    <td id="lot-price-sold" class="tw-px-4 tw-py-3
                                        tw-font-semibold
                                        tw-text-[#111111]
                                        tw-break-words">
                                    </td>

                                </tr>

                                {{-- Status --}}
                                <tr class="hover:tw-bg-[#D9D9D9]/20
                                    tw-transition-colors">

                                    <td class="tw-px-4 tw-py-3
                                        tw-font-medium
                                        tw-text-[#666666]">
                                        Status
                                    </td>

                                    <td class="tw-px-4 tw-py-3">

                                        <span class="tw-inline-flex
                                            tw-items-center tw-gap-2
                                            tw-px-2.5 tw-py-1
                                            tw-rounded-md
                                            tw-bg-[#FEE2E2]
                                            tw-text-[#B42318]
                                            tw-text-[10px]
                                            tw-font-semibold
                                            tw-tracking-wide">

                                            <span class="tw-w-1.5
                                                tw-h-1.5
                                                tw-rounded-full
                                                tw-bg-[#B42318]">
                                            </span>

                                            SOLD

                                        </span>

                                    </td>

                                </tr>

                                {{-- Lot Area --}}
                                <tr class="hover:tw-bg-[#D9D9D9]/20
                                    tw-transition-colors">

                                    <td class="tw-px-4 tw-py-3
                                        tw-font-medium
                                        tw-text-[#666666]">
                                        Lot Area
                                    </td>

                                    <td id="lot-lot-area-sold" class="tw-px-4 tw-py-3
                                        tw-text-[#111111]
                                        tw-break-words">
                                    </td>

                                </tr>

                                {{-- Floor Area --}}
                                <tr class="hover:tw-bg-[#D9D9D9]/20
                                    tw-transition-colors">

                                    <td class="tw-px-4 tw-py-3
                                        tw-font-medium
                                        tw-text-[#666666]">
                                        Floor Area
                                    </td>

                                    <td id="lot-floor-area-sold" class="tw-px-4 tw-py-3
                                        tw-text-[#111111]
                                        tw-break-words">
                                    </td>

                                </tr>

                                {{-- Orientation --}}
                                <tr class="hover:tw-bg-[#D9D9D9]/20
                                    tw-transition-colors">

                                    <td class="tw-px-4 tw-py-3
                                        tw-font-medium
                                        tw-text-[#666666]">
                                        Orientation
                                    </td>

                                    <td id="lot-orientation-sold" class="tw-px-4 tw-py-3
                                        tw-text-[#111111]
                                        tw-break-words">
                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </section>

            {{-- Sold Notice --}}
            <section class="bottom-section tw-w-full
                tw-flex tw-items-center tw-gap-6
                tw-p-4
                tw-rounded-lg
                tw-bg-[#FEF2F2]
                tw-border tw-border-[#FECACA]">

                {{-- Notice Icon --}}
                <div class="tw-flex tw-items-center
                    tw-justify-center tw-flex-shrink-0
                    tw-w-9 tw-h-9
                    tw-rounded-lg
                    tw-bg-[#FEE2E2]">

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#B42318"
                        stroke-width="1.8" class="tw-w-5 tw-h-5">

                        <circle cx="12" cy="12" r="9" />

                        <path d="m9 9 6 6m0-6-6 6" stroke-linecap="round" stroke-linejoin="round" />

                    </svg>

                </div>

                {{-- Notice Content --}}
                <div class="tw-flex tw-flex-col tw-gap-1
                    tw-min-w-0">

                    <h3 class="tw-text-sm tw-font-semibold
                        tw-text-[#B42318]">
                        This lot has been sold
                    </h3>

                    <p class="tw-text-xs sm:tw-text-sm
                        tw-leading-5 tw-text-[#666666]">
                        Thank you for your interest. This property
                        is no longer available. Please explore other
                        available lots within the subdivision.
                    </p>
                </div>
            </section>
        </div>
    </div>
</div>

{{-- Lot Details Template --}}
<template id="lot-details-template">
    <div class="tw-grid tw-grid-cols-2 tw-gap-3">

        <div class="tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-p-3">
            <p class="tw-text-xs tw-text-gray-500 tw-mb-1">
                Name
            </p>
            <p data-field="name" class="tw-text-sm tw-font-semibold tw-text-[#06100D]">
                N/A
            </p>
        </div>

        <div class="tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-p-3">
            <p class="tw-text-xs tw-text-gray-500 tw-mb-1">
                Block Number
            </p>
            <p data-field="block_id" class="tw-text-sm tw-font-semibold tw-text-[#06100D]">
                N/A
            </p>
        </div>

    </div>
</template>