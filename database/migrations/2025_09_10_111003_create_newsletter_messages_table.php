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
        Schema::create('newsletter_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('object');
            $table->text('message');
            $table->string('name_from')->nullable();
            $table->string('email_from')->nullable();
            $table->integer('status')->default(0);
            $table->integer('pending_sent')->default(0);
            $table->integer('failure_sent')->default(0);
            $table->integer('success_sent')->default(0);
            $table->unsignedBigInteger('categorie_abonne_id')->nullable();
            $table->foreign('categorie_abonne_id')->references('id')->on('categories')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletter_messages');
    }
};
