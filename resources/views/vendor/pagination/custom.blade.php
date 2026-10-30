@if ($paginator->hasPages())
    <nav role="navigation"
        aria-label="{{ __('Pagination Navigation') }}"
        class="tw-flex tw-flex-col tw-gap-4 tw-border-t tw-border-[#C4C4C4]/50 tw-bg-white tw-px-5 tw-py-4 sm:tw-flex-row sm:tw-items-center sm:tw-justify-between">

        {{-- Mobile Pagination --}}
        <div class="tw-flex tw-items-center tw-justify-between tw-gap-3 sm:tw-hidden">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="tw-inline-flex tw-items-center tw-gap-2 tw-rounded-lg tw-border tw-border-[#C4C4C4]/50 tw-bg-[#D9D9D9]/20 tw-px-3.5 tw-py-2 tw-text-xs tw-font-medium tw-text-[#AAAAAA]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m15 18-6-6 6-6"/>
                    </svg>
                    Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    rel="prev"
                    class="tw-inline-flex tw-items-center tw-gap-2 tw-rounded-lg tw-border tw-border-[#C4C4C4]/70 tw-bg-white tw-px-3.5 tw-py-2 tw-text-xs tw-font-medium tw-text-[#444444] tw-transition-colors hover:tw-border-[#1ED9D7] hover:tw-bg-[#1ED9D7]/10 hover:tw-text-[#06100D] focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06EBB6]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m15 18-6-6 6-6"/>
                    </svg>
                    Previous
                </a>
            @endif

            <span class="tw-text-xs tw-font-medium tw-tabular-nums tw-text-[#666666]">
                Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}
            </span>

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    rel="next"
                    class="tw-inline-flex tw-items-center tw-gap-2 tw-rounded-lg tw-border tw-border-[#C4C4C4]/70 tw-bg-white tw-px-3.5 tw-py-2 tw-text-xs tw-font-medium tw-text-[#444444] tw-transition-colors hover:tw-border-[#1ED9D7] hover:tw-bg-[#1ED9D7]/10 hover:tw-text-[#06100D] focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06EBB6]">
                    Next
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>
                </a>
            @else
                <span class="tw-inline-flex tw-items-center tw-gap-2 tw-rounded-lg tw-border tw-border-[#C4C4C4]/50 tw-bg-[#D9D9D9]/20 tw-px-3.5 tw-py-2 tw-text-xs tw-font-medium tw-text-[#AAAAAA]">
                    Next
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>
                </span>
            @endif
        </div>

        {{-- Desktop Pagination --}}
        <div class="tw-hidden sm:tw-flex sm:tw-w-full sm:tw-items-center sm:tw-justify-between sm:tw-gap-6">

            {{-- Results Information --}}
            <p class="tw-text-xs tw-text-[#666666]">
                Showing
                <span class="tw-font-semibold tw-tabular-nums tw-text-[#111111]">{{ $paginator->firstItem() }}</span>
                to
                <span class="tw-font-semibold tw-tabular-nums tw-text-[#111111]">{{ $paginator->lastItem() }}</span>
                of
                <span class="tw-font-semibold tw-tabular-nums tw-text-[#111111]">{{ number_format($paginator->total()) }}</span>
                results
            </p>

            {{-- Page Navigation --}}
            <div class="tw-flex tw-items-center tw-gap-1">

                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true"
                        class="tw-inline-flex tw-h-9 tw-w-9 tw-items-center tw-justify-center tw-rounded-lg tw-border tw-border-[#C4C4C4]/40 tw-bg-[#D9D9D9]/15 tw-text-[#BBBBBB]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m15 18-6-6 6-6"/>
                        </svg>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}"
                        rel="prev"
                        aria-label="Previous page"
                        class="tw-inline-flex tw-h-9 tw-w-9 tw-items-center tw-justify-center tw-rounded-lg tw-border tw-border-[#C4C4C4]/70 tw-bg-white tw-text-[#444444] tw-transition-colors hover:tw-border-[#1ED9D7] hover:tw-bg-[#1ED9D7]/10 hover:tw-text-[#06100D] focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06EBB6]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m15 18-6-6 6-6"/>
                        </svg>
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($elements as $element)

                    {{-- Pagination Separator --}}
                    @if (is_string($element))
                        <span class="tw-inline-flex tw-h-9 tw-min-w-[36px] tw-items-center tw-justify-center tw-text-xs tw-text-[#888888]">
                            {{ $element }}
                        </span>
                    @endif

                    {{-- Pagination Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)

                            @if ($page == $paginator->currentPage())
                                <span
                                    aria-current="page"
                                    aria-label="Page {{ $page }}"
                                    class="tw-inline-flex tw-h-9 tw-min-w-[36px] tw-items-center tw-justify-center tw-rounded-lg tw-border tw-border-[#06EBB6] tw-bg-[#06EBB6] tw-px-3 tw-text-xs tw-font-bold tw-tabular-nums tw-text-[#06100D]">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                    aria-label="Go to page {{ $page }}"
                                    class="tw-inline-flex tw-h-9 tw-min-w-[36px] tw-items-center tw-justify-center tw-rounded-lg tw-border tw-border-transparent tw-bg-white tw-px-3 tw-text-xs tw-font-medium tw-tabular-nums tw-text-[#555555] tw-transition-colors hover:tw-border-[#C4C4C4]/70 hover:tw-bg-[#D9D9D9]/30 hover:tw-text-[#111111] focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06EBB6]">
                                    {{ $page }}
                                </a>
                            @endif

                        @endforeach
                    @endif

                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}"
                        rel="next"
                        aria-label="Next page"
                        class="tw-inline-flex tw-h-9 tw-w-9 tw-items-center tw-justify-center tw-rounded-lg tw-border tw-border-[#C4C4C4]/70 tw-bg-white tw-text-[#444444] tw-transition-colors hover:tw-border-[#1ED9D7] hover:tw-bg-[#1ED9D7]/10 hover:tw-text-[#06100D] focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06EBB6]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m9 18 6-6-6-6"/>
                        </svg>
                    </a>
                @else
                    <span aria-disabled="true"
                        class="tw-inline-flex tw-h-9 tw-w-9 tw-items-center tw-justify-center tw-rounded-lg tw-border tw-border-[#C4C4C4]/40 tw-bg-[#D9D9D9]/15 tw-text-[#BBBBBB]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m9 18 6-6-6-6"/>
                        </svg>
                    </span>
                @endif

            </div>
        </div>
    </nav>
@endif