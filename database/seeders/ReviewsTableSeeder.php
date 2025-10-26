<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReviewsTableSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('reviews')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $users = DB::table('users')->select('id', 'name')->get();

        $blocks = range(1, 37);

        $positiveComments = [
            'Beautiful and peaceful area, perfect for families.',
            'Love the environment — very calm and relaxing.',
            'Well-maintained surroundings and friendly neighbors.',
            'Good access to main roads and amenities.',
            'The place feels safe and welcoming.',
            'Great community — highly recommended!',
            'Spacious lots and fresh air.',
            'Good sunlight and nice elevation.',
            'Affordable yet premium-looking area.',
            'Would love to build a home here someday.'
        ];

        $negativeComments = [
            'Too noisy at certain hours.',
            'Floods during heavy rain.',
            'Needs better road maintenance.',
            'Far from main access points.',
            'Security could be improved.',
            'Water pressure is inconsistent.',
            'Poor waste management around the area.',
            'Feels too crowded for comfort.',
            'Limited nearby stores or services.',
            'Dusty during dry season.'
        ];

        $now = Carbon::now();

        // 100 reviews across 37 blocks
        for ($i = 1; $i <= 100; $i++) {
            $user = $users->random();
            $blockId = $blocks[array_rand($blocks)];

            $sentiment = rand(0, 1) ? 'positive' : 'negative';

            if ($sentiment === 'positive') {
                $rating = rand(4, 5);
                $baseComment = $positiveComments[array_rand($positiveComments)];
            } else {
                $rating = rand(1, 2);
                $baseComment = $negativeComments[array_rand($negativeComments)];
            }

            $comment = $baseComment;

            DB::table('reviews')->insert([
                'user_id' => $user->id,
                'block_id' => $blockId,
                'rating' => $rating,
                'user_name' => $user->name,
                'comment' => $comment,
                'sentiment' => $sentiment,
                'created_at' => $now->copy()->subDays(rand(0, 365)),
                'updated_at' => $now,
            ]);
        }
    }
}
