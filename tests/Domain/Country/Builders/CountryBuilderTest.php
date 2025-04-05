<?php

namespace Tests\Domain\Country\Builders;

use Domain\Country\Models\Country;
use Tests\TestCase;

class CountryBuilderTest extends TestCase
{
    public function test_list(): void
    {
        Country::factory()->count(10)->create();
        $countries = Country::query()->list()->get();

        $this->assertCount(10, $countries);
    }
}