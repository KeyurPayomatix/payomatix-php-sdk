<?php

namespace PayomatixSDK\Services;

use PayomatixSDK\Contracts\HostedTransactionServiceInterface;
use PayomatixSDK\Services\HttpService;

class HostedTransactionService implements HostedTransactionServiceInterface
{
    protected HttpService $httpService;

    public function __construct(HttpService $httpService)
    {
        $this->httpService = $httpService;
    }

    public function process($request): array
    {
        $config = require __DIR__ . '/../Config/Payomatix.php';
        $endpoint = $config['endpoints']['hosted_transaction'];

        return $this->httpService->post($endpoint, $request->toArray());
    }
}