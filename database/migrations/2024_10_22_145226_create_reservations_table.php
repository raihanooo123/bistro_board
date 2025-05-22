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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id'); 
            $table->timestamp('reservation_datetime'); 
            $table->unsignedInteger('guest_count'); 
            $table->string('special_requests')->nullable(); // Special requests
            $table->string('reservation_reference')->unique(); // Unique reference code
            $table->enum('status', ['pending', 'confirmed', 'canceled', 'completed'])->default('pending');

            // Foreign key for the user
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
           
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
