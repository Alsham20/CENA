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
        Schema::create('download_links', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('file_id');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
            $table->integer('max_downloads')->default(1);
            $table->integer('downloads')->default(0);
            $table->unsignedBigInteger('user_id')->nullable();
            // $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('download_links');
    }
};
