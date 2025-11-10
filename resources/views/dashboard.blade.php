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
        <h2 class="tw-text-xl tw-font-semibold tw-mb-4 tw-text-gray-800">3D Model Preview</h2>
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
          <ul class="tw-space-y-4 tw-max-h-64 tw-overflow-y-auto">
            @forelse ($recentReviews as $review)
              <li class="tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-p-4 tw-shadow-sm" data-review-id="{{ $review->id }}">
                <div class="tw-flex tw-items-center tw-justify-between">
                  <div class="tw-flex tw-items-center tw.space-x-2">
                    <strong class="tw-text-gray-800">
                      {{ $review->user->name ?? 'Anonymous' }}
                    </strong>
                    <span class="tw-text-gray-500">→ {{ $review->block->name ?? 'Unknown Block' }}</span>
                    {!! $ownerTag ?? '' !!}
                  </div>
                  <div class="tw-flex tw-space-x-1">
                    @php
                      $rating = $review->rating ?? 0;
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                      @if ($i <= $rating)
                        {{-- Filled star --}}
                        <svg class="tw-w-4 tw-h-4 tw-text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.962a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.962c.3.922-.755 1.688-1.54 1.118l-3.37-2.447a1 1 0 00-1.176 0l-3.37 2.447c-.784.57-1.838-.196-1.539-1.118l1.286-3.962a1 1 0 00-.364-1.118L2.064 9.39c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.285-3.962z"/>
                        </svg>
                      @else
                        {{-- Empty star --}}
                        <svg class="tw-w-4 tw-h-4 tw-text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.962a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.962c.3.922-.755 1.688-1.54 1.118l-3.37-2.447a1 1 0 00-1.176 0l-3.37 2.447c-.784.57-1.838-.196-1.539-1.118l1.286-3.962a1 1 0 00-.364-1.118L2.064 9.39c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.285-3.962z"/>
                        </svg>
                      @endif
                    @endfor
                  </div>
                </div>

                <p class="tw-text-gray-700 tw-mt-2">{{ Str::limit($review->comment, 200) }}</p>

                <div class="tw-flex tw-items-center tw-justify-between tw-mt-3">
                  <small class="tw-text-gray-500">
                    {{ \Carbon\Carbon::parse($review->created_at)->format('M d, Y h:i A') }}
                  </small>
                  {!! $buttons ?? '' !!}
                </div>
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
