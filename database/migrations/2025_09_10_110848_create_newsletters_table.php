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
        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();
            $table->string('lastname')->nullable();
            $table->string('firstname')->nullable();
            $table->string('email');
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('newsletters');
    }
};
