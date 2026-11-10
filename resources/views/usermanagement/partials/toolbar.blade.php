{{-- Table toolbar --}}
<div class="tw-flex tw-flex-col tw-gap-3 tw-border-b tw-border-[#C4C4C4]/60 tw-p-4 sm:tw-flex-row sm:tw-items-center sm:tw-justify-between sm:tw-p-5">
    <div>
        <h2 class="tw-text-base tw-font-semibold tw-text-[#111111]">System users</h2>
        <p class="tw-mt-0.5 tw-text-xs tw-text-[#666666]">
            Review accounts and manage assigned access levels.
        </p>
    </div>

    <form
        method="GET"
        action="{{ route('usermanagement.index') }}"
        class="tw-flex tw-w-full tw-items-center tw-gap-2 tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-py-2 focus-within:tw-border-[#06B995] focus-within:tw-ring-2 focus-within:tw-ring-[#06EBB6]/20 sm:tw-max-w-xs"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="tw-h-4 tw-w-4 tw-flex-shrink-0 tw-text-[#666666]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="7" />
            <path stroke-linecap="round" stroke-linejoin="round" d="m20 20-4-4" />
        </svg>
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search users..."
            aria-label="Search users"
            class="tw-w-full tw-border-0 tw-bg-transparent tw-p-0 tw-text-sm tw-text-[#111111] placeholder:tw-text-[#999999] focus:tw-outline-none focus:tw-ring-0"
        />
        @if(request('search'))
            <a
                href="{{ route('usermanagement.index') }}"
                class="tw-flex-shrink-0 tw-text-xs tw-font-medium tw-text-[#666666] hover:tw-text-[#111111]"
                aria-label="Clear search"
            >
                Clear
            </a>
        @endif
    </form>
</div>