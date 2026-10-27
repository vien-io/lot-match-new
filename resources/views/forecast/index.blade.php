@extends('layouts.app')

@section('title', 'AI Summary & Forecasting')

@section('content')
    <main class="tw-mx-auto tw-w-full tw-max-w-[1600px]">

        {{-- Page Header --}}
        <header class="lm-heading">
            <div>
                <span class="lm-eyebrow">Analytics & Intelligence</span>
                <h1>AI Summary & Forecasting</h1>
                <p>Understand predicted satisfaction, explore sentiment patterns, and uncover AI-generated insights for each block.</p>
            </div>
        </header>


        {{-- Forecast Configuration --}}
        <section class="tw-mb-7 tw-overflow-hidden tw-rounded-2xl tw-border tw-border-[#C4C4C4]/70 tw-shadow-[0_8px_28px_rgba(6,16,13,0.08)]">
            <div class="tw-grid tw-grid-cols-1 tw-items-center md:tw-grid-cols-[minmax(0,1fr)_minmax(400px,500px)] tw-rounded-2xl tw-bg-white">

                <div class="tw-relative tw-overflow-hidden tw-p-5 sm:tw-p-7 lg:tw-p-8">
                    {{-- Decorative accents --}}
                    <div class="tw-pointer-events-none tw-absolute -tw-right-8 -tw-top-16 tw-h-48 tw-w-48 tw-rounded-full tw-border tw-border-[#059669]/10"></div>
                    <div class="tw-pointer-events-none tw-absolute -tw-right-2 -tw-top-10 tw-h-36 tw-w-36 tw-rounded-full tw-border tw-border-[#059669]/10"></div>

                    <div class="tw-relative tw-flex tw-items-center tw-gap-9">
                        <div class="tw-flex tw-h-11 tw-w-11 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-xl tw-border tw-border-[#059669]/20 tw-bg-[#059669]/10">
                            <svg class="tw-h-7 tw-w-7 tw-text-[#059669]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <path d="M4 19V5M4 19H21" stroke-linecap="round"/>
                                <path d="m7 15 4-4 3 2 6-7" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M16 6h4v4" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>

                        <div class="tw-min-w-0">
                            <p class="tw-text-[10px] tw-font-semibold tw-uppercase tw-tracking-[0.2em] tw-text-[#047857]">
                                Workspace configuration
                            </p>

                            <h2 class="tw-mt-2 tw-text-xl tw-font-semibold tw-tracking-tight tw-text-gray-900 sm:tw-text-2xl">
                                Select your analysis
                            </h2>

                            <p class="tw-max-w-3xl tw-text-sm tw-leading-6 tw-text-gray-600">
                                Choose a block to explore its available satisfaction forecast and sentiment analysis.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="tw-border-t tw-border-gray-200 tw-bg-gray-50 tw-p-5 sm:tw-p-6 md:tw-border-l md:tw-border-t-0">
                    <label for="summaryBlockSelector"
                        class="tw-mb-2.5 tw-flex tw-items-center tw-gap-2 tw-text-xs tw-font-semibold tw-text-gray-700">
                        <span class="tw-h-1.5 tw-w-1.5 tw-rounded-full tw-bg-[#059669]"></span>
                        Select block
                    </label>

                    <div class="tw-relative">
                        <select id="summaryBlockSelector"
                                class="tw-w-full tw-appearance-none tw-rounded-xl tw-border tw-border-gray-300 tw-bg-white tw-px-4 tw-py-3.5 tw-pr-11 tw-text-sm tw-font-medium tw-text-gray-900 tw-outline-none tw-transition tw-duration-200 hover:tw-border-[#059669]/60 focus:tw-border-[#059669] focus:tw-ring-2 focus:tw-ring-[#059669]/20">
                            <option value="">Choose a block</option>

                            @foreach($blocks->sortBy('id') as $block)
                                <option value="{{ $block->id }}">{{ $block->name }}</option>
                            @endforeach
                        </select>

                        <svg class="tw-pointer-events-none tw-absolute tw-right-4 tw-top-1/2 tw-h-4 tw-w-4 -tw-translate-y-1/2 tw-text-[#059669]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path d="m7 10 5 5 5-5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>

                    <p class="tw-mt-2.5 tw-text-[11px] tw-leading-5 tw-text-gray-500">
                        Forecast availability depends on the selected block.
                    </p>
                </div>

            </div>
        </section>


        {{-- Main Analysis Workspace --}}
        <div class="tw-grid tw-grid-cols-1 tw-items-start tw-gap-6 xl:tw-grid-cols-[minmax(0,1fr)_610px] 2xl:tw-grid-cols-[minmax(0,1fr)_590px]">

            {{-- Main Column --}}
            <section class="tw-min-w-0 tw-space-y-6">

                {{-- AI Forecast Summary --}}
                <article class="tw-group tw-overflow-hidden tw-rounded-2xl tw-border tw-border-[#DDE1DE] tw-bg-white tw-shadow-[0_3px_14px_rgba(6,16,13,0.025)] tw-transition-shadow tw-duration-300 hover:tw-shadow-[0_8px_28px_rgba(6,16,13,0.055)]">

                    <div class="tw-flex tw-flex-col tw-gap-4 tw-border-b tw-border-[#E8EBE8] tw-px-5 tw-py-5 sm:tw-flex-row sm:tw-items-center sm:tw-justify-between sm:tw-px-7">

                        <div class="tw-min-w-0">
                                <div class="tw-flex tw-flex-wrap tw-items-center tw-gap-2">
                                    <h2 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-[#111111] sm:tw-text-lg">
                                        Forecast summary
                                    </h2>

                                    <span class="tw-rounded-md tw-bg-[#E7FBF4] tw-px-2 tw-py-1 tw-text-[9px] tw-font-bold tw-uppercase tw-tracking-[0.12em] tw-text-[#087A59]">
                                        AI insights
                                    </span>
                                </div>

                                <p class="tw-mt-1 tw-text-xs tw-leading-5 tw-text-[#777777] sm:tw-text-sm">
                                    Key findings and predicted outcomes
                                </p>
                        </div>

                        <div class="tw-flex tw-items-center tw-gap-2 tw-self-start tw-rounded-lg tw-bg-[#F4F6F4] tw-px-3 tw-py-2 sm:tw-self-auto">
                            <svg class="tw-h-3.5 tw-w-3.5 tw-shrink-0 tw-text-[#6A766F]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 11v5m0-8h.01" stroke-linecap="round"/>
                            </svg>

                            <span class="tw-text-[10px] tw-font-medium tw-text-[#66716A]">
                                Forecast overview
                            </span>
                        </div>
                    </div>

                    <div class="tw-p-5 sm:tw-p-7">
                        <div id="aiSummary"
                             aria-live="polite"
                             class="tw-max-h-[360px] tw-overflow-y-auto tw-break-words tw-pr-2 tw-text-sm tw-leading-7 tw-text-[#414842] tw-scrollbar-thin tw-scrollbar-thumb-[#CDD4CE] tw-scrollbar-track-transparent">
                            <div class="tw-flex tw-flex-col tw-items-center tw-justify-center tw-px-6 tw-py-12 tw-text-center">

                                {{-- Empty state illustration --}}
                                <div class="tw-relative tw-mb-5 tw-flex tw-h-24 tw-w-24 tw-items-center tw-justify-center">

                                    {{-- Soft background glow --}}
                                    <div class="tw-absolute tw-inset-0 tw-rounded-full tw-bg-[#059669]/[0.07]"></div>
                                    <div class="tw-absolute tw-inset-2 tw-rounded-full tw-border tw-border-[#059669]/15"></div>

                                    {{-- Floating accent --}}
                                    <div class="tw-absolute tw-right-1 tw-top-2 tw-flex tw-h-7 tw-w-7 tw-items-center tw-justify-center tw-rounded-lg tw-border tw-border-[#059669]/20 tw-bg-white tw-shadow-sm">
                                        <svg class="tw-h-3.5 tw-w-3.5 tw-text-[#047857]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <path d="m12 3 2.7 5.47 6.03.88-4.36 4.25 1.03 6.01L12 16.77l-5.4 2.84 1.03-6.01L3.27 9.35l6.03-.88L12 3Z" stroke-linejoin="round"/>
                                        </svg>
                                    </div>

                                    {{-- Main document icon --}}
                                    <div class="tw-relative tw-flex tw-h-14 tw-w-14 tw-items-center tw-justify-center tw-rounded-2xl tw-border tw-border-[#DDE7DF] tw-bg-[#F0F6F1] tw-shadow-sm">
                                        <svg class="tw-h-7 tw-w-7 tw-text-[#28734F]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                            <path d="M7 3.75h7l4 4v12.5H7a2 2 0 0 1-2-2v-12.5a2 2 0 0 1 2-2Z" stroke-linejoin="round"/>
                                            <path d="M14 3.75v4h4M8.5 12h7M8.5 15.5h5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>

                                    {{-- Decorative dots --}}
                                    <span class="tw-absolute tw-bottom-3 tw-left-2 tw-h-1.5 tw-w-1.5 tw-rounded-full tw-bg-[#059669]/50"></span>
                                    <span class="tw-absolute tw-right-3 tw-bottom-1 tw-h-1 tw-w-1 tw-rounded-full tw-bg-[#9CA3AF]"></span>
                                </div>

                                <h3 class="tw-text-sm tw-font-semibold tw-tracking-tight tw-text-[#222A24]">
                                    No forecast to summarize yet
                                </h3>

                                <p class="tw-mt-2 tw-max-w-xs tw-text-xs tw-leading-6 tw-text-[#6B756D]">
                                    Choose a block to explore its forecast highlights, key trends, and predicted outcomes.
                                </p>
                            </div>
                        </div>
                    </div>
                </article>


                {{-- Detailed Forecast Report --}}
                <article class="tw-overflow-hidden tw-rounded-2xl tw-border tw-border-[#DDE1DE] tw-bg-white tw-shadow-[0_3px_14px_rgba(6,16,13,0.025)] tw-transition-shadow tw-duration-300 hover:tw-shadow-[0_8px_28px_rgba(6,16,13,0.055)]">

                    <div class="tw-flex tw-items-center tw-gap-3.5 tw-border-b tw-border-[#E8EBE8] tw-px-5 tw-py-5 sm:tw-px-7">
                        <div class="tw-min-w-0">
                            <h2 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-[#111111] sm:tw-text-lg">
                                Detailed forecast report
                            </h2>

                            <p class="tw-mt-1 tw-text-xs tw-leading-5 tw-text-[#777777] sm:tw-text-sm">
                                Expanded narrative and supporting analysis
                            </p>
                        </div>
                    </div>

                    <div class="tw-p-5 sm:tw-p-7">
                        <div id="aiForecastNarrative"
                             aria-live="polite"
                             class="tw-max-h-[600px] tw-overflow-y-auto tw-break-words tw-pr-2 tw-text-sm tw-leading-7 tw-text-[#414842] tw-scrollbar-thin tw-scrollbar-thumb-[#CDD4CE] tw-scrollbar-track-transparent">
                            
                            <div class="tw-flex tw-flex-col tw-items-center tw-justify-center tw-px-6 tw-py-12 tw-text-center">

                                {{-- Empty state illustration --}}
                                <div class="tw-relative tw-mb-5 tw-flex tw-h-24 tw-w-24 tw-items-center tw-justify-center">

                                    {{-- Soft background glow --}}
                                    <div class="tw-absolute tw-inset-0 tw-rounded-full tw-bg-[#059669]/[0.07]"></div>
                                    <div class="tw-absolute tw-inset-2 tw-rounded-full tw-border tw-border-[#059669]/15"></div>

                                    {{-- Floating accent --}}
                                    <div class="tw-absolute tw-right-1 tw-top-2 tw-flex tw-h-7 tw-w-7 tw-items-center tw-justify-center tw-rounded-lg tw-border tw-border-[#059669]/20 tw-bg-white tw-shadow-sm">
                                        <svg class="tw-h-3.5 tw-w-3.5 tw-text-[#047857]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <path d="m12 3 2.7 5.47 6.03.88-4.36 4.25 1.03 6.01L12 16.77l-5.4 2.84 1.03-6.01L3.27 9.35l6.03-.88L12 3Z" stroke-linejoin="round"/>
                                        </svg>
                                    </div>

                                    {{-- Main document icon --}}
                                    <div class="tw-relative tw-flex tw-h-14 tw-w-14 tw-items-center tw-justify-center tw-rounded-2xl tw-border tw-border-[#DDE7DF] tw-bg-[#F0F6F1] tw-shadow-sm">
                                        <svg class="tw-h-7 tw-w-7 tw-text-[#28734F]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                            <path d="M7 3.75h7l4 4v12.5H7a2 2 0 0 1-2-2v-12.5a2 2 0 0 1 2-2Z" stroke-linejoin="round"/>
                                            <path d="M14 3.75v4h4M8.5 12h7M8.5 15.5h5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>

                                    {{-- Decorative dots --}}
                                    <span class="tw-absolute tw-bottom-3 tw-left-2 tw-h-1.5 tw-w-1.5 tw-rounded-full tw-bg-[#059669]/50"></span>
                                    <span class="tw-absolute tw-right-3 tw-bottom-1 tw-h-1 tw-w-1 tw-rounded-full tw-bg-[#9CA3AF]"></span>
                                </div>

                                <h3 class="tw-text-sm tw-font-semibold tw-tracking-tight tw-text-[#222A24]">
                                    Detailed analysis will appear here
                                </h3>

                                <p class="tw-mt-2 tw-max-w-xs tw-text-xs tw-leading-6 tw-text-[#6B756D]">
                                    Select a block to view its available forecast narrative, detailed findings, and supporting analysis.
                                </p>
                            </div>


                        </div>
                    </div>

                </article>

            </section>


            {{-- Insights Sidebar --}}
            <aside class="tw-min-w-0 tw-space-y-5 xl:tw-sticky xl:tw-top-6">

                {{-- Satisfaction Rating --}}
                <section class="tw-overflow-hidden tw-rounded-2xl tw-border tw-border-white/[0.08] tw-bg-[#0D1712] tw-shadow-[0_4px_20px_rgba(0,0,0,0.15)]">

                    {{-- Header --}}
                    <div class="tw-flex tw-items-center tw-gap-3 tw-border-b tw-border-white/[0.08] tw-px-5 tw-py-4">
                        <div class="tw-flex tw-h-10 tw-w-10 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-xl tw-bg-[#06EBB6]/[0.08] tw-text-[#06EBB6]">
                            <svg class="tw-h-5 tw-w-5" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <path d="M12 3 14.8 8.7 21 9.6l-4.5 4.4 1.1 6.2L12 17.3l-5.6 2.9 1.1-6.2L3 9.6l6.2-.9L12 3Z"
                                    stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>

                        <div class="tw-min-w-0">
                            <h2 class="tw-text-sm tw-font-semibold tw-text-white">
                                Forecast insights
                            </h2>
                            <p class="tw-mt-1 tw-text-xs tw-text-[#819187]">
                                Predicted customer satisfaction
                            </p>
                        </div>

                        <div class="tw-ml-auto tw-flex tw-shrink-0 tw-items-center tw-gap-1.5 tw-rounded-full tw-border tw-border-[#06EBB6]/15 tw-bg-[#06EBB6]/[0.06] tw-px-2.5 tw-py-1">
                            <span class="tw-h-1.5 tw-w-1.5 tw-rounded-full tw-bg-[#06EBB6]"></span>
                            <span class="tw-text-[10px] tw-font-medium tw-text-[#06EBB6]">
                                AI Forecast
                            </span>
                        </div>
                    </div>

                    {{-- Rating Content --}}
                    <div class="tw-p-4 sm:tw-p-5">
                        <div class="tw-relative tw-overflow-hidden tw-rounded-xl tw-border tw-border-white/[0.06] tw-bg-[#101F18] tw-p-5 sm:tw-p-6">

                            {{-- Subtle background accent --}}
                            <div class="tw-pointer-events-none tw-absolute -tw-right-12 -tw-top-12 tw-h-40 tw-w-40 tw-rounded-full tw-bg-[#06EBB6]/[0.035] tw-blur-2xl"></div>

                            <div class="tw-relative">
                                <div class="tw-flex tw-flex-col tw-gap-6 sm:tw-flex-row sm:tw-items-center sm:tw-justify-between">

                                    {{-- Main Rating --}}
                                    <div>
                                        <p class="tw-text-[10px] tw-font-semibold tw-uppercase tw-tracking-[0.16em] tw-text-[#8DA296]">
                                            Predicted rating
                                        </p>

                                        <div class="tw-mt-3 tw-flex tw-items-baseline tw-gap-2">
                                            <span id="aiForecastRating"
                                                class="tw-text-6xl tw-font-semibold tw-leading-none tw-tracking-[-0.055em] tw-text-white">
                                                --
                                            </span>
                                            <span class="tw-text-base tw-font-medium tw-text-[#819187]">
                                                / 5.0
                                            </span>
                                        </div>

                                        <div id="forecastStars"
                                            class="tw-mt-3 tw-flex tw-items-center tw-gap-1 tw-text-xl tw-leading-none tw-text-[#E6B85C]"
                                            role="img"
                                            aria-label="Forecast rating not yet available">
                                            ☆ ☆ ☆ ☆ ☆
                                        </div>
                                    </div>

                                    {{-- Rating Indicator --}}
                                    <div class="tw-w-full sm:tw-max-w-[180px]">
                                        <div class="tw-flex tw-items-center tw-justify-between">
                                            <span class="tw-text-xs tw-text-[#93A399]">
                                                Satisfaction level
                                            </span>
                                            <span id="forecastPercentage"
                                                class="tw-text-sm tw-font-semibold tw-tabular-nums tw-text-[#06EBB6]">
                                                --
                                            </span>
                                        </div>

                                        <div class="tw-mt-3 tw-h-2 tw-overflow-hidden tw-rounded-full tw-bg-white/[0.07]">
                                            <div id="forecastRatingBar"
                                                class="tw-h-full tw-rounded-full tw-bg-gradient-to-r tw-from-[#059B7B] tw-to-[#06EBB6] tw-transition-[width] tw-duration-500"
                                                style="width: 0%">
                                            </div>
                                        </div>

                                        <div class="tw-mt-2 tw-flex tw-justify-between tw-text-[10px] tw-text-[#718278]">
                                            <span>0</span>
                                            <span>5.0</span>
                                        </div>
                                    </div>

                                </div>

                                {{-- Divider --}}
                                <div class="tw-my-5 tw-h-px tw-bg-white/[0.07]"></div>

                                {{-- Footer --}}
                                <div class="tw-flex tw-items-start tw-gap-2.5">
                                    <svg class="tw-mt-0.5 tw-h-4 tw-w-4 tw-shrink-0 tw-text-[#06EBB6]/80"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.7" aria-hidden="true">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="M12 11v5m0-8h.01" stroke-linecap="round"/>
                                    </svg>

                                    <p class="tw-text-xs tw-leading-5 tw-text-[#8DA095]">
                                        Estimated satisfaction based on available forecasting data.
                                        Predictions may differ from actual customer ratings.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>


                {{-- Sentiment Trend Chart --}}
                <section class="tw-overflow-hidden tw-rounded-2xl tw-border tw-border-[#DDE1DE] tw-bg-white tw-shadow-[0_3px_14px_rgba(6,16,13,0.025)] tw-transition-shadow tw-duration-300 hover:tw-shadow-[0_8px_28px_rgba(6,16,13,0.055)]">

                    {{-- Header --}}
                    <div class="tw-flex tw-items-center tw-gap-3 tw-border-b tw-border-[#E8EBE8] tw-px-5 tw-py-4">
                        <div class="tw-flex tw-h-10 tw-w-10 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-xl tw-border tw-border-[#225C42]/10 tw-bg-[#225C42]/[0.06]">
                            <svg class="tw-h-5 tw-w-5 tw-text-[#225C42]"
                                viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.7"
                                aria-hidden="true">
                                <path d="M3 17.5 8.5 12l4 3L21 6.5"
                                    stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M15.5 6.5H21v5.5"
                                    stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>

                        <div class="tw-min-w-0">
                            <h2 class="tw-text-sm tw-font-semibold tw-text-[#111111]">
                                Sentiment trend
                            </h2>
                            <p class="tw-mt-1 tw-text-xs tw-text-[#777777]">
                                Sentiment across the forecast period
                            </p>
                        </div>

                        <span class="tw-ml-auto tw-hidden tw-items-center tw-gap-1.5 tw-rounded-full tw-bg-[#F0F4F1] tw-px-2.5 tw-py-1 tw-text-[10px] tw-font-medium tw-text-[#225C42] sm:tw-inline-flex">
                            <span class="tw-h-1.5 tw-w-1.5 tw-rounded-full tw-bg-[#225C42]"></span>
                            Trend analysis
                        </span>
                    </div>

                    {{-- Chart Content --}}
                    <div class="tw-p-4 sm:tw-p-5">

                        {{-- Chart / Empty State Container --}}
                        <div class="tw-relative tw-flex tw-min-h-[280px] tw-items-center tw-justify-center tw-overflow-hidden tw-rounded-xl tw-border tw-border-[#E8EBE8] tw-bg-[#FAFBFA] sm:tw-min-h-[300px]">

                            {{-- Subtle decorative grid --}}
                            <div class="tw-pointer-events-none tw-absolute tw-inset-0 tw-opacity-60"
                                aria-hidden="true"
                                style="background-image: linear-gradient(to right, #E8EBE8 1px, transparent 1px), linear-gradient(to bottom, #E8EBE8 1px, transparent 1px); background-size: 40px 40px; mask-image: linear-gradient(to bottom, black, transparent 85%);">
                            </div>

                            {{-- Keep the canvas for Chart.js --}}
                            <div id="sentimentChartEmptyState"
                                class="tw-relative tw-z-10 tw-flex tw-w-full tw-flex-col tw-items-center tw-px-6 tw-py-10 tw-text-center">

                                <div class="tw-relative tw-flex tw-h-16 tw-w-16 tw-items-center tw-justify-center tw-rounded-2xl tw-border tw-border-[#DDE8DF] tw-bg-white tw-shadow-[0_4px_16px_rgba(34,92,66,0.06)]">
                                    <svg class="tw-h-8 tw-w-8 tw-text-[#225C42]"
                                        viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.5"
                                        aria-hidden="true">
                                        <path d="M3 17.5 8.5 12l4 3L21 6.5"
                                            stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M15.5 6.5H21v5.5"
                                            stroke-linecap="round" stroke-linejoin="round"/>
                                        <circle cx="8.5" cy="12" r="1"
                                                fill="currentColor" stroke="none"/>
                                        <circle cx="12.5" cy="15" r="1"
                                                fill="currentColor" stroke="none"/>
                                    </svg>
                                </div>

                                <h3 class="tw-mt-5 tw-text-sm tw-font-semibold tw-text-[#202923]">
                                    Your sentiment trend starts here
                                </h3>

                                <p class="tw-mt-2 tw-max-w-xs tw-text-xs tw-leading-5 tw-text-[#788179]">
                                    Select a block to explore its available sentiment patterns and changes throughout the forecast period.
                                </p>
                            </div>

                            {{-- Chart canvas --}}
                            <div id="sentimentChartContainer"
                                class="tw-absolute tw-inset-0 tw-hidden tw-p-4 sm:tw-p-5">
                                <canvas id="sentimentChart"
                                        role="img"
                                        aria-label="Sentiment trend chart">
                                    Sentiment trend chart.
                                </canvas>
                            </div>
                        </div>

                        {{-- Supporting note --}}
                        <div class="tw-mt-4 tw-flex tw-items-start tw-gap-2.5 tw-rounded-lg tw-border tw-border-[#E8EBE8] tw-bg-white tw-p-3">
                            <svg class="tw-mt-0.5 tw-h-4 tw-w-4 tw-shrink-0 tw-text-[#758179]"
                                viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.7"
                                aria-hidden="true">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 11v5m0-8h.01" stroke-linecap="round"/>
                            </svg>

                            <p class="tw-text-[11px] tw-leading-5 tw-text-[#69736C]">
                                Trend data is displayed when sentiment records are available for the selected block.
                            </p>
                        </div>

                    </div>
                </section>


                {{-- Forecast Context --}}
                <section class="tw-overflow-hidden tw-rounded-2xl tw-border tw-border-[#CFE8DB] tw-bg-[#EAF7F0]">
                    <div class="tw-p-5">
                        <div class="tw-flex tw-items-start tw-gap-3">
                            <div class="tw-flex tw-h-9 tw-w-9 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-xl tw-bg-[#06100D]">
                                <svg class="tw-h-4 tw-w-4 tw-text-[#06EBB6]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path d="M12 11v5m0-8h.01" stroke-linecap="round"/>
                                </svg>
                            </div>

                            <div class="tw-min-w-0">
                                <h3 class="tw-text-sm tw-font-semibold tw-text-[#173C2B]">
                                    About these forecasts
                                </h3>

                                <p class="tw-mt-2 tw-text-xs tw-leading-6 tw-text-[#527060]">
                                    Predictions are estimates based on the data available to the forecasting system. Interpret them alongside the detailed report and the context of each block.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

            </aside>

        </div>


        {{-- Footer --}}
        <footer class="tw-mt-10 tw-border-t tw-border-[#DDE1DE] tw-py-6">
            <div class="tw-flex tw-flex-col tw-items-center tw-justify-between tw-gap-2 sm:tw-flex-row">
                <div class="tw-flex tw-items-center tw-gap-2">
                    <span class="tw-flex tw-h-6 tw-w-6 tw-items-center tw-justify-center tw-rounded-md tw-bg-[#06100D] tw-text-[9px] tw-font-bold tw-text-[#06EBB6]">
                        LM
                    </span>

                    <p class="tw-text-xs tw-font-medium tw-text-[#5D665F]">
                        LotMatch
                    </p>
                </div>

                <p class="tw-text-center tw-text-[11px] tw-text-[#858C86]">
                    © {{ date('Y') }} LotMatch. All rights reserved.
                </p>

                <p class="tw-text-[10px] tw-font-medium tw-uppercase tw-tracking-[0.14em] tw-text-[#858C86]">
                    Analytics & Intelligence
                </p>
            </div>
        </footer>

    </main>
@endsection

@section('scripts')
    @vite('resources/js/charts/forecast.js')
    @vite('resources/js/smoothSticky.js')
@endsection