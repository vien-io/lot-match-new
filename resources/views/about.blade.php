{{-- resources/views/about.blade.php --}}
@extends('layouts.app')

@section('title', 'Technical Documentation')

@section('content')
    <div class="tw-mx-auto tw-w-full tw-max-w-[1400px]">

        {{-- Page Header --}}
        <header class="lm-heading">
            <div>
                <span class="lm-eyebrow">System / Documentation</span>
                <h1>Technical Documentation</h1>
                <p>System architecture, technical implementation, data processing, and platform overview.</p>
            </div>
        </header>

        {{-- Documentation Container --}}
        <div class="tw-overflow-hidden tw-rounded-xl tw-border tw-border-[#C4C4C4]/60 tw-bg-white tw-shadow-sm">

            {{-- Document Header --}}
            <div class="tw-border-b tw-border-[#C4C4C4]/50 tw-bg-white tw-p-6 sm:tw-px-8 sm:tw-py-7">
                <div class="tw-flex tw-items-start tw-gap-4">
                    <div
                        class="tw-flex tw-h-12 tw-w-12 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-xl tw-bg-[#06EBB6]/15">
                        <svg class="tw-h-6 tw-w-6 tw-text-[#087B60]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5l5 5v11a2 2 0 01-2 2z" />
                        </svg>
                    </div>

                    <div class="tw-min-w-0">
                        <h2 class="tw-text-lg tw-font-bold tw-text-[#111111]">
                            LotMatch System Overview
                        </h2>
                        <p class="tw-mt-1 tw-text-sm tw-leading-relaxed tw-text-[#666666]">
                            A technical reference covering the platform's architecture, visualization engine, analytics, and
                            processing workflows.
                        </p>

                        <div class="tw-mt-3 tw-flex tw-flex-wrap tw-items-center tw-gap-2">
                            <span
                                class="tw-rounded-md tw-bg-[#F3F5F4] tw-px-2.5 tw-py-1 tw-text-[11px] tw-font-semibold tw-text-[#555555]">
                                Technical Reference
                            </span>
                            <span
                                class="tw-rounded-md tw-bg-[#06EBB6]/15 tw-px-2.5 tw-py-1 tw-text-[11px] tw-font-semibold tw-text-[#087B60]">
                                LotMatch
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Document Content --}}
            <div class="tw-p-6 sm:tw-p-8">

                {{-- System Overview --}}
                <section class="tw-mb-8">
                    <div class="tw-mb-4 tw-flex tw-items-center tw-gap-3">
                        <span
                            class="tw-flex tw-h-8 tw-w-8 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-lg tw-bg-[#06EBB6]/15 tw-text-sm tw-font-bold tw-text-[#087B60]">01</span>
                        <h2 class="tw-text-lg tw-font-bold tw-text-[#111111]">
                            System Overview
                        </h2>
                    </div>

                    <div class="tw-pl-0 sm:tw-pl-11">
                        <p class="tw-text-sm tw-leading-7 tw-text-[#555555]">
                            <strong class="tw-font-semibold tw-text-[#111111]">LotMatch</strong> is a web-based real estate
                            analytics platform designed to visualize subdivision data in
                            <strong class="tw-text-[#111111]">3D</strong>, collect <strong class="tw-text-[#111111]">user
                                reviews</strong>, and generate
                            <strong class="tw-text-[#111111]">AI-powered insights</strong> such as sentiment analysis and
                            forecasted property ratings.
                            It unifies interactive visualization, data analytics, and AI processing into a seamless
                            environment for researchers, property developers, and managers.
                        </p>

                        <div class="tw-mt-4 tw-grid tw-grid-cols-1 tw-gap-3 sm:tw-grid-cols-2">
                            <div class="tw-rounded-lg tw-border tw-border-[#C4C4C4]/50 tw-bg-[#F8F9F9] tw-p-4">
                                <p class="tw-text-xs tw-font-semibold tw-text-[#111111]">3D Visualization</p>
                                <p class="tw-mt-1 tw-text-xs tw-text-[#666666]">Interactive property visualization using
                                    Three.js.</p>
                            </div>
                            <div class="tw-rounded-lg tw-border tw-border-[#C4C4C4]/50 tw-bg-[#F8F9F9] tw-p-4">
                                <p class="tw-text-xs tw-font-semibold tw-text-[#111111]">Sentiment Analysis</p>
                                <p class="tw-mt-1 tw-text-xs tw-text-[#666666]">AI-driven analysis of user-submitted
                                    reviews.</p>
                            </div>
                            <div class="tw-rounded-lg tw-border tw-border-[#C4C4C4]/50 tw-bg-[#F8F9F9] tw-p-4">
                                <p class="tw-text-xs tw-font-semibold tw-text-[#111111]">Forecasting</p>
                                <p class="tw-mt-1 tw-text-xs tw-text-[#666666]">Exponential Moving Average (EMA) property
                                    rating forecasts.</p>
                            </div>
                            <div class="tw-rounded-lg tw-border tw-border-[#C4C4C4]/50 tw-bg-[#F8F9F9] tw-p-4">
                                <p class="tw-text-xs tw-font-semibold tw-text-[#111111]">Data Analytics</p>
                                <p class="tw-mt-1 tw-text-xs tw-text-[#666666]">Dynamic charts and summaries through
                                    Chart.js.</p>
                            </div>
                        </div>

                        <ul class="tw-mt-4 tw-space-y-2 tw-text-sm tw-text-[#555555]">
                            <li class="tw-flex tw-items-start tw-gap-2">
                                <span
                                    class="tw-mt-1.5 tw-h-1.5 tw-w-1.5 tw-shrink-0 tw-rounded-full tw-bg-[#06EBB6]"></span>
                                Responsive TailwindCSS interface with Laravel Blade templates.
                            </li>
                            <li class="tw-flex tw-items-start tw-gap-2">
                                <span
                                    class="tw-mt-1.5 tw-h-1.5 tw-w-1.5 tw-shrink-0 tw-rounded-full tw-bg-[#06EBB6]"></span>
                                Asynchronous background processing through Laravel Jobs.
                            </li>
                        </ul>
                    </div>
                </section>

                <div class="tw-mb-8 tw-border-t tw-border-[#C4C4C4]/40"></div>

                {{-- 3D Visualization --}}
                <section class="tw-mb-8">
                    <div class="tw-mb-4 tw-flex tw-items-center tw-gap-3">
                        <span
                            class="tw-flex tw-h-8 tw-w-8 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-lg tw-bg-[#06EBB6]/15 tw-text-sm tw-font-bold tw-text-[#087B60]">02</span>
                        <h2 class="tw-text-lg tw-font-bold tw-text-[#111111]">
                            3D Visualization & Interaction
                        </h2>
                    </div>

                    <div class="tw-pl-0 sm:tw-pl-11">
                        <p class="tw-text-sm tw-leading-7 tw-text-[#555555]">
                            The platform leverages <strong class="tw-text-[#111111]">Three.js</strong> to render interactive
                            3D scenes of blocks and individual lots.
                            Users can pan, zoom, and rotate the camera with intuitive controls. Each property is represented
                            as a
                            Level-of-Detail (LOD) 3D model to ensure smooth performance even for large subdivisions.
                            Hovering over houses or blocks highlights them, displays tooltips, and allows selection for
                            detailed views.
                            Modal popups provide detailed 3D previews, AI summaries, user reviews, and forecast data.
                        </p>

                        <p class="tw-mt-3 tw-text-sm tw-leading-7 tw-text-[#555555]">
                            Interactive features include real-time highlighting via <strong
                                class="tw-text-[#111111]">raycasting</strong>,
                            dynamic modal loading for lot/block details, AI forecast overlays, and responsive chart
                            rendering.
                        </p>
                    </div>
                </section>

                <div class="tw-mb-8 tw-border-t tw-border-[#C4C4C4]/40"></div>

                {{-- Data Flow --}}
                <section class="tw-mb-8">
                    <div class="tw-mb-4 tw-flex tw-items-center tw-gap-3">
                        <span
                            class="tw-flex tw-h-8 tw-w-8 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-lg tw-bg-[#06EBB6]/15 tw-text-sm tw-font-bold tw-text-[#087B60]">03</span>
                        <h2 class="tw-text-lg tw-font-bold tw-text-[#111111]">
                            Data Flow
                        </h2>
                    </div>

                    <div class="tw-pl-0 sm:tw-pl-11">
                        <p class="tw-mb-4 tw-text-sm tw-leading-7 tw-text-[#555555]">
                            The system processes and visualizes data through several coordinated steps:
                        </p>

                        <div class="tw-space-y-3">
                            <div class="tw-flex tw-gap-3">
                                <span
                                    class="tw-flex tw-h-7 tw-w-7 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-lg tw-bg-[#F3F5F4] tw-text-xs tw-font-semibold tw-text-[#087B60]">1</span>
                                <p class="tw-pt-1 tw-text-sm tw-leading-6 tw-text-[#555555]">Users submit reviews and
                                    ratings through interactive 3D map modals.</p>
                            </div>
                            <div class="tw-flex tw-gap-3">
                                <span
                                    class="tw-flex tw-h-7 tw-w-7 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-lg tw-bg-[#F3F5F4] tw-text-xs tw-font-semibold tw-text-[#087B60]">2</span>
                                <p class="tw-pt-1 tw-text-sm tw-leading-6 tw-text-[#555555]"><strong
                                        class="tw-text-[#111111]">ReviewController</strong> handles creation, updating, and
                                    deletion of reviews.</p>
                            </div>
                            <div class="tw-flex tw-gap-3">
                                <span
                                    class="tw-flex tw-h-7 tw-w-7 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-lg tw-bg-[#F3F5F4] tw-text-xs tw-font-semibold tw-text-[#087B60]">3</span>
                                <p class="tw-pt-1 tw-text-sm tw-leading-6 tw-text-[#555555]"><strong
                                        class="tw-text-[#111111]">AnalyzeSentimentJob</strong> classifies user comments
                                    using NLP models from Hugging Face.</p>
                            </div>
                            <div class="tw-flex tw-gap-3">
                                <span
                                    class="tw-flex tw-h-7 tw-w-7 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-lg tw-bg-[#F3F5F4] tw-text-xs tw-font-semibold tw-text-[#087B60]">4</span>
                                <p class="tw-pt-1 tw-text-sm tw-leading-6 tw-text-[#555555]"><strong
                                        class="tw-text-[#111111]">GenerateBlockSummaryJob</strong> aggregates reviews and
                                    generates AI-based natural language summaries.</p>
                            </div>
                            <div class="tw-flex tw-gap-3">
                                <span
                                    class="tw-flex tw-h-7 tw-w-7 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-lg tw-bg-[#F3F5F4] tw-text-xs tw-font-semibold tw-text-[#087B60]">5</span>
                                <p class="tw-pt-1 tw-text-sm tw-leading-6 tw-text-[#555555]"><strong
                                        class="tw-text-[#111111]">ForecastController</strong> computes Exponential Moving
                                    Average (EMA) scores and produces trend charts.</p>
                            </div>
                            <div class="tw-flex tw-gap-3">
                                <span
                                    class="tw-flex tw-h-7 tw-w-7 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-lg tw-bg-[#F3F5F4] tw-text-xs tw-font-semibold tw-text-[#087B60]">6</span>
                                <p class="tw-pt-1 tw-text-sm tw-leading-6 tw-text-[#555555]">The front-end dynamically
                                    updates 3D modals, summaries, and forecast charts in real time.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="tw-mb-8 tw-border-t tw-border-[#C4C4C4]/40"></div>

                {{-- Algorithms --}}
                <section class="tw-mb-8">
                    <div class="tw-mb-4 tw-flex tw-items-center tw-gap-3">
                        <span
                            class="tw-flex tw-h-8 tw-w-8 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-lg tw-bg-[#06EBB6]/15 tw-text-sm tw-font-bold tw-text-[#087B60]">04</span>
                        <h2 class="tw-text-lg tw-font-bold tw-text-[#111111]">
                            Algorithms & Processing
                        </h2>
                    </div>

                    <div class="tw-pl-0 sm:tw-pl-11">
                        <div class="tw-overflow-hidden tw-rounded-lg tw-border tw-border-[#C4C4C4]/50">
                            <div class="tw-divide-y tw-divide-[#C4C4C4]/40">
                                <div class="tw-p-4">
                                    <h3 class="tw-text-sm tw-font-semibold tw-text-[#111111]">Exponential Moving Average
                                        (EMA)</h3>
                                    <p class="tw-mt-1 tw-text-sm tw-leading-6 tw-text-[#666666]">Smooths historical ratings
                                        to forecast block performance trends.</p>
                                </div>
                                <div class="tw-p-4">
                                    <h3 class="tw-text-sm tw-font-semibold tw-text-[#111111]">Sentiment Analysis</h3>
                                    <p class="tw-mt-1 tw-text-sm tw-leading-6 tw-text-[#666666]">NLP models classify user
                                        reviews as positive, neutral, or negative.</p>
                                </div>
                                <div class="tw-p-4">
                                    <h3 class="tw-text-sm tw-font-semibold tw-text-[#111111]">Data Aggregation</h3>
                                    <p class="tw-mt-1 tw-text-sm tw-leading-6 tw-text-[#666666]">Background jobs consolidate
                                        ratings and sentiments into AI-generated summaries.</p>
                                </div>
                                <div class="tw-p-4">
                                    <h3 class="tw-text-sm tw-font-semibold tw-text-[#111111]">Forecast Visualization</h3>
                                    <p class="tw-mt-1 tw-text-sm tw-leading-6 tw-text-[#666666]">Chart.js displays
                                        historical and forecasted scores, highlighting predicted trends.</p>
                                </div>
                                <div class="tw-p-4">
                                    <h3 class="tw-text-sm tw-font-semibold tw-text-[#111111]">3D Interaction Logic</h3>
                                    <p class="tw-mt-1 tw-text-sm tw-leading-6 tw-text-[#666666]">Raycasting detects
                                        hover/click events on properties to trigger visual feedback and modals.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="tw-mb-8 tw-border-t tw-border-[#C4C4C4]/40"></div>

                {{-- Architecture --}}
                <section class="tw-mb-8">
                    <div class="tw-mb-4 tw-flex tw-items-center tw-gap-3">
                        <span
                            class="tw-flex tw-h-8 tw-w-8 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-lg tw-bg-[#06EBB6]/15 tw-text-sm tw-font-bold tw-text-[#087B60]">05</span>
                        <h2 class="tw-text-lg tw-font-bold tw-text-[#111111]">
                            System Architecture
                        </h2>
                    </div>

                    <div class="tw-pl-0 sm:tw-pl-11">
                        <p class="tw-text-sm tw-leading-7 tw-text-[#555555]">
                            Built on the <strong class="tw-text-[#111111]">Laravel</strong> framework, the system follows an
                            MVC structure and modular design.
                            Eloquent models manage data persistence, while Blade templates and TailwindCSS power the
                            responsive interface.
                            Asynchronous Jobs handle intensive operations like AI sentiment analysis and forecast
                            calculations,
                            maintaining a responsive user experience.
                        </p>

                        <div class="tw-mt-5 tw-grid tw-grid-cols-1 tw-gap-4 md:tw-grid-cols-2">

                            {{-- Backend Components --}}
                            <div class="tw-rounded-lg tw-border tw-border-[#C4C4C4]/50 tw-bg-[#F8F9F9] tw-p-4">
                                <h3
                                    class="tw-mb-3 tw-text-xs tw-font-bold tw-uppercase tw-tracking-wider tw-text-[#666666]">
                                    Core Backend Components
                                </h3>

                                <div class="tw-space-y-3 tw-text-sm">
                                    <div>
                                        <p class="tw-text-xs tw-font-semibold tw-text-[#087B60]">Controllers</p>
                                        <p class="tw-mt-1 tw-font-mono tw-text-xs tw-text-[#444444]">ReviewController</p>
                                        <p class="tw-font-mono tw-text-xs tw-text-[#444444]">ForecastController</p>
                                    </div>
                                    <div>
                                        <p class="tw-text-xs tw-font-semibold tw-text-[#087B60]">Jobs</p>
                                        <p class="tw-mt-1 tw-font-mono tw-text-xs tw-text-[#444444]">AnalyzeSentimentJob</p>
                                        <p class="tw-font-mono tw-text-xs tw-text-[#444444]">GenerateBlockSummaryJob</p>
                                    </div>
                                    <div>
                                        <p class="tw-text-xs tw-font-semibold tw-text-[#087B60]">Models</p>
                                        <p class="tw-mt-1 tw-font-mono tw-text-xs tw-text-[#444444]">User, Block, Review,
                                            Forecast, Summary</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Database --}}
                            <div class="tw-rounded-lg tw-border tw-border-[#C4C4C4]/50 tw-bg-[#F8F9F9] tw-p-4">
                                <h3
                                    class="tw-mb-3 tw-text-xs tw-font-bold tw-uppercase tw-tracking-wider tw-text-[#666666]">
                                    Database Tables
                                </h3>

                                <div class="tw-space-y-3 tw-text-sm">
                                    <div>
                                        <p class="tw-font-mono tw-text-xs tw-font-semibold tw-text-[#087B60]">users</p>
                                        <p class="tw-mt-1 tw-text-xs tw-text-[#666666]">Registered users and administrators.
                                        </p>
                                    </div>
                                    <div>
                                        <p class="tw-font-mono tw-text-xs tw-font-semibold tw-text-[#087B60]">blocks</p>
                                        <p class="tw-mt-1 tw-text-xs tw-text-[#666666]">Subdivision blocks under management.
                                        </p>
                                    </div>
                                    <div>
                                        <p class="tw-font-mono tw-text-xs tw-font-semibold tw-text-[#087B60]">reviews</p>
                                        <p class="tw-mt-1 tw-text-xs tw-text-[#666666]">User-submitted ratings and comments
                                            per block or lot.</p>
                                    </div>
                                    <div>
                                        <p class="tw-font-mono tw-text-xs tw-font-semibold tw-text-[#087B60]">forecasts &
                                            summaries</p>
                                        <p class="tw-mt-1 tw-text-xs tw-text-[#666666]">AI-generated summaries and projected
                                            block ratings.</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>

                <div class="tw-mb-8 tw-border-t tw-border-[#C4C4C4]/40"></div>

                {{-- Workflow --}}
                <section class="tw-mb-8">
                    <div class="tw-mb-4 tw-flex tw-items-center tw-gap-3">
                        <span
                            class="tw-flex tw-h-8 tw-w-8 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-lg tw-bg-[#06EBB6]/15 tw-text-sm tw-font-bold tw-text-[#087B60]">06</span>
                        <h2 class="tw-text-lg tw-font-bold tw-text-[#111111]">
                            Example Review & Forecast Workflow
                        </h2>
                    </div>

                    <div class="tw-pl-0 sm:tw-pl-11">
                        <div class="tw-rounded-lg tw-border tw-border-[#C4C4C4]/50 tw-bg-[#F8F9F9] tw-p-4 sm:tw-p-5">
                            <div class="tw-space-y-4">
                                <div class="tw-flex tw-gap-3">
                                    <span
                                        class="tw-flex tw-h-7 tw-w-7 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-full tw-bg-[#06EBB6] tw-text-xs tw-font-bold tw-text-[#06100D]">1</span>
                                    <div>
                                        <p class="tw-text-sm tw-font-semibold tw-text-[#111111]">Review Submission</p>
                                        <p class="tw-mt-1 tw-text-xs tw-leading-6 tw-text-[#666666]">The user submits a
                                            review with a star rating and optional comment.</p>
                                    </div>
                                </div>

                                <div class="tw-ml-3.5 tw-h-4 tw-border-l tw-border-dashed tw-border-[#C4C4C4]"></div>

                                <div class="tw-flex tw-gap-3">
                                    <span
                                        class="tw-flex tw-h-7 tw-w-7 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-full tw-bg-[#06EBB6] tw-text-xs tw-font-bold tw-text-[#06100D]">2</span>
                                    <div>
                                        <p class="tw-text-sm tw-font-semibold tw-text-[#111111]">Review Processing</p>
                                        <p class="tw-mt-1 tw-text-xs tw-leading-6 tw-text-[#666666]">
                                            <strong>ReviewController</strong> stores the review and dispatches background
                                            jobs for analysis.</p>
                                    </div>
                                </div>

                                <div class="tw-ml-3.5 tw-h-4 tw-border-l tw-border-dashed tw-border-[#C4C4C4]"></div>

                                <div class="tw-flex tw-gap-3">
                                    <span
                                        class="tw-flex tw-h-7 tw-w-7 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-full tw-bg-[#06EBB6] tw-text-xs tw-font-bold tw-text-[#06100D]">3</span>
                                    <div>
                                        <p class="tw-text-sm tw-font-semibold tw-text-[#111111]">Sentiment Analysis</p>
                                        <p class="tw-mt-1 tw-text-xs tw-leading-6 tw-text-[#666666]">
                                            <strong>AnalyzeSentimentJob</strong> evaluates the review using AI sentiment
                                            models.</p>
                                    </div>
                                </div>

                                <div class="tw-ml-3.5 tw-h-4 tw-border-l tw-border-dashed tw-border-[#C4C4C4]"></div>

                                <div class="tw-flex tw-gap-3">
                                    <span
                                        class="tw-flex tw-h-7 tw-w-7 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-full tw-bg-[#06EBB6] tw-text-xs tw-font-bold tw-text-[#06100D]">4</span>
                                    <div>
                                        <p class="tw-text-sm tw-font-semibold tw-text-[#111111]">Summary Generation</p>
                                        <p class="tw-mt-1 tw-text-xs tw-leading-6 tw-text-[#666666]">
                                            <strong>GenerateBlockSummaryJob</strong> updates the block summary with
                                            aggregated data.</p>
                                    </div>
                                </div>

                                <div class="tw-ml-3.5 tw-h-4 tw-border-l tw-border-dashed tw-border-[#C4C4C4]"></div>

                                <div class="tw-flex tw-gap-3">
                                    <span
                                        class="tw-flex tw-h-7 tw-w-7 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-full tw-bg-[#06EBB6] tw-text-xs tw-font-bold tw-text-[#06100D]">5</span>
                                    <div>
                                        <p class="tw-text-sm tw-font-semibold tw-text-[#111111]">Forecast Calculation</p>
                                        <p class="tw-mt-1 tw-text-xs tw-leading-6 tw-text-[#666666]">
                                            <strong>ForecastController</strong> calculates the EMA forecast and integrates
                                            it into trend charts.</p>
                                    </div>
                                </div>

                                <div class="tw-ml-3.5 tw-h-4 tw-border-l tw-border-dashed tw-border-[#C4C4C4]"></div>

                                <div class="tw-flex tw-gap-3">
                                    <span
                                        class="tw-flex tw-h-7 tw-w-7 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-full tw-bg-[#06EBB6] tw-text-xs tw-font-bold tw-text-[#06100D]">6</span>
                                    <div>
                                        <p class="tw-text-sm tw-font-semibold tw-text-[#111111]">Visualization Update</p>
                                        <p class="tw-mt-1 tw-text-xs tw-leading-6 tw-text-[#666666]">The front-end updates
                                            in real time with new reviews, summaries, and forecasted trends displayed in 3D
                                            modals and analytics charts.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="tw-mb-8 tw-border-t tw-border-[#C4C4C4]/40"></div>

                {{-- Design and UX --}}
                <section class="tw-mb-8">
                    <div class="tw-mb-4 tw-flex tw-items-center tw-gap-3">
                        <span
                            class="tw-flex tw-h-8 tw-w-8 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-lg tw-bg-[#06EBB6]/15 tw-text-sm tw-font-bold tw-text-[#087B60]">07</span>
                        <h2 class="tw-text-lg tw-font-bold tw-text-[#111111]">
                            Design & User Experience
                        </h2>
                    </div>

                    <div class="tw-pl-0 sm:tw-pl-11">
                        <p class="tw-text-sm tw-leading-7 tw-text-[#555555]">
                            The system emphasizes clarity, performance, and immersion. Real-time AI processing ensures
                            feedback loops between user actions and visual updates. TailwindCSS gradients, shadows, and
                            rounded corners create a clean, modern dashboard aesthetic.
                        </p>

                        <div class="tw-mt-4 tw-space-y-3">
                            <div class="tw-flex tw-gap-3">
                                <span class="tw-mt-1 tw-h-2 tw-w-2 tw-shrink-0 tw-rounded-full tw-bg-[#06EBB6]"></span>
                                <p class="tw-text-sm tw-leading-6 tw-text-[#555555]"><strong
                                        class="tw-text-[#111111]">Immersive Visualization:</strong> 3D interaction replaces
                                    static property lists.</p>
                            </div>
                            <div class="tw-flex tw-gap-3">
                                <span class="tw-mt-1 tw-h-2 tw-w-2 tw-shrink-0 tw-rounded-full tw-bg-[#06EBB6]"></span>
                                <p class="tw-text-sm tw-leading-6 tw-text-[#555555]"><strong class="tw-text-[#111111]">AI
                                        Feedback Loop:</strong> User reviews immediately influence analytics and forecasts.
                                </p>
                            </div>
                            <div class="tw-flex tw-gap-3">
                                <span class="tw-mt-1 tw-h-2 tw-w-2 tw-shrink-0 tw-rounded-full tw-bg-[#06EBB6]"></span>
                                <p class="tw-text-sm tw-leading-6 tw-text-[#555555]"><strong
                                        class="tw-text-[#111111]">Scalable Rendering:</strong> Instanced 3D meshes maintain
                                    smooth performance on large maps.</p>
                            </div>
                            <div class="tw-flex tw-gap-3">
                                <span class="tw-mt-1 tw-h-2 tw-w-2 tw-shrink-0 tw-rounded-full tw-bg-[#06EBB6]"></span>
                                <p class="tw-text-sm tw-leading-6 tw-text-[#555555]"><strong
                                        class="tw-text-[#111111]">Responsive Design:</strong> TailwindCSS ensures seamless
                                    layout on all devices.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="tw-mb-8 tw-border-t tw-border-[#C4C4C4]/40"></div>

                {{-- Summary --}}
                <section>
                    <div class="tw-rounded-xl tw-border tw-border-[#06EBB6]/40 tw-bg-[#06EBB6]/5 tw-p-5 sm:tw-p-6">
                        <div class="tw-mb-3 tw-flex tw-items-center tw-gap-3">
                            <div
                                class="tw-flex tw-h-9 tw-w-9 tw-items-center tw-justify-center tw-rounded-lg tw-bg-[#06EBB6]/20">
                                <svg class="tw-h-5 tw-w-5 tw-text-[#087B60]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9c0-1.268-.196-2.49-.558-3.624z" />
                                </svg>
                            </div>

                            <h2 class="tw-text-lg tw-font-bold tw-text-[#111111]">
                                Summary
                            </h2>
                        </div>

                        <p class="tw-text-sm tw-leading-7 tw-text-[#444444]">
                            By integrating <strong>3D visualization</strong>, <strong>AI sentiment analysis</strong>,
                            and <strong>forecasting analytics</strong>, LotMatch provides an advanced and responsive system
                            for real estate performance monitoring. It delivers actionable insights through immersive
                            visualization,
                            intelligent automation, and scalable architecture—transforming static property data into
                            a living, interactive, and data-driven experience.
                        </p>
                    </div>
                </section>

            </div>
        </div>

        {{-- Document Footer --}}
        <div class="tw-mt-4 tw-flex tw-items-center tw-justify-between tw-px-1">
            <p class="tw-text-[11px] tw-text-[#999999]">
                LotMatch · Technical Documentation
            </p>
            <p class="tw-text-[11px] tw-text-[#999999]">
                System Reference
            </p>
        </div>

    </div>
@endsection