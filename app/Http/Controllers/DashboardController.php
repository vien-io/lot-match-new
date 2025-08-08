<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Block;
use App\Models\Lot;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $totalBlocks = Block::count();
        $totalLots = Lot::count();
        $avgRating = Review::avg('rating') ?? 0;
        $newReviewsThisMonth = Review::whereMonth('created_at', now()->month)->count();
        $recentReviews = Review::latest()->limit(5)->get();

        $ratingsDistribution = Review::select('rating', DB::raw('count(*) as count'))
        ->groupBy('rating')
        ->pluck('count', 'rating')
        ->toArray();

        return view('dashboard', compact(
            'totalBlocks',
            'totalLots',
            'avgRating',
            'newReviewsThisMonth',
            'recentReviews',
            'ratingsDistribution'
        ));
    }
}
