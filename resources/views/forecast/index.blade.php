@extends('layouts.app')

@section('title', 'AI Summary & Forecasting')

@section('content')
<div class="tw-bg-gradient-to-br tw-from-green-50 tw-to-white tw-min-h-screen tw-py-12">

  <div class="tw-max-w-7xl tw-mx-auto tw-px-6 tw-flex tw-flex-col lg:tw-flex-row tw-gap-8">

    <!-- Left Column: AI Summary & Report -->
    <div class="tw-flex-1 tw-bg-white tw-rounded-3xl tw-shadow-md tw-p-6 tw-flex tw-flex-col tw-gap-6">

      <h1 class="tw-text-2xl tw-font-bold">AI Summary & Forecast</h1>

      <!-- Block Selector -->
      <div>
        <label class="tw-block tw-font-semibold tw-mb-1">Select Block</label>
        <select id="summaryBlockSelector" class="tw-border tw-rounded tw-p-2 tw-w-full">
          <option value="">Choose a block</option>
          @foreach($blocks->sortBy('id') as $block)
              <option value="{{ $block->id }}">{{ $block->name }}</option>
          @endforeach
        </select>
      </div>

      <!-- Forecast Card -->
      <div class="tw-bg-gray-50 tw-rounded-xl tw-shadow-inner tw-p-4">
        <h3 class="tw-font-semibold tw-mb-2">Forecast</h3>
        <div id="aiSummary" class="tw-text-gray-700 tw-whitespace-pre-line tw-max-h-[200px] tw-overflow-y-auto tw-pr-2 tw-scrollbar-thin tw-scrollbar-thumb-[#22c55e] tw-scrollbar-track-gray-200 tw-scrollbar-thumb-rounded-full tw-scrollbar-track-rounded-full">
          Forecast will appear here
        </div>
      </div>

      <!-- Detailed Report Card -->
      <div class="tw-bg-gray-50 tw-rounded-xl tw-shadow-inner tw-p-4 tw-flex-1">
        <h3 class="tw-font-semibold tw-mb-2">Detailed Report</h3>
        <div id="aiForecastNarrative" class="tw-text-gray-700 tw-whitespace-pre-line tw-max-h-[300px] tw-overflow-y-auto tw-pr-2 tw-scrollbar-thin tw-scrollbar-thumb-[#22c55e] tw-scrollbar-track-gray-200 tw-scrollbar-thumb-rounded-full tw-scrollbar-track-rounded-full">
          A detailed narrative will appear here
        </div>
      </div>

    </div>

    <!-- Right Column: Forecast Stats -->
    <div class="tw-w-full lg:tw-w-[30vw] tw-bg-white tw-rounded-3xl tw-shadow-md tw-p-6 tw-flex tw-flex-col tw-gap-6 tw-self-start">

      <h2 class="tw-font-bold tw-text-xl">Forecast Insights</h2>

      <!-- Forecasted Rating -->
      <div class="tw-text-center">
        <h1 id="aiForecastRating" class="tw-text-4xl tw-font-bold tw-text-[#1f2937]">--</h1>
        <div id="forecastStars" class="tw-flex tw-justify-center tw-text-yellow-400 tw-mt-1">
          ☆☆☆☆☆
        </div>
        <p class="tw-text-gray-500 tw-text-sm tw-mt-1">Predicted satisfaction rating</p>
      </div>

      <!-- Sentiment Chart -->
      <div class="tw-bg-gray-50 tw-rounded-xl tw-p-4 tw-h-64">
        <h3 class="tw-font-semibold tw-mb-2">Sentiment Trend</h3>
        <canvas id="sentimentChart" class="tw-w-full tw-h-full"></canvas>
      </div>

    </div>
  </div>

  <!-- FOOTER -->
    <footer class="tw-py-6 tw-text-center tw-text-sm tw-text-gray-500 tw-mt-12">
      © 2025 LotMatch Interactive 3D Mapping with Forecasting Data Analytics. All rights reserved.
    </footer>
</div>
@endsection

@section('scripts')
  @vite('resources/js/charts/forecast.js')
  @vite('resources/js/smoothSticky.js')
@endsection
