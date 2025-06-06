<?php
namespace PayomatixSDK\Contracts;

interface PaymentRequestInterface
{
    /**
     * Convert the request data to an array.
     *
     * @return array
     */
    public function toArray(): array;
}
