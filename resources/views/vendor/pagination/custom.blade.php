@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="tw-flex tw-items-center tw-justify-between">
        {{-- Mobile --}}
        <div class="tw-flex tw-justify-between tw-flex-1 sm:tw-hidden">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="tw-px-3 tw-py-2 tw-text-sm tw-text-gray-400 tw-border tw-rounded-lg">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="tw-px-3 tw-py-2 tw-text-sm tw-text-emerald-700 tw-border tw-rounded-lg hover:tw-bg-emerald-50">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="tw-px-3 tw-py-2 tw-text-sm tw-text-emerald-700 tw-border tw-rounded-lg hover:tw-bg-emerald-50">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="tw-px-3 tw-py-2 tw-text-sm tw-text-gray-400 tw-border tw-rounded-lg">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        {{-- Desktop --}}
        <div class="tw-hidden sm:tw-flex sm:tw-flex-1 sm:tw-items-center sm:tw-justify-between tw-gap-10">
            <p class="tw-text-sm tw-text-gray-600">
                Showing 
                <span class="tw-font-medium">{{ $paginator->firstItem() }}</span> 
                to 
                <span class="tw-font-medium">{{ $paginator->lastItem() }}</span> 
                of 
                <span class="tw-font-medium">{{ $paginator->total() }}</span> results
            </p>

            <div class="tw-flex tw-gap-1">
                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                    <span class="tw-px-3 tw-py-2 tw-text-sm tw-text-gray-400 tw-border tw-rounded-lg">&laquo;</span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="tw-px-3 tw-py-2 tw-text-sm tw-text-emerald-700 tw-border tw-rounded-lg hover:tw-bg-emerald-50">&laquo;</a>
                @endif

                {{-- Pages --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="tw-px-3 tw-py-2 tw-text-sm tw-text-gray-400">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="tw-px-3 tw-py-2 tw-text-sm tw-bg-emerald-700 tw-text-white tw-rounded-lg">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="tw-px-3 tw-py-2 tw-text-sm tw-text-emerald-700 tw-border tw-rounded-lg hover:tw-bg-emerald-50">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="tw-px-3 tw-py-2 tw-text-sm tw-text-emerald-700 tw-border tw-rounded-lg hover:tw-bg-emerald-50">&raquo;</a>
                @else
                    <span class="tw-px-3 tw-py-2 tw-text-sm tw-text-gray-400 tw-border tw-rounded-lg">&raquo;</span>
                @endif
            </div>
        </div>
    </nav>
@endif
