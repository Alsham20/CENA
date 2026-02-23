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
        Schema::create('evenements', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->string('slug');
            $table->string('place')->nullable();
            $table->text('event_description')->nullable();
            $table->dateTime('event_date')->nullable();
            $table->unsignedBigInteger('category')->nullable();
            $table->foreign('category')->references('id')->on('categories')->nullOnDelete();
            $table->unsignedBigInteger('poster')->nullable();
            $table->foreign('poster')->references('id')->on('media')->nullOnDelete();
            $table->timestamp('event_start')->nullable();
            $table->timestamp('event_end')->nullable();
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
        Schema::dropIfExists('evenements');
    }
};
