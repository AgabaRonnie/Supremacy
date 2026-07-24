<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('studio_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->date('preferred_date');
            $table->string('preferred_time')->nullable();
            $table->string('session_type')->nullable(); // recording, mixing, mastering, production...
            $table->text('message')->nullable();
            $table->string('status')->default('pending'); // pending | confirmed | declined
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('studio_bookings');
    }
};
