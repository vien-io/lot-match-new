<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE lots ALTER COLUMN price DROP NOT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE lots ALTER COLUMN price SET NOT NULL');
    }
};
