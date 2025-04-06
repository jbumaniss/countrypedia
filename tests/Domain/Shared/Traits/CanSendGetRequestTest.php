<?php

namespace Tests\Domain\Shared\Traits;

use Domain\Shared\Traits\CanSendGetRequest;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CanSendGetRequestTest extends TestCase
{
    public function test_can_send_get(): void
    {
        $baseUrl = 'https://restcountries.com/v3.1';
        $endpoint = '/all';
        $url = $baseUrl . $endpoint;

        Http::fake([
            $url => Http::response(
                [
                    'name'       => 'Test Country',
                    'capital'    => 'Test Capital',
                    'region'     => 'Test Region',
                    'subregion'  => 'Test Subregion',
                    'population' => 1000000,
                    'area'       => 100000,
                    'languages'  => ['English'],
                    'currencies' => ['USD'],
                ],
                200
            ),
        ]);

        $traitInstance = new class {
            use CanSendGetRequest;
        };

        $request = Http::baseUrl($baseUrl);
        $response = $traitInstance->get($request, $url);

        $this->assertEquals(200, $response->status());
        $json = $response->json();
        $this->assertIsArray($json);
    }
}