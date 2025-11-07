<?php
// might not have been used, might be deletable
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Lot;
use Illuminate\Support\Facades\Http;

class GenerateLotSummary implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Lot $lot;

    public function __construct(Lot $lot)
    {
        $this->lot = $lot;        
    }

    public function handle(): void
    {
        $summaryPrompt = <<<PROMPT
        Summarize the following lot details into a professional residential summary paragraph. 
        Include the lot area, floor area, orientation, sunlight, flood risk, and view in natural language.

        Lot details:
        - Lot area: {$this->lot->lot_area} sqm
        - Floor area: {$this->lot->floor_area} sqm
        - Orientation: {$this->lot->orientation}
        - Sunlight: {$this->lot->sunlight}
        - Flood risk: {$this->lot->flood_risk}
        - View: {$this->lot->view}

        Output should be a single paragraph suitable for display on a website.
        PROMPT;

        $openAiKey = config('services.openai.key');

        $response = Http::withToken($openAiKey)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a real estate assistant writing professional lot summaries.'],
                    ['role' => 'user', 'content' => $summaryPrompt]
                ],
                'temperature' => 0.7,
                'max_tokens' => 200
            ]);

            $summary = $response->json('choices.0.message.content');

            $this->lot->ai_summary = $summary;
            $this->lot->save();
    }
}


?>