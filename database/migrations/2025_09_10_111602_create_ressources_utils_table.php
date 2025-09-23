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
        Schema::create('documentations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('doc_id');
            $table->dateTime('date_creation')->nullable();
            $table->unsignedBigInteger('categorie_id')->nullable();
            $table->foreign('categorie_id')->references('id')->on('categories')->nullOnDelete();
            $table->text('description')->nullable();
            $table->string('doc_type')->nullable();
            $table->integer('doc_size')->nullable();
            $table->string('doc_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ressources_utils');
    }
};
