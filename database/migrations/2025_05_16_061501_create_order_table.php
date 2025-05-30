<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('pending');
            $table->decimal('total_amount', 10, 2);

            // Customer information fields
            $table->string('full_name');
            $table->string('email');
            $table->string('phone_number');
            $table->text('address');
            $table->string('postal_code');
            $table->string('city');
            $table->string('province');

            $table->json('cart_items'); // Add this to store cart items as JSON

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
