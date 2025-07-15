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
        Schema::create('obstacles', function (Blueprint $table) {
            $table->id();
            $table->string('obstacle');  // Name of the obstacle
            $table->text('description');  // Description of the obstacle
            $table->integer('position_x');  // X position on the map or area
            $table->integer('position_y');  // Y position on the map or area
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key for users table
            $table->timestamp('finished_at')->nullable(); // Timestamp when the milestone is finished
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obstacles');
    }
};
