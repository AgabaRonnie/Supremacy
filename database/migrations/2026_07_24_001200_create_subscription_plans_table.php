<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // e.g. "Inner Circle", "Superfan"
            $table->decimal('price', 12, 2);
            $table->string('currency', 10)->default('UGX');
            $table->string('interval')->default('monthly'); // monthly | yearly
            $table->json('perks')->nullable(); // list of perks
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscription_plans');
    }
};
