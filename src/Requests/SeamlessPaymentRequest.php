<?php

namespace PayomatixSDK\Requests;

use PayomatixSDK\Contracts\PaymentRequestInterface;

class SeamlessPaymentRequest implements PaymentRequestInterface
{
    public string $email;
    public float $amount;
    public string $currency;
    public string $returnUrl;
    public string $notifyUrl;
    public string $merchantRef;
    public ?string $paymentCategoryOverride = null;

    public function toArray(): array
    {
        $data = [
            'email'        => $this->email,
            'amount'       => $this->amount,
            'currency'     => $this->currency,
            'return_url'   => $this->returnUrl,
            'notify_url'   => $this->notifyUrl,
            'merchant_ref' => $this->merchantRef,
        ];

        if (!empty($this->paymentCategoryOverride)) {
            $data['search_key'] = $this->paymentCategoryOverride;
        }

        return $data;
    }
}
