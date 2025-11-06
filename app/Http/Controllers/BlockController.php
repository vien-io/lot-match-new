<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Block;
use Illuminate\Support\Facades\Auth;

class BlockController extends Controller
{
    public function getBlocks()
    {
        $blocks = Block::all();  // or use pagination if needed
        return response()->json($blocks);
    }
    public function show($id)
    {
        // eager load block-level reviews with user info
        $block = Block::with(['lots', 'reviews.user'])->find($id);
    
        if (!$block) {
            return response()->json(['error' => 'Block not found'], 404);
        }
    
        // structure reviews
        $reviews = $block->reviews->map(function ($review) {
            return [
                'id' => $review->id,
                'user_id' => $review->user_id,
                'user_name' => $review->user->name ?? 'Unknown',
                'role' => $review->user->role ?? null, 
                'rating' => $review->rating,
                'comment' => $review->comment,
                'created_at' => $review->created_at->toDateTimeString(),
            ];
        });
    
        $existingReview = $reviews->firstWhere('user_id', Auth::id());
    
        // structure lots
        $lots = $block->lots->map(function ($lot) {
            return [
                'id' => $lot->id,
                'name' => $lot->name,
                'lot_area' => $lot->lot_area,
                'price' => $lot->price,
                'block_id' => $lot->block_id,
                'owner_id' => $lot->owner_id, 
                'status' => $lot->status,
                'modelUrl' => $lot->model_url ? asset('models/' . $lot->model_url) : null,
            ];
        });
    
        return response()->json([
            'id' => $block->id,
            'name' => $block->name,
            'modelUrl' => $block->model_url ? asset('models/' . $block->model_url) : null,
            'lots' => $lots,
            'reviews' => $reviews,
            'existingReview' => $existingReview,
        ]);
    }

    public function showForecast(Block $block)
    {
        return view('block-forecast', ['block' => $block]);
    }

    public function getBlockWithReviewsAndLots(Block $block)
    {
        $block->load(['lots', 'reviews.user']); 

        $reviews = $block->reviews->map(function ($review) {
            return [
                'id' => $review->id,
                'user_id' => $review->user_id,
                'user_name' => $review->user->name ?? 'Unknown',
                'role' => $review->user->role ?? 'buyer',
                'rating' => $review->rating,
                'comment' => $review->comment,
                'created_at' => $review->created_at->toDateTimeString(),
            ];
        });

        $lots = $block->lots->map(function ($lot) {
            return [
                'id' => $lot->id,
                'name' => $lot->name,
                'owner_id' => $lot->owner_id, 
            ];
        });

        return response()->json([
            'id' => $block->id,
            'name' => $block->name,
            'modelUrl' => $block->model_url,
            'lots' => $lots,
            'reviews' => $reviews,
        ]);
    }




}
