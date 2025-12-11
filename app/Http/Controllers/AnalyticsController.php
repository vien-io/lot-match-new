<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function dashboard()
    {
        // block ratings
        $blockRatings = DB::table('blocks as b')
        ->join('reviews as r', 'b.id', '=', 'r.block_id')
        ->select(
            'b.name',
            DB::raw('AVG(r.rating) as avg_rating'),
            DB::raw('COUNT(r.id) as total_reviews')
        )
        ->groupBy('b.name')
        ->get();
    

        $topRatedLots = DB::table('blocks as b')
            ->join('reviews as r', 'b.id', '=', 'r.block_id') 
            ->join('lots as l', 'b.id', '=', 'l.block_id')  
            ->select('l.id', 'l.name', 'l.price', DB::raw('AVG(r.rating) as avg_rating'))
            ->groupBy('l.id', 'l.name', 'l.price')
            ->orderByDesc('avg_rating')   
            ->limit(5)                 
            ->get();

        
        // lot available
        $availableLots = DB::table('lots')->where('status', 'available')->count();
        $soldLots = DB::table('lots')->where('status', 'sold')->count();
    

        // rating dist
        $rawDistribution = DB::table('reviews')
        ->select(DB::raw('FLOOR(rating) as rating'), DB::raw('COUNT(id) as count'))
        ->groupBy(DB::raw('FLOOR(rating)'))
        ->orderBy('rating')
        ->pluck('count', 'rating'); 
    
        // fill missing ratings with 0
        $ratingDistribution = collect(range(1, 5))->map(function ($rating) use ($rawDistribution) {
            return [
                'rating' => $rating,
                'count' => $rawDistribution->get($rating, 0)
            ];
        });

        $totalLots = DB::table('lots')->count();


        return view('analytics', compact(
            'blockRatings', 
            'topRatedLots', 
            // 'recentReviews', 
            'availableLots', 
            'soldLots', 
            'ratingDistribution',
            'totalLots'
        ));

    }
}
