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
                'password' => bcrypt('Password123'),
                'role' => 'admin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'username' => 'admin',
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => 'admin@example.com',
                'password' => bcrypt('Password123'),
                'role' => 'admin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'username' => 'buyer',
                'first_name' => 'Buyer',
                'last_name' => 'User',
                'email' => 'buyer@example.com',
                'password' => bcrypt('Password123'),
                'role' => 'buyer',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'username' => 'owner1',
                'first_name' => 'Owner',
                'last_name' => 'Block1',
                'email' => 'owner1@example.com',
                'password' => bcrypt('Password123'),
                'role' => 'owner',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'username' => 'owner2',
                'first_name' => 'Owner',
                'last_name' => 'Block2',
                'email' => 'owner2@example.com',
                'password' => bcrypt('Password123'),
                'role' => 'owner',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'username' => 'owner3',
                'first_name' => 'Owner',
                'last_name' => 'Block3',
                'email' => 'owner3@example.com',
                'password' => bcrypt('Password123'),
                'role' => 'owner',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'username' => 'owner4',
                'first_name' => 'Owner',
                'last_name' => 'Block4',
                'email' => 'owner4@example.com',
                'password' => bcrypt('Password123'),
                'role' => 'owner',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        $users = array_merge($users, $specialUsers);

    


        // insert users
        DB::table('users')->insert($users);

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
