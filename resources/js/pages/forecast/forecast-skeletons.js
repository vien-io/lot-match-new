
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


export function showRatingLoading(element) {
    element.innerHTML = `
        <div class="tw-relative tw-overflow-hidden tw-rounded-xl tw-border tw-border-white/[0.06] tw-bg-[#101F18] tw-p-5 sm:tw-p-6">

            <div class="tw-flex tw-flex-col tw-gap-6 sm:tw-flex-row sm:tw-items-center sm:tw-justify-between">

                <!-- Main Rating Skeleton -->
                <div>
                    <div class="tw-skeleton-dark tw-h-2.5 tw-w-28 tw-rounded"></div>

                    <div class="tw-mt-4 tw-flex tw-items-baseline tw-gap-2">
                        <div class="tw-skeleton-dark tw-h-14 tw-w-24 tw-rounded-lg"></div>
                        <div class="tw-skeleton-dark tw-h-4 tw-w-10 tw-rounded"></div>
                    </div>

                    <div class="tw-mt-4 tw-flex tw-gap-1.5">
                        ${Array.from({ length: 5 }, () => `
                            <div class="tw-skeleton-dark tw-h-5 tw-w-5 tw-rounded"></div>
                        `).join('')}
                    </div>
                </div>

                <!-- Satisfaction Level Skeleton -->
                <div class="tw-w-full sm:tw-max-w-[180px]">
                    <div class="tw-flex tw-items-center tw-justify-between">
                        <div class="tw-skeleton-dark tw-h-3 tw-w-24 tw-rounded"></div>
                        <div class="tw-skeleton-dark tw-h-4 tw-w-10 tw-rounded"></div>
                    </div>

                    <div class="tw-mt-2 tw-flex tw-justify-between">
                        <div class="tw-skeleton-dark tw-h-2 tw-w-3 tw-rounded"></div>
                        <div class="tw-skeleton-dark tw-h-2 tw-w-5 tw-rounded"></div>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="tw-my-5 tw-h-px tw-bg-white/[0.07]"></div>

            <!-- Footer Skeleton -->
            <div class="tw-flex tw-items-start tw-gap-2.5">
                <div class="tw-skeleton-dark tw-h-4 tw-w-4 tw-shrink-0 tw-rounded-full"></div>

                <div class="tw-flex-1 tw-space-y-2">
                    <div class="tw-skeleton-dark tw-h-3 tw-w-full tw-rounded"></div>
                    <div class="tw-skeleton-dark tw-h-3 tw-w-4/5 tw-rounded"></div>
                </div>
            </div>

            <!-- Loading indicator -->
            <div class="tw-mt-5 tw-flex tw-items-center tw-gap-2">
                <span class="tw-flex tw-gap-1">
                    <span class="tw-loading-dot tw-h-1.5 tw-w-1.5 tw-rounded-full tw-bg-[#06EBB6]"></span>
                    <span class="tw-loading-dot tw-h-1.5 tw-w-1.5 tw-rounded-full tw-bg-[#06EBB6]"></span>
                    <span class="tw-loading-dot tw-h-1.5 tw-w-1.5 tw-rounded-full tw-bg-[#06EBB6]"></span>
                </span>
                <span class="tw-text-[10px] tw-text-[#819187]">
                    Calculating satisfaction rating
                </span>
            </div>
        </div>
    `;
}


