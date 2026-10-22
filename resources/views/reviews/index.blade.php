
@extends('layouts.app')

@section('title', 'Reviews & Ratings')

@section('content')
    <main>
        {{-- Page Header --}}
        <header class="lm-heading tw-flex tw-flex-col tw-gap-4 sm:tw-flex-row sm:tw-items-center sm:tw-justify-between">
            <div>
                <span class="lm-eyebrow">Community</span>
                <h1>Reviews &amp; Ratings</h1>
                <p>Explore community feedback and share your experience with a block.</p>
            </div>

            <a href="#reviewForm"
                class="tw-inline-flex tw-w-fit tw-items-center tw-justify-center tw-gap-2 tw-rounded-lg tw-bg-[#06EBB6] tw-px-4 tw-py-2.5 tw-text-sm tw-font-semibold tw-text-[#06100D] tw-transition-colors hover:tw-bg-[#1ED9D7] focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06100D] focus-visible:tw-ring-offset-2">
                <span aria-hidden="true" class="tw-text-lg tw-leading-none">+</span>
                Write a review
            </a>
        </header>

        {{-- Main Layout --}}
        <div class="tw-grid tw-grid-cols-1 tw-items-start tw-gap-6 xl:tw-grid-cols-[minmax(0,1fr)_360px]">

            {{-- Left Column: Community Reviews --}}
            <section class="tw-min-w-0 tw-space-y-6">

                {{-- Rating Overview --}}
                <div class="tw-rounded-xl tw-border tw-border-[#C4C4C4]/70 tw-bg-white tw-p-5 sm:tw-p-6">

                    <div class="tw-mb-5 tw-flex tw-items-center tw-justify-between tw-gap-4">
                        <div>
                            <h2 class="tw-text-base tw-font-semibold tw-text-[#111111]">
                                Community overview
                            </h2>
                            <p class="tw-mt-1 tw-text-sm tw-text-[#666666]">
                                Ratings and feedback from the community
                            </p>
                        </div>

                        <span class="tw-hidden tw-rounded-md tw-bg-[#06EBB6]/15 tw-px-3 tw-py-1.5 tw-text-xs tw-font-semibold tw-text-[#06100D] sm:tw-inline-flex">
                            Overall rating
                        </span>
                    </div>

                    {{-- Block Selector --}}
                    <div class="tw-mb-6 tw-max-w-sm">
                        <label for="blockSelector"
                               class="tw-mb-2 tw-block tw-text-sm tw-font-medium tw-text-[#111111]">
                            Filter by block
                        </label>

                        <select id="blockSelector"
                                class="tw-w-full tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-py-2.5 tw-text-sm tw-text-[#111111] tw-outline-none tw-transition focus:tw-border-[#06100D] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/40">
                            <option value="">All Blocks</option>
                            @foreach($blocks as $block)
                                <option value="{{ $block->id }}">{{ $block->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="tw-grid tw-grid-cols-1 tw-gap-6 md:tw-grid-cols-[200px_minmax(0,1fr)] md:tw-gap-8">

                        {{-- Average Rating --}}
                        <div id="averageRatingDisplay"
                             class="tw-flex tw-flex-col tw-items-start tw-justify-center tw-border-b tw-border-[#C4C4C4]/60 tw-pb-6 md:tw-border-b-0 md:tw-border-r md:tw-pb-0 md:tw-pr-8">

                            <p class="tw-text-sm tw-font-medium tw-text-[#666666]">
                                Average rating
                            </p>

                            <div class="tw-mt-2 tw-flex tw-items-baseline tw-gap-1.5">
                                <h2 id="averageRating"
                                    class="tw-text-5xl tw-font-semibold tw-tracking-tight tw-text-[#111111]">
                                    {{ number_format($averageRating, 1) }}
                                </h2>
                                <span class="tw-text-sm tw-text-[#666666]">/ 5</span>
                            </div>

                            <div id="averageStars"
                                 class="tw-mt-2 tw-flex tw-text-xl tw-leading-none tw-text-[#B7791F]"
                                 aria-label="{{ number_format($averageRating, 1) }} out of 5 stars">
                                {!! str_repeat('★', round($averageRating)) !!}{!! str_repeat('☆', 5 - round($averageRating)) !!}
                            </div>

                            <p id="totalReviews"
                               class="tw-mt-2 tw-text-sm tw-text-[#666666]">
                                Based on {{ $reviews->count() }} reviews
                            </p>
                        </div>

                        {{-- Rating Distribution --}}
                        <div class="tw-space-y-3" aria-label="Rating distribution">
                            @foreach([5, 4, 3, 2, 1] as $star)
                                @php
                                    $count = $ratingCounts[$star] ?? 0;
                                    $percentage = $reviews->count()
                                        ? ($count / $reviews->count()) * 100
                                        : 0;
                                @endphp

                                <div class="tw-grid tw-grid-cols-[54px_minmax(0,1fr)_32px] tw-items-center tw-gap-3">
                                    <span class="tw-text-sm tw-text-[#666666]">
                                        {{ $star }} star{{ $star > 1 ? 's' : '' }}
                                    </span>

                                    <div class="tw-h-2 tw-overflow-hidden tw-rounded-full tw-bg-[#D9D9D9]/70"
                                         role="progressbar"
                                         aria-label="{{ $star }} star ratings"
                                         aria-valuemin="0"
                                         aria-valuemax="100"
                                         aria-valuenow="{{ round($percentage) }}">
                                        <div id="rating-bar-{{ $star }}"
                                             class="tw-h-full tw-rounded-full tw-bg-[#06EBB6] tw-transition-[width] tw-duration-300"
                                             style="width: {{ $percentage }}%">
                                        </div>
                                    </div>

                                    <span id="rating-count-{{ $star }}"
                                          class="tw-text-right tw-text-sm tw-font-medium tw-tabular-nums tw-text-[#111111]">
                                        {{ $count }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Review Feed --}}
                <div class="tw-overflow-hidden tw-rounded-xl tw-border tw-border-[#C4C4C4]/70 tw-bg-white">

                    <div class="tw-flex tw-flex-col tw-gap-1 tw-border-b tw-border-[#C4C4C4]/60 tw-px-5 tw-py-4 sm:tw-flex-row sm:tw-items-center sm:tw-justify-between sm:tw-px-6">
                        <div>
                            <h2 class="tw-text-base tw-font-semibold tw-text-[#111111]">
                                Community reviews
                            </h2>
                            <p class="tw-mt-1 tw-text-sm tw-text-[#666666]">
                                Read experiences shared by other users.
                            </p>
                        </div>
                    </div>

                    <div id="reviewsContainer"
                         class="tw-max-h-[650px] tw-overflow-y-auto tw-divide-y tw-divide-[#C4C4C4]/50 tw-scrollbar-thin tw-scrollbar-thumb-[#C4C4C4] tw-scrollbar-track-transparent">

                        @forelse($reviews as $review)
                            <article class="tw-flex tw-gap-3 tw-p-5 tw-transition-colors hover:tw-bg-[#D9D9D9]/15 sm:tw-gap-4 sm:tw-px-6">

                                {{-- Reviewer Avatar --}}
                                <img
                                    src="{{ $review->user?->avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode(trim(($review->user?->first_name ?? '') . ' ' . ($review->user?->last_name ?? 'Deleted User'))) . '&background=06100D&color=06EBB6&rounded=true' }}"
                                    class="tw-h-10 tw-w-10 tw-shrink-0 tw-rounded-full tw-border tw-border-[#C4C4C4]/60 tw-object-cover"
                                    alt="{{ trim(($review->user?->first_name ?? '') . ' ' . ($review->user?->last_name ?? 'Deleted User')) }}"
                                    loading="lazy"
                                >

                                <div class="tw-min-w-0 tw-flex-1">

                                    <div class="tw-flex tw-flex-col tw-gap-2 sm:tw-flex-row sm:tw-items-start sm:tw-justify-between">
                                        <div class="tw-min-w-0">
                                            <h3 class="tw-break-words tw-text-sm tw-font-semibold tw-text-[#111111]">
                                                {{ trim(($review->user?->first_name ?? '') . ' ' . ($review->user?->last_name ?? '')) ?: 'Deleted User' }}
                                            </h3>

                                            <p class="tw-mt-1 tw-text-xs tw-text-[#666666]">
                                                {{ $review->block?->name ?? 'Unknown Block' }}
                                            </p>
                                        </div>

                                        <time datetime="{{ $review->created_at?->toIso8601String() }}"
                                              class="tw-shrink-0 tw-text-xs tw-text-[#666666]">
                                            {{ $review->created_at?->format('M j, Y · g:i A') ?? 'Date unavailable' }}
                                        </time>
                                    </div>

                                    <div class="tw-mt-2 tw-flex tw-items-center tw-gap-2">
                                        <div class="tw-flex tw-text-base tw-leading-none tw-text-[#B7791F]"
                                             aria-label="{{ $review->rating }} out of 5 stars">
                                            {!! str_repeat('★', $review->rating) !!}{!! str_repeat('☆', 5 - $review->rating) !!}
                                        </div>

                                        <span class="tw-text-xs tw-font-medium tw-text-[#666666]">
                                            {{ $review->rating }}.0 / 5
                                        </span>
                                    </div>

                                    <p class="tw-mt-3 tw-whitespace-pre-line tw-break-words tw-text-sm tw-leading-6 tw-text-[#444444]">
                                        {{ filled($review->comment) ? $review->comment : 'No comment provided.' }}
                                    </p>
                                </div>
                            </article>
                        @empty
                            <div class="tw-flex tw-flex-col tw-items-center tw-px-6 tw-py-14 tw-text-center">
                                <div class="tw-flex tw-h-12 tw-w-12 tw-items-center tw-justify-center tw-rounded-xl tw-bg-[#D9D9D9]/50 tw-text-xl tw-text-[#666666]"
                                     aria-hidden="true">
                                    ★
                                </div>

                                <h3 class="tw-mt-4 tw-text-sm tw-font-semibold tw-text-[#111111]">
                                    No reviews yet
                                </h3>

                                <p class="tw-mt-1 tw-max-w-sm tw-text-sm tw-leading-6 tw-text-[#666666]">
                                    Be the first to share your experience and help the community make informed decisions.
                                </p>

                                <a href="#reviewForm"
                                   class="tw-mt-4 tw-text-sm tw-font-semibold tw-text-[#111111] tw-underline tw-decoration-[#06EBB6] tw-decoration-2 tw-underline-offset-4 hover:tw-text-[#666666]">
                                    Write the first review
                                </a>
                            </div>
                        @endforelse

                    </div>
                </div>
            </section>

            {{-- Right Column: Review Form --}}
            <aside class="tw-min-w-0 xl:tw-sticky xl:tw-top-6">

                <div class="tw-overflow-hidden tw-rounded-xl tw-border tw-border-[#C4C4C4]/70 tw-bg-white">

                    <div class="tw-border-b tw-border-[#C4C4C4]/60 tw-p-5 sm:tw-p-6">
                        <p class="tw-text-xs tw-font-semibold tw-uppercase tw-tracking-[0.12em] tw-text-[#666666]">
                            Your feedback
                        </p>

                        <h2 class="tw-mt-2 tw-text-lg tw-font-semibold tw-tracking-tight tw-text-[#111111]">
                            Write a review
                        </h2>

                        <p class="tw-mt-1 tw-text-sm tw-leading-6 tw-text-[#666666]">
                            Share your experience to help other members of the LotMatch community.
                        </p>
                    </div>

                    <div class="tw-p-5 sm:tw-p-6">

                        {{-- Submission Feedback --}}
                        <div id="reviewSuccessMsg"
                             class="tw-mb-4 tw-rounded-lg tw-border tw-border-[#06EBB6]/50 tw-bg-[#06EBB6]/10 tw-p-3 tw-text-sm tw-text-[#06100D]"
                             role="status"
                             aria-live="polite"
                             style="display: none;">
                        </div>

                        <form id="reviewForm"
                              action="{{ route('block.reviews.store') }}"
                              method="POST"
                              class="tw-space-y-5">
                            @csrf

                            {{-- Block Dropdown --}}
                            <div>
                                <label for="reviewBlockId"
                                       class="tw-mb-2 tw-block tw-text-sm tw-font-medium tw-text-[#111111]">
                                    Select block
                                    <span class="tw-text-red-600">*</span>
                                </label>

                                <select id="reviewBlockId"
                                        name="block_id"
                                        required
                                        class="tw-w-full tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-py-2.5 tw-text-sm tw-text-[#111111] tw-outline-none tw-transition focus:tw-border-[#06100D] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/40">
                                    <option value="">Choose a block</option>

                                    @foreach($blocks as $block)
                                        <option value="{{ $block->id }}"
                                            @selected(old('block_id') == $block->id)>
                                            {{ $block->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('block_id')
                                    <p class="tw-mt-1.5 tw-text-xs tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Rating --}}
                            <div>
                                <label for="reviewRating"
                                       class="tw-mb-2 tw-block tw-text-sm tw-font-medium tw-text-[#111111]">
                                    Your rating
                                    <span class="tw-text-red-600">*</span>
                                </label>

                                <select id="reviewRating"
                                        name="rating"
                                        required
                                        class="tw-w-full tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-py-2.5 tw-text-sm tw-text-[#111111] tw-outline-none tw-transition focus:tw-border-[#06100D] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/40">
                                    <option value="">Select a rating</option>

                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" @selected(old('rating') == $i)>
                                            {{ $i }} star{{ $i > 1 ? 's' : '' }}
                                        </option>
                                    @endfor
                                </select>

                                @error('rating')
                                    <p class="tw-mt-1.5 tw-text-xs tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Comment --}}
                            <div>
                                <label for="reviewComment"
                                       class="tw-mb-2 tw-block tw-text-sm tw-font-medium tw-text-[#111111]">
                                    Comment
                                    <span class="tw-font-normal tw-text-[#666666]">(optional)</span>
                                </label>

                                <textarea id="reviewComment"
                                          name="comment"
                                          rows="5"
                                          placeholder="What was your experience like?"
                                          class="tw-w-full tw-resize-y tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-py-3 tw-text-sm tw-leading-6 tw-text-[#111111] tw-outline-none tw-transition placeholder:tw-text-[#999999] focus:tw-border-[#06100D] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/40">{{ old('comment') }}</textarea>

                                @error('comment')
                                    <p class="tw-mt-1.5 tw-text-xs tw-text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Submit --}}
                            <button type="submit"
                                    class="tw-inline-flex tw-w-full tw-items-center tw-justify-center tw-gap-2 tw-rounded-lg tw-bg-[#06EBB6] tw-px-4 tw-py-3 tw-text-sm tw-font-semibold tw-text-[#06100D] tw-transition-colors hover:tw-bg-[#1ED9D7] focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06100D] focus-visible:tw-ring-offset-2">
                                Submit review
                                <span aria-hidden="true">→</span>
                            </button>

                            <p class="tw-text-center tw-text-xs tw-leading-5 tw-text-[#666666]">
                                Please keep your feedback constructive and respectful.
                            </p>
                        </form>
                    </div>
                </div>

                {{-- Supporting Information --}}
                <div class="tw-mt-4 tw-rounded-xl tw-border tw-border-[#C4C4C4]/70 tw-bg-white tw-p-4">
                    <div class="tw-flex tw-items-start tw-gap-3">
                        <div class="tw-flex tw-h-9 tw-w-9 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-lg tw-bg-[#06100D] tw-text-sm tw-font-semibold tw-text-[#06EBB6]">
                            i
                        </div>

                        <div>
                            <h3 class="tw-text-sm tw-font-semibold tw-text-[#111111]">
                                Help the community
                            </h3>
                            <p class="tw-mt-1 tw-text-xs tw-leading-5 tw-text-[#666666]">
                                Honest ratings and useful comments help others understand each block's community experience.
                            </p>
                        </div>
                    </div>
                </div>

            </aside>
        </div>

        {{-- Footer --}}
        <footer class="tw-py-6 tw-text-center tw-text-sm tw-text-gray-500 tw-mt-12">
        © 2025 LotMatch Interactive 3D Mapping with Forecasting Data Analytics. All rights reserved.
        </footer>

    </main>
@endsection

@section('scripts')
    @vite('resources/js/reviews.js')
    @vite('resources/js/smoothSticky.js')
@endsection
