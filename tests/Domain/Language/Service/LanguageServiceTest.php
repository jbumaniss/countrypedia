<?php

namespace Tests\Domain\Language\Service;

use Domain\Country\Models\Country;
use Domain\Language\Models\Language;
use Domain\Language\Services\LanguageService;
use Tests\TestCase;

class LanguageServiceTest extends TestCase
{
    public function test_it_shows_language(): void
    {
        $country = Country::factory()->create();
        $language = Language::factory()->create();
        $country->languages()->save($language);

        $response = resolve(LanguageService::class)->show($language->id);

        $this->assertInstanceOf(Language::class, $response);
        $this->assertEquals($language->id, $response->id);
        $this->assertEquals($language->code, $response->code);
        $this->assertCount(1, $response->countries);
        $this->assertEquals($country->id, $response->countries->first()->id);
    }
}