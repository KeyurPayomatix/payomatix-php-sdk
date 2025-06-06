<?php
namespace PayomatixSDK\Contracts;

use PayomatixSDK\Requests\SeamlessPaymentRequest;

interface SeamlessTransactionServiceInterface
{
    /**
     * Process a seamless payment request
     *
     * @param SeamlessPaymentRequest $request
     * @return array
     */
    public function process(SeamlessPaymentRequest $request): array;
}
