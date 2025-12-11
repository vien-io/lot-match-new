<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('username');
            $table->string('last_name')->nullable()->after('first_name');
        });

        DB::table('users')->select('id', 'name')->orderBy('id')->chunk(100, function ($users) {
            foreach ($users as $user) {
                if (!$user->name) continue;

                $parts = preg_split('/\s+/', trim($user->name));

                $first = $parts[0]; 
                $last = count($parts) > 1
                    ? implode(' ', array_slice($parts, 1)) 
                    : ''; 

                DB::table('users')->where('id', $user->id)->update([
                    'first_name' => $first,
                    'last_name' => $last
                ]);
            }
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable();
        });

        DB::table('users')->select('id', 'first_name', 'last_name')->orderBy('id')->chunk(100, function ($users) {
            foreach ($users as $user) {
                $full = trim($user->first_name . ' ' . $user->last_name);

                DB::table('users')->where('id', $user->id)->update([
                    'name' => $full
                ]);
            }
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name']);
        });
    }
};