@extends('layouts.app')

@section('title', 'LotMatch Dashboard')

@section('content')

<div class="lm-dashboard">
    <header class="lm-heading">
        <div>
            <span class="lm-eyebrow">Overview</span>
            <h1>Dashboard</h1>
            <p>Monitor your lots, ratings, and customer feedback.</p>
        </div>
    </header>

    {{-- Key metrics --}}
    <section class="lm-metrics" aria-label="Dashboard metrics">
        <article class="lm-metric">
            <div class="lm-metric-label">Total Blocks</div>
            <div class="lm-metric-value">
                {{ number_format($totalBlocks ?? 0) }}
            </div>
            <div class="lm-metric-note">Blocks across LotMatch</div>
        </article>

        <article class="lm-metric">
            <div class="lm-metric-label">Total Lots</div>
            <div class="lm-metric-value">
                {{ number_format($totalLots ?? 0) }}
            </div>
            <div class="lm-metric-note">Registered lots</div>
        </article>

        <article class="lm-metric">
            <div class="lm-metric-label">Average Rating</div>
            <div class="lm-metric-value">
                {{ number_format((float) ($avgRating ?? 0), 1) }}
                <span style="font-size: 17px; color: #D9A82E;">★</span>
            </div>
            <div class="lm-metric-note">
                <strong>{{ number_format($newReviewsThisMonth ?? 0) }}</strong>
                new reviews this month
            </div>
        </article>
    </section>

    {{-- Main dashboard --}}
    <div class="lm-dashboard-grid">
        <div class="lm-main-column">

            {{-- Rating analytics --}}
            <section class="lm-panel lm-panel-dark">
                <div class="lm-panel-header">
                    <div>
                        <h2 class="lm-panel-title">Ratings distribution</h2>
                        <p class="lm-panel-description">
                            Understand how customers rate their experience.
                        </p>
                    </div>
                </div>

                <div class="lm-rating-summary">
                    <span class="lm-rating-number">
                        {{ number_format((float) ($avgRating ?? 0), 1) }}
                    </span>
                    <div>
                        <div class="lm-stars" aria-label="Average rating">
                            ★★★★★
                        </div>
                        <div class="lm-rating-caption">
                            Average customer rating
                        </div>
                    </div>
                </div>

                <div class="lm-chart-container">
                    <canvas id="ratingsChart"
                            aria-label="Ratings distribution chart"></canvas>
                </div>
            </section>

            {{-- Recent reviews --}}
            <section class="lm-panel">
                <div class="lm-panel-header">
                    <div>
                        <h2 class="lm-panel-title">Recent Reviews</h2>
                        <p class="lm-panel-description">
                            The latest feedback from your customers.
                        </p>
                    </div>
                </div>

                <div class="lm-reviews-list">
                    @forelse ($recentReviews ?? [] as $review)
                        <article
                            class="lm-review"
                            id="review-{{ $review->id }}"
                            data-review-id="{{ $review->id }}"
                        >
                            <div class="lm-review-top">
                              <div class="lm-reviewer">
                                  <div class="lm-review-avatar" aria-hidden="true">
                                      {{ strtoupper(substr((string) ($review->user->first_name ?? 'U'), 0, 1)) }}
                                  </div>

                                  <div style="min-width: 0;">
                                      <div class="lm-reviewer-info">
                                          <div class="lm-reviewer-name">
                                              {{ trim(($review->user->first_name ?? '') . ' ' . ($review->user->last_name ?? '')) ?: 'Customer' }}
                                          </div>

                                          <span class="lm-review-block">
                                              → {{ $review->block->name ?? 'Unknown Block' }}
                                          </span>
                                      </div>

                                      <div class="lm-review-date">
                                          {{ $review->created_at?->format('M d, Y') ?? '' }}
                                      </div>
                                  </div>
                              </div>

                               <div class="lm-review-stars"
                                  aria-label="{{ (int) ($review->rating ?? 0) }} out of 5 stars">
                                  @for ($star = 1; $star <= 5; $star++)
                                      {{ $star <= (int) ($review->rating ?? 0) ? '★' : '☆' }}
                                  @endfor
                              </div>
                            </div>

                            <p class="lm-review-comment">
                                {{ $review->comment ?? '' }}
                            </p>

                            {{-- Preserve existing owner-specific review controls here. --}}
                            @if (!empty($ownerTag) || !empty($buttons))
                                <div class="lm-review-actions">
                                    {!! $ownerTag ?? '' !!}
                                    {!! $buttons ?? '' !!}
                                </div>
                            @endif
                        </article>
                    @empty
                        <div class="lm-empty-state">
                            <strong>No reviews yet</strong>
                            Customer reviews will appear here when available.
                        </div>
                    @endforelse
                </div>
            </section>
        </div>

        <aside class="lm-side-column">
            {{-- 3D House Preview --}}
            <section class="lm-panel lm-map-panel">

                <div class="lm-panel-header">
                    <div class="lm-preview-heading">
                        <div class="lm-preview-icon">
                            <i class="fas fa-house"></i>
                        </div>

                        <div>
                            <h2 class="lm-panel-title">House Preview</h2>
                            <p class="lm-panel-description">
                                Explore the property in 3D
                            </p>
                        </div>
                    </div>

                    <span class="lm-preview-badge">
                        3D VIEW
                    </span>
                </div>

                <div class="lm-map-viewport">
                    <div class="lm-preview-toolbar">
                        <span>INTERACTIVE MODEL</span>
                        <span class="lm-preview-ready">
                            <span class="lm-status-dot"></span>
                            Ready to explore
                        </span>
                    </div>

                    <div id="dashboard-map-container">
                        <div id="tooltiip">
                            <span id="tooltip-text"></span>
                        </div>
                    </div>

                    <div class="lm-preview-controls">
                        <span>
                            <i class="fas fa-arrows-alt"></i>
                            Drag to rotate
                        </span>
                    </div>
                </div>

                <div class="lm-map-caption">
                    <div>
                        <strong>Explore every angle</strong>
                        <p>Inspect the exterior from different perspectives.</p>
                    </div>

                    <i class="fas fa-cube"></i>
                </div>
            </section>
        </aside>
    </div>

    <!-- FOOTER -->
    <footer class="tw-py-6 tw-text-center tw-text-sm tw-text-gray-500 tw-mt-12">
      © 2025 LotMatch Interactive 3D Mapping with Forecasting Data Analytics. All rights reserved.
    </footer>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite('resources/js/dashboardMap.js')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const canvas = document.getElementById('ratingsChart');

            if (!canvas || typeof Chart === 'undefined') {
                return;
            }

            // Uses the existing controller-provided ratings data.
            const rawRatings = @json($ratingsDistribution ?? []);

            let labels = [];
            let values = [];

            if (Array.isArray(rawRatings)) {
                labels = rawRatings.map((item, index) =>
                    item.label ?? item.rating ?? `${index + 1}`
                );

                values = rawRatings.map(item =>
                    Number(item.count ?? item.total ?? item.value ?? 0)
                );
            } else if (rawRatings && typeof rawRatings === 'object') {
                labels = Object.keys(rawRatings);
                values = Object.values(rawRatings).map(Number);
            }

            const styles = getComputedStyle(document.documentElement);
            const mint = styles.getPropertyValue('--lm-mint').trim() || '#06EBB6';
            const teal = styles.getPropertyValue('--lm-teal').trim() || '#1ED9D7';

            Chart.defaults.color = '#A6B6B0';
            Chart.defaults.font.family = 'inherit';

            new Chart(canvas, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Reviews',
                        data: values,
                        backgroundColor: [
                            'rgba(6, 235, 182, 0.45)',
                            'rgba(30, 217, 215, 0.55)',
                            'rgba(6, 235, 182, 0.65)',
                            'rgba(30, 217, 215, 0.80)',
                            mint
                        ],
                        borderColor: [mint, teal, mint, teal, mint],
                        borderWidth: 1,
                        borderRadius: 5,
                        maxBarThickness: 42
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#111A16',
                            titleColor: '#FFFFFF',
                            bodyColor: '#D9E5DF',
                            borderColor: '#294238',
                            borderWidth: 1,
                            padding: 12,
                            displayColors: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                color: '#A6B6B0'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255,255,255,0.08)'
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                precision: 0,
                                color: '#A6B6B0'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection

