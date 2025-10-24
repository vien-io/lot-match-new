<div x-data="{ open: false }" class="tw-relative">
    <a href="{{ $href }}"
        @mouseenter="open = true" @mouseleave="open = false"
        class="tw-flex tw-items-center tw-justify-center tw-w-12 tw-h-12 tw-my-3 tw-rounded-xl tw-transition-colors {{ $active }}">
        <i class="{{ $icon }} tw-text-2xl"></i>
    </a>

    <!-- tooltip -->
    <div x-show="open" 
        x-transition:enter="tw-transition tw-ease-out tw-duration-150"
        x-transition:enter-start="tw-opacity-0"
        x-transition:enter-end="tw-opacity-100"
        x-transition:leave="tw-transition tw-ease-in tw-duration-100"
        x-transition:leave-start="tw-opacity-100"
        x-transition:leave-end="tw-opacity-0"
        x-cloak
        class="tw-absolute tw-left-14 tw-top-1/2 tw--translate-y-1/2 tw-bg-gray-800 tw-text-white tw-text-sm tw-px-2 tw-py-1 tw-rounded-lg tw-shadow-md tw-whitespace-nowrap">
        {{ $tooltip }}
    </div>
</div>