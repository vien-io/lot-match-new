{{-- Lot Availability --}}
<section class="tw-bg-white tw-border tw-border-[#E5E9E7] tw-rounded-xl tw-p-6">
    <div class="tw-flex tw-flex-col sm:tw-flex-row sm:tw-items-center sm:tw-justify-between tw-gap-2 tw-mb-6">
        <div>
            <h2 class="tw-text-base tw-font-semibold tw-text-[#111111]">
                Property availability
            </h2>
            <p class="tw-text-sm tw-text-[#666666] tw-mt-1">
                Distribution of available and sold properties.
            </p>
        </div>

        <span class="tw-text-sm tw-font-semibold tw-text-[#06100D]">
            {{ $totalLots ? number_format(($soldLots / $totalLots) * 100, 1) : 0 }}% sold
        </span>
    </div>

    <div class="tw-flex tw-h-3 tw-w-full tw-overflow-hidden tw-rounded-full tw-bg-[#E9EEEC]">
        <div class="tw-h-full tw-bg-[#06EBB6] tw-transition-all"
            style="width: {{ $totalLots ? ($availableLots / $totalLots) * 100 : 0 }}%">
        </div>

        <div class="tw-h-full tw-bg-[#06100D]" style="width: {{ $totalLots ? ($soldLots / $totalLots) * 100 : 0 }}%">
        </div>
    </div>

    <div class="tw-grid tw-grid-cols-2 tw-gap-4 tw-mt-5">
        <div class="tw-flex tw-items-center tw-gap-3">
            <span class="tw-h-3 tw-w-3 tw-rounded-sm tw-bg-[#06EBB6]"></span>
            <div>
                <p class="tw-text-xs tw-text-[#666666]">Available</p>
                <p class="tw-text-lg tw-font-semibold tw-text-[#111111]">
                    {{ number_format($availableLots) }}
                </p>
            </div>
        </div>

        <div class="tw-flex tw-items-center tw-gap-3">
            <span class="tw-h-3 tw-w-3 tw-rounded-sm tw-bg-[#06100D]"></span>
            <div>
                <p class="tw-text-xs tw-text-[#666666]">Sold</p>
                <p class="tw-text-lg tw-font-semibold tw-text-[#111111]">
                    {{ number_format($soldLots) }}
                </p>
            </div>
        </div>
    </div>
</section>