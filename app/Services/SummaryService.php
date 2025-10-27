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

        

        $prompt = <<<PROMPT
        You are analyzing neighborhood livability for someone considering moving to this block.

        Here is the summary of resident comments:
        {$summary}

        Forecasted average rating: {$forecast} (on a scale of 1 to 5)
        Monthly sentiment data: {$sentimentText}

        Produce a friendly, human-readable narrative that:
        - Forecasts what daily life and community experience on this block is like
        - Highlights what residents enjoy and what challenges they face
        - Explains positive and negative sentiment trends over time in plain language
        - Gives practical advice and considerations for someone thinking about moving here

        Focus on a narrative perspective: “what it’s like to live here.” Keep the tone engaging, natural, and concise, avoiding technical jargon or raw data tables.
        PROMPT;


        
        $response = Http::withToken(config('services.openai.api_key'))
            ->timeout(30)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a neighborhood expert. Your task is to forecast what living on a specific block is like, based on resident comments, sentiment trends, and forecasted ratings. Focus on interpreting the experience, not just summarizing past comments.'],
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
        Log::info('The main string to summarize: ', ['text' => $input]);

      

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
                        ['role' => 'system', 'content' => 'Summarize these resident comments.'],
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

    public function generateDetailedForecastReport($blockId, $summary, $forecastedRating, $sentiments)
    {
        $sentimentText = collect($sentiments)->map(function ($value, $month) {
            return "$month: " . $value['positive'] . " positive, " . $value['negative'] . " negative.";
        })->implode('; ');

        $prompt = <<<PROMPT
        Reformat the following neighborhood forecast into a professional, structured data analytics report.
        Include:
        1. Executive Summary
        2. Sentiment Trend Analysis
        3. Forecast Details
        4. Recommendations

        Keep the meaning and forecast values exactly the same

        Forecast paragraph:
        {$summary}

        Monthly Sentiment Data:
        {$sentimentText}

        Forecasted Rating:
        {$forecastedRating}
        PROMPT;


        $openAiKey = config('services.openai.api_key');
        $aiEnabled = env('AI_SUMMARY_ENABLED', true);

        if ($openAiKey && $aiEnabled) {
            try {
                $response = Http::withToken($openAiKey)
                    ->timeout(30)
                    ->post('https://api.openai.com/v1/chat/completions', [
                        'model' => 'gpt-3.5-turbo',
                        'messages' => [
                            ['role' => 'system', 'content' => 'You are a data analyst summarizing neighborhood livability with structured report.'],
                            ['role' => 'user', 'content' => $prompt]
                        ],
                        'temperature' => 0.7,
                        'max_tokens' => 600,
                    ]);

                    if ($response->successful()){
                        return $response->json()['choices'][0]['message']['content'] ?? '[No content returned]';
                    } else {
                        Log::warning('OpenAI detailed report failed', ['status' => $response->status()]);
                    }
            } catch (\Exception $e) {
                Log::error('OpenAI request failed for detailed report', ['message' => $e->getMessage()]);
            }
        } else {
            Log::info('OpenAI detailed report skipped or missing an API key');
        }
        return '[Detailed forecast report unavailable]';
    }
}

?>