<?php

namespace Tests\Domain\Shared\Services;

use Domain\Country\Resources\CountryApiResource;
use Domain\Shared\Services\ApiService;
use Domain\Shared\Traits\CanSendGetRequest;
use ReflectionClass;
use Tests\TestCase;

class ApiServiceTest extends TestCase
{
    private ApiService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = resolve(ApiService::class);
    }

    public function test_it_uses_can_send_get_request_trait(): void
    {
        $this->assertContains(
            CanSendGetRequest::class,
            class_uses($this->service),
            'ApiService does not use CanSendGetRequest trait'
        );
    }

    public function test_it_has_bas_url(): void
    {
        $apiService = $this->service;
        $baseUrl = 'https://api.example.com';
        $response = $apiService->withBaseUrl($baseUrl);
        $reflection = new ReflectionClass($response);
        $property = $reflection->getProperty('baseUrl');
        $this->assertEquals($baseUrl, $property->getValue($response), 'Base URL is not set correctly');
    }

    public function test_it_has_country_resource(): void
    {
        $countryResource = $this->service->countryResource();
        $this->assertInstanceOf(CountryApiResource::class, $countryResource, 'Country resource is not an instance of CountryApiResource');
    }
}