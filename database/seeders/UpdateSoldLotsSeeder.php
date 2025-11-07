<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class UpdateSoldLotsSeeder extends Seeder
{
    public function run()
    {
        $filePath = database_path('seeders/data/sold_lots.xlsx');
        $rows = Excel::toArray([], $filePath)[0];

        foreach (array_slice($rows, 1) as $row) {
            $block = trim($row[0]);
            $lot = trim($row[1]);

            if (!$block || !$lot) {
                continue;
            }

            preg_match_all('/\d+/', $lot, $matches);
            $lotNumbers = $matches[0] ?? [$lot];

            foreach ($lotNumbers as $lotNum) {
                $updated = DB::table('lots')
                    ->where('block_id', $block)
                    ->where(function ($query) use ($lotNum) {
                        $query->where('name', $lotNum)
                              ->orWhere('name', 'LIKE', "%$lotNum%");
                    })
                    ->update(['status' => 'sold']);

                if ($updated) {
                    echo "✅ Updated Block {$block} Lot {$lotNum} to SOLD\n";
                } else {
                    echo "⚠️ No match found for Block {$block} Lot {$lotNum}\n";
                }
            }
        }
    }
}