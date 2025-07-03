<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Review;
use Illuminate\Support\Facades\Log;

class SummaryService
{
    public function generateBlockSummaryViaHuggingFace($blockId)
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
        Log::info('Length of summary input (chars): ' . strlen($textToSummarize));

       
        
        $input = Str::words($textToSummarize, 150);

        // chatgpt prio
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
                    return $summary;
                } else {
                    Log::warning('OpenAI failed. Falling back to Hugging Face', ['status' => $response->status()]);
                }
            } catch (\Exception $e) {
                Log::error('OpenAI request failed. Falling back to Hugging Face', ['message' => $e->getMessage()]);
            }
        } else {
            Log::warning('OpenAI key not set. Using Hugging Face instead.');
        }

        // fallback to Hugging Face
        $apiKey = config('services.huggingface.api_key');

        if (!$apiKey) {
            Log::error('Hugging Face API key is missing.');
            return "Summary cannot be generated: API Key is missing.";
        }
        
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.huggingface.api_key'),
            ])
            ->timeout(90)
            ->retry(3, 5000)
            ->post('https://api-inference.huggingface.co/models/sshleifer/distilbart-cnn-12-6', [
                'inputs' => $input,
                'parameters' => [
                    'max_length' => 100,
                    'min_length' => 40,
                ]
            ]);

            if ($response->successful()) {
                $summary = $response->json()[0]['summary_text'] ?? null;
                
                Log::info('Hugging Face AI Summary:', ['summary' => $summary]);
                Log::info('Hugging Face Summary Raw Response:', $response->json());

                return $summary;    
            } else {
                Log::error('Hugging Face summary failed.', [
                    'block_id' => $blockId,
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }

         
        } catch (\Exception $e) {
            Log::error('Hugging Face API request exception', [
                'block_id' => $blockId,
                'message' => $e->getMessage(),
            ]);
        }

        return "[AI summary unavailable due to server error.]";
    }
}

?>