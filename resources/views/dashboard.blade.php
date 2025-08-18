@extends('layouts.app')

@section('title', 'LotMatch Dashboard')

@section('content')
<div class="tw-bg-gradient-to-br tw-from-green-50 tw-to-white tw-min-h-screen tw-flex">


  {{-- Main Content --}}
  <div class="tw-flex-1 tw-p-8">

  {{-- Welcome Section --}}
  <div class="tw-mb-8">
    <h1 class="tw-text-3xl tw-font-bold tw-text-gray-800">Welcome, {{ auth()->user()->name ?? 'Researcher' }}!</h1>
    <p class="tw-text-gray-600">Here is the overview of Sameera Subdivision.</p>
  </div>

  {{-- Statistic Cards --}}
  <div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 md:tw-grid-cols-4 tw-gap-6 tw-mb-10">

  {{-- Total Blocks (Blue) --}}
  <div class="tw-bg-white tw-rounded-2xl tw-shadow-md tw-p-6 tw-text-center
              tw-border tw-border-transparent tw-transition-all tw-duration-300 hover:tw-scale-105 hover:tw-shadow-lg hover:tw-border-blue-400">
    <div class="tw-text-4xl tw-font-semibold tw-text-blue-500">{{ $totalBlocks }}</div>
    <div class="tw-text-gray-500 tw-mt-2">Total Blocks</div>
  </div>

  {{-- Total Lots (Green) --}}
  <div class="tw-bg-white tw-rounded-2xl tw-shadow-md tw-p-6 tw-text-center
              tw-border tw-border-transparent tw-transition-all tw-duration-300 hover:tw-scale-105 hover:tw-shadow-lg hover:tw-border-green-400">
    <div class="tw-text-4xl tw-font-semibold tw-text-green-500">{{ $totalLots }}</div>
    <div class="tw-text-gray-500 tw-mt-2">Total Lots</div>
  </div>

  {{-- Average Rating (Yellow) --}}
  <div class="tw-bg-white tw-rounded-2xl tw-shadow-md tw-p-6 tw-text-center
              tw-border tw-border-transparent tw-transition-all tw-duration-300 hover:tw-scale-105 hover:tw-shadow-lg hover:tw-border-yellow-400">
    <div class="tw-text-4xl tw-font-semibold tw-text-yellow-500">{{ number_format($avgRating, 1) }}/5</div>
    <div class="tw-text-gray-500 tw-mt-2">Average Rating</div>
  </div>

  {{-- New Reviews (Purple) --}}
  <div class="tw-bg-white tw-rounded-2xl tw-shadow-md tw-p-6 tw-text-center
              tw-border tw-border-transparent tw-transition-all tw-duration-300 hover:tw-scale-105 hover:tw-shadow-lg hover:tw-border-purple-400">
    <div class="tw-text-4xl tw-font-semibold tw-text-purple-500">{{ $newReviewsThisMonth }}</div>
    <div class="tw-text-gray-500 tw-mt-2">New Reviews This Month</div>
  </div>

