<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Jobs\AnalyzeSentimentJob;

class ToolsController extends Controller
{
    public function backfillSentiment()
    {
        $reviews = Review::whereNull('sentiment')->limit(50)->get();

        foreach ($reviews as $review) {
            AnalyzeSentimentJob::dispatch($review->id, $review->comment);
        }

        return response()->json([
            'message' => 'Dispatched ' . count($reviews) . ' sentiment jobs.'
        ]);
    }
}
