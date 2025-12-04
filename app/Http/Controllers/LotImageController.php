<?php

namespace App\Http\Controllers;

use App\Models\LotImage;
use Illuminate\Support\Facades\Log;

class LotImageController extends Controller
{
    public function index($lotId)
    {
        $images = LotImage::where('lot_id', $lotId)->get(['path']);
        return response()->json($images);
    }
    public function fallback()
    {
        $fallbackFolder = storage_path('app/public/fallback_images'); 

        if (!is_dir($fallbackFolder)) {
            Log::info('Folder does not exist: ' . $fallbackFolder);
            return response()->json([]);
        }

        $files = \File::files($fallbackFolder);

        if (empty($files)) {
            Log::info('No files found in: ' . $fallbackFolder);
            return response()->json([]);
        }

        $images = array_map(function ($file) {
            return ['path' => 'fallback_images/' . $file->getFilename()];
        }, $files);

        Log::info('Fallback images found: ', $images);

        return response()->json($images);
    }


}