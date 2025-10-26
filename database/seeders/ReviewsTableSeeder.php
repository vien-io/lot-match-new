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

        $blocks = range(1, 37); 
        $sentiments = ['positive', 'negative'];

        $positiveComments = [
            'Absolutely loved it! Worth every penny.',
            'Fantastic experience — would definitely come back!',
            'Peaceful environment and great amenities.',
            'Everything exceeded my expectations.',
            'A hidden gem! Perfect for families.',
            'Highly recommended — top-notch service.',
            'Superb location and very relaxing vibe.',
            'Modern and clean facilities, loved it!',
            'Beautiful place, staff were very accommodating.',
            'Comfortable and well-maintained surroundings.',
            'Perfect spot for a weekend getaway.',
            'Truly a five-star experience!',
            'Amazing atmosphere and attention to detail.',
            'Great investment potential in this area.',
            'Loved the greenery and peaceful environment.',
            'Smooth process and friendly staff.',
            'Excellent community and amenities.',
            'Had an unforgettable stay!',
            'Spacious and beautifully designed units.',
            'Everything went perfectly — highly satisfied!'
        ];

        $negativeComments = [
            'Disappointed — not as advertised.',
            'Poor service and unfriendly staff.',
            'Had several issues with cleanliness.',
            'Definitely not worth the price.',
            'Would not recommend — waste of money.',
            'Very noisy and uncomfortable stay.',
            'Bad experience overall, needs improvement.',
            'Too crowded and poorly maintained.',
            'Customer support was unhelpful.',
            'Construction nearby ruined the experience.',
            'Looks nice in photos but reality is different.',
            'Felt unsafe in the area.',
            'Overpriced for what it offers.',
            'Terrible maintenance, leaking ceilings.',
            'Wouldn’t come back again.',
            'Slow response from management.',
            'The rooms were dirty and smelled bad.',
            'Facilities were outdated and broken.',
            'Staff ignored our requests multiple times.',
            'Completely regret choosing this place.'
        ];

        $now = Carbon::now();

        for ($i = 1; $i <= 200; $i++) {
            $blockId = $blocks[array_rand($blocks)];
            $sentiment = $sentiments[array_rand($sentiments)];

            if ($sentiment === 'positive') {
                $rating = rand(4, 5);
                $comment = $positiveComments[array_rand($positiveComments)];
            } else {
                $rating = rand(1, 2);
                $comment = $negativeComments[array_rand($negativeComments)];
            }

            DB::table('reviews')->insert([
                'user_id' => rand(1, 50),
                'block_id' => $blockId,
                'rating' => $rating,
                'user_name' => 'User' . rand(1, 50),
                'comment' => $comment,
                'sentiment' => $sentiment,
                'created_at' => $now->copy()->subDays(rand(0, 365)),
                'updated_at' => $now,
            ]);
        }
    }
}
