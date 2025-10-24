<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('blocks', function (Blueprint $table) {
            $table->text('ai_summary')->nullable()->after('name'); // store the AI summary
            $table->text('full_forecast_report')->nullable()->after('ai_summary'); // full forecast report
            $table->float('forecasted_rating')->nullable()->after('full_forecast_report'); // numeric forecast
            $table->json('sentiment_data')->nullable()->after('forecasted_rating'); // store sentiment trends
        });
    }

    public function down(): void
    {
        Schema::table('blocks', function (Blueprint $table) {
            $table->dropColumn(['ai_summary', 'full_forecast_report', 'forecasted_rating', 'sentiment_data']);
        });
    }
};
