<?php
namespace PayomatixSDK\Contracts;

use PayomatixSDK\Requests\TransactionStatusRequest;

interface TransactionStatusServiceInterface
{
    /**
     * Check transaction status
     *
     * @param TransactionStatusRequest $request
     * @return array
     */
    public function check(TransactionStatusRequest $request): array;
}
