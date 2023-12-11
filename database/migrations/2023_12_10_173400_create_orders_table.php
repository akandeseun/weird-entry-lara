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
            $table->string('user_id')->nullable();
            $table->string('cart_id')->nullable();

            // Delivery
            $table->json('shipping_address');
            $table->string('payment_status')->default('unpaid');
            $table->string('order_status')->default('unconfirmed'); // canceled, confirmed, processing, delivered

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
