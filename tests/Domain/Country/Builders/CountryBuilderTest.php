<?php

namespace Tests\Domain\Country\Builders;

use Domain\Country\Models\Country;
use Domain\Region\Models\SubRegion;
use Tests\TestCase;

class CountryBuilderTest extends TestCase
{
    public function test_list(): void
    {
        Country::factory()->count(10)->create();
        $countries = Country::query()->list()->get();

        $this->assertCount(10, $countries);
    }

    public function test_it_can_find_by_id(): void
    {
        $country = Country::factory()->create();

        $response = Country::query()->findById($country->id);

        $this->assertInstanceOf(Country::class, $response);
        $this->assertEquals($country->id, $response->id);
        $this->assertEquals($country->common_name, $response->common_name);
    }

    public function test_it_can_filter_by_search(): void
    {
        $countryA = Country::factory()->create([
            'common_name' => 'Bravo',
        ]);
        $countryA->translations()->create([
            'code' => 'BR',
            'official' => 'Bravo',
            'common' => 'Bravo',
        ]);

        $countryB = Country::factory()->create([
            'common_name' => 'Alpha',
        ])->translations()->create([
            'code' => 'AL',
            'official' => 'Alpha',
            'common' => 'Alpha',
        ]);

        $response = Country::query()->filterBySearch('bravo')->get();

        $this->assertCount(1, $response);
        $findCountryA = $response->firstWhere('id', $countryA->id);
        $findCountryB = $response->firstWhere('id', $countryB->id);
        $this->assertNotNull($findCountryA);
        $this->assertNull($findCountryB);
    }

    public function test_it_wont_filter_without_search_param(): void
    {
        $countryA = Country::factory()->create([
            'common_name' => 'Bravo',
        ]);
        $countryA->translations()->create([
            'code' => 'BR',
            'official' => 'Bravo',
            'common' => 'Bravo',
        ]);

        $countryB = Country::factory()->create([
            'common_name' => 'Alpha',
        ]);
        $countryB->translations()->create([
            'code' => 'AL',
            'official' => 'Alpha',
            'common' => 'Alpha',
        ]);

        $response = Country::query()
            ->filterBySearch()
            ->get();

        $this->assertCount(2, $response);
        $findCountryA = $response->firstWhere('id', $countryA->id);
        $findCountryB = $response->firstWhere('id', $countryB->id);
        $this->assertNotNull($findCountryA);
        $this->assertNotNull($findCountryB);
    }

    public function test_it_can_find_by_fifa_codes(): void
    {
        $fifa = 'BR';
        $countryA = Country::factory()->create([
            'common_name' => 'Bravo',
            'neighbors' => [$fifa],

        ]);
        $countryB = Country::factory()->create([
            'common_name' => 'Alpha',
            'fifa' => $fifa
        ]);

        $response = Country::query()->findByFifaCodes($countryA->neighbors)
            ->get();

        $this->assertCount(1, $response);
        $findCountryA = $response->firstWhere('id', $countryA->id);
        $findCountryB = $response->firstWhere('id', $countryB->id);
        $this->assertNull($findCountryA);
        $this->assertNotNull($findCountryB);
    }

    public function test_it_can_calculate_country_rank(): void
    {
        $countryA = Country::factory()->create([
            'population' => 100,
        ]);
        $countryB = Country::factory()->create([
            'population' => 200,
        ]);

        $response = Country::query()->calculateCountryRank($countryA->population);

        $this->assertEquals(2, $response);
    }
}