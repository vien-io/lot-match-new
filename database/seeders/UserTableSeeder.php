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
            $name = "$first $last";
            $email = strtolower(Str::slug($first . '.' . $last . $i)) . '@example.com';

            $users[] = [
                'id' => $i,
                'name' => $name,
                'email' => $email,
                'password' => bcrypt('password123'),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('users')->insert($users);
    }
}