export function showSentimentChartLoading(element) {
    element.innerHTML = `
        <div class="tw-relative tw-inset-0 tw-overflow-hidden tw-rounded-xl tw-bg-[#FAFBFA]">

            <!-- Skeleton chart grid  -->
            <div class="tw-pointer-events-none tw-absolute tw-inset-0 tw-opacity-60"
                style="background-image: linear-gradient(to right, #E8EBE8 1px, transparent 1px), linear-gradient(to bottom, #E8EBE8 1px, transparent 1px); background-size: 40px 40px;">
            </div>

            <!-- Chart skeleton -->
            <div class="tw-relative tw-z-10 tw-flex tw-h-full tw-min-h-[280px] tw-flex-col tw-p-5 sm:tw-min-h-[300px]">

                <div class="tw-mb-5 tw-flex tw-items-center tw-justify-between">
                    <div class="tw-skeleton tw-h-3 tw-w-24 tw-rounded"></div>

                    <div class="tw-flex tw-items-center tw-gap-3">
                        <div class="tw-flex tw-items-center tw-gap-1.5">
                            <div class="tw-h-2 tw-w-2 tw-rounded-full tw-bg-[#B8D8C5]"></div>
                            <div class="tw-skeleton tw-h-2 tw-w-12 tw-rounded"></div>
                        </div>
                        <div class="tw-flex tw-items-center tw-gap-1.5">
                            <div class="tw-h-2 tw-w-2 tw-rounded-full tw-bg-[#D5DDD7]"></div>
                            <div class="tw-skeleton tw-h-2 tw-w-10 tw-rounded"></div>
                        </div>
                    </div>
                </div>

                <!-- Chart plotting area  -->
                <div class="tw-relative tw-min-h-0 tw-flex-1">

                    <!-- Y-axis labels -->
                    <div class="tw-absolute tw-inset-y-0 tw-left-0 tw-flex tw-flex-col tw-justify-between tw-pb-5 tw-pr-3">
                        <div class="tw-skeleton tw-h-2 tw-w-6 tw-rounded"></div>
                        <div class="tw-skeleton tw-h-2 tw-w-6 tw-rounded"></div>
                        <div class="tw-skeleton tw-h-2 tw-w-6 tw-rounded"></div>
                        <div class="tw-skeleton tw-h-2 tw-w-6 tw-rounded"></div>
                    </div>

                    <!-- Animated line and data points-->
                    <div class="tw-absolute tw-top-2 tw-bottom-6 tw-left-10 tw-right-2">

                        <svg
                            class="tw-h-full tw-w-full"
                            viewBox="0 0 500 220"
                            preserveAspectRatio="none"
                            fill="none"
                            aria-hidden="true"
                        >
                            <!-- Shaded area below trend -->
                            <path
                                d="M0 165 C45 150 55 95 100 115 S160 165 205 105 S270 55 310 90 S370 140 410 60 S465 70 500 25 L500 220 L0 220 Z"
                                fill="#DCEDE2"
                                opacity="0.45"
                            />

                            <path
                                d="M0 165 C45 150 55 95 100 115 S160 165 205 105 S270 55 310 90 S370 140 410 60 S465 70 500 25"
                                stroke="#A7CBB4"
                                stroke-width="3"
                                stroke-linecap="round"
                                stroke-dasharray="10 8"
                                class="tw-animate-pulse"
                            />

                            <circle cx="100" cy="115" r="5" fill="#FFFFFF" stroke="#A7CBB4" stroke-width="3" class="tw-animate-pulse"/>
                            <circle cx="205" cy="105" r="5" fill="#FFFFFF" stroke="#A7CBB4" stroke-width="3" class="tw-animate-pulse"/>
                            <circle cx="310" cy="90" r="5" fill="#FFFFFF" stroke="#A7CBB4" stroke-width="3" class="tw-animate-pulse"/>
                            <circle cx="410" cy="60" r="5" fill="#FFFFFF" stroke="#A7CBB4" stroke-width="3" class="tw-animate-pulse"/>
                        </svg>
                    </div>

                    <div class="tw-absolute tw-bottom-0 tw-left-10 tw-right-2 tw-flex tw-justify-between">
                        <div class="tw-skeleton tw-h-2 tw-w-8 tw-rounded"></div>
                        <div class="tw-skeleton tw-h-2 tw-w-8 tw-rounded"></div>
                        <div class="tw-skeleton tw-h-2 tw-w-8 tw-rounded"></div>
                        <div class="tw-skeleton tw-h-2 tw-w-8 tw-rounded"></div>
                    </div>
                </div>

                <div class="tw-mt-5 tw-flex tw-items-center tw-justify-center tw-gap-2">
                    <span class="tw-flex tw-gap-1">
                        <span class="tw-loading-dot tw-h-1.5 tw-w-1.5 tw-rounded-full tw-bg-[#225C42]"></span>
                        <span class="tw-loading-dot tw-h-1.5 tw-w-1.5 tw-rounded-full tw-bg-[#225C42]"></span>
                        <span class="tw-loading-dot tw-h-1.5 tw-w-1.5 tw-rounded-full tw-bg-[#225C42]"></span>
                    </span>
                    <span class="tw-text-xs tw-font-medium tw-text-[#69736C]">
                        Loading sentiment trends
                    </span>
                </div>
            </div>
        </div>
    `;
}
