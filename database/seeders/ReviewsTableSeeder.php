<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReviewsTableSeeder extends Seeder
{
    public function run()
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql'){
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('reviews')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } else if ($driver === 'pgsql') {
            DB::statement('TRUNCATE TABLE reviews RESTART IDENTITY CASCADE;');
        } else {
            DB::table('reviews')->delete();
        }
        

        $blocks = range(1, 37); 
        $sentiments = ['positive', 'negative'];

        $comments = require database_path('seeders/data/ReviewComments.php');

        $positiveComments = $comments['positive'];
        $negativeComments = $comments['negative'];

        $now = Carbon::now();

        $userIds = DB::table('users')->pluck('id')->toArray();

        for ($i = 1; $i <= 200; $i++) {
            $blockId = $blocks[array_rand($blocks)];
            $userId = $userIds[array_rand($userIds)];
            $sentiment = $sentiments[array_rand($sentiments)];

            if ($sentiment === 'positive') {
                $rating = rand(4, 5);
                $comment = $positiveComments[array_rand($positiveComments)];
            } else {
                $rating = rand(1, 2);
                $comment = $negativeComments[array_rand($negativeComments)];
            }

            DB::table('reviews')->insert([
                'user_id' => $userId,
                'block_id' => $blockId,
                'rating' => $rating,
                'comment' => $comment,
                'sentiment' => $sentiment,
                'created_at' => $now->copy()->subDays(rand(0, 365)),
                'updated_at' => $now,
            ]);
        }
    }
}
