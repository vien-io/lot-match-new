@extends('layouts.app')

@section('title', 'AI Summary & Forecasting')

@section('content')
<div class="tw-flex tw-flex-col lg:tw-flex-row tw-gap-8 tw-items-start tw-mt-12 tw-px-6">

  {{-- Left Column: AI Summary & Report --}}
  <div class="tw-flex-1 tw-max-w-5xl tw-bg-white tw-rounded-3xl tw-shadow-md tw-p-6">
    <h1 class="tw-text-2xl tw-font-bold tw-mb-6">AI Summary & Forecast</h1>

    {{-- Block Selector --}}
    <div class="tw-mb-6">
        <label class="tw-block tw-font-semibold tw-mb-1">Select Block</label>
        <select id="summaryBlockSelector" class="tw-border tw-rounded tw-p-2 tw-w-full">
            <option value="">Choose a block</option>
            @foreach($blocks->sortBy('id') as $block)
                <option value="{{ $block->id }}">{{ $block->name }}</option>
            @endforeach

        </select>
    </div>

    {{-- Summary Card --}}
    <div class="tw-mb-6 tw-bg-gray-50 tw-rounded-xl tw-p-4">
        <h3 class="tw-font-semibold tw-mb-2">Forecast</h3>
        <div id="aiSummary" class="tw-text-gray-700 tw-whitespace-pre-line">
            Forecast will appear here
        </div>
    </div>

    {{-- Full Forecast Report Card --}}
    <div class="tw-bg-gray-50 tw-rounded-xl tw-p-4">
        <h3 class="tw-font-semibold tw-mb-2">Detailed Report</h3>
        <div id="aiForecastNarrative" class="tw-text-gray-700 tw-whitespace-pre-line">
            A detailed narrative will appear here
        </div>
    </div>
  </div>

  {{-- Right Column: Forecast Stats --}}
  <div class="tw-w-full lg:tw-w-[40rem] lg:tw-w-96 tw-bg-white tw-rounded-3xl tw-shadow-md tw-p-6 smooth-follow">
    <h2 class="tw-font-bold tw-mb-4">Forecast Insights</h2>

    {{-- Forecasted Rating --}}
    <div class="tw-text-center tw-mb-6">
        <h1 id="aiForecastRating" class="tw-text-4xl tw-font-bold tw-text-[#1f2937]">
            --
        </h1>
        <div id="forecastStars" class="tw-flex tw-justify-center tw-text-yellow-400 tw-mt-1">
            ☆☆☆☆☆
        </div>
        <p class="tw-text-gray-500 tw-text-sm tw-mt-1">
            Predicted satisfaction rating
        </p>
    </div>

    {{-- chart for sentiment trends --}}
    <div class="tw-bg-gray-50 tw-rounded-xl tw-p-4 tw-h-64">
        <h3 class="tw-font-semibold tw-mb-2">Sentiment Trend</h3>
        <canvas id="sentimentChart" class="tw-w-full tw-h-full"></canvas>
    </div>

    </div>
</div>

@endsection

@section('scripts')
  @vite('resources/js/charts/forecast.js')
  @vite('resources/js/smoothSticky.js')
@endsection
