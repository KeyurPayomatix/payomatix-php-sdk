<?php

namespace PayomatixSDK\Requests;

use PayomatixSDK\Contracts\PaymentRequestInterface;

class TransactionStatusRequest implements PaymentRequestInterface
{
    public string $merchantRef;
    public string $orderId;

    public function toArray(): array
    {
        return [
            'merchant_ref'        => $this->merchantRef,
            'order_id'       => $this->orderId,
        ];
    }
}
