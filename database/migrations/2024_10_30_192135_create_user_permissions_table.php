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
        if(!Schema::hasTable('user_permissions'))
        Schema::create('user_permissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            // $table->uuid('user_id')->index();
            $table->foreignUuid('user_id')->references('id')->on('users');
            $table->foreignUuid('permission_id')->references('id')->on('permissions');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_permissions');
    }
};
