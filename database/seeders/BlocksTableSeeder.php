<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BlocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('reviews')->delete(); 
        DB::table('lots')->delete();
        DB::table('blocks')->delete();
        DB::table('users')->truncate(); 
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('blocks')->insert([
            [
                'id' => 1,
                'name' => 'Block 1',
                'description' => 'This is a description for Block 1.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'Block 2',
                'description' => 'This is a description for Block 2.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'name' => 'Block 3',
                'description' => 'This is a description for Block 3.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
              [
                'id' => 4,
                'name' => 'Block 4',
                'description' => 'This is a description for Block 4.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 5,
                'name' => 'Block 5',
                'description' => 'This is a description for Block 5.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 6,
                'name' => 'Block 6',
                'description' => 'This is a description for Block 6.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
              [
                'id' => 7,
                'name' => 'Block 7',
                'description' => 'This is a description for Block 7.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 8,
                'name' => 'Block 8',
                'description' => 'This is a description for Block 8.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 9,
                'name' => 'Block 9',
                'description' => 'This is a description for Block 9.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
              [
                'id' => 10,
                'name' => 'Block 10',
                'description' => 'This is a description for Block 10.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 11,
                'name' => 'Block 11',
                'description' => 'This is a description for Block 11.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 12,
                'name' => 'Block 12',
                'description' => 'This is a description for Block 12.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
    ['id' => 13, 'name' => 'Block 13', 'description' => 'This is a description for Block 13.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ['id' => 14, 'name' => 'Block 14', 'description' => 'This is a description for Block 14.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ['id' => 15, 'name' => 'Block 15', 'description' => 'This is a description for Block 15.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ['id' => 16, 'name' => 'Block 16', 'description' => 'This is a description for Block 16.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ['id' => 17, 'name' => 'Block 17', 'description' => 'This is a description for Block 17.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ['id' => 18, 'name' => 'Block 18', 'description' => 'This is a description for Block 18.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ['id' => 19, 'name' => 'Block 19', 'description' => 'This is a description for Block 19.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ['id' => 20, 'name' => 'Block 20', 'description' => 'This is a description for Block 20.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ['id' => 21, 'name' => 'Block 21', 'description' => 'This is a description for Block 21.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ['id' => 22, 'name' => 'Block 22', 'description' => 'This is a description for Block 22.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ['id' => 23, 'name' => 'Block 23', 'description' => 'This is a description for Block 23.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ['id' => 24, 'name' => 'Block 24', 'description' => 'This is a description for Block 24.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ['id' => 25, 'name' => 'Block 25', 'description' => 'This is a description for Block 25.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ['id' => 26, 'name' => 'Block 26', 'description' => 'This is a description for Block 26.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ['id' => 27, 'name' => 'Block 27', 'description' => 'This is a description for Block 27.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ['id' => 28, 'name' => 'Block 28', 'description' => 'This is a description for Block 28.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ['id' => 29, 'name' => 'Block 29', 'description' => 'This is a description for Block 29.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ['id' => 30, 'name' => 'Block 30', 'description' => 'This is a description for Block 30.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ['id' => 31, 'name' => 'Block 31', 'description' => 'This is a description for Block 31.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ['id' => 32, 'name' => 'Block 32', 'description' => 'This is a description for Block 32.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ['id' => 33, 'name' => 'Block 33', 'description' => 'This is a description for Block 33.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ['id' => 34, 'name' => 'Block 34', 'description' => 'This is a description for Block 34.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ['id' => 35, 'name' => 'Block 35', 'description' => 'This is a description for Block 35.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ['id' => 36, 'name' => 'Block 36', 'description' => 'This is a description for Block 36.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
    ['id' => 37, 'name' => 'Block 37', 'description' => 'This is a description for Block 37.', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

        ]);

        DB::table('blocks')->update(['model_url' => 'basic/housemodel.glb']);

        $this->call([
            UserTableSeeder::class,
            LotSeeder::class,
            ReviewsTableSeeder::class,
        ]);
    }
}
