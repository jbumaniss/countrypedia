<?php

namespace Tests\Domain\Country\Models;

use Domain\Country\Models\Country;
use Domain\Country\Models\CountryAlias;
use Domain\Language\Models\Language;
use Domain\Region\Models\Region;
use Domain\Region\Models\SubRegion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class CountryTest extends TestCase
{
    public function test_it_uses_factory(): void
    {
        $this->assertContains(
            HasFactory::class, class_uses(Country::class), 'Country model does not use HasFactory trait'
        );
    }

    public function test_it_has_correct_table_name(): void
    {
        $this->assertEquals('countries', (new Country())->getTable(), 'Country model does not have the correct table name');
    }

    public function test_it_has_correct_casts(): void
    {
        $country = new Country();
        $casts = $country->getCasts();

        $this->assertArrayHasKey('population', $casts, 'Country model does not have the correct casts');
        $this->assertArrayHasKey('area', $casts, 'Country model does not have the correct casts');

        $this->assertEquals('integer', $casts['population'], 'Country model does not have the correct casts');
        $this->assertEquals('float', $casts['area'], 'Country model does not have the correct casts');
    }

    public function test_it_has_relationship_region(): void
    {
        $region = Region::factory()->create();
        $country = Country::factory()
            ->for($region)
            ->create();

        $this->assertTrue(
            method_exists($country, 'region'), 'Country model does not have the correct relationship'
        );

        $this->assertInstanceOf(
            BelongsTo::class, $country->region(), 'Country model does not have the correct relationship'
        );
        $this->assertEquals($region->id, $country->region->id, 'Country model does not have the correct relationship');
    }

    public function test_it_has_relationship_subRegion(): void
    {
        $subRegion = SubRegion::factory()->create();
        $country = Country::factory()
            ->for($subRegion)
            ->create();
        $this->assertTrue(
            method_exists($country, 'subRegion'), 'Country model does not have the correct relationship'
        );

        $this->assertInstanceOf(
            BelongsTo::class, $country->subRegion(), 'Country model does not have the correct relationship'
        );
        $this->assertEquals($subRegion->id, $country->subRegion->id, 'Country model does not have the correct relationship');
    }

    public function test_it_has_relationship_languages(): void
    {
        $language = Language::factory()->create();
        $country = Country::factory()
            ->hasAttached($language)
            ->create();
        $this->assertTrue(
            method_exists($country, 'languages'), 'Country model does not have the correct relationship'
        );

        $this->assertInstanceOf(
            BelongsToMany::class, $country->languages(), 'Country model does not have the correct relationship'
        );
        $this->assertEquals($language->id, $country->languages->first()->id, 'Country model does not have the correct relationship');
    }

    public function test_it_has_relationship_aliases(): void
    {
        $country = Country::factory()->create();
        $countryAlias = CountryAlias::factory()
            ->for($country)
            ->create();
        $this->assertTrue(
            method_exists($country, 'aliases'), 'Country model does not have the correct relationship'
        );

        $this->assertInstanceOf(
            HasMany::class, $country->aliases(), 'Country model does not have the correct relationship'
        );
    }
}