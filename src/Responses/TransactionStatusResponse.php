<?php

namespace PayomatixSDK\Responses;

use PayomatixSDK\Support\Helpers;

class TransactionStatusResponse
{
    /** @var string */
    public $orderId;

    /** @var string */
    public $merchantRef;

    /** @var string */
    public $connector;

    /** @var string */
    public $email;

    /** @var float */
    public $amount;

    /** @var string */
    public $currency;

    /** @var string */
    public $status;

    /** @var int  */
    public $statusCode;

    /** @var string */
    public $rawStatusMessage;

    /** @var array|null */
    public $paymentGatewayResponse;

    /** @var string */
    public $merchantReturnUrl;

    /** @var string|null */
    public $webhookCallbackUrl;


    /**
     * TransactionStatusResponse constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->orderId                = $data['order_id'] ?? '';
        $this->merchantRef            = $data['merchant_ref'] ?? '';
        $this->connector              = $data['connector'] ?? '';
        $this->email                  = $data['email'] ?? '';
        $this->amount                 = isset($data['amount']) ? (float) $data['amount'] : 0.0;
        $this->currency               = $data['currency'] ?? 'INR';
        $this->status                 = Helpers::mapStatus($data['status'] ?? '');
        $this->statusCode                 = $data['status'];
        $this->rawStatusMessage       = $data['response'] ?? '';
        $this->paymentGatewayResponse = Helpers::decodeJson($data['payment_gateway_response'] ?? '');
        $this->merchantReturnUrl      = $data['return_url'] ?? '';
        $this->webhookCallbackUrl     = $data['notify_url'] ?? null;
    }


    /**
     * Convert object to array for http method request
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'order_id' => $this->orderId,
            'merchant_ref' => $this->merchantRef,
            'connector' => $this->connector,
            'email' => $this->email,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'status' => $this->status,
            'status_code' => $this->statusCode,
            'raw_status_message' => $this->rawStatusMessage,
            'payment_gateway_response' => $this->paymentGatewayResponse,
            'return_url' => $this->merchantReturnUrl,
            'notify_url' => $this->webhookCallbackUrl
        ];
    }
}
