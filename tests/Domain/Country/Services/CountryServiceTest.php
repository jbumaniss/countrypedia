<?php

namespace Tests\Domain\Country\Services;

use Domain\Country\Models\Country;
use Domain\Country\Services\CountryService;
use Domain\Region\Models\SubRegion;
use Tests\TestCase;

class CountryServiceTest extends TestCase
{
    private CountryService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = resolve(CountryService::class);
    }

    public function test_list(): void
    {
        $countryA = Country::factory()->create([
            'common_name' => 'Bravo',
        ]);

        $countryB = Country::factory()->create([
            'common_name' => 'Alpha',
        ]);

        $response = $this->service->list();

        $this->assertEquals(2, $response->count());
        $countryAFound = $response->firstWhere('id', $countryA->id);
        $countryBFound = $response->firstWhere('id', $countryB->id);
        $this->assertNotNull($countryAFound);
        $this->assertNotNull($countryBFound);
        $this->assertEquals($response->first()->id, $countryB->id);
    }

    public function test_list_with_search(): void
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

        $response = $this->service->list('bravo');

        $this->assertEquals(1, $response->count());
        $countryAFound = $response->firstWhere('id', $countryA->id);
        $this->assertNotNull($countryAFound);
    }

    public function test_show(): void
    {
        $country = Country::factory()->create([
            'common_name' => 'Bravo',
        ]);

        $response = $this->service->show($country->id);

        $this->assertNotNull($response);
        $this->assertEquals($country->id, $response->id);
        $this->assertEquals($country->common_name, $response->common_name);
        $this->assertEquals($country->official_name, $response->official_name);
    }

    public function test_show_with_population_rank(): void
    {
        $countryA = Country::factory()->create([
            'common_name' => 'Bravo',
            'population' => 100,
        ]);

        $countryB = Country::factory()->create([
            'common_name' => 'Bravo',
            'population' => 1000,
        ]);

        $response = $this->service->show($countryA->id);

        $this->assertNotNull($response);
        $this->assertEquals($countryA->id, $response->id);
        $this->assertEquals($countryA->common_name, $response->common_name);
        $this->assertEquals($countryA->official_name, $response->official_name);
        $this->assertEquals(2, $response->population_rank);
    }

    public function test_show_with_neighbours(): void
    {
        $validAlias = "neighbor a";
        $invalidAlias = "neighbor b";
        $countryA = Country::factory()
            ->create([
                'common_name' => 'Bravo',
                'neighbors' => [$validAlias],
            ]);
        $countryB = Country::factory()
            ->create([
                'common_name' => 'Alpha',
            ]);
        $countryB->aliases()->create([
            'name' => $validAlias,
        ]);
        $invalidCountry = Country::factory()
            ->create([
                'common_name' => 'Invalid',
            ]);
        $invalidCountry->aliases()->create([
            'name' => $invalidAlias,
        ]);

        $response = $this->service->show($countryA->id);

        $this->assertNotNull($response);
        $this->assertEquals($countryA->id, $response->id);
        $this->assertEquals($countryA->common_name, $response->common_name);
        $this->assertEquals($countryA->official_name, $response->official_name);
        $this->assertEquals(1, $response->neighbours->count());
        $this->assertEquals($countryB->id, $response->neighbours->first()->id);
        $this->assertNotEquals($invalidCountry->id, $response->neighbours->first()->id);

    }
}