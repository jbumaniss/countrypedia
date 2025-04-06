<?php

namespace Tests\Domain\Language\Builders;

use Domain\Country\Models\Country;
use Domain\Language\Models\Language;
use Tests\TestCase;

class LanguageBuilderTest extends TestCase
{
    public function test_it_can_find_by_id():void
    {
        $country = Country::factory()->create();
        $language = Language::factory()->create();
        $country->languages()->save($language);

        $response = Language::query()->findById($language->id);

        $this->assertInstanceOf(Language::class, $response);
        $this->assertEquals($language->id, $response->id);
        $this->assertEquals($language->code, $response->code);
        $this->assertCount(1, $response->countries);
        $this->assertEquals($country->id, $response->countries->first()->id);
    }
}