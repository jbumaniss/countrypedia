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
            $table->string('official_name')->nullable();
            $table->json('native_names')->nullable();
            $table->string('cca2')->unique();
            $table->string('ccn3')->nullable();
            $table->string('cca3')->nullable();
            $table->string('cioc')->nullable();
            $table->boolean('independent')->default(false);
            $table->string('status')->nullable();
            $table->boolean('un_member')->default(false);
            $table->json('tld')->nullable();
            $table->json('capital')->nullable();
            $table->json('alt_spellings')->nullable();

            $table->unsignedBigInteger('region_id')->nullable();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('set null');

            $table->string('subregion')->nullable();

            $table->json('translations')->nullable();

            $table->decimal('lat', 8, 5)->nullable();
            $table->decimal('lng', 8, 5)->nullable();

            $table->boolean('landlocked')->default(false);
            $table->double('area')->nullable();
            $table->json('demonyms')->nullable();
            $table->bigInteger('population')->nullable();
            $table->json('gini')->nullable();
            $table->string('fifa')->nullable();

            $table->json('car_signs')->nullable();
            $table->string('car_side')->nullable();

            $table->json('timezones')->nullable();
            $table->json('continents')->nullable();

            $table->string('flag')->nullable();
            $table->json('maps')->nullable();
            $table->json('flags')->nullable();
            $table->json('coat_of_arms')->nullable();

            $table->string('start_of_week')->nullable();
            $table->json('postal_code')->nullable();

            $table->timestamps();

            $table->index('common_name');
            $table->index('official_name');
            $table->index('cca2');

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
