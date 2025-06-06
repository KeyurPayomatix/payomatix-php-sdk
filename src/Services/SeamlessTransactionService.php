<?php

namespace PayomatixSDK\Services;

use PayomatixSDK\Requests\SeamlessPaymentRequest;

class SeamlessTransactionService
{
    private HttpService $httpService;

    const SEAMLESS_API_URL = 'https://admin.payomatix.com/payment/merchant/seamless/transaction';

    public function __construct(HttpService $httpService)
    {
        $this->httpService = $httpService;
    }

    public function create(SeamlessPaymentRequest $seamlessTransactionDto): array
    {
        return $this->httpService->post(self::SEAMLESS_API_URL, $seamlessTransactionDto->toArray(), [
            'User-Agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown-Agent',
        ]);
    }
}
