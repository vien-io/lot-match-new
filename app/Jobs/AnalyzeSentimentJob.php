<?php

namespace App\Jobs;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class AnalyzeSentimentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $reviewId;
    public $comment;

    public function __construct($reviewId, $comment)
    {
        $this->reviewId = $reviewId;
        $this->comment = $comment;
    }

    public function handle()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.huggingface.api_key'),
            ])
            ->timeout(60)
            ->post('https://api-inference.huggingface.co/models/cardiffnlp/twitter-roberta-base-sentiment', [
                'inputs' => $this->comment,
            ]);

            $label = null;
            if ($response->successful()) {
                $result = $response->json()[0];
                $label = $result[0]['label'] ?? null;
            }

            $sentiment = match ($label) {
                'LABEL_0' => 'negative',
                'LABEL_1' => 'neutral',
                'LABEL_2' => 'positive',
                default => 'neutral',
            };

            $review = Review::find($this->reviewId);
            if ($review) {
                $review->sentiment = $sentiment;
                $review->save();

                Log::info('Sentiment analysis completed', [
                    'comment' => $this->comment,
                    'sentiment' => $sentiment
                ]);
            }

        } catch (\Throwable $e) {
            Log::error('Sentiment analysis failed', [
                'review_id' => $this->reviewId,
                'error' => $e->getMessage()
            ]);
        }
    }
}
