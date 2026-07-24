<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fan_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_plan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('artist_id')->constrained()->cascadeOnDelete(); // snapshot for scoping
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('status')->default('pending'); // pending | active | cancelled
            $table->timestamp('started_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fan_subscriptions');
    }
};
