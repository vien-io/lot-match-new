
{{-- Toolbar --}}
<div class="tw-flex tw-flex-col tw-gap-4 tw-border-b tw-border-[#C4C4C4]/60 tw-p-4 sm:tw-p-5 xl:tw-flex-row xl:tw-items-center xl:tw-justify-between">

    {{-- Left: Status and Block Filters --}}
    <div class="tw-flex tw-min-w-0 tw-flex-col tw-gap-3 sm:tw-flex-row sm:tw-flex-wrap sm:tw-items-center">

        {{-- Status Filters --}}
        <div class="tw-flex tw-flex-wrap tw-items-center tw-gap-1.5"
            role="group"
            aria-label="Filter properties by status">

            @php
                $currentStatus = request('status', 'all');
                $statuses = [
                    'all' => 'All',
                    'available' => 'Available',
                    'sold' => 'Sold',
                ];
            @endphp

            @foreach ($statuses as $value => $label)
                <button
                    type="button"
                    data-status="{{ $value }}"
                    onclick="setPropertyFilter('status', '{{ $value }}')"
                    aria-pressed="{{ $currentStatus === $value ? 'true' : 'false' }}"
                    class="tw-inline-flex tw-items-center tw-justify-center tw-rounded-lg tw-border tw-px-3.5 tw-py-2 tw-text-sm tw-font-medium tw-transition-colors focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06EBB6]
                        {{ $currentStatus === $value
                            ? 'tw-border-[#06100D] tw-bg-[#06100D] tw-text-white'
                            : 'tw-border-[#C4C4C4] tw-bg-white tw-text-[#444444] hover:tw-border-[#06100D] hover:tw-bg-[#D9D9D9]/30' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        {{-- Block Filter --}}
        @if (isset($blocks) && $blocks->count() > 1)
            <div class="tw-relative tw-min-w-0 sm:tw-w-44">
                <label for="blockFilter" class="tw-sr-only">
                    Filter by block
                </label>

                <select
                    id="blockFilter"
                    name="block"
                    form="propertyFilters"
                    onchange="document.getElementById('propertyFilters').requestSubmit()"
                    class="tw-w-full tw-appearance-none tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-py-2.5 tw-pl-3 tw-pr-9 tw-text-sm tw-text-[#111111] tw-outline-none tw-transition focus:tw-border-[#06100D] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/40">

                    <option value="">All blocks</option>

                    @foreach ($blocks as $block)
                        <option
                            value="{{ $block->id }}"
                            @selected((string) request('block') === (string) $block->id)>
                            {{ $block->name }}
                        </option>
                    @endforeach
                </select>

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="tw-pointer-events-none tw-absolute tw-right-3 tw-top-1/2 tw-h-4 tw-w-4 -tw-translate-y-1/2 tw-text-[#666666]"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="1.8" d="m6 9 6 6 6-6" />
                </svg>
            </div>
        @endif
    </div>

    {{-- Right: Search and Print --}}
    <div class="tw-flex tw-min-w-0 tw-flex-col tw-gap-2 sm:tw-flex-row sm:tw-items-center">

        <form id="propertyFilters"
            method="GET"
            action="{{ route('properties.index') }}"
            class="tw-flex tw-min-w-0 tw-items-center tw-gap-2 tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-transition focus-within:tw-border-[#06100D] focus-within:tw-ring-2 focus-within:tw-ring-[#06EBB6]/40 sm:tw-w-[300px]">

            {{-- Preserve selected filters --}}
            <input type="hidden"
                id="statusFilter"
                name="status"
                value="{{ $currentStatus }}">

            <input type="hidden"
                name="block"
                id="blockFilterFallback"
                value="{{ request('block') }}"
                @if (isset($blocks) && $blocks->count() > 1) disabled @endif>

            <svg xmlns="http://www.w3.org/2000/svg"
                class="tw-h-4 tw-w-4 tw-shrink-0 tw-text-[#666666]"
                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2"
                    d="m21 21-6-6m2-5a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
            </svg>

            <input
                type="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search properties..."
                aria-label="Search by block, lot, or status"
                class="tw-min-w-0 tw-flex-1 tw-bg-transparent tw-py-2.5 tw-text-sm tw-text-[#111111] tw-outline-none placeholder:tw-text-[#999999]">

            @if (request('search'))
                <a href="{{ route('properties.index', array_filter([
                    'status' => $currentStatus !== 'all' ? $currentStatus : null,
                    'block' => request('block'),
                ])) }}"
                    aria-label="Clear search"
                    title="Clear search"
                    class="tw-shrink-0 tw-text-xs tw-font-medium tw-text-[#666666] hover:tw-text-[#111111]">
                    Clear
                </a>
            @endif
        </form>

        <button
            type="button"
            onclick="window.print()"
            class="tw-inline-flex tw-items-center tw-justify-center tw-gap-2 tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-4 tw-py-2.5 tw-text-sm tw-font-medium tw-text-[#111111] tw-transition-colors hover:tw-bg-[#D9D9D9]/40 focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06EBB6]">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="tw-h-4 tw-w-4"
                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="1.8"
                    d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2m-4 0v4m0 0h4m-4 0H8" />
            </svg>

            Print
        </button>
    </div>
</div>

<script>
    function setPropertyFilter(name, value) {
        const form = document.getElementById('propertyFilters');

        if (name === 'status') {
            document.getElementById('statusFilter').value = value;
        }

        form.requestSubmit();
    }
</script>
