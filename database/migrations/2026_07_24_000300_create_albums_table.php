<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->string('cover')->nullable();
            $table->date('release_date')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->nullable(); // null = not for direct sale
            $table->string('currency', 10)->default('UGX');
            $table->json('links')->nullable(); // {spotify: url, apple_music: url, ...}
            $table->boolean('is_published')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->unique(['artist_id', 'slug']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('albums');
    }
};
