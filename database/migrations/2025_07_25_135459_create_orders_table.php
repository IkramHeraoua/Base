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
            $table->foreignId('cart_id')->constrained('carts');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('restaurant_id')->constrained('restaurants');
            $table->string('total_price');
            $table->string('total_quantity');
            $table->string('total_discount');
            $table->string('total_tax');
            $table->string('total_delivery_fee');
            $table->string('total_amount');
            $table->string('payment_method')->default('cash');
            $table->string('payment_status')->default('pending');
            $table->string('payment_id')->nullable();
            $table->string('payment_url')->nullable();
            $table->string('payment_response')->nullable();
            $table->string('payment_response_code')->nullable();
            $table->string('payment_response_message')->nullable();
            $table->string('payment_response_data')->nullable();
            $table->string('delivery_address')->nullable();
            $table->string('delivery_lat')->nullable();
            $table->string('delivery_lon')->nullable();

            $table->string('status')->default('pending');
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
