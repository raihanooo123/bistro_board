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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamp('order_datetime');
            $table->uuid('user_id'); // Foreign key column must be unsigned to match 'id' in users
            $table->decimal('total_amount', 10, 2);
            $table->enum('order_status', ['pending', 'preparing', 'delivered', 'canceled', 'completed'])->default('pending');
            $table->enum('order_type', ['dine-in', 'takeout', 'delivery'])->default('dine-in');
            $table->text('order_notes')->nullable(); //Customers might want to leave special instructions

            $table->decimal('discount_amount', 10, 2)->default(0); // If system involves discounts,
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->string('delivery_address')->nullable();
            $table->boolean('payment_status')->default(false);
            $table->string('order_code');

            // Foreign keys here
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
        Schema::dropIfExists('orders');
    }
};
