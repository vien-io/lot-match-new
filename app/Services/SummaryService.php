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

        $apiKey = config('services.huggingface.api_key');

        if (!$apiKey) {
            Log::error('Hugging Face API key is missing.');
            return "Summary cannot be generated: API Key is missing.";
        }
        
        $input = Str::words($textToSummarize, 150);
        
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