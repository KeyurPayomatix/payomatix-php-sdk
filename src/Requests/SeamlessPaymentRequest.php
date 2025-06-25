<?php

namespace PayomatixSDK\Requests;

use PayomatixSDK\Contracts\PaymentRequestInterface;
use PayomatixSDK\Support\Helpers;

class SeamlessPaymentRequest implements PaymentRequestInterface
{
    public string $email;
    public float $amount;
    public string $currency;

    /** @var string $merchantReturnUrl URL to redirect the customer after transaction */
    public string $merchantReturnUrl;

    /** @var string $webhookCallbackUrl URL to receive server-side webhook notification */
    public string $webhookCallbackUrl;

    /**
     * @var int|string $paymentMethodType
     *
     * Required. Indicates the selected payment method type used in the transaction.
     * This value determines which additional fields are required in the `additionalInfo` section.
     *
     * Accepted values:
     *   1 => Credit Card
     *   2 => Debit Card
     *   3 => UPI
     *   4 => Wallet
     *   5 => Net Banking
     *   8 => Buy Now Pay Later
     *   9 => EMI
     *   10 => E-Challan
     */
    public int $paymentMethodType;

    /**
     * @var array $additionalInfo
     *
     * Optional. Pre-fills the checkout form with customer information
     * (e.g., firstName, lastName, address, state, city, zip, country, phoneNo, cardNo, customerVpa, etc.) if provided.
     */
    private array $additionalInfo = [];

    public function toArray(): array
    {
        $data = [
            'email'        => $this->email,
            'amount'       => $this->amount,
            'currency'     => $this->currency,
        ];

        if (!empty($this->paymentMethodType)) {
            $data['type_id'] = $this->paymentMethodType;
        }

        if (!empty($this->merchantReturnUrl)) {
            $data['return_url'] = $this->merchantReturnUrl;
        }

        if (!empty($this->webhookCallbackUrl)) {
            $data['notify_url'] = $this->webhookCallbackUrl;
        }

        if (!empty($this->paymentCategoryOverride)) {
            $data['search_key'] = $this->paymentCategoryOverride;
        }

        if (!empty($this->additionalInfo)) {
            $otherData = Helpers::convertToSnakeCase($this->additionalInfo);
            $data = array_merge($data, $otherData);
        }

        return $data;
    }

    /**
     * Set additional customer information to prefill the payment form.
     *
     * @param array<string, mixed> $additionalInfo
     *      Associative array of additional customer details such as
     *      firstName, lastName, address, state, city, zip, country, phoneNo, cardNo, customerVpa, etc.
     */
    public function setAdditionalInfo(array $additionalInfo): void
    {
//        // Map cardNumber to card_no
//        if(isset($additionalInfo['cardNumber'])) {
//            $additionalInfo['card_no'] = $additionalInfo['cardNumber'];
//            unset($additionalInfo['cardNumber']);
//        }
//
//        // Map upiAddress to customer_vpa
//        if(isset($additionalInfo['upiAddress'])) {
//            $additionalInfo['customer_vpa'] = $additionalInfo['upiAddress'];
//            unset($additionalInfo['upiAddress']);
//        }

        $this->additionalInfo = $additionalInfo;
    }
}
