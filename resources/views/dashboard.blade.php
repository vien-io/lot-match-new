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
                        <canvas id="ratingsChart" data-ratings='@json($ratingsDistribution ?? [])' aria-label="Ratings distribution chart"></canvas>
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
                            <article class="lm-review" id="review-{{ $review->id }}" data-review-id="{{ $review->id }}">
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
                                            </div>

                                            <div class="lm-reviewer-head">
                                                <span class="lm-review-date">
                                                    {{ $review->created_at?->format('M d, Y') ?? '' }}
                                                </span>
                                                <span
                                                    class="tw-inline-block tw-h-[4px] tw-w-[4px] tw-rounded-full tw-bg-current tw-align-middle tw-text-[#D3D3D3]"></span>
                                                <span class="lm-review-block">
                                                    {{ $review->block->name ?? 'Unknown Block' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tw-flex tw-flex-col tw-items-start">
                                        <div class="lm-review-stars"
                                            aria-label="{{ (int) ($review->rating ?? 0) }} out of 5 stars">
                                            @for ($star = 1; $star <= 5; $star++)
                                                {{ $star <= (int) ($review->rating ?? 0) ? '★' : '☆' }}
                                            @endfor
                                        </div>

                                        <span class="tw-mt-1 tw-text-[11px] tw-text-gray-500">
                                            {{ (int) ($review->rating ?? 0) }} out of 5
                                        </span>
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
                            <div id="map-loading" class="lm-map-loading">
                                <div class="lm-loading-spinner"></div>
                                <span>Loading 3D preview...</span>
                            </div>

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

        {{-- Footer --}}
        <footer class="tw-pt-2 tw-text-center tw-text-xs tw-leading-5 tw-text-[#666666]">
            © {{ date('Y') }} LotMatch Interactive 3D Mapping with Forecasting Data Analytics. All rights reserved.
        </footer>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite([
        'resources/js/pages/dashboard/dashboardMap.js',
        'resources/js/pages/dashboard/dashboard.js'
    ])
    
@endsection