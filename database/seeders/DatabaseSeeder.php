<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        if (!User::where('email', 'test@example.com')->exists()) {
            User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'), 
            ]);

            $this->call([
                BlocksTableSeeder::class,            
                LotSeeder::class,                   
                ReviewsTableSeeder::class,          
                UpdateLotsWithModelUrlSeeder::class,
                UserTableSeeder::class
            ]);
        }
    }
}
