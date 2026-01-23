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





    public function checkToxicity(string $comment): bool
    {
        try {
            $hfResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('HUGGINGFACE_API_KEY'),
                'User-Agent' => 'LaravelApp/1.0'
            ])->post('https://router.huggingface.co/models/unitary/toxic-bert', [
                'inputs' => $comment
            ]);

            if ($hfResponse->failed()) {
                Log::error('Hugging Face API request failed', [
                    'status' => $hfResponse->status(),
                    'body'   => $hfResponse->body()
                ]);
                return false; 
            }

            $toxicity = $hfResponse->json();

            if (!isset($toxicity[0]) || isset($toxicity['error'])) {
                Log::warning('Hugging Face API returned unexpected response', [
                    'response' => $toxicity
                ]);
                return false;
            }

            // dd($hfResponse->json());

            foreach ($toxicity[0] as $label => $score) {
                if (in_array($label, ['toxic', 'severe_toxic', 'obscene', 'insult', 'threat']) 
                    && $score >= 0.5) 
                {
                    return true; 
                }
            }

            return false; 

        } catch (\Exception $e) {
            Log::error('Error calling Hugging Face API', [
                'message' => $e->getMessage()
            ]);
            return false; 
        }
    }



    protected $bannedWords = [
        'ass', 'bastard', 'bitch', 'bollocks', 'bugger', 'crap', 'cunt', 
        'damn', 'dick', 'dyke', 'fag', 'fuck', 'goddamn', 'hell', 'homo', 
        'idiot', 'jackass', 'jerk', 'kike', 'loser', 'moron', 'nigger', 
        'piss', 'prick', 'slut', 'shit', 'twat', 'whore', 'wanker'
    ];


    public function store(Request $request) {

        $request->validate([
            'block_id' => 'required|exists:blocks,id',  
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $block = Block::find($request->block_id);

        if (!$block) {
            return response()->json([
                'message' => 'Review updated, but block not found.',
            ], 404);
        }

        $comment = $request->comment;

        // -----------------------------
        // BASIC CONTENT FILTERS
        // -----------------------------
        if ($comment) {
            /* if ($this->checkToxicity($comment)) {
                return response()->json([
                    'message' => 'Comment detected as toxic. Please revise.'
                ], 422);
            } else {
                Log::error('Toxicity Check failed!');
            } */
            
            if (strlen(trim($comment)) < 15) {
                return response()->json([
                    'message' => 'Comment is too short (minimum 15 characters).'
                ], 422);
            }

            if (preg_match('/(.)\1{5,}/', $comment)) {
                return response()->json([
                    'message' => 'Comment contains repeated characters.'
                ], 422);
            }

            $existsIdentical = Review::where('user_id', Auth::id())
                ->where('block_id', $request->block_id)
                ->where('comment', $comment)
                ->exists();

            if ($existsIdentical) {
                return response()->json([
                    'message' => 'You have already submitted this exact comment.'
                ], 422);
            }
            

            $pattern = '/(' . implode('|', $this->bannedWords) . '|https?:\/\/\S+)/i';
            if (preg_match($pattern, $comment)) {
                return response()->json([
                    'message' => 'Comment contains prohibited content or links.'
                ], 422);
            }
        }

        // -----------------------------
        // CREATE OR UPDATE REVIEW
        // -----------------------------
        $existingReview = Review::where('user_id', Auth::id())
                                ->where('block_id', $request->block_id) 
                                ->first();

        $review = null;
        if ($existingReview) {
            $existingReview->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);
        } else {
            $review = Review::create([
                'user_id' => Auth::id(),
                'block_id' => $request->block_id,  
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);
        }

        // unify
        $finalReview = $existingReview ?? $review;

        // -----------------------------
        // DISPATCH JOBS
        // -----------------------------
        if ($request->comment && isset($finalReview)) {
            $block->update(['forecast_status' => 'processing']);

            DB::afterCommit(function () use ($finalReview, $request) {
                $chain = [
                    (new \App\Jobs\ProcessBlockForecast($request->block_id, app(\App\Services\SummaryService::class)))->delay(now()->addSeconds(3))
                ];

                dispatch(
                    (new AnalyzeSentimentJob($finalReview->id, $request->comment))
                        ->delay(now()->addSeconds(5))
                        ->chain($chain)
                );
            });
        }

        $block->load('reviews.user');

        $reviewsMapped = $block->reviews->map(function ($review) {
            $user = $review->user;
            $username = $user ? trim($user->first_name . ' ' . $user->last_name) : 'Unknown Person';
            return [
                'id' => $review->id,
                'user_id' => $review->user_id,
                'user_name' => $username, 
                'role' => $review->user->role ?? 'buyer',
                'rating' => $review->rating,
                'comment' => $review->comment,
                'created_at' => $review->created_at->toDateTimeString(),
            ];
        });

        $blockMapped = $block->toArray();
        $blockMapped['reviews'] = $reviewsMapped;
        


        $finalReview->load('user', 'block'); 
        return response()->json([
            'message' => 'Review submitted successfully!',
            'block' => $blockMapped,  
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review = Review::findOrFail($id);

        // ensure review belongs to the authenticated user
        if ($review->user_id != Auth::id()) {
            return response()->json(['message' => 'You can only update your own reviews.'], 403);
        }

        // update review data
        $review->update($request->only('rating', 'comment'));

        // re-run forecast and sentiment analysis if comment updated
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

        // load block with all reviews + user info
        $block = \App\Models\Block::with('reviews.user')->find($review->block_id);

        if (!$block) {
            return response()->json([
                'message' => 'Review updated, but block not found.',
            ], 404);
        }

        // Map reviews to include user_name and role (same as store)
        $reviewsMapped = $block->reviews->map(fn($r) => [
            'id' => $r->id,
            'user_id' => $r->user_id,
            'user_name' => $r->user->name ?? 'Unknown',
            'role' => $r->user->role ?? 'buyer',
            'rating' => $r->rating,
            'comment' => $r->comment,
            'created_at' => $r->created_at->toDateTimeString(),
        ]);

        $blockMapped = $block->toArray();
        $blockMapped['reviews'] = $reviewsMapped;

        // ensure review also includes its user relationship
        $review->load('user');

        return response()->json([
            'message' => 'Review updated successfully!',
            'block' => $blockMapped,
            'review' => $review,
        ]);
    }


public function destroy($id)
{
    $review = Review::findOrFail($id);
    $user = Auth::user();

    // allow deletion if user is the review owner OR an admin
    if ($review->user_id !== $user->id && $user->role !== 'admin') {
        return response()->json(['message' => 'Unauthorized.'], 403);
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

