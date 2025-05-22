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
        Schema::create('chefs', function (Blueprint $table) {
            $table->uuid()->primary;
            $table->string('name');
            $table->string('specialty');
            $table->text('bio')->nullable(); 
            $table->integer('experience')->default(0); 
            $table->string('image')->nullable();
            $table->json('social_links')->nullable(); 
            $table->timestamps();
            $table->softDeletes();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chefs');
    }
};
