<?php

use App\Http\Controllers\ForecastController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;

Route::get('/dummy-test', function () {
    return response()->json(['ok' => 'dummy route working']);
});

Route::post('/test-sentiment', function (Request $request) {
    $text = $request->input('text', '');

    $controller = new ReviewController();

    $sentiment = $controller->analyzeSentimentViaHuggingFace($text);

    return response()->json([
        'text' => $text,
        'sentiment' => $sentiment,
    ]);
});

Route::get('/blocks/{blockId}/insight', [ForecastController::class, 'getCombinedBlockInsight']);
Route::get('/forecast/summary/{blockId}', [ForecastController::class, 'getBlockSummary']);
Route::get('/forecast/data/{blockId}', [ForecastController::class, 'getForecastData']);