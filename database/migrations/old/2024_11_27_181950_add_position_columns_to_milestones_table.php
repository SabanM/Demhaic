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
        Schema::table('milestones', function (Blueprint $table) {
            $table->integer('x_position')->nullable()->after('updated_at'); // Add x_position column
            $table->integer('y_position')->nullable()->after('x_position'); // Add y_position column
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('milestones', function (Blueprint $table) {
            $table->dropColumn(['x_position', 'y_position']); // Remove the columns if rolled back
        });
    }
};
