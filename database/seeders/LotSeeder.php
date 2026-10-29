<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LotSeeder extends Seeder
{
    public function run(): void
    {
        $driver = DB::getDriverName();

        // Clear the lots table safely.
        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            try {
                DB::table('lots')->truncate();
            } finally {
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }
        } elseif ($driver === 'pgsql') {
            DB::statement('TRUNCATE TABLE lots RESTART IDENTITY CASCADE;');
        } else {
            DB::table('lots')->delete();
        }

        // Lot counts per block.
        $lotsPerBlock = [
            1 => 14,
            2 => 30,
            3 => 30,
            4 => 15,
            5 => 19,
            6 => 19,
            7 => 38,
            8 => 18,
            9 => 66,
            10 => 39,
            11 => 64,
            12 => 74,
            13 => 80,
            14 => 84,
            15 => 88,
            16 => 98,
            17 => 104,
            18 => 25,
            19 => 24,
            20 => 54,
            21 => 56,
            22 => 60,
            23 => 64,
            24 => 66,
            25 => 66,
            26 => 68,
            27 => 67,
            28 => 70,
            29 => 70,
            30 => 68,
            31 => 107,
            32 => 32,
            33 => 32,
            34 => 31,
            35 => 31,
            36 => 20,
            37 => 39,
        ];

        $orientations = ['North', 'East', 'South', 'West'];

        $sunlights = [
            'Morning Sun',
            'Afternoon Sun',
            'Full Day Sun',
            'Shade',
        ];

        $floodRisks = ['Low', 'Medium', 'High'];

        $modelUrl = '/models/basic/housemodel.glb';
        $now = now();
        $lots = [];

        foreach ($lotsPerBlock as $blockId => $lotCount) {
            // Keep approximately 25% of each block sold,
            // grouped into contiguous clusters.
            $soldCount = (int) round($lotCount * 0.55);
            $soldLots = [];

            // Deterministically vary the cluster's starting position by block.
            $clusterStart = 1 + (($blockId * 7) % max(1, (int) ($lotCount * 0.6)));

            for ($i = 0; $i < $soldCount; $i++) {
                // Wrap around if the cluster reaches the end of the block.
                $lotNumber = (($clusterStart - 1 + $i) % $lotCount) + 1;

                $soldLots[$lotNumber] = true;
            }

            for ($lotNumber = 1; $lotNumber <= $lotCount; $lotNumber++) {
                // Stable, deterministic attribute selection.
                $seed = ($blockId * 37) + ($lotNumber * 13);

                // Assign a property type deterministically.
                $isTownhouse = ($seed % 2) === 0;

                // Set dimensions and starting price based on property type.
                if ($isTownhouse) {
                    // 2-Storey Townhouse
                    $propertyType = '2-Storey Townhouse';
                    $lotArea = 48;
                    $floorArea = 51;
                    $basePrice = 999000;
                } else {
                    // 2-Storey Rowhouse
                    $propertyType = '2-Storey Rowhouse';
                    $lotArea = 35;
                    $floorArea = 38.5;
                    $basePrice = 656000;
                }

                // Check whether this lot is sold.
                $isSold = isset($soldLots[$lotNumber]);

                // Sold properties have no price; available properties use
                // their assigned property type's starting price.
                $price = $isSold ? null : $basePrice;

                $lots[] = [
                    'block_id'    => $blockId,
                    'name'        => "Lot {$lotNumber}",
                    'price'       => $price,
                    'lot_area'    => $lotArea,
                    'floor_area'  => $floorArea,
                    'status'      => $isSold ? 'sold' : 'available',
                    'orientation' => $orientations[$seed % count($orientations)],
                    'sunlight'    => $sunlights[($seed * 3) % count($sunlights)],
                    'flood_risk'  => $floodRisks[($seed * 5) % count($floodRisks)],
                    'modelUrl'    => $modelUrl,
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ];
            }
        }

        // Insert in chunks to avoid oversized SQL statements.
        foreach (array_chunk($lots, 500) as $chunk) {
            DB::table('lots')->insert($chunk);
        }
    }
}
