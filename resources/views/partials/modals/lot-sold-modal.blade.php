<div id="lot-sold-modal" 
     class="modal tw-fixed tw-inset-0 tw-flex tw-items-center tw-justify-center tw-bg-black/50 tw-z-50 tw-hidden tw-animate-[modal-pop_0.25s_ease-out]">

    <div class="modal-content tw-w-11/12 tw-max-w-3xl tw-p-6 tw-relative
                tw-rounded-2xl tw-text-white tw-font-sans
                tw-flex tw-flex-col tw-gap-6
                tw-border-2 tw-border-transparent
                tw-bg-[linear-gradient(#212121,#212121)_padding-box,linear-gradient(145deg,transparent_35%,#e81cff,#40c9ff)_border-box]
                tw-shadow-[0_0_20px_rgba(0,0,0,0.6)]">

        <!-- Header -->
        <div class="topTab tw-flex tw-justify-between tw-items-center">
            <h2 class="tw-text-xl tw-font-semibold tw-text-[#ffffff]">Lot Details</h2>
            <span class="close-btn lot-close 
                  tw-text-2xl tw-cursor-pointer tw-text-[#f87171]
                  [text-shadow:0_0_8px_#f87171]
                  hover:[text-shadow:0_0_18px_#f87171]
                  hover:tw-scale-150
                  tw-inline-block tw-transition-transform tw-duration-300 tw-ease-out">
                &times;
            </span>
        </div>

        <!-- Content -->
        <div class="modal-inner-content tw-flex tw-flex-col tw-gap-6">

            <!-- Top Section: Details Only -->
            <div class="top-section tw-flex tw-gap-6">

                <!-- Lot Details -->
                <div class="left-column gradient-border-red tw-flex-1 tw-p-4 tw-rounded-xl
                    tw-transition-transform tw-duration-300 hover:tw--translate-y-1 hover:tw-shadow-[0_4px_20px_rgba(255,255,255,0.05)] hover:tw-bg-[#f87171]/20">

                    <div id="lot-details-sold"></div>

                    <!-- Lot Attributes Table -->
                    <div class="tw-mt-4">
                        <h3 class="tw-text-[#717171] tw-font-semibold tw-mb-2">Lot Attributes</h3>
                        <table class="tw-w-full tw-text-sm tw-border-collapse">
                            <tbody>
                                <tr class="tw-border-b tw-border-[#414141]">
                                    <td class="tw-py-1 tw-pr-4 tw-font-semibold">Price</td>
                                    <td class="tw-py-1" id="lot-price-sold"></td>
                                </tr>
                                <tr class="tw-border-b tw-border-[#414141]">
                                    <td class="tw-py-1 tw-pr-4 tw-font-semibold">Status</td>
                                    <td class="tw-py-1 tw-text-red-500 tw-font-semibold">SOLD</td>
                                </tr>
                                <tr class="tw-border-b tw-border-[#414141]">
                                    <td class="tw-py-1 tw-pr-4 tw-font-semibold">Lot Area</td>
                                    <td class="tw-py-1" id="lot-lot-area-sold"></td>
                                </tr>
                                <tr class="tw-border-b tw-border-[#414141]">
                                    <td class="tw-py-1 tw-pr-4 tw-font-semibold">Floor Area</td>
                                    <td class="tw-py-1" id="lot-floor-area-sold"></td>
                                </tr>
                                <tr class="tw-border-b tw-border-[#414141]">
                                    <td class="tw-py-1 tw-pr-4 tw-font-semibold">Orientation</td>
                                    <td class="tw-py-1" id="lot-orientation-sold"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>

            <!-- Bottom Section: Sold Notice -->
            <div class="bottom-section gradient-border-red tw-w-3/4 tw-mx-auto tw-p-4 tw-rounded-xl tw-flex tw-flex-col tw-items-center tw-justify-center
                        tw-transition-transform tw-duration-300 tw-ease-out
                        hover:tw--translate-y-1 hover:tw-shadow-[0_4px_20px_rgba(255,0,0,0.2)]">
                <h3 class="tw-text-2xl tw-font-bold tw-text-red-500 tw-mb-2">This lot has been sold</h3>
                <p class="tw-text-sm tw-text-gray-300 tw-text-center">
                    Thank you for your interest. Please explore other available lots.
                </p>
            </div>

        </div>
    </div>
</div>
