<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FullForecastReportSeeder extends Seeder
{
    public function run(): void
    {
        $reports = require database_path(
            'seeders/data/FullForecastReports.php'
        );

        DB::transaction(function () use ($reports) {
            // Clear all existing forecast reports first.
            DB::table('blocks')->update([
                'full_forecast_report' => null,
            ]);

            // Assign mock reports to the corresponding blocks.
            $blocks = DB::table('blocks')
                ->orderBy('id')
                ->get(['id']);

            foreach ($blocks->values() as $index => $block) {
                $key = sprintf('block_%02d', $index + 1);

                if (!array_key_exists($key, $reports)) {
                    continue;
                }

                DB::table('blocks')
                    ->where('id', $block->id)
                    ->update([
                        'full_forecast_report' => $reports[$key],
                        'updated_at' => now(),
                    ]);
            }
        });

        $this->command?->info(
            'Full forecast reports seeded successfully.'
        );
    }
}
