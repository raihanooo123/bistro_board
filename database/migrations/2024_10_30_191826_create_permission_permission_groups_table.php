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
        if(!Schema::hasTable('permission_permission_groups'))
        Schema::create('permission_permission_groups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('permission_id')->references('id')->on('permissions');
            $table->foreignUuid('permission_group_id')->references('id')->on('permission_groups');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_permission_groups');
    }
};
