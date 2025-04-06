<?php

namespace Tests\Domain\Language\Models;

use Domain\Country\Models\Country;
use Domain\Language\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Tests\TestCase;

class LanguageTest extends TestCase
{
    public function test_it_uses_factory(): void
    {
        $this->assertContains(
            HasFactory::class, class_uses(Language::class), 'Language model does not use HasFactory trait'
        );
    }

    public function test_it_has_correct_table_name(): void
    {
        $this->assertEquals('languages', (new Language())->getTable(), 'Language model does not have the correct table name');
    }

    public function test_it_has_relationship_countries(): void
    {
        $language = Language::factory()->create();
        $country = Country::factory()
            ->create();
        $language->countries()->attach($country);

        $this->assertTrue(
            method_exists($language, 'countries'), 'Language model does not have the correct relationship'
        );

        $this->assertInstanceOf(
            BelongsToMany::class, $language->countries(), 'Language model does not have the correct relationship'
        );
        $this->assertEquals($language->id, $language->countries()->first()->id, 'Language model does not have the correct relationship');
    }
}