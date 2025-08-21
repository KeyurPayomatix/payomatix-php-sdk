<?php

namespace PayomatixSDK\Requests;

use PayomatixSDK\Contracts\PaymentRequestInterface;

class TransactionStatusRequest implements PaymentRequestInterface
{
    /** @var string $orderId Transaction Order ID */
    public string $orderId;

    /**
     * Converts TransactionData to an array format expected by the API
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'order_id' => $this->orderId,
        ];
    }
} 