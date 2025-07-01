<?php

namespace App\Jobs;

use App\Models\BlockSummary;
use App\Services\SummaryService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateBlockSummaryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $blockId;

    public function __construct($blockId)
    {
        $this->blockId = $blockId;
    }

    public function handle()
    {
        $summaryService = new SummaryService();
        $summary = $summaryService->generateBlockSummaryViaHuggingFace($this->blockId);

        if ($summary) {
            BlockSummary::updateOrCreate(
                ['block_id' => $this->blockId],
                ['summary' => $summary]
            );
        Log::info('AI summary job completed for block ID: ' . $this->blockId);
        } else {
            Log::warning('AI summary job failed or returned null for block ID: ' . $this->blockId);
        }
    }
}
