<?php

namespace PayomatixSDK\Services;

use PayomatixSDK\Responses\TransactionStatusResponse;
use PayomatixSDK\Services\HttpService;

class TransactionStatusService
{
    private HttpService $httpService;

    public function __construct(HttpService $httpService)
    {
        $this->httpService = $httpService;
    }

    public function check($payload): TransactionStatusResponse
    {
        $config = require __DIR__ . '/../Config/Payomatix.php';
        $endpoint = $config['endpoints']['transaction_status'];

        $response = $this->httpService->post($endpoint, $payload->toArray());

        if (($response['responseCode'] ?? 400) !== 200 || !isset($response['data'])) {
            throw new \Exception($response['response'] ?? 'Unknown error');
        }

        return new TransactionStatusResponse($response['data']);
    }
} 