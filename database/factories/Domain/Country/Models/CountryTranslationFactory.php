<?php

namespace Database\Factories\Domain\Country\Models;

use Domain\Country\Models\Country;
use Domain\Country\Models\CountryTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CountryTranslation>
 */
class CountryTranslationFactory extends Factory
{
    /**
     * @var string<CountryTranslation>
     */
    protected $model = CountryTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->languageCode(),
            'official' => fake()->name(),
            'common' => fake()->name(),
            'country_id' => Country::factory(),
        ];
    }
}
