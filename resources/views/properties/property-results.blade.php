{{-- Property Results --}}
<div id="propertyResults">

    @include('properties.printable-table')

    {{-- Pagination --}}
    <div
        class="tw-flex tw-flex-col tw-gap-3 tw-border-t tw-border-[#C4C4C4]/60 tw-p-4 tw-text-sm tw-text-[#666666] sm:tw-flex-row sm:tw-items-center sm:tw-justify-between">

        <span>
            Showing {{ $properties->firstItem() ?? 0 }}–{{ $properties->lastItem() ?? 0 }}
            of {{ $properties->total() }} properties
        </span>

        <div class="tw-overflow-x-auto">
            {{ $properties->links('vendor.pagination.custom') }}
        </div>

    </div>

</div>