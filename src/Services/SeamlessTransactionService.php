<?php

namespace PayomatixSDK\Services;

use PayomatixSDK\Services\HttpService;

class SeamlessTransactionService
{
    private HttpService $httpService;

    public function __construct(HttpService $httpService)
    {
        $this->httpService = $httpService;
    }

    public function process($request): array
    {
        $config = require __DIR__ . '/../Config/Payomatix.php';
        $endpoint = $config['endpoints']['seamless_transaction'];

        return $this->httpService->post($endpoint, $request->toArray(), [
            'User-Agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown-Agent',
        ]);
    }
} 