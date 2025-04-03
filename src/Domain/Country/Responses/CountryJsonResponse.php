<?php

namespace Domain\Country\Responses;

use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CountryJsonResponse extends JsonResponse
{
    public static function make(Response $response): CountryJsonResponse
    {
        return new self($response->json(), $response->status());
    }
}
