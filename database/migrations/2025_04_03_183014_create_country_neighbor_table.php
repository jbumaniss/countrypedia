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
        Schema::create('country_neighbor', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('neighbor_id');

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('neighbor_id')->references('id')->on('countries')->onDelete('cascade');

            $table->unique(['country_id', 'neighbor_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('country_neighbor');
    }
};
