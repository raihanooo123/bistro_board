<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique(); // Ensure each permission is unique
            $table->timestamps();
            $table->softDeletes();
        });

       
    }

    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
