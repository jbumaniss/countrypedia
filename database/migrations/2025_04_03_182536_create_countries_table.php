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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();

            $table->string('common_name');
            $table->string('official_name');
            $table->string('country_code')->unique();
            $table->string('fifa')->nullable();
            $table->bigInteger('population');
            $table->string('flag');
            $table->float('area');
            $table->json('neighbors')->nullable();

            $table->unsignedBigInteger('region_id');
            $table->unsignedBigInteger('sub_region_id')->nullable();

            $table->foreign('region_id')->references('id')->on('regions');
            $table->foreign('sub_region_id')->references('id')->on('sub_regions');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
