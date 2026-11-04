{{-- Ratings Overview --}}
<section class="tw-space-y-4 tw-mb-6">

    {{-- Block Ratings Chart --}}
    <div class="tw-bg-white tw-border tw-border-[#E5E9E7] tw-rounded-xl tw-p-5 sm:tw-p-6">
        <div class="tw-flex tw-flex-col tw-gap-4">

            {{-- Chart Header --}}
            <div class="tw-flex tw-flex-wrap tw-items-center tw-justify-between tw-gap-3">

                <div class="max-w-sm">
                    <h2 class="tw-text-md tw-font-bold tw-text-[#111111]">
                        Ratings overview
                    </h2>
                    <p class="tw-text-xs tw-text-[#666666] tw-mt-1">
                        Explore block ratings and the distribution of resident reviews.
                    </p>
                </div>

                {{-- Filters --}}
                <div id="blockRatingFilters"
                    class="tw-flex tw-flex-1 tw-max-w-[300px] tw-justify-center tw-items-center tw-gap-1 tw-rounded-xl tw-bg-gray-100 tw-p-1">

                    <button type="button" data-rating-filter="top" aria-pressed="true" class="rating-filter-btn">
                        Top 10
                    </button>

                    <button type="button" data-rating-filter="lowest" aria-pressed="false" class="rating-filter-btn">
                        Lowest 10
                    </button>

                    <button type="button" data-rating-filter="all" aria-pressed="false" class="rating-filter-btn">
                        All Blocks
                    </button>

                </div>
            </div>

            {{-- Chart --}}
            <div class="tw-h-[400px] tw-overflow-y-auto tw-overflow-x-hidden" data-chart-scroll>

                <div data-chart-container class="tw-relative tw-w-full">

                    <canvas id="ratingsChart"></canvas>

                </div>

            </div>

        </div>
    </div>
</section>