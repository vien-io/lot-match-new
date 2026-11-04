{{-- Top Rated Blocks --}}
<section class="tw-space-y-4">
    <div>
        <h2 class="tw-text-lg tw-font-bold tw-text-[#111111]">
            Top-rated blocks
        </h2>
        <p class="tw-text-sm tw-text-[#666666] tw-mt-1">
            Blocks with the highest average resident ratings.
        </p>
    </div>

    <div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 xl:tw-grid-cols-3 2xl:tw-grid-cols-5 tw-gap-4">

        @forelse($topRatedBlocks as $block)
            <div
                class="tw-bg-white tw-border tw-border-[#E5E9E7] tw-rounded-xl tw-p-5 hover:tw-border-[#06EBB6] tw-transition-colors">

                <div class="tw-flex tw-items-center tw-justify-between tw-mb-4">
                    <span class="tw-text-xs tw-font-medium tw-text-[#666666]">
                        TOP RATED
                    </span>

                    <i class="fas fa-award tw-text-[#06B99A]"></i>
                </div>

                <h3 class="tw-text-base tw-font-semibold tw-text-[#111111]">
                    {{ $block->name }}
                </h3>

                <div class="tw-flex tw-items-center tw-gap-2 tw-mt-3">
                    <span class="tw-text-2xl tw-font-bold tw-text-[#111111]">
                        {{ number_format($block->avg_rating, 1) }}
                    </span>
                    <span class="tw-text-sm tw-text-[#888888]">/ 5.0</span>
                    <span class="tw-text-[#D9A600]">★</span>
                </div>

                <p class="tw-text-xs tw-text-[#666666] tw-mt-2">
                    {{ number_format($block->total_reviews) }}
                    review{{ $block->total_reviews == 1 ? '' : 's' }}
                </p>
            </div>
        @empty
            <div class="tw-col-span-full tw-bg-white tw-border tw-border-[#E5E9E7] tw-rounded-xl tw-p-8 tw-text-center">
                <p class="tw-text-sm tw-text-[#888888]">
                    No top-rated blocks available.
                </p>
            </div>
        @endforelse

    </div>
</section>