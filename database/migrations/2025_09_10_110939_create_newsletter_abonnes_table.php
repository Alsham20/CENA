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
        Schema::create('newsletter_abonnes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('message_id')->nullable();
            $table->unsignedBigInteger('abonne_id')->nullable();
            $table->enum('status', ['pending', 'success', 'failure'])->default('pending');
            $table->string('back_message')->nullable();
            $table->foreign('message_id')->references('id')->on('newsletter_messages')->nullOnDelete();
            $table->foreign('abonne_id')->references('id')->on('news_letters')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletter_abonnes');
    }
};
