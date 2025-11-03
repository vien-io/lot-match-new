<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Block;
use App\Models\Lot;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        // Example: search blocks first
        $block = Block::where('name', 'like', "%{$query}%")->first();
        if ($block) {
            return redirect()->route('blocks.show', $block->id);
        }

        // Search lots
        $lot = Lot::where('name', 'like', "%{$query}%")->first();
        if ($lot) {
            return redirect()->route('lots.show', [
                'blockId' => $lot->block_id,
                'lotNumber' => $lot->name, 
            ]);
        }

        // Default: redirect to dashboard or show "not found"
        return redirect()->route('dashboard')->with('error', 'No results found for "' . $query . '"');
    }
}
