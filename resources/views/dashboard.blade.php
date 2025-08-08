@extends('layouts.app')

@section('title', 'LotMatch Dashboard')

@section('content')
<div class="container mx-auto p-6">

  {{-- Welcome Section --}}
  <div class="mb-6">
    <h1 class="text-3xl font-bold mb-2">Welcome, {{ auth()->user()->name ?? 'Researcher' }}!</h1>
    <p class="text-gray-600">Here is the overview of Sameera Subdivision.</p>
  </div>

  {{-- Statistic Cards --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-10">
    <div class="bg-white shadow rounded-lg p-5 text-center">
      <div class="text-4xl font-semibold text-blue-600">{{ $totalBlocks }}</div>
      <div class="mt-2 text-gray-600">Total Blocks</div>
    </div>
    <div class="bg-white shadow rounded-lg p-5 text-center">
      <div class="text-4xl font-semibold text-green-600">{{ $totalLots }}</div>
      <div class="mt-2 text-gray-600">Total Lots</div>
    </div>
    <div class="bg-white shadow rounded-lg p-5 text-center">
      <div class="text-4xl font-semibold text-yellow-600">{{ number_format($avgRating, 1) }}/5</div>
      <div class="mt-2 text-gray-600">Average Rating</div>
    </div>
    <div class="bg-white shadow rounded-lg p-5 text-center">
      <div class="text-4xl font-semibold text-purple-600">{{ $newReviewsThisMonth }}</div>
      <div class="mt-2 text-gray-600">New Reviews This Month</div>
    </div>
  </div>

  {{-- Main Content Grid --}}
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Left: Map Preview --}}
    <div class="lg:col-span-2 bg-white shadow rounded-lg p-5 h-[800px]">
      <h2 class="text-xl font-semibold mb-4">3D Map Preview</h2>
      <div id="dashboard-map-container" class="border border-gray-300 rounded-md h-[640px] text-gray-400 overflow-hidden relative"></div>
    </div>

    {{-- Right: Analytics & Reviews --}}
    <div class="flex flex-col gap-6">

      {{-- Charts --}}
      <div class="bg-white shadow rounded-lg p-5">
        <h2 class="text-xl font-semibold mb-4">Ratings Distribution</h2>
        <canvas id="ratingsChart" height="200"></canvas>
      </div>

      {{-- Recent Reviews --}}
      <div class="bg-white shadow rounded-lg p-5">
        <h2 class="text-xl font-semibold mb-4">Recent Reviews</h2>
        <ul class="space-y-3 max-h-64 overflow-y-auto">
          @forelse ($recentReviews as $review)
            <li class="border-b border-gray-200 pb-2">
              <p class="font-medium">{{ $review->user_name ?? 'Anonymous' }}</p>
              <p class="text-gray-700">{{ Str::limit($review->comment, 100) }}</p>
              <p class="text-sm text-gray-500">Rating: {{ $review->rating ?? 'N/A' }}/5</p>
            </li>
          @empty
            <li class="text-gray-500">No recent reviews.</li>
          @endforelse
        </ul>
      </div>

    </div>
  </div>

  {{-- Quick Links Sidebar (ill think about this, at bottom for mobile) --}}
  <div class="mt-10">
    <h2 class="text-xl font-semibold mb-4">Quick Links</h2>
    <div class="flex flex-wrap gap-4">
      <a href="{{ route('properties.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Manage Properties</a>
      <a href="{{ route('map') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">View 3D Map</a>
      <a href="{{ route('reviews.index') }}" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition">View Reviews</a>
    </div>
  </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('ratingsChart').getContext('2d');

  const ratingsData = @json($ratingsDistribution);

  const labels = Object.keys(ratingsData);
  const data = Object.values(ratingsData);

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Number of Ratings',
        data: data,
        backgroundColor: 'rgba(59, 130, 246, 0.7)',
        borderColor: 'rgba(59, 130, 246, 1)',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          precision: 0
        }
      }
    }
  });
</script>
@vite('resources/js/dashboardMap.js')
@endsection
