<?php

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