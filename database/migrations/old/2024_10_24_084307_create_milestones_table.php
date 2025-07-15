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
        Schema::create('milestones', function (Blueprint $table) {
            $table->id();
            $table->string('milestone'); // The milestone description
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key for users table
            $table->timestamp('finished_at')->nullable(); // Timestamp when the milestone is finished
            $table->timestamps(); // Laravel's created_at and updated_at fields
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milestones');
    }
};
