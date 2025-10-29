<?php

namespace App\Jobs;

use App\Models\Block;
use App\Services\SummaryService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessBlockForecast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $blockId;
    protected $summaryService;

    public function __construct($blockId, SummaryService $summaryService)
    {
        $this->blockId = $blockId;
        $this->summaryService = $summaryService;
    }

    public function handle()
    {
        $block = Block::find($this->blockId);
        if (!$block) return;

        \Log::info("[ProcessBlockForecast] Started for Block ID: {$this->blockId}");
        $block->update(['forecast_status' => 'processing']);

        // Exponential Moving Average
        $forecastedRating = app()->make(\App\Http\Controllers\ForecastController::class)
                                ->calculateForecast($this->blockId);

        // Sentiment trends
        $sentiments = app()->make(\App\Http\Controllers\ForecastController::class)
                          ->fetchSentimentTrends($this->blockId);

        // AI Summary
        $summary = $this->summaryService->generateFullForecastNarrative($this->blockId, $forecastedRating, $sentiments);

        // Detailed Report
        $detailedReport = $this->summaryService->generateDetailedForecastReport($this->blockId, $summary, $forecastedRating, $sentiments);


        // Save to blocks table
        $block->update([
            'ai_summary' => $summary,
            'full_forecast_report' => $detailedReport,
            'forecasted_rating' => $forecastedRating,
            'sentiment_data' => json_encode($sentiments),
            'forecast_updated_at' => now(),
            'forecast_status' => 'done',
        ]);
        \Log::info('[DEBUG] Forecast status after job:', ['status' => $block->forecast_status]);
        \Log::info("[ProcessBlockForecast] Completed for Block ID: {$this->blockId}");
    }
}