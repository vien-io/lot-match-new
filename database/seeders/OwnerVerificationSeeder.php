<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class OwnerVerificationSeeder extends Seeder
{
    public function run(): void
    {
        $users = DB::table('users')->pluck('id');
        $lots = DB::table('lots')->pluck('id');

        if ($users->isEmpty()) {
            throw new RuntimeException('No users found. Run UserTableSeeder first.');
        }

        if ($lots->isEmpty()) {
            throw new RuntimeException('No lots found. Run LotSeeder first.');
        }

        $statuses = [
            'pending',
            'approved',
            'rejected',
        ];

        $now = now();

        for ($i = 0; $i < 15; $i++) {
            $userId = $users[$i % $users->count()];
            $lotId = $lots[$i % $lots->count()];

            $proofDocument = sprintf(
                'owner_verifications/sample_proof_%02d.png',
                $i + 1
            );

            $createdAt = $now->copy()->subDays(rand(1, 30));

            DB::table('owner_verifications')->updateOrInsert(
                [
                    'user_id' => $userId,
                    'lot_id' => $lotId,
                    'proof_document' => $proofDocument,
                ],
                [
                    'status' => $statuses[$i % count($statuses)],
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]
            );
        }

        $this->command->info('Owner verification records seeded successfully.');
    }
}
