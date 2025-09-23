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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id')->nullable();
            $table->foreign('author_id')->references('id')->on('users')->nullOnDelete();
            $table->string('title');
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
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
