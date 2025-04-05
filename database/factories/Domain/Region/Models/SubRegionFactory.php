<?php

namespace Database\Factories\Domain\Region\Models;

use Domain\Region\Models\SubRegion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SubRegion>
 */
class SubRegionFactory extends Factory
{
    /**
     * @var string<SubRegion>
     */
    protected $model = SubRegion::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
        ];
    }
}
