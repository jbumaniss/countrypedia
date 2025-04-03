<?php

namespace Domain\Shared\Services;

use Domain\Country\Resources\CountryResource;
use Domain\Shared\Traits\CanSendGetRequest;
use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiService
{
    use CanSendGetRequest;

    public function withBaseUrl(string $baseUrl): PendingRequest
    {
        return Http::baseUrl($baseUrl);
    }

    public function countryResource(): CountryResource
    {
        return new CountryResource($this);
    }
}
