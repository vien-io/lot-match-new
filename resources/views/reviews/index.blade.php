@extends('layouts.app')

@section('title', 'Reviews & Ratings')

@section('content')
<div class="tw-flex tw-flex-col lg:tw-flex-row tw-gap-8 tw-mt-12 tw-px-6">

  {{-- Left Column: Community Reviews --}}
  <div class="tw-flex-1 tw-bg-white tw-rounded-3xl tw-shadow-md tw-p-6">
    <h1 class="tw-text-2xl tw-font-bold tw-mb-6">Community Reviews</h1>



    {{-- Block Selector --}}
    <div class="tw-mb-4">
        <label class="tw-block tw-font-semibold">Select Block</label>
        <select id="blockSelector" class="tw-border tw-rounded tw-p-2 tw-w-full">
            <option value="">All Blocks</option>
            @foreach($blocks as $block)
                <option value="{{ $block->id }}">{{ $block->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Average Rating Display --}}
    <div id="averageRatingDisplay" class="tw-text-center tw-mb-4">
        <h1 id="averageRating" class="tw-text-4xl tw-font-bold tw-text-[#1f2937]">{{ number_format($averageRating,1) }}</h1>
        <div id="averageStars" class="tw-flex tw-justify-center tw-text-yellow-400 tw-mt-1">
            {!! str_repeat('★', round($averageRating)) !!}
            {!! str_repeat('☆', 5 - round($averageRating)) !!}
        </div>
        <p id="totalReviews" class="tw-text-gray-500 tw-text-sm tw-mt-1">
            Based on {{ $reviews->count() }} reviews
        </p>
    </div>

    {{-- Progress Bars --}}
    <div class="tw-mb-6 tw-space-y-2">
      @foreach($ratingCounts as $label => $count)
        @php
          $percentage = $reviews->count() ? ($count / $reviews->count()) * 100 : 0;
        @endphp
        <div class="tw-flex tw-items-center tw-justify-between tw-text-sm tw-text-gray-600">
          <span class="tw-w-20">{{ $label }}</span>
          <div class="tw-flex-1 tw-mx-2 tw-bg-gray-200 tw-rounded-full tw-h-2">
            <div class="tw-bg-[#22c55e] tw-h-2 tw-rounded-full" style="width: {{ $percentage }}%;"></div>
          </div>
          <span class="tw-w-10 tw-text-right tw-text-gray-700">{{ $count }}</span>
        </div>
      @endforeach
    </div>

    {{-- Reviews --}}
    <div id="reviewsContainer" class="tw-space-y-4">
        @foreach ($reviews as $review)
        <div class="tw-flex tw-gap-3">
            <img src="{{ $review->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name ?? 'Deleted Iser') . '&background=34d399&color=fff&rounded=true' }}" 
                class="tw-w-10 tw-h-10 tw-rounded-full" alt="user">
            <div>
                <h3 class="tw-font-semibold tw-text-sm tw-text-[#1f2937]">
                    {{ $review->user->name ?? 'Deleted User'}} &rarr; {{ $review->block->name ?? 'Unknown Block' }}
                </h3>
                <div class="tw-flex tw-text-yellow-400 tw-text-xs">
                    {!! str_repeat('★', $review->rating) !!}{!! str_repeat('☆', 5 - $review->rating) !!}
                </div>
                <p class="tw-text-xs tw-text-gray-500 tw-mt-1">{{ $review->comment ?? 'No comment' }}</p>
                <span class="tw-text-gray-400 tw-text-xs">{{ $review->created_at->format('n/j/Y, g:i A') }}</span>
            </div>
        </div>
        @endforeach

    </div>

  </div>

  {{-- Right Column: Write a Review Form --}}
  <div class="tw-w-full lg:tw-w-96 tw-bg-white tw-rounded-3xl tw-shadow-md tw-p-6">
    <div id="reviewSuccessMsg" class="tw-mb-2 tw-text-green-600" style="display: none;"></div>
    <h2 class="tw-font-bold tw-mb-4">Write a Review</h2>
    <form id="reviewForm" action="{{ route('block.reviews.store') }}" method="POST">
        @csrf

        {{-- Block Dropdown --}}
        <div class="tw-mb-2">
            <label class="tw-block tw-font-semibold">Select Block</label>
            <select name="block_id" class="tw-border tw-rounded tw-p-2 tw-w-full" required>
                <option value="">Choose a block</option>
                @foreach($blocks as $block)
                    <option value="{{ $block->id }}">{{ $block->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Rating --}}
        <div class="tw-mb-2">
            <label class="tw-block tw-font-semibold">Rating</label>
            <select name="rating" class="tw-border tw-rounded tw-p-2 tw-w-full" required>
                <option value="">Select rating</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                @endfor
            </select>
        </div>

        {{-- Comment --}}
        <div class="tw-mb-2">
            <label class="tw-block tw-font-semibold">Comment</label>
            <textarea name="comment" rows="3" class="tw-border tw-rounded tw-p-2 tw-w-full" placeholder="Write your comment..."></textarea>
        </div>

        <button type="submit" class="tw-bg-green-500 tw-text-white tw-rounded tw-px-4 tw-py-2 hover:tw-bg-green-600">
            Submit Review
        </button>
    </form>
  </div>


</div>
@endsection

@section('scripts')
    @vite('resources/js/reviews.js')
@endsection