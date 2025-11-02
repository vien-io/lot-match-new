<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateLotStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lots')->update([
            'price' => 2100000.00,
            'lot_area' => 35.00,
            'floor_area' => 42.00,
            'flood_risk' => 'low',
        ]);

        $soldLots = [
            1 => [1,2,3,6,7,8,9,10,11,12],
            2 => [1,3,4,5,6,7,8,10,11,12,13,14,15,16,18,19,20,21,22,23,24,25,26,29,30],
            3 => [1,2,3,4,5,6,7,8,9,10,11,12,21,22,23,24,25,26,27,28,29,30],
            4 => [2,4,5,6,8,9,10,11,12,13],
            5 => [1,2,3,5,6,7,8,9,10,11,12,13,14,17],
            6 => [2,3,4,6,7,8,11,12,14,15],
            7 => range(1,10) + range(18,38),
            8 => [1,3,4,5,6,7,8,9,10,13,14,15,17,18,19,20],
            9 => array_merge(range(1,23), range(34,42), [47,48,49,50,55,56,59,60], range(63,66)),
            10 => array_merge(range(1,6), range(8,16), [18,19], range(21,34), range(36,39)),
            11 => array_merge(range(1,10), [17], range(19,40), [42,43], range(45,58)),
        ];

        DB::table('lots')->update(['status' => 'available']);

        foreach ($soldLots as $blockId => $lots) {
        DB::table('lots')
            ->where('block_id', $blockId)
            ->whereIn(DB::raw('CAST(SUBSTRING(name, 5) AS UNSIGNED)'), $lots)
            ->update(['status' => 'sold']);
    }
    }
}
