<?php

namespace Domain\Country\Responses;

use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;

class CountryJsonResponse extends JsonResponse
{
    public static function make(Response $response): CountryJsonResponse
    {
        return new self($response->json(), $response->status());
    }
}
