<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Review;
use Illuminate\Support\Facades\Log;

class SummaryService
{
    public function generateBlockSummaryViaGPT($blockId)
    {
        $reviews = Review::where('block_id', $blockId)
        ->whereNotNull('comment')
        ->orderBy('created_at', 'desc')
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

      

        // gpt 3.5 turbo
        $openAiKey = config('services.openai.api_key');
        if ($openAiKey) {
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
            Log::warning('OpenAI key not set.');
        }

        

        return "[AI summary unavailable due to server error.]";
    }
}

?>