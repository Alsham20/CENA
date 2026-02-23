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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('video_description')->nullable();
            $table->dateTime('date_video')->nullable();
            $table->string('video_path');
            $table->unsignedBigInteger('category')->nullable();
            $table->foreign('category')->references('id')->on('categories')->nullOnDelete();
            $table->unsignedBigInteger('activity')->nullable();
            $table->foreign('activity')->references('id')->on('activities')->nullOnDelete();
            $table->boolean('is_published')->default(false);
            $table->unsignedBigInteger('author')->nullable();
            $table->foreign('author')->references('id')->on('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
