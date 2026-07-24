<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('link_clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained()->cascadeOnDelete();
            $table->foreignId('track_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('platform'); // spotify, apple-music, instagram...
            $table->timestamps();
            $table->index(['artist_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('link_clicks');
    }
};
