<?php
namespace PayomatixSDK\Contracts;

use PayomatixSDK\Requests\HostedPaymentRequest;

interface HostedTransactionServiceInterface
{
    /**
     * Process a hosted payment request
     *
     * @param HostedPaymentRequest $request
     * @return array
     */
    public function process(HostedPaymentRequest $request): array;
}
