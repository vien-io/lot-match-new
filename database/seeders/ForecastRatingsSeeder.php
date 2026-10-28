<?php

namespace Database\Seeders;

use App\Services\ForecastService;
use Illuminate\Database\Seeder;

class ForecastRatingsSeeder extends Seeder
{
    public function run(): void
    {
        $updated = app(ForecastService::class)
            ->calculateForAllBlocks();

        $this->command?->info(
            "Forecast calculation complete. "
            . "Updated {$updated} blocks."
        );
    }
}
