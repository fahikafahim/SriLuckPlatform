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
        Schema::create('payments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
    $table->string('payment_method');
    $table->decimal('amount', 8, 2);
    $table->string('status');

    // Credit card fields (nullable since not all payments will use credit card)
    $table->string('card_number')->nullable();
    $table->string('card_name')->nullable();
    $table->string('expiry_date')->nullable();
    $table->string('cvv')->nullable();

    $table->timestamp('payment_date')->nullable();
    $table->timestamps();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
