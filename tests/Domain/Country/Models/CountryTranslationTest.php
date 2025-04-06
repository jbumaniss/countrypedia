<?php

namespace Domain\Country\Models;

use Domain\Country\Models\CountryAlias;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class CountryTranslationTest extends TestCase
{
    public function test_it_uses_factory(): void
    {
        $this->assertContains(
            HasFactory::class, class_uses(CountryTranslation::class), 'CountryTranslation model does not use HasFactory trait'
        );
    }

    public function test_it_has_correct_table_name(): void
    {
        $this->assertEquals('country_translations', (new CountryTranslation())->getTable(), 'CountryTranslation model does not have the correct table name');
    }

    public function test_it_has_correct_casts(): void
    {
        $this->assertArrayHasKey('country_id', (new CountryTranslation())->getCasts(), 'CountryTranslation model does not have the correct casts');
        $this->assertEquals('integer', (new CountryTranslation())->getCasts()['country_id'], 'CountryTranslation model does not have the correct casts');
    }

    public function test_it_has_relationship_country(): void
    {
        $countryTranslation = CountryTranslation::factory()->create();
        $this->assertTrue(
            method_exists($countryTranslation, 'country'), 'CountryTranslation model does not have the correct relationship'
        );
        $this->assertInstanceOf(
            BelongsTo::class, $countryTranslation->country(), 'CountryTranslation model does not have the correct relationship'
        );
    }
}