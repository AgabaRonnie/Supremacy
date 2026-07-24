<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique(); // e.g. SS-9F3K2A7B
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->decimal('total', 12, 2);
            $table->string('currency', 10)->default('UGX');
            $table->string('status')->default('pending'); // pending | paid | fulfilled | cancelled
            $table->string('payment_method')->nullable(); // whatsapp | flutterwave | pesapal | cash
            $table->string('payment_ref')->nullable();    // gateway transaction reference
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
