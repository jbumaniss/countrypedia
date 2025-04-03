<?php

namespace Domain\Country\Resources;

use Domain\Country\Responses\CountryJsonResponse;
use Domain\Shared\Services\ApiService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;

class CountryResource
{
    public function __construct(private readonly ApiService $service)
    {
    }

    /**
     * @throws ConnectionException
     */
    public function list(): JsonResponse
    {
        $response = $this->service->get(
            request: $this->service->withBaseUrl('https://restcountries.com/v3.1'),
            url: '/all'
        );

        return CountryJsonResponse::make($response);
    }
}
