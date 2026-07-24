<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('demo_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('artist_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('genre')->nullable();
            $table->text('links')->nullable(); // links to their music
            $table->text('message')->nullable();
            $table->string('status')->default('new'); // new | reviewed | contacted
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('demo_submissions');
    }
};
