<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\SummaryService;

class SummaryServiceTest extends TestCase
{
    // use RefreshDatabase; // uncomment if you're testing DB state

    /** @test */
    public function it_returns_ai_summary_when_huggingface_response_is_successful()
    {
        // fake the huggingface API response
        Http::fake([
            'https://api-inference.huggingface.co/*' => Http::response([
                ['summary_text' => 'This is a test summary.']
            ], 200)
        ]);

        // mock block_id with sample data in DB or just use existing one
        $service = new SummaryService();
        $summary = $service->generateBlockSummaryViaHuggingFace(1);

        // assert the summary matches the fake response
        $this->assertEquals('This is a test summary.', $summary);
    }

    /** @test */
    public function it_handles_huggingface_failure_gracefully()
    {
        // simulate Hugging Face server error
        Http::fake([
            'https://api-inference.huggingface.co/*' => Http::response('Service Unavailable', 503)
        ]);

        $service = new SummaryService();
        $summary = $service->generateBlockSummaryViaHuggingFace(1);

        $this->assertEquals('[AI summary unavailable due to server error.]', $summary);

    }
}
