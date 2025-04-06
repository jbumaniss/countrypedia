<?php

namespace Tests\Domain\Country\Models;

use Domain\Country\Models\CountryAlias;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class CountryAliasesTest extends TestCase
{
    public function test_it_uses_factory(): void
    {
        $this->assertContains(
            HasFactory::class, class_uses(CountryAlias::class), 'CountryAlias model does not use HasFactory trait'
        );
    }

    public function test_it_has_correct_table_name(): void
    {
        $this->assertEquals('country_aliases', (new CountryAlias())->getTable(), 'CountryAlias model does not have the correct table name');
    }

    public function test_it_has_correct_casts(): void
    {
        $this->assertArrayHasKey('country_id', (new CountryAlias())->getCasts(), 'CountryAlias model does not have the correct casts');
        $this->assertEquals('integer', (new CountryAlias())->getCasts()['country_id'], 'CountryAlias model does not have the correct casts');
    }

    public function test_it_has_relationship_country(): void
    {
        $countryAlias = CountryAlias::factory()->create();
        $this->assertTrue(
            method_exists($countryAlias, 'country'), 'CountryAlias model does not have the correct relationship'
        );
        $this->assertInstanceOf(
            BelongsTo::class, $countryAlias->country(), 'CountryAlias model does not have the correct relationship'
        );
    }
}