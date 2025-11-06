<div id="full-report-modal" 
     class="tw-fixed tw-inset-0 tw-flex tw-items-center tw-justify-center tw-bg-black/50 tw-z-50 tw-hidden tw-animate-[modal-pop_0.25s_ease-out]">

    <div class="tw-bg-[#1c1c1c] tw-p-6 tw-rounded-2xl tw-max-w-3xl tw-w-11/12 tw-max-h-[80vh] tw-overflow-y-auto
                tw-border-2 tw-border-transparent
                tw-bg-[linear-gradient(#212121,#212121)_padding-box,linear-gradient(145deg,transparent_35%,#10B981,#34D399)_border-box]
                tw-shadow-[0_0_20px_rgba(0,0,0,0.6)] tw-text-white tw-flex tw-flex-col tw-gap-4
                tw-transition-all tw-duration-300 hover:tw-scale-[1.02] hover:tw-shadow-[0_0_35px_rgba(16,185,129,0.4)] hover:tw-border-[#10B981]">

        <!-- Header -->
        <div class="tw-flex tw-items-center tw-justify-between tw-border-b tw-border-white/10 tw-pb-3">
            <h3 class="tw-text-xl tw-font-semibold tw-text-white">
                Full Forecast Report
            </h3>

            <button id="close-full-report"
                class="tw-text-2xl tw-text-gray-400 hover:tw-text-white tw-transition tw-duration-200">
                &times;
            </button>
        </div>

        <!-- Content -->
        <div id="full-report-content" class="tw-mt-2">
            <!-- Forecast report content will be injected here -->
        </div>
    </div>
</div>
