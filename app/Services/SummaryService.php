<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Review;
use Illuminate\Support\Facades\Log;

class SummaryService
{
    public function generateFullForecastNarrative($blockId, $forecast, $sentiments)
    {
        $summary = $this->generateBlockSummaryViaGPT($blockId);

        $sentimentText = collect($sentiments)->map(function ($value, $month) {
            return "$month: " . $value['positive'] . " positive, " . $value['negative'] . "negative";
        })->implode('; ');

        /* $prompt = "Here is a brief summary of resident comments: {$summary}. The forecasted average rating is {$forecast}. Sentiment trends: {$sentimentText}. Generate a short, helpful narrative for a user deciding whether this block is livable. Give me a forecast on what it's like living on that block."; */

        $prompt = <<<PROMPT
        You are analyzing neighborhood livability based on resident reviews, forecasted satisfaction scores, and monthly sentiment trends.

        Here is a summary of recent comments:
        {$summary}

        The forecasted average rating is {$forecast} (on a scale of 1 to 5).

        Here are the monthly sentiment details:
        {$sentimentText}

        Based on this data, provide:
        1. Key highlights residents mentioned (positives or issues).
        2. Noticeable trends over time (e.g., improving, declining, or fluctuating satisfaction).
        3. A forecast-style narrative for someone considering moving into this block.

        Keep it brief, practical, and helpful.
        PROMPT;
        
        $response = Http::withToken(config('services.openai.api_key'))
            ->timeout(30)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are an assistant summarizing neigborhood livability based on sentiment trends, forecasted ratings, and resident feedback'],
                    ['role' => 'user', 'content' => $prompt]
                ],
                'temperature' => 0.7,
                'max_tokens' => 200,
            ]);

            if ($response->successful()) {
                return $response->json()['choices'][0]['message']['content'] ?? null;
            }
            return '[GPT forecast narrative unavailable.]';
    }

   

    public function generateBlockSummaryViaGPT($blockId)
    {
        $reviews = Review::where('block_id', $blockId)
        ->whereNotNull('comment')
        ->orderBy('updated_at', 'desc')
        ->limit(10)
        ->pluck('comment')
        ->toArray();

        if(empty($reviews)) {
            return null;
        }

        $textToSummarize = implode(' ', $reviews);
        Log::info('Combined comments for summarization:', ['text' => $textToSummarize]);

        Log::info('Length of summary input (chars): ' . strlen($textToSummarize));

       
        
        $input = Str::words($textToSummarize, 150);
        // Log::info('The main string to summarize: ', ['text' => $input]);

      

        // gpt 3.5 turbo
        $openAiKey = config('services.openai.api_key');
        $aiEnabled = env('AI_SUMMARY_ENABLED', true);
        if ($openAiKey && $aiEnabled) {
            try {
                $response = Http::withToken($openAiKey)
                ->timeout(30)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => 'Summarize these resident comments in a helpful tone.'],
                        ['role' => 'user', 'content' => $input]
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 150,
                ]);

                if ($response->successful()) {
                    $summary = $response->json()['choices'][0]['message']['content'] ?? null;
                    Log::info('OpenAI summary used.');
                    Log::info('Summary Content:', ['summary' => $summary]);
                    return $summary;
                } else {
                    Log::warning('OpenAI failed. ', ['status' => $response->status()]);
                }
            } catch (\Exception $e) {
                Log::error('OpenAI request failed. ', ['message' => $e->getMessage()]);
            }
        } else {
            Log::info('OpenAI summary skipped: AI_SUMMARY_ENABLED is false or missing API key.');
            return '[AI summary disabled temporarily.]';
        }

        

        return "[AI summary unavailable due to server error.]";
    }
}

?>