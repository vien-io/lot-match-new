@extends('layouts.app')

@section('title', 'Analytics Dashboard')

@section('content')
<div class="tw-flex tw-flex-col tw-gap-6 tw-p-6 tw-bg-gray-50 min-h-screen">

    {{-- Header --}}
    <div class="tw-text-center tw-mb-6">
        <h1 class="tw-text-3xl tw-font-bold tw-text-gray-800">Analytics Dashboard</h1>
        <p class="tw-text-gray-600">Overview of blocks, lots, ratings, and reviews.</p>
    </div>

    {{-- Top Row: Block Ratings Chart --}}
    <div class="tw-bg-white tw-rounded-3xl tw-shadow-md tw-p-6">
        <h2 class="tw-text-xl tw-font-semibold tw-mb-4">Block Ratings</h2>
        <div class="tw-h-80">
            <canvas id="ratingsChart" class="tw-w-full tw-h-full"></canvas>
        </div>
    </div>

    {{-- Row: Rating Distribution & Top Rated Lots --}}
    <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-2 tw-gap-6">

        {{-- Rating Distribution --}}
        <div class="tw-bg-white tw-rounded-3xl tw-shadow-md tw-p-6">
            <h2 class="tw-text-xl tw-font-semibold tw-mb-4">Rating Distribution</h2>
            <div class="tw-h-64">
                <canvas id="ratingDistributionChart" class="tw-w-full tw-h-full"></canvas>
            </div>
        </div>

        {{-- Top 5 Rated Lots --}}
        <div class="tw-bg-white tw-rounded-3xl tw-shadow-md tw-p-6">
            <h2 class="tw-text-xl tw-font-semibold tw-mb-4">Top 5 Highest Rated Lots</h2>
            <div class="tw-h-64">
                <canvas id="topRatedLotsChart" class="tw-w-full tw-h-full"></canvas>
            </div>
        </div>

    </div>

    {{-- Block Ratings Table --}}
    <div class="tw-flex tw-justify-center tw-mt-6">
        <div class="tw-bg-white tw-rounded-3xl tw-shadow-md tw-p-6 tw-w-1/2 tw-max-w-full">
            <h2 class="tw-text-xl tw-font-semibold tw-mb-4 tw-text-center">Block Ratings Analytics</h2>

            <div class="tw-max-h-96 tw-overflow-auto tw-border tw-border-gray-200 tw-rounded-lg">
                <table class="tw-w-full tw-table-auto tw-text-left">
                    <thead class="tw-bg-gray-100 tw-sticky tw-top-0">
                        <tr>
                            <th class="tw-px-4 tw-py-2">Block</th>
                            <th class="tw-px-4 tw-py-2">Average Rating</th>
                            <th class="tw-px-4 tw-py-2">Total Reviews</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($blockRatings as $row)
                        <tr class="tw-border-b hover:tw-bg-gray-50">
                            <td class="tw-px-4 tw-py-2">{{ $row->name }}</td>
                            <td class="tw-px-4 tw-py-2">{{ number_format($row->avg_rating, 1) }}</td>
                            <td class="tw-px-4 tw-py-2">{{ $row->total_reviews }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Lot Availability --}}
    <div class="tw-bg-white tw-rounded-3xl tw-shadow-md tw-p-6">
        <h2 class="tw-text-xl tw-font-semibold tw-mb-4">Lot Availability</h2>

        <div class="tw-mb-4">
            <div class="tw-flex tw-justify-between tw-text-sm tw-text-gray-600">
                <span>Available Lots</span>
                <span>{{ $availableLots }}</span>
            </div>
            <div class="tw-w-full tw-bg-gray-200 tw-rounded-full tw-h-3">
                <div class="tw-bg-green-500 tw-h-3 tw-rounded-full" 
                    style="width: {{ $totalLots ? ($availableLots / $totalLots) * 100 : 0 }}%">
                </div>
            </div>
        </div>

        <div>
            <div class="tw-flex tw-justify-between tw-text-sm tw-text-gray-600">
                <span>Sold Lots</span>
                <span>{{ $soldLots }}</span>
            </div>
            <div class="tw-w-full tw-bg-gray-200 tw-rounded-full tw-h-3">
                <div class="tw-bg-red-500 tw-h-3 tw-rounded-full" 
                    style="width: {{ $totalLots ? ($soldLots / $totalLots) * 100 : 0 }}%">
                </div>
            </div>
        </div>
    </div>

{{-- Top Rated Lots Cards --}}
<div class="tw-flex tw-flex-wrap tw-gap-6 tw-justify-center tw-mt-6">
    @foreach($topRatedLots as $lot)
    <div class="tw-bg-white tw-rounded-2xl tw-shadow-lg tw-p-6 tw-flex-1 tw-max-w-xs tw-transition tw-transform hover:tw-scale-105 hover:tw-shadow-2xl">
        <h3 class="tw-font-semibold tw-text-lg tw-mb-2">{{ $lot->name }}</h3>
        <p class="tw-text-gray-500 tw-mb-2">Price: ₱{{ number_format($lot->price, 0) }}</p>
        <div class="tw-flex tw-items-center tw-gap-2">
            <div class="tw-text-yellow-400">
                {!! str_repeat('★', round($lot->avg_rating)) !!}
                {!! str_repeat('☆', 5 - round($lot->avg_rating)) !!}
            </div>
            <span class="tw-text-gray-600 tw-text-sm">({{ number_format($lot->avg_rating, 1) }})</span>
        </div>
    </div>
    @endforeach
</div>


    {{-- Row: Recent Reviews --}}
    {{-- <div class="tw-bg-white tw-rounded-3xl tw-shadow-md tw-p-6">
        <h2 class="tw-text-xl tw-font-semibold tw-mb-4">Recent Reviews</h2>
        <ul class="tw-space-y-2 tw-max-h-64 tw-overflow-y-auto">
            @foreach($recentReviews as $review)
            <li class="tw-border-b tw-border-gray-200 tw-pb-2">
                <p class="tw-font-medium">{{ $review->user_name ?? 'Anonymous' }} - Lot #{{ $review->block_id }}</p>
                <p class="tw-text-sm tw-text-gray-700">Rating: {{ $review->rating }}/5</p>
            </li>
            @endforeach
        </ul>
    </div> --}}

    {{-- Hidden Data for Charts --}}
    <div id="ratings-data"
        data-block-labels='@json($blockRatings->pluck("name"))'
        data-block-ratings='@json($blockRatings->pluck("avg_rating"))'
        data-rating-labels='@json($ratingDistribution->pluck("rating"))'
        data-rating-counts='@json($ratingDistribution->pluck("count"))'
        data-block-reviews='@json($blockRatings->pluck("total_reviews"))'>
    </div>
    <div id="top-rated-data"
        data-lot-names='@json($topRatedLots->pluck("name"))'
        data-ratings='@json($topRatedLots->pluck("avg_rating"))'>
    </div>


</div>
@endsection

@section('scripts')
    {{-- @vite('resources/js/charts/analytics.js') --}}
@endsection
