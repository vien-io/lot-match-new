<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ForecastService
{
    /**
     * Calculate the EMA forecast for a block.
     */
    public function calculateForecast(
        int $blockId,
        float $alpha = 0.3
    ): ?float {
        $ratings = DB::table('reviews')
            ->where('block_id', $blockId)
            ->orderBy('created_at', 'asc')
            ->orderBy('id', 'asc')
            ->pluck('rating');

        if ($ratings->isEmpty()) {
            return null;
        }

        $ema = (float) $ratings[0];

        for ($i = 1; $i < $ratings->count(); $i++) {
            $ema = ($alpha * $ratings[$i])
                + ((1 - $alpha) * $ema);
        }

        return round($ema, 2);
    }

    /**
     * Calculate and save a single block's forecast.
     */
    public function calculateAndSaveForecast(
        int $blockId,
        float $alpha = 0.3
    ): ?float {
        $forecast = $this->calculateForecast($blockId, $alpha);

        if ($forecast === null) {
            return null;
        }

        DB::table('blocks')
            ->where('id', $blockId)
            ->update([
                'forecasted_rating' => $forecast,
            ]);

        return $forecast;
    }

    /**
     * Calculate and save forecasts for all blocks.
     */
    public function calculateForAllBlocks(
        float $alpha = 0.3
    ): int {
        $blocks = DB::table('blocks')->pluck('id');

        $updated = 0;

        foreach ($blocks as $blockId) {
            $forecast = $this->calculateAndSaveForecast(
                (int) $blockId,
                $alpha
            );

            if ($forecast !== null) {
                $updated++;
            }
        }

        return $updated;
    }
}
