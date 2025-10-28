<?php

namespace App\Http\Controllers;

use App\Models\LotImage;
use Illuminate\Http\Request;

class LotImageController extends Controller
{
    public function index($lotId)
    {
        $images = LotImage::where('lot_id', $lotId)->get(['path']);
        return response()->json($images);
    }
}