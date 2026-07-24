<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::create('jobs', function (Blueprint $table) {
        $table->id();

        // Category Reference
        $table->unsignedBigInteger('category_id')->nullable();
        $table->foreign('category_id')->references('id')->on('job_categories')->onDelete('set null');

        // Basic Job Information
        $table->string('title');
        $table->string('slug')->unique();

        // Job Details
        $table->text('description');
        $table->string('short_description', 500)->nullable();

        // Requirements & Qualifications
        $table->text('requirements')->nullable();
        $table->text('responsibilities')->nullable();
        $table->text('qualifications')->nullable();

        // Additional Details
        $table->text('benefits')->nullable();
        $table->string('location')->nullable();

        // Application Settings
        $table->date('application_deadline')->nullable();
        $table->integer('positions_available')->default(1);

        // Status & Visibility
        $table->enum('status', ['draft', 'active', 'closed', 'filled'])->default('active');
        $table->boolean('is_featured')->default(false);

        // SEO & Metadata
        $table->string('meta_title')->nullable();
        $table->string('meta_description', 500)->nullable();
        $table->string('keywords')->nullable();

        // Analytics
        $table->unsignedInteger('views_count')->default(0);
        $table->unsignedInteger('applications_count')->default(0);

        // Timestamps
        $table->timestamps();
        $table->timestamp('published_at')->nullable();

        // Indexes for better performance
        $table->index('category_id');
        $table->index('status');
        $table->index('is_featured');
        $table->index('application_deadline');
        $table->fullText(['title', 'description', 'short_description']);
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};
