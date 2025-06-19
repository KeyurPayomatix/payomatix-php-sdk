<?php

namespace PayomatixSDK\Services;

use PayomatixSDK\Requests\TransactionStatusRequest;
use PayomatixSDK\Responses\TransactionStatusResponse;

class TransactionStatusService
{
    private HttpService $httpService;

    public function __construct(HttpService $httpService)
    {
        $this->httpService = $httpService;
    }


    public function check(TransactionStatusRequest $payload): TransactionStatusResponse
    {
        $config = require __DIR__ . '/../config/payomatix.php';
        $endpoint = $config['endpoints']['transaction_status'];

        $response = $this->httpService->post($endpoint, $payload->toArray());

        if (($response['responseCode'] ?? 400) !== 200 || !isset($response['data'])) {
            throw new \Exception($response['response'] ?? 'Unknown error');
        }

        return new TransactionStatusResponse($response['data']);
    }
}
