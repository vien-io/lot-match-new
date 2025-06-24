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
        ->pluck('comment')
        ->toArray();

        if(empty($reviews)) {
            return null;
        }

        $textToSummarize = implode('. ', $reviews);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.huggingface.api_key'),
        ])->timeout(30)->post('https://api-inference.huggingface.co/models/facebook/bart-large-cnn', [
            'inputs' => Str::limit($textToSummarize, 2048),
            'parameters' => [
                'max_length' => 150,
                'min_length' => 60,
            ]
            ]);

            if ($response->successful()) {
                $summary = $response->json()[0]['summary_text'] ?? null;
                
                Log::info('Hugging Face AI Summary:', ['summary' => $summary]);
                Log::info('Hugging Face Summary Raw Response:', $response->json());

                return $summary;    
            }

            Log::error('Hugging Face summary failed.', [
                'block_id' => $blockId,
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            Log::info('Hugging Face Summary Raw Response:', $response->json());
            return null;
    }
}




?>