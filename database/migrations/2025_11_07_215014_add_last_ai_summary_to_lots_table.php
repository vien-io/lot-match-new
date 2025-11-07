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
        Schema::table('lots', function ($table) {
            $table->timestamp('last_ai_summary_at')->nullable()->after('ai_summary');
        });
    }

    public function down()
    {
        Schema::table('lots', function ($table) {
            $table->dropColumn('last_ai_summary_at');
        });
    }
};
