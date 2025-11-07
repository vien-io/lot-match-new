<?php

namespace App\Console\Commands;

use App\Jobs\GenerateLotAiSummaryJob;
use Illuminate\Console\Command;
use App\Models\Lot;
use App\Services\AiSummaryService;

class GenerateAiSummaries extends Command
{
    protected $signature = 'lots:generate-ai-summaries';
    protected $description = 'Generate AI summaries for lots that have changed';

    protected AiSummaryService $aiService;

    public function __construct(AiSummaryService $aiService)
    {
        parent::__construct();
        $this->aiService = $aiService;
    }

    public function handle()
    {
        $lots = Lot::where('status', 'available')
            ->where(function ($query) {
                $query->whereNull('last_ai_summary_at')
                    ->orWhereColumn('updated_at', '>', 'last_ai_summary_at');
            })
            ->get();

            $this->info("Found {$lots->count()} available lots for summarization.");

        if ($lots->isEmpty()) {
            $this->info('No lots to summarize.');
            return 0;
        }

        foreach ($lots as $i => $lot) {
            GenerateLotAiSummaryJob::dispatch($lot)
                ->onQueue('ai-summaries')
                ->delay(now()->addSeconds($i * 2));

            $this->info("Dispatched job for Lot ID {$lot->id}");
        }

        $this->info("Dispatched {$lots->count()} AI summary jobs.");
        return 0;
    }

}