
@extends('layouts.app')

@section('title', 'AI Summary & Forecasting')

@section('content')
<div class="tw-min-h-screen tw-bg-[#D9D9D9]/40 tw-text-[#111111]">

    <main class="tw-mx-auto tw-w-full tw-max-w-[1600px] tw-px-4 tw-py-6 sm:tw-px-6 lg:tw-px-8 lg:tw-py-8">

        {{-- Page Header --}}
        <header class="tw-mb-7">
            <div class="tw-flex tw-flex-col tw-gap-4 sm:tw-flex-row sm:tw-items-center sm:tw-justify-between">
                <div>
                    <p class="tw-mb-1 tw-text-xs tw-font-semibold tw-uppercase tw-tracking-[0.14em] tw-text-[#666666]">
                        Analytics & Intelligence
                    </p>

                    <h1 class="tw-text-2xl tw-font-semibold tw-tracking-tight tw-text-[#111111] sm:tw-text-3xl">
                        AI Summary & Forecasting
                    </h1>

                    <p class="tw-mt-2 tw-max-w-2xl tw-text-sm tw-leading-6 tw-text-[#666666]">
                        Explore predicted satisfaction ratings, sentiment trends, and AI-generated insights for each block.
                    </p>
                </div>

                <div class="tw-inline-flex tw-w-fit tw-items-center tw-gap-2 tw-rounded-lg tw-border tw-border-[#C4C4C4]/70 tw-bg-white tw-px-3 tw-py-2">
                    <span class="tw-h-2 tw-w-2 tw-rounded-full tw-bg-[#06EBB6]"></span>
                    <span class="tw-text-xs tw-font-medium tw-text-[#444444]">
                        Forecasting insights
                    </span>
                </div>
            </div>
        </header>

        {{-- Block Selector --}}
        <section class="tw-mb-6 tw-rounded-xl tw-border tw-border-[#C4C4C4]/70 tw-bg-white tw-p-5 sm:tw-p-6">
            <div class="tw-flex tw-flex-col tw-gap-4 md:tw-flex-row md:tw-items-end md:tw-justify-between">
                <div>
                    <h2 class="tw-text-base tw-font-semibold tw-text-[#111111]">
                        Forecast configuration
                    </h2>

                    <p class="tw-mt-1 tw-text-sm tw-leading-6 tw-text-[#666666]">
                        Select a block to view its available forecast and sentiment analysis.
                    </p>
                </div>

                <div class="tw-w-full md:tw-max-w-sm">
                    <label for="summaryBlockSelector"
                           class="tw-mb-2 tw-block tw-text-sm tw-font-medium tw-text-[#111111]">
                        Select block
                    </label>

                    <select id="summaryBlockSelector"
                            class="tw-w-full tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-py-2.5 tw-text-sm tw-text-[#111111] tw-outline-none tw-transition focus:tw-border-[#06100D] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/40">
                        <option value="">Choose a block</option>

                        @foreach($blocks->sortBy('id') as $block)
                            <option value="{{ $block->id }}">{{ $block->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </section>

        {{-- Main Content Grid --}}
        <div class="tw-grid tw-grid-cols-1 tw-items-start tw-gap-6 xl:tw-grid-cols-[minmax(0,1fr)_380px]">

            {{-- Left Column: AI Summary and Report --}}
            <section class="tw-min-w-0 tw-space-y-6">

                {{-- Forecast Summary --}}
                <article class="tw-overflow-hidden tw-rounded-xl tw-border tw-border-[#C4C4C4]/70 tw-bg-white">

                    <div class="tw-border-b tw-border-[#C4C4C4]/60 tw-px-5 tw-py-4 sm:tw-px-6">
                        <div class="tw-flex tw-items-start tw-gap-3">
                            <div class="tw-flex tw-h-10 tw-w-10 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-lg tw-bg-[#06100D] tw-text-sm tw-font-semibold tw-text-[#06EBB6]">
                                AI
                            </div>

                            <div>
                                <h2 class="tw-text-base tw-font-semibold tw-text-[#111111]">
                                    Forecast summary
                                </h2>

                                <p class="tw-mt-1 tw-text-sm tw-text-[#666666]">
                                    Key findings and predicted outcomes
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="tw-p-5 sm:tw-p-6">
                        <div id="aiSummary"
                             aria-live="polite"
                             class="tw-max-h-[280px] tw-overflow-y-auto tw-whitespace-pre-line tw-break-words tw-pr-2 tw-text-sm tw-leading-7 tw-text-[#444444] tw-scrollbar-thin tw-scrollbar-thumb-[#C4C4C4] tw-scrollbar-track-transparent">
                            <div class="tw-flex tw-flex-col tw-items-start tw-gap-2">
                                <p class="tw-font-medium tw-text-[#111111]">
                                    Forecast summary will appear here
                                </p>

                                <p class="tw-text-sm tw-leading-6 tw-text-[#666666]">
                                    Select a block above to view its available AI-generated forecast.
                                </p>
                            </div>
                        </div>
                    </div>
                </article>

                {{-- Detailed Forecast Report --}}
                <article class="tw-overflow-hidden tw-rounded-xl tw-border tw-border-[#C4C4C4]/70 tw-bg-white">

                    <div class="tw-border-b tw-border-[#C4C4C4]/60 tw-px-5 tw-py-4 sm:tw-px-6">
                        <h2 class="tw-text-base tw-font-semibold tw-text-[#111111]">
                            Detailed forecast report
                        </h2>

                        <p class="tw-mt-1 tw-text-sm tw-text-[#666666]">
                            Expanded narrative and supporting analysis
                        </p>
                    </div>

                    <div class="tw-p-5 sm:tw-p-6">
                        <div id="aiForecastNarrative"
                             aria-live="polite"
                             class="tw-max-h-[460px] tw-overflow-y-auto tw-whitespace-pre-line tw-break-words tw-pr-2 tw-text-sm tw-leading-7 tw-text-[#444444] tw-scrollbar-thin tw-scrollbar-thumb-[#C4C4C4] tw-scrollbar-track-transparent">
                            <p class="tw-text-sm tw-leading-6 tw-text-[#666666]">
                                A detailed forecast narrative will appear here after you select a block.
                            </p>
                        </div>
                    </div>
                </article>

            </section>

            {{-- Right Column: Forecast Insights --}}
            <aside class="tw-min-w-0 tw-space-y-6 xl:tw-sticky xl:tw-top-6">

                {{-- Predicted Rating --}}
                <section class="tw-overflow-hidden tw-rounded-xl tw-border tw-border-[#C4C4C4]/70 tw-bg-white">

                    <div class="tw-border-b tw-border-[#C4C4C4]/60 tw-px-5 tw-py-4">
                        <h2 class="tw-text-base tw-font-semibold tw-text-[#111111]">
                            Forecast insights
                        </h2>

                        <p class="tw-mt-1 tw-text-sm tw-text-[#666666]">
                            Predicted satisfaction metrics
                        </p>
                    </div>

                    <div class="tw-p-5 sm:tw-p-6">
                        <div class="tw-rounded-lg tw-bg-[#D9D9D9]/25 tw-p-5">
                            <p class="tw-text-sm tw-font-medium tw-text-[#666666]">
                                Predicted satisfaction rating
                            </p>

                            <div class="tw-mt-3 tw-flex tw-items-baseline tw-gap-2">
                                <h3 id="aiForecastRating"
                                    class="tw-text-5xl tw-font-semibold tw-tracking-tight tw-text-[#111111]">
                                    --
                                </h3>

                                <span class="tw-text-sm tw-text-[#666666]">
                                    / 5
                                </span>
                            </div>

                            <div id="forecastStars"
                                 class="tw-mt-3 tw-flex tw-text-xl tw-leading-none tw-text-[#B7791F]"
                                 aria-label="Forecast rating not yet available">
                                ☆☆☆☆☆
                            </div>

                            <p class="tw-mt-3 tw-text-xs tw-leading-5 tw-text-[#666666]">
                                Estimated satisfaction based on available forecasting data.
                            </p>
                        </div>
                    </div>
                </section>

                {{-- Sentiment Chart --}}
                <section class="tw-overflow-hidden tw-rounded-xl tw-border tw-border-[#C4C4C4]/70 tw-bg-white">

                    <div class="tw-border-b tw-border-[#C4C4C4]/60 tw-px-5 tw-py-4">
                        <h2 class="tw-text-base tw-font-semibold tw-text-[#111111]">
                            Sentiment trend
                        </h2>

                        <p class="tw-mt-1 tw-text-sm tw-text-[#666666]">
                            Sentiment patterns across the forecast period
                        </p>
                    </div>

                    <div class="tw-p-4 sm:tw-p-5">
                        <div class="tw-relative tw-h-[260px] tw-w-full">
                            <canvas id="sentimentChart"
                                    role="img"
                                    aria-label="Sentiment trend chart">
                                Sentiment trend chart.
                            </canvas>
                        </div>

                        <p class="tw-mt-3 tw-text-xs tw-leading-5 tw-text-[#666666]">
                            Select a block to display its available sentiment data.
                        </p>
                    </div>
                </section>

                {{-- Context Panel --}}
                <section class="tw-rounded-xl tw-border tw-border-[#C4C4C4]/70 tw-bg-white tw-p-4">
                    <div class="tw-flex tw-items-start tw-gap-3">
                        <div class="tw-flex tw-h-9 tw-w-9 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-lg tw-bg-[#06100D] tw-text-sm tw-font-semibold tw-text-[#06EBB6]">
                            i
                        </div>

                        <div>
                            <h3 class="tw-text-sm tw-font-semibold tw-text-[#111111]">
                                About these forecasts
                            </h3>

                            <p class="tw-mt-1 tw-text-xs tw-leading-5 tw-text-[#666666]">
                                Predictions are estimates based on the data available to the forecasting system and should be interpreted alongside the detailed report.
                            </p>
                        </div>
                    </div>
                </section>

            </aside>
        </div>

        {{-- Footer --}}
        <footer class="tw-mt-10 tw-border-t tw-border-[#C4C4C4]/70 tw-py-5">
            <p class="tw-text-center tw-text-xs tw-leading-5 tw-text-[#666666]">
                © {{ date('Y') }} LotMatch. All rights reserved.
            </p>
        </footer>

    </main>
</div>
@endsection

@section('scripts')
    @vite('resources/js/charts/forecast.js')
    @vite('resources/js/smoothSticky.js')
@endsection
