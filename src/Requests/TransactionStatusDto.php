<?php

namespace PayomatixSDK\Requests;

class TransactionStatusDto
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
