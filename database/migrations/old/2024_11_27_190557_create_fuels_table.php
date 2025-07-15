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
        Schema::create('fuels', function (Blueprint $table) {
            $table->id();
            $table->string('fuel'); // Name of the fuel
            $table->text('description'); // Description of the fuel
            $table->unsignedBigInteger('user_id'); // Foreign key for user
            $table->timestamp('finished_at')->nullable(); // Optional finished_at timestamp
            $table->timestamps(); // created_at and updated_at timestamps

            // Optional: Add a foreign key constraint if needed
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuels');
    }
};
