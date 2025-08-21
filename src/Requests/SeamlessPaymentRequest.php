<?php

namespace PayomatixSDK\Requests;

use PayomatixSDK\Contracts\PaymentRequestInterface;
use PayomatixSDK\Support\Helpers;

class SeamlessPaymentRequest implements PaymentRequestInterface
{
    public string $email = '';
    public float $amount = 0.0;
    public string $currency = 'INR';

    /** @var string $merchantReturnUrl URL to redirect the customer after transaction */
    public string $merchantReturnUrl = '';

    /** @var string $webhookCallbackUrl URL to receive server-side webhook notification */
    public string $webhookCallbackUrl = '';

    /** @var string|null $merchantRef Merchant reference for the transaction */
    public ?string $merchantRef = null;

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
    public int $paymentMethodType = 1;

    /** @var string|null $upiAddress UPI address for UPI payments */
    public ?string $upiAddress = null;

    /** @var string|null $cardNumber Card number for card payments */
    public ?string $cardNumber = null;

    /** @var string|null $cvvNumber CVV number for card payments */
    public ?string $cvvNumber = null;

    /** @var string|null $expiryMonth Card expiry month */
    public ?string $expiryMonth = null;

    /** @var string|null $expiryYear Card expiry year */
    public ?string $expiryYear = null;

    /**
     * @var array $additionalInfo
     *
     * Optional. Pre-fills the checkout form with customer information
     * (e.g., firstName, lastName, address, state, city, zip, country, phoneNo, etc.) if provided.
     */
    private array $additionalInfo = [];

    /**
     * Constructor to initialize the request with payload data
     *
     * @param array<string, mixed> $payload
     */
    public function __construct(array $payload = [])
    {
        if (!empty($payload)) {
            $this->fromArray($payload);
        }
    }

    /**
     * Initialize the request from an array payload
     *
     * @param array<string, mixed> $payload
     */
    public function fromArray(array $payload): void
    {
        // Set basic fields
        if (isset($payload['email'])) {
            $this->email = $payload['email'];
        }

        if (isset($payload['amount'])) {
            $this->amount = (float) $payload['amount'];
        }

        if (isset($payload['currency'])) {
            $this->currency = $payload['currency'];
        }

        if (isset($payload['merchantReturnUrl'])) {
            $this->merchantReturnUrl = $payload['merchantReturnUrl'];
        }

        if (isset($payload['webhookCallbackUrl'])) {
            $this->webhookCallbackUrl = $payload['webhookCallbackUrl'];
        }

        if (isset($payload['paymentMethodType'])) {
            $this->paymentMethodType = (int) $payload['paymentMethodType'];
        }

        if (isset($payload['upiAddress'])) {
            $this->upiAddress = $payload['upiAddress'];
        }

        if (isset($payload['cardNumber'])) {
            $this->cardNumber = $payload['cardNumber'];
        }

        if (isset($payload['cvvNumber'])) {
            $this->cvvNumber = $payload['cvvNumber'];
        }

        if (isset($payload['expiryMonth'])) {
            $this->expiryMonth = $payload['expiryMonth'];
        }

        if (isset($payload['expiryYear'])) {
            $this->expiryYear = $payload['expiryYear'];
        }

        if (isset($payload['merchantRef'])) {
            $this->merchantRef = $payload['merchantRef'];
        }

        // Set additional info
        if (isset($payload['additionalInfo']) && is_array($payload['additionalInfo'])) {
            $this->setAdditionalInfo($payload['additionalInfo']);
        }
    }

    public function toArray(): array
    {
        $data = [
            'email'        => $this->email,
            'amount'       => number_format($this->amount, 2, '.', ''),
            'currency'     => $this->currency,
            'merchantReturnUrl' => $this->merchantReturnUrl,
            'webhookCallbackUrl' => $this->webhookCallbackUrl,
            'paymentMethodType' => (string) $this->paymentMethodType,
        ];

        if (!empty($this->upiAddress)) {
            $data['upiAddress'] = $this->upiAddress;
        }

        if (!empty($this->cardNumber)) {
            $data['cardNumber'] = $this->cardNumber;
        }

        if (!empty($this->cvvNumber)) {
            $data['cvvNumber'] = $this->cvvNumber;
        }

        if (!empty($this->expiryMonth)) {
            $data['expiryMonth'] = $this->expiryMonth;
        }

        if (!empty($this->expiryYear)) {
            $data['expiryYear'] = $this->expiryYear;
        }

        if (!empty($this->merchantRef)) {
            $data['merchantRef'] = $this->merchantRef;
        }

        if (!empty($this->additionalInfo)) {
            $data['additionalInfo'] = $this->additionalInfo;
        }

        return $data;
    }

    /**
     * Set additional customer information to prefill the payment form.
     *
     * @param array<string, mixed> $additionalInfo
     *      Associative array of additional customer details such as
     *      firstName, lastName, address, state, city, zip, country, phoneNo, etc.
     */
    public function setAdditionalInfo(array $additionalInfo): void
    {
        // Keep the original field names as specified in the format
        $this->additionalInfo = $additionalInfo;
    }
} 