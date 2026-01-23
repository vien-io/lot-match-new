<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OpenAITestController extends Controller
{
    public function test()
    {
        try {
            $response = Http::withToken(config('services.openai.api_key'))
                ->timeout(20)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'user', 'content' => 'Say hello in one sentence.']
                    ],
                    'max_tokens' => 20,
                ]);

                if ($response->failed()) {
                    return response()->json([
                        'status' => 'failed',
                        'http_status' => $response->status(),
                        'error' => $response->json(),
                    ], 500);
                }

                return response()->json([
                    'status' => 'ok',
                    'reply' => $response->json()['choices'][0]['message']['content'] ?? null,
                ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'exception',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
