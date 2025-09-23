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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('primary_title')->nullable();
            $table->string('secondary_title')->nullable();
            $table->string('url');
            $table->string('icon')->nullable();
            $table->string('permission')->nullable();
            $table->boolean('new_tab')->default(false);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('menu_emplacement_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('menus')->nullOnDelete();
            $table->foreign('menu_emplacement_id')->references('id')->on('menu_emplacements')->nullOnDelete();
            $table->unsignedBigInteger('position')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
