<?php
namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Block;
use App\Models\BlockSummary;
use App\Services\SummaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Jobs\GenerateBlockSummaryJob;
use App\Jobs\AnalyzeSentimentJob;
use Illuminate\Support\Facades\DB;


class ReviewController extends Controller
{

    public function blockReviews($blockId = null)
    {
        $query = Review::with(['user', 'block']);

        if ($blockId && $blockId !== 'all') {
            $query->where('block_id', $blockId);
        }

        $reviews = $query->latest()->get();

        $ratingCounts = [
            5 => $reviews->where('rating', 5)->count(),
            4 => $reviews->where('rating', 4)->count(),
            3 => $reviews->where('rating', 3)->count(),
            2 => $reviews->where('rating', 2)->count(),
            1 => $reviews->where('rating', 1)->count(),
        ];

        return response()->json([
            'reviews' => $reviews,
            'averageRating' => $reviews->avg('rating') ?? 0,
            'totalReviews' => $reviews->count(),
            'ratingCounts' => $ratingCounts,
        ]);
    }



    public function index(Request $request)
    {
        $reviewsQuery = Review::with('user');

        if ($request->has('block_id')) {
            $reviewsQuery->where('block_id', $request->block_id);
        }

        $reviews = $reviewsQuery->latest()->get();
        $averageRating = $reviewsQuery->avg('rating') ?? 0;

        $ratingCounts = [
            5 => $reviews->where('rating', 5)->count(),
            4 => $reviews->where('rating', 4)->count(),
            3 => $reviews->where('rating', 3)->count(),
            2 => $reviews->where('rating', 2)->count(),
            1 => $reviews->where('rating', 1)->count(),
        ];
        // return JSON if AJAX
        if ($request->wantsJson()) {
            return response()->json([
                'reviews' => $reviews,
                'averageRating' => $averageRating,
                'totalReviews' => $reviews->count(),
                'ratingCounts' => $ratingCounts,
            ]);
        }

        $blocks = Block::all(); 
        return view('reviews.index', compact('reviews', 'averageRating', 'ratingCounts', 'blocks'));
    }







    public function store(Request $request) {
        Log::info("ReviewController store is called");

        $request->validate([
            'block_id' => 'required|exists:blocks,id',  
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        // check if user has already submitted review for the block
        $existingReview = Review::where('user_id', Auth::id())
                                ->where('block_id', $request->block_id) 
                                ->first();

        if ($existingReview) {
            // update existing review
            $existingReview->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);



        } else {
            // create new review
            $review = Review::create([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'block_id' => $request->block_id,  
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);

            
        }

        // unify
        $finalReview = $existingReview ?? $review;


        if ($request->comment && isset($finalReview)) {
            DB::afterCommit(function () use ($finalReview, $request) {
                $chain = [
                    // (new GenerateBlockSummaryJob($request->block_id))->delay(now()->addSeconds(2)),
                    // temporarily removed GenerateBlockSummaryJob because its redundant (two calls)
                    (new \App\Jobs\ProcessBlockForecast($request->block_id, app(\App\Services\SummaryService::class)))->delay(now()->addSeconds(3))
                ];

                dispatch(
                    (new AnalyzeSentimentJob($finalReview->id, $request->comment))
                        ->delay(now()->addSeconds(5))
                        ->chain($chain)
                );
            });
        }

        // fetch block with its reviews and related user info
        $block = Block::with('reviews.user')->find($request->block_id);
        

        if (!$block) {
            return response()->json([
                'message' => 'Review updated, but block not found.',
            ], 404);
        }

        $finalReview->load('user', 'block'); 
        return response()->json([
            'message' => 'Review submitted successfully!',
            'block' => $block,  
            'review' => $finalReview,  
        ]);
    }

    public function edit($id) {
        $review = Review::findOrFail($id);

        // make sure review belongs to the authenticated user
        if ($review->user_id != Auth::id()) {
            return response()->json(['message' => 'You can only edit your own reviews.'], 403);
        }

        return response()->json($review); 
    }

    public function update(Request $request, $id) {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review = Review::findOrFail($id);

        // make sure review belongs to authenticated user
        if ($review->user_id != Auth::id()) {
            return response()->json(['message' => 'You can only update your own reviews.'], 403);
        }

        // update review
        $review->update($request->only('rating', 'comment'));

        // analyze and update sentiment
        /* if ($request->comment) {
            $sentiment = $this->analyzeSentimentViaHuggingFace($request->comment);

            Log::info('Sentiment Result (update method):', [
                'comment' => $request->comment,
                'sentiment' => $sentiment
            ]);

            $review->sentiment = strtolower($sentiment);
            $review->save();
        } */
        if ($request->comment) {
            DB::afterCommit(function () use ($review, $request) {
                $chain = [
                    (new \App\Jobs\ProcessBlockForecast(
                        $review->block_id,
                        app(\App\Services\SummaryService::class)
                    ))->delay(now()->addSeconds(3))
                ];

                dispatch(
                    (new AnalyzeSentimentJob($review->id, $request->comment))
                        ->delay(now()->addSeconds(5))
                        ->chain($chain)
                );
            });
        }
        $block = \App\Models\Block::with('reviews.user')->find($review->block_id);
        if (!$block) {
            return response()->json([
                'message' => 'Review updated, but block not found.',
            ], 404);
        }

        return response()->json([
            'message' => 'Review updated successfully!',
            'block' => $block,
            'review' => $review,
        ]);
    }

    public function destroy($id) {
        $review = Review::findOrFail($id);

        // make sure review belongs to the authenticated user
        if ($review->user_id != Auth::id()) {
            return response()->json(['message' => 'You can only delete your own reviews.'], 403);
        }

        $review->delete();

        return response()->json(['message' => 'Review deleted successfully!']);
    }

// this part needs review, mightve been useless now
    private function analyzeSentimentViaHuggingFace($text)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.huggingface.api_key'),
        ])->post('https://api-inference.huggingface.co/models/cardiffnlp/twitter-roberta-base-sentiment', [
            'inputs' => $text
        ]);

        if ($response->successful()) {
            $result = $response->json();
            Log::info('Hugging Face Raw Response: ', $result);

            $labelMap = [
                'LABEL_0' => 'negative',
                'LABEL_1' => 'neutral',
                'LABEL_2' => 'positive',
            ];

            $scores = $result[0] ?? [];
            if (empty($scores)) {
                return null;
            }

            // sort by score descending
            usort($scores, function ($a, $b) {
                return $b['score'] <=> $a['score'];
            });

            $top = $scores[0];
            $label = $top['label'] ?? null;
            
            return $labelMap[$label] ?? 'neutral';
        } 

         Log::error('Hugging Face API failed:', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
        return null;
    }


}

