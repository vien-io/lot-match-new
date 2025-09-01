<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('lots', function (Blueprint $table) {
            $table->decimal('lot_area', 8, 2)->nullable()->after('size');
            $table->decimal('floor_area', 8, 2)->nullable()->after('lot_area');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('lots', function (Blueprint $table) {
            $table->dropColumn(['lot_area', 'floor_area']);
        });
    }
};
