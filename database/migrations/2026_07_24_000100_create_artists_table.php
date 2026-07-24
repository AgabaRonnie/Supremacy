<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tagline')->nullable();
            $table->string('genre')->nullable();
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();        // profile / portrait image
            $table->string('cover_image')->nullable();  // hero / banner image
            $table->json('gallery')->nullable();        // extra photos
            $table->string('location')->nullable();
            $table->year('joined_year')->nullable();
            $table->boolean('is_published')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('artists');
    }
};
