<?php

namespace Domain\Shared\Services;

use Domain\Country\Resources\CountryApiResource;
use Domain\Shared\Traits\CanSendGetRequest;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class ApiService
{
    use CanSendGetRequest;

    public function withBaseUrl(string $baseUrl): PendingRequest
    {
        return Http::baseUrl($baseUrl);
    }

    public function countryResource(): CountryApiResource
    {
        return new CountryApiResource($this);
    }
}
