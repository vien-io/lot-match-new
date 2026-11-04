{{-- Block Ratings Table --}}
<section class="tw-bg-white tw-border tw-border-[#E5E9E7] tw-rounded-xl tw-overflow-hidden tw-max-h-[480px]">

    {{-- Header --}}
    <div class="tw-p-5 sm:tw-p-6 tw-border-b tw-border-[#E5E9E7]">
        <div class="tw-flex tw-flex-col sm:tw-flex-row sm:items-center justify-between tw-gap-3">
            <div>
                <h2 class="tw-text-base tw-font-semibold tw-text-[#111111]">
                    Block ratings analytics
                </h2>
                <p class="tw-text-sm tw-text-[#666666] tw-mt-1">
                    Detailed breakdown of average ratings and resident review activity.
                </p>
            </div>

            <span
                class="tw-ml-auto tw-inline-flex tw-items-center tw-rounded-lg tw-bg-[#06EBB6]/10 tw-px-3 tw-py-1.5 tw-text-sm tw-font-semibold tw-text-[#06100D]">
                {{ $blockRatings->count() }} Blocks
            </span>
        </div>
    </div>

    {{-- Table --}}
    <div class="tw-overflow-x-auto tw-overflow-y-auto tw-max-h-[380px]">
        <table class="tw-w-full tw-table-fixed tw-text-left tw-text-sm">
            <thead class="tw-bg-[#F5F7F6] tw-sticky tw-top-0 tw-z-10">
                <tr>
                    <th
                        class="tw-w-1/3 tw-px-6 tw-py-3.5 tw-font-semibold tw-text-xs tw-uppercase tw-tracking-wide tw-text-[#666666]">
                        Block
                    </th>

                    <th
                        class="tw-w-1/3 tw-px-6 tw-py-3.5 tw-font-semibold tw-text-xs tw-uppercase tw-tracking-wide tw-text-[#666666]">
                        Average rating
                    </th>

                    <th
                        class="tw-w-1/3 tw-px-6 tw-py-3.5 tw-font-semibold tw-text-xs tw-uppercase tw-tracking-wide tw-text-[#666666]">
                        Total reviews
                    </th>
                </tr>
            </thead>

            <tbody class="tw-divide-y tw-divide-[#EEF1EF]">

                @forelse($blockRatings as $row)
                    <tr class="hover:tw-bg-[#F8FAF9] tw-transition-colors">

                        {{-- Block --}}
                        <td class="tw-px-6 tw-py-4">
                            <span class="tw-font-semibold tw-text-[#111111]">
                                {{ $row->name }}
                            </span>
                        </td>

                        {{-- Average Rating --}}
                        <td class="tw-px-6 tw-py-4">
                            <div class="tw-flex tw-items-center tw-gap-2">
                                <span class="tw-font-semibold tw-text-[#111111] tw-tabular-nums">
                                    {{ number_format($row->avg_rating, 2) }}
                                </span>

                                <div class="tw-flex tw-items-center tw-gap-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i
                                            class="fas fa-star tw-text-[10px] {{ $row->avg_rating >= $i ? 'tw-text-[#D9A600]' : 'tw-text-[#D9D9D9]' }}"></i>
                                    @endfor
                                </div>
                            </div>
                        </td>

                        {{-- Total Reviews --}}
                        <td class="tw-px-6 tw-py-4">
                            <span class="tw-text-[#666666] tw-font-medium tw-tabular-nums">
                                {{ number_format($row->total_reviews) }}
                            </span>
                            <span class="tw-text-xs tw-text-[#999999] tw-ml-1">
                                reviews
                            </span>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="tw-px-6 tw-py-14">
                            <div class="tw-flex tw-flex-col tw-items-center tw-justify-center tw-text-center">
                                <div
                                    class="tw-h-11 tw-w-11 tw-rounded-xl tw-bg-[#F5F7F6] tw-flex tw-items-center tw-justify-center tw-mb-3">
                                    <i class="fas fa-chart-bar tw-text-[#888888] tw-text-lg"></i>
                                </div>

                                <p class="tw-text-sm tw-font-semibold tw-text-[#111111]">
                                    No rating data available
                                </p>

                                <p class="tw-text-xs tw-text-[#888888] tw-mt-1">
                                    Block ratings will appear here once resident reviews are recorded.
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

</section>