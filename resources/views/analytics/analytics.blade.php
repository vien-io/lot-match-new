@extends('layouts.app')

@section('title', 'Analytics - LotMatch')

@push('styles')
    @vite('resources/css/pages/analytics/analytics.css')
@endpush

@section('content')
    <div class="tw-min-h-screen tw-bg-[#F5F7F6] tw-space-y-7">

        {{-- Page Header --}}
        <header class="lm-heading">
            <div>
                <span class="lm-eyebrow">LotMatch Analytics</span>
                <h1>Analytics overview</h1>
                <p>Monitor block performance, property availability, and resident feedback.</p>
            </div>
        </header>

        <div class="tw-grid tw-grid-cols-1 xl:tw-grid-cols-2 tw-gap-6">
            {{-- Left Column --}}
            <div class="tw-space-y-6">
                @include('analytics.partials.summary-metrics')
                @include('analytics.partials.lot-availability')
                @include('analytics.partials.pie-chart')
            </div>

            {{-- Right Column --}}
            <div>
                @include('analytics.partials.ratings-overview')
                @include('analytics.partials.ratings-table')
            </div>
        </div>


        {{-- Hidden Chart Data --}}
        <div id="ratings-data" data-block-ids='@json($blockRatings->pluck("id"))'
            data-block-labels='@json($blockRatings->pluck("name"))'
            data-block-ratings='@json($blockRatings->pluck("avg_rating"))'
            data-rating-labels='@json($ratingDistribution->pluck("rating"))'
            data-rating-counts='@json($ratingDistribution->pluck("count"))'
            data-block-reviews='@json($blockRatings->pluck("total_reviews"))'>
        </div>

        <div id="top-rated-blocks-data" data-block-names='@json($topRatedBlocks->pluck("name"))'
            data-block-rate='@json($topRatedBlocks->pluck("avg_rating"))'>
        </div>

    </div>
@endsection

@push('scripts')
    @vite('resources/js/pages/analytics/block-ratings-chart.js')
@endpush