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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('title');
            $table->string('fonction')->nullable();
            $table->integer('order')->default(0);
            $table->string('description')->nullable();
            $table->boolean('is_private')->default(false);
            $table->unsignedBigInteger('avatar')->nullable();
            $table->foreign('avatar')->references('id')->on('media')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
