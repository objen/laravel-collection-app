<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 100);
            $table->year('released')->nullable();
            $table->integer('pieces')->unsigned();
            $table->integer('rating')->unsigned();
            $table->string('description', 500)->nullable();
            $table->boolean('owned')->default(true);
            $table->string('theme', 50)->default('Classic');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sets');
    }
};
