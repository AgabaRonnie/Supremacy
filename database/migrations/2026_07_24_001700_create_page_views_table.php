<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained()->cascadeOnDelete();
            $table->string('page'); // profile | smartlink | epk
            $table->foreignId('track_id')->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->index(['artist_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('page_views');
    }
};
