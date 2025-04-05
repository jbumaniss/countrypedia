<?php

namespace Database\Factories\Domain\Country\Models;

use Domain\Country\Models\Country;
use Domain\Region\Models\Region;
use Domain\Region\Models\SubRegion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Country>
 */
class CountryFactory extends Factory
{
    /**
     * @var string<Country>
     */
    protected $model = Country::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'common_name' => fake()->name(),
            'official_name' => fake()->name(),
            'country_code' => fake()->countryCode(),
            'population' => fake()->numberBetween(1000, 1000000),
            'flag' => fake()->safeColorName(),
            'area' => fake()->numberBetween(1000, 1000000),
            'region_id' => Region::factory(),
            'sub_region_id' => SubRegion::factory(),
        ];
    }
}
