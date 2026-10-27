
export function showSummaryLoading(element) {
    element.innerHTML = `
        <div>
            <div class="tw-mb-5 tw-flex tw-items-center tw-gap-3">
                <div class="tw-skeleton tw-h-10 tw-w-10 tw-rounded-xl"></div>
                <div class="tw-flex-1 tw-space-y-2">
                    <div class="tw-skeleton tw-h-3 tw-w-32 tw-rounded"></div>
                    <div class="tw-skeleton tw-h-2 tw-w-20 tw-rounded"></div>
                </div>
            </div>

            <div class="tw-space-y-3">
                <div class="tw-skeleton tw-h-3 tw-w-full tw-rounded"></div>
                <div class="tw-skeleton tw-h-3 tw-w-[94%] tw-rounded"></div>
                <div class="tw-skeleton tw-h-3 tw-w-[88%] tw-rounded"></div>
                <div class="tw-skeleton tw-h-3 tw-w-full tw-rounded"></div>
                <div class="tw-skeleton tw-h-3 tw-w-[65%] tw-rounded"></div>
            </div>

            <div class="tw-mt-6 tw-rounded-xl tw-border tw-border-[#DDE7DF] tw-bg-[#F8FAF8] tw-p-4">
                <div class="tw-skeleton tw-mb-3 tw-h-3 tw-w-28 tw-rounded"></div>
                <div class="tw-space-y-2">
                    <div class="tw-skeleton tw-h-2 tw-w-full tw-rounded"></div>
                    <div class="tw-skeleton tw-h-2 tw-w-4/5 tw-rounded"></div>
                </div>
            </div>

            <div class="tw-mt-5 tw-flex tw-items-center tw-gap-2 tw-text-xs tw-text-[#6B756D]">
                <span class="tw-flex tw-gap-1">
                    <span class="tw-loading-dot tw-h-1.5 tw-w-1.5 tw-rounded-full tw-bg-[#059669]"></span>
                    <span class="tw-loading-dot tw-h-1.5 tw-w-1.5 tw-rounded-full tw-bg-[#059669]"></span>
                    <span class="tw-loading-dot tw-h-1.5 tw-w-1.5 tw-rounded-full tw-bg-[#059669]"></span>
                </span>
                Analyzing forecast insights
            </div>
        </div>
    `;
}

export function showNarrativeLoading(element) {
    element.innerHTML = `
        <div>
            <div class="tw-mb-4 tw-flex tw-items-center tw-gap-2">
                <div class="tw-skeleton tw-h-8 tw-w-8 tw-rounded-lg"></div>
                <div class="tw-skeleton tw-h-3 tw-w-36 tw-rounded"></div>
            </div>

            <div class="tw-space-y-3">
                <div class="tw-skeleton tw-h-3 tw-w-full tw-rounded"></div>
                <div class="tw-skeleton tw-h-3 tw-w-[92%] tw-rounded"></div>
                <div class="tw-skeleton tw-h-3 tw-w-[84%] tw-rounded"></div>
            </div>

            <div class="tw-my-5 tw-grid tw-grid-cols-2 tw-gap-3">
                <div class="tw-rounded-xl tw-border tw-border-[#DDE7DF] tw-p-3">
                    <div class="tw-skeleton tw-mb-3 tw-h-2 tw-w-16 tw-rounded"></div>
                    <div class="tw-skeleton tw-h-5 tw-w-20 tw-rounded"></div>
                </div>
                <div class="tw-rounded-xl tw-border tw-border-[#DDE7DF] tw-p-3">
                    <div class="tw-skeleton tw-mb-3 tw-h-2 tw-w-16 tw-rounded"></div>
                    <div class="tw-skeleton tw-h-5 tw-w-20 tw-rounded"></div>
                </div>
            </div>

            <div class="tw-space-y-3">
                <div class="tw-skeleton tw-h-3 tw-w-full tw-rounded"></div>
                <div class="tw-skeleton tw-h-3 tw-w-[72%] tw-rounded"></div>
            </div>

            <div class="tw-mt-5 tw-flex tw-items-center tw-gap-2 tw-text-xs tw-text-[#6B756D]">
                <span class="tw-flex tw-gap-1">
                    <span class="tw-loading-dot tw-h-1.5 tw-w-1.5 tw-rounded-full tw-bg-[#059669]"></span>
                    <span class="tw-loading-dot tw-h-1.5 tw-w-1.5 tw-rounded-full tw-bg-[#059669]"></span>
                    <span class="tw-loading-dot tw-h-1.5 tw-w-1.5 tw-rounded-full tw-bg-[#059669]"></span>
                </span>
                Preparing block forecast
            </div>
        </div>
    `;
}
