@extends('layouts.app') {{-- Or your main layout --}}

@section('title', 'Analytics Dashboard')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Analytics Dashboard</h1>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="p-4 bg-green-100 rounded-xl shadow text-center">
            <h2 class="text-lg font-semibold">Total Blocks</h2>
            <p class="text-2xl font-bold">{{ $totalBlocks }}</p>
        </div>

        <div class="p-4 bg-blue-100 rounded-xl shadow text-center">
            <h2 class="text-lg font-semibold">Available Lots</h2>
            <p class="text-2xl font-bold">{{ $availableLots }}</p>
        </div>

        <div class="p-4 bg-yellow-100 rounded-xl shadow text-center">
            <h2 class="text-lg font-semibold">Reserved Lots</h2>
            <p class="text-2xl font-bold">{{ $reservedLots }}</p>
        </div>
    </div>

    {{-- Block Ratings --}}
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Block Ratings</h2>
        <table class="table-auto w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">Block Name</th>
                    <th class="px-4 py-2 border">Average Rating</th>
                    <th class="px-4 py-2 border">Total Reviews</th>
                </tr>
            </thead>
            <tbody>
                @foreach($blockRatings as $block)
                <tr>
                    <td class="px-4 py-2 border">{{ $block->name }}</td>
                    <td class="px-4 py-2 border">{{ number_format($block->avg_rating, 2) }}</td>
                    <td class="px-4 py-2 border">{{ $block->total_reviews }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Top Rated Lots --}}
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Top 5 Highest Rated Lots</h2>
        <ul class="list-disc pl-5">
            @foreach($topRatedLots as $lot)
            <li>Lot #{{ $lot->id }} - ₱{{ number_format($lot->price) }} - Avg Rating: {{ number_format($lot->avg_rating, 2) }}</li>
            @endforeach
        </ul>
    </div>

    {{-- Recent Reviews --}}
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Recent Reviews</h2>
        <ul class="list-disc pl-5">
            @foreach($recentReviews as $review)
            <li>{{ $review->user_name }} rated Lot #{{ $review->lot_id }} with {{ $review->rating }} stars</li>
            @endforeach
        </ul>
    </div>

    {{-- Rating Distribution --}}
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Rating Distribution</h2>
        <table class="table-auto w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">Rating</th>
                    <th class="px-4 py-2 border">Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ratingDistribution as $rating)
                <tr>
                    <td class="px-4 py-2 border">{{ $rating['rating'] }} stars</td>
                    <td class="px-4 py-2 border">{{ $rating['count'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
