<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LotSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('lots')->truncate();

        // Lot counts per block
        $lotsPerBlock = [
            1 => 14, 2 => 30, 3 => 30, 4 => 15, 5 => 19, 6 => 18, 7 => 38,
            8 => 18, 9 => 66, 10 => 39, 11 => 64, 12 => 74, 13 => 80, 14 => 84,
            15 => 88, 16 => 98, 17 => 104, 18 => 25, 19 => 24, 20 => 54,
            21 => 56, 22 => 60, 23 => 64, 24 => 66, 25 => 66, 26 => 68,
            27 => 67, 28 => 70, 29 => 70, 30 => 68, 31 => 107, 32 => 32,
            33 => 32, 34 => 31, 35 => 31, 36 => 20, 37 => 39
        ];

        $orientations = ['North', 'East', 'South', 'West'];
        $sunlights = ['Morning Sun', 'Afternoon Sun', 'Full Day Sun', 'Shade'];
        $views = ['Pool View', 'Near Gate', 'Street View', 'Garden View'];
        $floodRisks = ['Low', 'Medium', 'High'];

        $lots = [];
        $idCounter = 1;

        foreach ($lotsPerBlock as $blockId => $lotCount) {
            $modelUrl = '/models/basic/housemodel.glb'; // same model for all lots
            for ($lotNumber = 1; $lotNumber <= $lotCount; $lotNumber++) {
                $lots[] = [
                    'id' => $idCounter++,
                    'block_id' => $blockId,
                    'name' => "Lot {$lotNumber}",
                    'description' => "Block {$blockId}, Lot {$lotNumber}",
                    'size' => rand(100, 600),
                    'price' => rand(1000, 6000),
                    'lot_area' => rand(80, 500),
                    'floor_area' => rand(60, 300),
                    'status' => rand(0,1) ? 'available' : 'sold',
                    'orientation' => $orientations[array_rand($orientations)],
                    'sunlight' => $sunlights[array_rand($sunlights)],
                    'view' => $views[array_rand($views)],
                    'flood_risk' => $floodRisks[array_rand($floodRisks)],
                    'modelUrl' => $modelUrl,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('lots')->insert($lots);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
