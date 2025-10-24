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
        if (!env('SENTIMENT_ENABLED', true)) {
            Log::info('Sentiment analysis skipped for review ID:', ['review_id' => $this->reviewId]);
            // update review with placeholder
            $review = Review::find($this->reviewId);
            if ($review) {
                $review->sentiment = 'neutral'; // or null
                $review->save();
            }

            return;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.huggingface.api_key'),
                'Content-Type' => 'application/json',
            ])
            ->timeout(90)
            ->retry(3, 5000)
            ->post('https://api-inference.huggingface.co/models/distilbert/distilbert-base-uncased-finetuned-sst-2-english', [
                'inputs' => $this->comment,
            ]);

            $sentiment = 'neutral';

            if ($response->successful()) {
                $result = $response->json();
                $label = $result[0][0]['label'] ?? null;

                $sentiment = match ($label) {
                    'NEGATIVE' => 'negative',
                    'POSITIVE' => 'positive',
                    default => 'neutral',
                };
            }




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
