<?php

namespace Database\Factories\Domain\Country\Models;

use Domain\Country\Models\Country;
use Domain\Country\Models\CountryAlias;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CountryAlias>
 */
class CountryAliasFactory extends Factory
{
    /**
     * @var string<CountryAlias>
     */
    protected $model = CountryAlias::class;

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
            'country_id' => Country::factory()->create()->id,
        ];
    }
}
