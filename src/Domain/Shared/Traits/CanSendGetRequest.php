<?php

namespace Domain\Shared\Traits;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

trait CanSendGetRequest
{
    /**
     * @throws ConnectionException
     */
    public function get(PendingRequest $request, string $url): Response
    {
        $response = $request
            ->withHeaders([
                'Accept' => '*/*',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Connection' => 'keep-alive',
            ])
            ->get(url: $url);

        if ($response->serverError()) {
            Log::error("API: {$response->reason()}");
        }

        return $response;
    }
}
