<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lot;
use Illuminate\Support\Facades\Auth;

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

        // fetch lot by both lot and block id
        $lot = Lot::with('reviews.user')
            ->where('block_id', $blockId)
            ->where('name', $lotName)
            ->first();

        if (!$lot) {
            return response()->json(['error' => 'Lot not found'], 404);
        }

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

        $existingReview = null;
        if (Auth::check()) {
            $existingReview = $reviews->firstWhere('user_id', Auth::id());
        }

        return response()->json([
            'id' => $lot->id,
            'name' => $lot->name,
            'description' => $lot->description,
            'size' => $lot->size,
            'price' => $lot->price,
            'block_id' => $lot->block_id,
            'reviews' => $reviews,
            'existingReview' => $existingReview, 
        ]);
    }

    public function addImage(Request $request)
    {
        $request->validate([
            'lot_id' => 'required|exists:lots,id',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:4096',
        ]);
        
        $lot = Lot::findOrFail($request->lot_id);

        // store uploaded image in storage/app/public/lot_images
        $path = $request->file('image')->store('lot_images', 'public');


        return response()->json(['message' => 'Image uploaded successfuly', 'path' => $path]);
    }


}
