<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlockAiSummarySeeder extends Seeder
{
    public function run(): void
    {
        $summaries = require database_path(
            'seeders/data/BlockAiSummaries.php'
        );

        $updated = 0;
        $missing = [];

        foreach ($summaries as $blockId => $summary) {
            $exists = DB::table('blocks')
                ->where('id', $blockId)
                ->exists();

            if (!$exists) {
                $missing[] = $blockId;
                continue;
            }

            DB::table('blocks')
                ->where('id', $blockId)
                ->update([
                    'ai_summary' => $summary,
                ]);

            $updated++;
        }

        $this->command?->info(
            "Updated AI summaries for {$updated} blocks."
        );

        if (!empty($missing)) {
            $this->command?->warn(
                'No matching block found for IDs: '
                . implode(', ', $missing)
            );
        }
    }
}
