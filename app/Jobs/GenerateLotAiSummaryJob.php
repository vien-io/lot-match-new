<?php

namespace App\Jobs;

use App\Models\Lot;
use App\Services\AiSummaryService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateLotAiSummaryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Lot $lot;

    /**
     * Create a new job instance.
     */
    public function __construct(Lot $lot)
    {
        $this->lot = $lot;
    }

    /**
     * Execute the job.
     */
    public function handle(AiSummaryService $aiService)
    {
        try {
            $aiService->getLotSummary($this->lot);

            // Update timestamp
            $this->lot->last_ai_summary_at = now();
            $this->lot->save();

            // Log::info("AI summary generated for Lot ID {$this->lot->id}");
        } catch (\Exception $e) {
            Log::error("Failed AI summary for Lot ID {$this->lot->id}: " . $e->getMessage());
        }
    }
}