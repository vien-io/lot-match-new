<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop 'description' from blocks table if it exists
        if (Schema::hasColumn('blocks', 'description')) {
            Schema::table('blocks', function (Blueprint $table) {
                $table->dropColumn('description');
            });
        }

        // Drop 'description' from lots table if it exists
        if (Schema::hasColumn('lots', 'description')) {
            Schema::table('lots', function (Blueprint $table) {
                $table->dropColumn('description');
            });
        }
    }

    public function down(): void
    {
        // Restore 'description' columns
        if (!Schema::hasColumn('blocks', 'description')) {
            Schema::table('blocks', function (Blueprint $table) {
                $table->text('description')->nullable();
            });
        }

        if (!Schema::hasColumn('lots', 'description')) {
            Schema::table('lots', function (Blueprint $table) {
                $table->text('description')->nullable();
            });
        }
    }
};