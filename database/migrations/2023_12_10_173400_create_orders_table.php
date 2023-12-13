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
            $table->string('order_reference');
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->unsignedBigInteger('cart_id')->unsigned();

            $table->float('subtotal', 10);
            $table->float('delivery_fee', 10);
            $table->float('total', 10);

            // Delivery and payment
            $table->json('shipping_address');
            $table->string('payment_status')->default('unpaid');
            // pending, refund, cancelled, completed
            $table->string('payment_ref')->nullable();
            $table->string('order_status')->default('unconfirmed'); // 'processing', 'shipped', 'delivered', 'cancelled', 'unconfirmed'

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');

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
