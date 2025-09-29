<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Lot;

class LotSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('lots')->truncate();

        $blocks = 10;   
        $lotsPerBlock = 30; 

        $lots = [];
        $idCounter = 1;

        for ($block = 1; $block <= $blocks; $block++) {
            for ($lot = 1; $lot <= $lotsPerBlock; $lot++) {
                $lots[] = [
                    'id' => $idCounter++,
                    'block_id' => $block,
                    'name' => "Lot {$lot}",
                    'description' => "Block {$block}, Lot {$lot}",
                    'size' => rand(100, 600),      
                    'price' => rand(1000, 6000),   
                    'lot_area' => rand(80, 500),
                    'floor_area' => rand(60, 300),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('lots')->insert($lots);

        // defaults
        Lot::whereNull('lot_area')->orWhere('lot_area', 0)->update(['lot_area' => 100]);
        Lot::whereNull('floor_area')->orWhere('floor_area', 0)->update(['floor_area' => 80]);
        Lot::whereNull('price')->orWhere('price', 0)->update(['price' => 1000000]);
        Lot::whereNull('status')->update(['status' => 'available']);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
