
<div id="full-report-modal"
    class="tw-fixed tw-inset-0 tw-flex tw-items-center tw-justify-center
           tw-bg-black/40 tw-backdrop-blur-sm tw-z-50 tw-hidden
           tw-p-4">

    <div class="tw-bg-white tw-w-full tw-max-w-4xl
                tw-max-h-[85vh] tw-rounded-xl
                tw-border tw-border-[#E2E8E4]
                tw-shadow-[0_20px_60px_rgba(0,0,0,0.18)]
                tw-text-[#1A2520] tw-flex tw-flex-col tw-overflow-hidden">

        <!-- Header -->
        <div class="tw-flex tw-items-center tw-justify-between
                    tw-px-6 tw-py-5 tw-border-b tw-border-[#E5EAE7]
                    tw-bg-[#F8FAF9] tw-shrink-0">

            <div class="tw-flex tw-flex-col tw-gap-1">
                <h3 class="tw-text-lg tw-font-semibold tw-text-[#17211C]">
                    Forecast Report
                </h3>

                <p class="tw-text-xs tw-text-[#7A8780]">
                    Detailed block sentiment and forecast analysis
                </p>
            </div>

            <button id="close-full-report"
                class="tw-w-9 tw-h-9 tw-flex tw-items-center tw-justify-center
                       tw-rounded-lg tw-text-[#7A8780]
                       hover:tw-bg-[#EDF2EF] hover:tw-text-[#17211C]
                       tw-transition-colors tw-duration-200"
                aria-label="Close report">

                <span class="tw-text-2xl tw-leading-none">&times;</span>
            </button>
        </div>

        <!-- Report Content -->
        <div id="full-report-content"
            class="tw-px-6 tw-py-6 tw-overflow-y-auto tw-flex-1
                   tw-min-h-0 tw-bg-white">

            <!-- Forecast report content injected here -->

        </div>

        <!-- Footer -->
        <div class="tw-flex tw-items-center tw-justify-between
                    tw-px-6 tw-py-4 tw-border-t tw-border-[#E5EAE7]
                    tw-bg-[#F8FAF9] tw-shrink-0">

            <span class="tw-text-xs tw-text-[#89958E]">
                LotMatch Analytics
            </span>

            <button id="close-full-report-footer"
                class="tw-px-4 tw-py-2 tw-rounded-lg
                       tw-bg-[#06EBB6] tw-text-[#06100D]
                       tw-font-semibold tw-text-sm
                       hover:tw-bg-[#1ED9D7]
                       tw-transition-colors tw-duration-200">
                Close Report
            </button>
        </div>

    </div>
</div>
