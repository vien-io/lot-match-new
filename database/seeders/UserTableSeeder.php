<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $firstNames = [
            'Juan', 'Maria', 'Jose', 'Ana', 'Carlos', 'Luz', 'Antonio', 'Carmen', 'Rafael', 'Teresa',
            'Benigno', 'Gloria', 'Andres', 'Isabel', 'Diego', 'Mila', 'Rogelio', 'Lilia', 'Tomas', 'Rosario',
            'Emil', 'Marites', 'Jomar', 'Fe', 'Ernesto', 'Ligaya', 'Ricardo', 'Nena', 'Eduardo', 'Elsa',
            'Arnel', 'Melinda', 'Bong', 'Corazon', 'Lito', 'Sonia', 'Ronilo', 'Norma', 'Jun', 'Evangeline',
            'Rey', 'Flor', 'Noel', 'Maricel', 'Rene', 'Lourdes', 'Nestor', 'Perla', 'Vic', 'Charito'
        ];

        $lastNames = [
            'Santos', 'Reyes', 'Cruz', 'Bautista', 'Garcia', 'Dizon', 'Pineda', 'Macapagal', 'Manalili', 'Mallari',
            'David', 'Tuazon', 'Soriano', 'Ramos', 'Lazatin', 'Samson', 'Gonzales', 'Navarro', 'Aquino', 'Del Rosario',
            'Paras', 'Pangan', 'Yumul', 'Panlilio', 'Tiongson', 'De Guzman', 'Canlas', 'Lingad', 'Salonga', 'Galang',
            'Torres', 'Abad', 'Manabat', 'Gutierrez', 'Alvarez', 'Mercado', 'Tolentino', 'Corpuz', 'Hizon', 'Tugade',
            'Balagtas', 'Sarmiento', 'Basa', 'Magsino', 'Guevarra', 'Lapid', 'Pamintuan', 'Ventura', 'Pagcu', 'Quiambao'
        ];

        $users = [];

        for ($i = 1; $i <= 50; $i++) {
            $first = $firstNames[array_rand($firstNames)];
            $last = $lastNames[array_rand($lastNames)];

            $username = strtolower(Str::slug($first.$last.$i));
            $email = $username . '@example.com';

            $users[] = [
                'username' => $username,
                'first_name' => $first,
                'last_name' => $last,
                'email' => $email,
                'email_verified_at' => null,
                'password' => bcrypt('Password123'),
                'role' => 'buyer',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // demo users
        $specialUsers = [
            [
                'username' => 'vien',
                'first_name' => 'Vienry',
                'last_name' => 'Omania',
                'email' => 'vienryomania@gmail.com',
                'email_verified_at' => $now,
                'password' => bcrypt('Password123'),
                'role' => 'admin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'username' => 'admin',
                'first_name' => 'Lucie',
                'last_name' => 'Davis',
                'email' => 'admin@example.com',
                'email_verified_at' => null,
                'password' => bcrypt('Password123'),
                'role' => 'admin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'username' => 'buyer',
                'first_name' => 'Justine',
                'last_name' => 'Tiangco',
                'email' => 'buyer@example.com',
                'email_verified_at' => null,
                'password' => bcrypt('Password123'),
                'role' => 'buyer',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'username' => 'owner1',
                'first_name' => 'Harvey Rain',
                'last_name' => 'Domingo',
                'email' => 'owner1@example.com',
                'email_verified_at' => null,
                'password' => bcrypt('Password123'),
                'role' => 'owner',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'username' => 'owner2',
                'first_name' => 'Santino',
                'last_name' => 'Luz',
                'email' => 'owner2@example.com',
                'email_verified_at' => null,
                'password' => bcrypt('Password123'),
                'role' => 'owner',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'username' => 'owner3',
                'first_name' => 'Aries Poncie',
                'last_name' => 'Laxamana',
                'email' => 'owner3@example.com',
                'email_verified_at' => null,
                'password' => bcrypt('Password123'),
                'role' => 'owner',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'username' => 'owner4',
                'first_name' => 'Jeremiah',
                'last_name' => 'Ong',
                'email' => 'owner4@example.com',
                'email_verified_at' => null,
                'password' => bcrypt('Password123'),
                'role' => 'owner',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        $users = array_merge($users, $specialUsers);

    


        // insert users
        DB::table('users')->insertOrIgnore($users);

        // Assign lots to owners (blocks 1–4)
        foreach (range(1, 4) as $blockId) {
            $owner = DB::table('users')->where('username', 'owner'.$blockId)->first();
            if ($owner) {
                DB::table('lots')
                    ->where('block_id', $blockId)
                    ->update(['owner_id' => $owner->id]);
            }
        }
    }
}
