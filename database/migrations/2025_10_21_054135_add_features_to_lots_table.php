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
            $table->string('orientation')->nullable();
            $table->string('sunlight')->nullable();
            $table->string('view')->nullable();
            $table->string('flood_risk')->nullable();
        });
    }

    public function down()
    {
        Schema::table('lots', function (Blueprint $table) {
            $table->dropColumn(['orientation', 'sunlight', 'view', 'flood_risk']);
        });
    }

};