</div>


    {{-- Main Content Grid --}}
    <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-3 tw-gap-6">

      {{-- Left: Map Preview --}}
      <div class="lg:tw-col-span-2 tw-bg-white tw-rounded-2xl tw-shadow-md tw-p-6 tw-h-[800px]">
        <h2 class="tw-text-xl tw-font-semibold tw-mb-4 tw-text-gray-800">3D Map Preview</h2>
        <div id="dashboard-map-container" 
          class="tw-border tw-border-gray-200 tw-rounded-lg tw-h-[640px] tw-bg-gray-50 tw-overflow-hidden tw-relative">
          <div id="tooltiip">
            <span id="tooltip-text"></span>
          </div>
        </div>
      </div>

      {{-- Right: Analytics & Reviews --}}
      <div class="tw-flex tw-flex-col tw-gap-6">

        {{-- Ratings Chart --}}
        <div class="tw-bg-white tw-rounded-2xl tw-shadow-md tw-p-6">
          <h2 class="tw-text-xl tw-font-semibold tw-mb-4 tw-text-gray-800">Ratings Distribution</h2>
          <div style="width: 100%; height: 300px;">
            <canvas id="ratingsChart" height="200"></canvas>
          </div>
        </div>

        {{-- Recent Reviews --}}
        <div class="tw-bg-white tw-rounded-2xl tw-shadow-md tw-p-6">
          <h2 class="tw-text-xl tw-font-semibold tw-mb-4 tw-text-gray-800">Recent Reviews</h2>
          <ul class="tw-space-y-3 tw-max-h-64 tw-overflow-y-auto">
            @forelse ($recentReviews as $review)
              <li class="tw-border-b tw-border-gray-200 tw-pb-2">
                <p class="tw-font-medium">{{ $review->user_name ?? 'Anonymous' }}</p>
                <p class="tw-text-gray-700">{{ Str::limit($review->comment, 100) }}</p>
                <p class="tw-text-sm tw-text-gray-500">Rating: {{ $review->rating ?? 'N/A' }}/5</p>
              </li>
            @empty
              <li class="tw-text-gray-500">No recent reviews.</li>
            @endforelse
          </ul>
        </div>

      </div>
    </div>

  </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('ratingsChart').getContext('2d');

  const gradient = ctx.createLinearGradient(0, 0, 0, 300);
  gradient.addColorStop(0, 'rgba(34, 197, 94, 0.8)');
  gradient.addColorStop(1, 'rgba(34, 197, 94, 0.3)');

  const ratingsData = @json($ratingsDistribution);
  const labels = Object.keys(ratingsData);
  const data = Object.values(ratingsData);

  let delayed; 

  setTimeout(() => {
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: 'Number of Ratings',
          data: data,
          backgroundColor: gradient,
          borderColor: 'rgba(34, 197, 94, 1)',
          borderWidth: 1,
          borderRadius: {topLeft: 10, topRight: 10, bottomLeft: 2, bottomRight: 2},
          maxBarThickness: 40,
          hoverBackgroundColor: 'rgba(34, 197, 94, 1)',
          hoverBorderColor: 'rgba(64, 184, 108, 1)',
          hoverBorderWidth: 2,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
          duration: 1000,
          easing: 'easeOutQuart',
          onComplete: () => {
            delayed = true;
          },
          delay: (context) => {
            let delay = 0;
            if (context.type === 'data' && context.mode === 'default' && !delayed) {
              delay = context.dataIndex * 300 + context.datasetIndex * 100; 
            }
            return delay;
          }
        },
        scales: {
          x: {
            ticks: { color: '#334155', font: { family: "'Nunito', sans-serif", weight: '600', size: 14 } },
            grid: { display: false },
          },
          y: {
            beginAtZero: true,
            precision: 0,
            ticks: { color: '#334155', font: { family: "'Nunito', sans-serif", weight: '600', size: 14 } },
            grid: { color: 'rgba(148, 163, 184, 0.3)', drawBorder: false, borderDash: [5, 5] }
          }
        },
        plugins: {
          title: {
            display: true,
            text: 'Ratings Distribution Overview',
            color: '#166534',
            font: { family: "'Nunito', sans-serif", size: 18, weight: '700' },
            padding: { top: 10, bottom: 20 }
          },
          legend: {
            display: true,
            labels: { color: '#334155', font: { family: "'Nunito', sans-serif", size: 14, weight: '600' } }
          },
          tooltip: {
            backgroundColor: 'rgba(34, 197, 94, 0.9)',
            titleFont: { family: "'Nunito', sans-serif", size: 16, weight: '700' },
            bodyFont: { family: "'Nunito', sans-serif", size: 14 },
            padding: 10,
            cornerRadius: 6,
            callbacks: {
              label: ctx => `Count: ${ctx.parsed.y}`,
              title: ctx => `Rating: ${ctx[0].label}`
            }
          }
        }
      },
      plugins: [{
        id: 'barShadow',
        beforeDatasetDraw(chart) {
          const ctx = chart.ctx;
          ctx.save();
          ctx.shadowColor = 'rgba(0,0,0,0.15)';
          ctx.shadowBlur = 10;
          ctx.shadowOffsetX = 0;
          ctx.shadowOffsetY = 4;
        },
        afterDatasetDraw(chart) {
          chart.ctx.restore();
        }
      }]
    });
  }, 1200);
  
</script>

@vite('resources/js/dashboardMap.js')
@endsection
