<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Lot;
use Illuminate\Support\Facades\Log;

class AiSummaryService
{
    protected string $apiKey;
    protected bool $enabled;

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
        $this->enabled = env('AI_SUMMARY_ENABLED', true);
    }

    public function getLotSummary(Lot $lot): string
    {
        if ($lot->ai_summary) {
            return $this->formatAsHtml($lot->ai_summary);
        }

        if (!$this->apiKey || !$this->enabled) {
            return '<p>AI summarization is disabled.</p>';
        }

        $prompt = $this->buildPrompt($lot);

        try {
            $response = Http::withToken($this->apiKey)
                ->timeout(30)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a professional real estate summarizer.'],
                        ['role' => 'user', 'content' => $prompt]
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 150,
                ]);

            $summary = $response->json()['choices'][0]['message']['content'] ?? '[No content returned]';

            $lot->ai_summary = $summary;
            $lot->save();

            return $this->formatAsHtml($summary);
        } catch (\Exception $e) {
            return '<p>Failed to generate AI summary.</p>';
        }
    }

    protected function formatAsHtml(string $text): string
    {
        $paragraphs = preg_split('/\r?\n\r?\n|\r?\n/', $text, -1, PREG_SPLIT_NO_EMPTY);
        return collect($paragraphs)->map(fn($p) => '<p>'.trim($p).'</p>')->implode("\n");
    }

    protected function buildPrompt(Lot $lot): string
    {
        Log::info('Generating AI summary prompt for lot:', [
        'name' => $lot->name,
        'lot_area' => $lot->lot_area,
        'floor_area' => $lot->floor_area,
        'price' => $lot->price,
        'block_id' => $lot->block_id,
        'status' => $lot->status,
        'orientation' => $lot->orientation,
        'sunlight' => $lot->sunlight,
        'flood_risk' => $lot->flood_risk,
        'model_url' => $lot->modelUrl,
        ]);
        
        return <<<PROMPT
        Write a friendly, natural-sounding summary for a real estate buyer who might be interested in this lot. 
        The tone should be warm and inviting, like a property listing written by a helpful agent.
        Keep it concise — 3 to 4 sentences maximum. 
        Avoid technical jargon, and highlight what makes the lot appealing or worth considering.

        Details:
        - Lot: {$lot->name}
        - Lot Area: {$lot->lot_area} sqm
        - Floor Area: {$lot->floor_area} sqm
        - Price: PHP {$lot->price}
        - Block: {$lot->block_id}
        - Status: {$lot->status}
        - Orientation: {$lot->orientation}
        - Sunlight: {$lot->sunlight}
        - Flood Risk: {$lot->flood_risk}
        - Model URL: {$lot->modelUrl}

        Example tone: 
        This spacious and well-oriented lot offers a comfortable space perfect for a growing family. With its bright sunlight exposure and peaceful surroundings, it’s a great place to build your dream home.

        PROMPT;
    }

}