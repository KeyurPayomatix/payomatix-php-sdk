<?php

namespace PayomatixSDK\Services;

use PayomatixSDK\Requests\TransactionStatusDto;

class TransactionStatusService
{
    private HttpService $httpService;

    const STATUS_API_URL = 'https://admin.payomatix.com/payment/get/transaction';

    public function __construct(HttpService $httpService)
    {
        $this->httpService = $httpService;
    }


    //string $merchantRef, ?string $orderId = null
    public function check(TransactionStatusDto $transactionStatusDto): array
    {
        return $this->httpService->post(self::STATUS_API_URL, $transactionStatusDto->toArray());
    }
}
