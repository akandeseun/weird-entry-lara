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
            $table->ulid('id')->primary();
            $table->string('order_reference');
            $table->ulid('user_id');
            $table->ulid('cart_id');

            $table->float('subtotal', 10);
            $table->float('delivery_fee', 10);
            $table->float('total', 10);

            // Delivery and payment
            $table->json('shipping_address');
            $table->string('payment_status')->default('unpaid');
            // pending, refund, cancelled, completed
            $table->string('payment_ref')->nullable();
            $table->string('order_status')->default('unconfirmed'); // 'pending', 'shipped', 'delivered', 'cancelled', 'unconfirmed'

            $table->timestamps();
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
