<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ReviewsTableSeeder extends Seeder
{
    public function run()
    {
        $driver = DB::getDriverName();

        // Clear existing reviews.
        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            try {
                DB::table('reviews')->truncate();
            } finally {
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }
        } elseif ($driver === 'pgsql') {
            DB::statement(
                'TRUNCATE TABLE reviews RESTART IDENTITY CASCADE;'
            );
        } else {
            DB::table('reviews')->delete();
        }

        $blocks = range(1, 37);

        // Load the comment arrays.
        $comments = require database_path(
            'seeders/data/ReviewComments.php'
        );

        $positiveComments = array_values(
            $comments['positive'] ?? []
        );

        $negativeComments = array_values(
            $comments['negative'] ?? []
        );

        // Validate the expected comment counts.
        if (
            count($positiveComments) !== 98 ||
            count($negativeComments) !== 50
        ) {
            throw new RuntimeException(
                'Expected 98 positive and 50 negative comments. Found '
                . count($positiveComments) . ' positive and '
                . count($negativeComments) . ' negative.'
            );
        }

        // Use existing users in a predictable order.
        $userIds = DB::table('users')
            ->orderBy('id')
            ->pluck('id')
            ->all();

        if (empty($userIds)) {
            throw new RuntimeException(
                'No users found. Please seed users before reviews.'
            );
        }

        /*
         * DETERMINISTIC DISTRIBUTION
         *
         * Blocks 1–24:
         *   3 positive + 1 negative
         *
         * Blocks 25–37:
         *   2 positive + 2 negative
         *
         * Total:
         *   98 positive + 50 negative = 148 reviews
         *
         * No shuffle(), rand(), or array_rand().
         */

        $positiveIndex = 0;
        $negativeIndex = 0;
        $reviewIndex = 0;

        $baseDate = Carbon::create(
            2026, 1, 1, 9, 0, 0
        );

        $reviews = [];

        foreach ($blocks as $blockId) {
            $positiveCount = $blockId <= 24 ? 3 : 2;
            $negativeCount = $blockId <= 24 ? 1 : 2;

            // Assign positive comments in their original array order.
            for ($i = 0; $i < $positiveCount; $i++) {
                $comment = $positiveComments[$positiveIndex];

                // Deterministic positive ratings: vary between 3 and 5.
                $positiveRatings = [5, 4, 5, 3, 4, 5, 4, 4, 5, 3];

                $rating = $positiveRatings[
                    ($positiveIndex * 3 + $blockId) % count($positiveRatings)
                ];

                $dayOffset = ($reviewIndex * 47 + $blockId * 13) % 301;
                $hour = 8 + (($reviewIndex * 5 + $blockId) % 12);
                $minute = ($reviewIndex * 17 + $blockId * 7) % 60;

                $createdAt = $baseDate
                    ->copy()
                    ->addDays($dayOffset)
                    ->setTime($hour, $minute, 0);

                $reviews[] = [
                    'user_id' => $userIds[
                        $reviewIndex % count($userIds)
                    ],
                    'block_id' => $blockId,
                    'rating' => $rating,
                    'comment' => $comment,
                    'sentiment' => 'positive',
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];

                $positiveIndex++;
                $reviewIndex++;
            }

            // Assign negative comments in their original array order.
            for ($i = 0; $i < $negativeCount; $i++) {
                $comment = $negativeComments[$negativeIndex];

                // Deterministic negative ratings: vary between 1 and 3.
                $negativeRatings = [1, 2, 1, 3, 2, 1, 2, 2, 3, 1];

                $rating = $negativeRatings[
                    ($negativeIndex * 3 + $blockId) % count($negativeRatings)
                ];

                $createdAt = $baseDate
                    ->copy()
                    ->addDays($reviewIndex);

                $reviews[] = [
                    'user_id' => $userIds[
                        $reviewIndex % count($userIds)
                    ],
                    'block_id' => $blockId,
                    'rating' => $rating,
                    'comment' => $comment,
                    'sentiment' => 'negative',
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];

                $negativeIndex++;
                $reviewIndex++;
            }
        }

        // Insert reviews in batches.
        foreach (array_chunk($reviews, 100) as $batch) {
            DB::table('reviews')->insert($batch);
        }

        $this->command?->info(
            'Successfully seeded ' . count($reviews)
            . ' reviews across 37 blocks.'
        );

        $this->command?->info(
            'Positive: ' . $positiveIndex
            . ' | Negative: ' . $negativeIndex
        );
    }
}
