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
        Schema::table('insights', function (Blueprint $table) {
            $table->text('insight_es')->nullable()->after('insight');
            $table->longText('daily_progress_es')->nullable()->after('daily_progress');
            $table->longText('weekly_progress_es')->nullable()->after('weekly_progress');
            $table->longText('regression_tree_es')->nullable()->after('regression_tree');
            $table->longText('factor_predictors_es')->nullable()->after('factor_predictors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insights', function (Blueprint $table) {
            $table->dropColumn([
                'insight_es',
                'daily_progress_es',
                'weekly_progress_es',
                'regression_tree_es',
                'factor_predictors_es',
            ]);
        });
    }
};
