<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id')->nullable();
            $table->foreign('author_id')->references('id')->on('users')->nullOnDelete();
            $table->string('title');
            $table->dateTime('date_article')->nullable();
            $table->unsignedBigInteger('category')->nullable();
            $table->foreign('category')->references('id')->on('categories')->nullOnDelete();
            $table->unsignedBigInteger('poster')->nullable();
            $table->foreign('poster')->references('id')->on('media')->nullOnDelete();
            $table->text('resume')->nullable();
            $table->string('slug');
            $table->integer('publications_count')->default(0);
            $table->text('content');
            $table->text('content_keywords')->nullable();
            $table->text('content_description')->nullable();
            $table->text('tags')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_private')->default(false);
            $table->boolean('is_deleted')->default(false);
            $table->boolean('is_archive')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
