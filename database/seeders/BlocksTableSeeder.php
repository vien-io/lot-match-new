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
        ]);

        $this->call([
            UserTableSeeder::class,
            LotSeeder::class,
            ReviewsTableSeeder::class,
        ]);
    }
}
