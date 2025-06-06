<?php

namespace PayomatixSDK\Services;

use PayomatixSDK\Requests\HostedPaymentRequest;

class HostedTransactionService
{
    protected HttpService $httpService;

    public function __construct(HttpService $httpService)
    {
        $this->httpService = $httpService;
    }

    public function process(HostedPaymentRequest $dto): array
    {
        $config = require __DIR__ . '/../config/payomatix.php';
        $endpoint = $config['endpoints']['hosted_transaction'];

        print_r($dto->toArray());
        return $this->httpService->post($endpoint, $dto->toArray());
    }
}