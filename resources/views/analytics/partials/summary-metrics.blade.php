{{-- Summary Metrics --}}
<div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 xl:tw-grid-cols-3 tw-gap-4">

    {{-- Total Lots --}}
    <div class="tw-bg-white tw-border tw-border-[#E5E9E7] tw-rounded-xl tw-p-5">
        <div class="tw-flex tw-items-center tw-justify-between">
            <p class="tw-text-sm tw-text-[#666666]">Total Properties</p>
            <div class="tw-h-9 tw-w-9 tw-rounded-lg tw-bg-[#06EBB6]/10 tw-flex tw-items-center tw-justify-center">
                                <i class="fas fa-house tw-text-[#06100D]"></i>

            </div>
        </div>

        <p class="tw-text-3xl tw-font-bold tw-text-[#111111] tw-mt-3">
            {{ number_format($totalLots) }}
        </p>
        <p class="tw-text-xs tw-text-[#888888] tw-mt-1">Registered lots</p>
    </div>

    {{-- Available Lots --}}
    <div class="tw-bg-white tw-border tw-border-[#E5E9E7] tw-rounded-xl tw-p-5">
        <div class="tw-flex tw-items-center tw-justify-between">
            <p class="tw-text-sm tw-text-[#666666]">Available Properties</p>
            <div class="tw-h-9 tw-w-9 tw-rounded-lg tw-bg-[#06EBB6]/10 tw-flex tw-items-center tw-justify-center">
                <i class="fas fa-house-circle-check tw-text-[#06100D]"></i>
            </div>
        </div>

        <p class="tw-text-3xl tw-font-bold tw-text-[#111111] tw-mt-3">
            {{ number_format($availableLots) }}
        </p>
        <p class="tw-text-xs tw-text-[#888888] tw-mt-1">Currently available</p>
    </div>

    {{-- Sold Lots --}}
    <div class="tw-bg-white tw-border tw-border-[#E5E9E7] tw-rounded-xl tw-p-5">
        <div class="tw-flex tw-items-center tw-justify-between">
            <p class="tw-text-sm tw-text-[#666666]">Sold Properties</p>
            <div class="tw-h-9 tw-w-9 tw-rounded-lg tw-bg-[#06EBB6]/10 tw-flex tw-items-center tw-justify-center">
                <i class="fas fa-check-circle tw-text-[#06100D]"></i>
            </div>
        </div>

        <p class="tw-text-3xl tw-font-bold tw-text-[#111111] tw-mt-3">
            {{ number_format($soldLots) }}
        </p>
        <p class="tw-text-xs tw-text-[#888888] tw-mt-1">Successfully sold</p>
    </div>
</div>