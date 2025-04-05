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
        Schema::create('country_aliases', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->string('official');
            $table->string('common');

            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')
                ->on('countries');
            $table->index('official');
            $table->index('common');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('country_aliases');
    }
};
