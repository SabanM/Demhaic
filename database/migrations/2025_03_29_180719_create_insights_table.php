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
        Schema::create('insights', function (Blueprint $table) {
            $table->id();
            $table->text('insight')->nullable(); // Contains the plain language insight
            $table->longtext('daily_progress')->nullable(); // Adjust the type as needed (e.g., string, integer, or decimal)
            $table->longtext('weekly_progress')->nullable(); // Adjust the type as needed
            $table->longtext('regression_tree')->nullable(); // Holds the regression tree information as JSON or text
            $table->longtext('factor_predictors')->nullable(); // Stores factor predictors details
            $table->longtext('chartsDataJson')->nullable(); // Adjust the type as needed (e.g., string, integer, or decimal)
            $table->unsignedBigInteger('user_id');
            $table->timestamps(); // This will add both 'created_at' and 'updated_at'
            
            // If you want to add a foreign key constraint to users table:
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insights');
    }
};
