<?php

namespace PayomatixSDK\Services;

use PayomatixSDK\Contracts\HostedTransactionServiceInterface;
use PayomatixSDK\Requests\HostedPaymentRequest;

class HostedTransactionService implements HostedTransactionServiceInterface
{
    protected HttpService $httpService;

    public function __construct(HttpService $httpService)
    {
        $this->httpService = $httpService;
    }

    public function process(HostedPaymentRequest $payload): array
    {
        $config = require __DIR__ . '/../config/payomatix.php';
        $endpoint = $config['endpoints']['hosted_transaction'];

        return $this->httpService->post($endpoint, $payload->toArray());
    }
}