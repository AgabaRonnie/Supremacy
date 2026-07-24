<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained()->cascadeOnDelete();
            $table->foreignId('album_id')->nullable()->constrained()->nullOnDelete(); // null = single
            $table->string('title');
            $table->string('slug');
            $table->string('cover')->nullable();
            $table->string('preview_audio')->nullable(); // short preview clip
            $table->date('release_date')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->string('currency', 10)->default('UGX');
            $table->boolean('is_free')->default(false);
            $table->json('links')->nullable(); // streaming platform links
            $table->boolean('is_published')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->unique(['artist_id', 'slug']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tracks');
    }
};
