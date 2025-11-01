<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LotController extends Controller
{
    public function getLots($blockId)
    {
        $lots = Lot::where('block_id', $blockId)->get();
        return response()->json($lots);
    }

    public function show($blockId, $lotNumber)
    {
        $lotName = "Lot " . $lotNumber;

        // Fetch lot with reviews
        $lot = Lot::with('reviews.user')
            ->where('block_id', $blockId)
            ->where('name', $lotName)
            ->first();

        if (!$lot) {
            return response()->json(['error' => 'Lot not found'], 404);
        }

        // Map reviews
        $reviews = $lot->reviews->map(function ($review) {
            return [
                'id' => $review->id,
                'user_id' => $review->user_id,
                'user_name' => $review->user->name ?? 'Unknown', 
                'rating' => $review->rating,
                'comment' => $review->comment,
                'created_at' => $review->created_at->toDateTimeString(),
            ];
        });

        // Check if the authenticated user already has a review
        $existingReview = Auth::check() ? $reviews->firstWhere('user_id', Auth::id()) : null;

        // Return all lot attributes dynamically
        $lotData = $lot->toArray(); // converts all DB columns to array
        $lotData['reviews'] = $reviews;
        $lotData['existingReview'] = $existingReview;

        return response()->json($lotData);
    }

    public function addImage(Request $request)
    {
        Log::info('addImage called', [
        'lot_id' => $request->lot_id,
        'has_file' => $request->hasFile('image'),
        'file_name' => $request->file('image')?->getClientOriginalName()
    ]);

        $request->validate([
            'lot_id' => 'required|exists:lots,id',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:4096',
        ]);
        
        $lot = Lot::findOrFail($request->lot_id);

        // store uploaded image in storage/app/public/lot_images
        $path = $request->file('image')->store('lot_images', 'public');

        $image = \App\Models\LotImage::create([
            'lot_id' => $lot->id,
            'path' => $path,
        ]);

        Log::info('LotImage created', ['id' => $image->id, 'path' => $image->path]);

        return response()->json([
            'message' => 'Image uploaded successfuly', 
            'path' => $path
        ]);
    }

    public function generateSummary($lotId)
    {
        $lot = Lot::findOrFail($lotId);
        

    }


}
