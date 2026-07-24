<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->nullable()->constrained()->cascadeOnDelete(); // null = label event
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('venue')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->default('Uganda');
            $table->dateTime('starts_at');
            $table->string('ticket_url')->nullable();
            $table->string('price_info')->nullable(); // e.g. "UGX 20,000 - 50,000" or "Free entry"
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
};
