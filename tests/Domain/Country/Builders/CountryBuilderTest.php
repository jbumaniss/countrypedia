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
        $countryA->aliases()->create([
            'code' => 'BR',
            'official' => 'Bravo',
            'common' => 'Bravo',
        ]);

        $countryB = Country::factory()->create([
            'common_name' => 'Alpha',
        ])->aliases()->create([
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
        $countryA->aliases()->create([
            'code' => 'BR',
            'official' => 'Bravo',
            'common' => 'Bravo',
        ]);

        $countryB = Country::factory()->create([
            'common_name' => 'Alpha',
        ]);
        $countryB->aliases()->create([
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

    public function test_it_can_find_by_region(): void
    {
        $region = SubRegion::factory()->create();
        $countryA = Country::factory()->create([
            'sub_region_id' => $region->id,
            'common_name' => 'Bravo',
        ]);
        $countryB = Country::factory()->create([
            'sub_region_id' => $region->id,
            'common_name' => 'Alpha',
        ]);

        $response = Country::query()->findByRegion($region->id)->get();

        $this->assertCount(2, $response);
        $findCountryA = $response->firstWhere('id', $countryA->id);
        $findCountryB = $response->firstWhere('id', $countryB->id);
        $this->assertNotNull($findCountryA);
        $this->assertNotNull($findCountryB);
    }

    public function test_it_can_find_by_region_with_exclude_id(): void
    {
        $region = SubRegion::factory()->create();
        $countryA = Country::factory()->create([
            'sub_region_id' => $region->id,
            'common_name' => 'Bravo',
        ]);
        $countryB = Country::factory()->create([
            'sub_region_id' => $region->id,
            'common_name' => 'Alpha',
        ]);

        $response = Country::query()->findByRegion(
            $region->id,
            $countryA->id
        )->get();

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