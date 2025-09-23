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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author');
            $table->foreign('author')->references('id')->on('users');
            $table->unsignedBigInteger('parent')->nullable();
            $table->foreign('parent')->references('id')->on('categories')->nullOnDelete();
            $table->string('label');
            $table->enum('type', ['FAQ', 'Page', 'Documentation', 'Article', 'Video', 'Event', 'Abonne']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
