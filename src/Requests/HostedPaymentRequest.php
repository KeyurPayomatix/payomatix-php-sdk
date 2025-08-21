<?php

namespace PayomatixSDK\Requests;

use PayomatixSDK\Contracts\PaymentRequestInterface;
use PayomatixSDK\Support\Helpers;

class HostedPaymentRequest implements PaymentRequestInterface
{
    /** @var string $email Customer email address */
    public string $email;

    /** @var float $amount Transaction amount */
    public float $amount;

    /** @var string $currency Transaction currency (default: INR) */
    public string $currency = 'INR';

    /** @var string $merchantReturnUrl URL to redirect the customer after transaction */
    public string $merchantReturnUrl;

    /** @var string $webhookCallbackUrl URL to receive server-side webhook notification */
    public string $webhookCallbackUrl;

    /**
     * @var array $additionalInfo
     *
     * Optional. Pre-fills the checkout form with customer information
     * (e.g., firstName, lastName, address, state, city, zip, country, phoneNo, cardNo, customerVpa, etc.) if provided.
     */
    private array $additionalInfo = [];

    /**
     * @var array<int, array{name: string, quantity: string|int, price: string|float, imageUrl: string}>
     *
     * Optional. Contains a list of products to be displayed on the checkout page.
     * Each product includes the name, quantity, price, and an image URL.
     */
    private array $products = [];

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

        // Set additional info
        if (isset($payload['additionalInfo']) && is_array($payload['additionalInfo'])) {
            $this->setAdditionalInfo($payload['additionalInfo']);
        }

        // Set products
        if (isset($payload['products']) && is_array($payload['products'])) {
            $this->setProducts($payload['products']);
        }
    }

    /**
     * Converts TransactionData to an array format expected by the API
     *
     * @return array
     */
    public function toArray(): array
    {
        $data = [
            'email'        => $this->email,
            'amount'       => number_format($this->amount, 2, '.', ''),
            'currency'     => $this->currency,
            'merchantReturnUrl' => $this->merchantReturnUrl,
            'webhookCallbackUrl' => $this->webhookCallbackUrl,
        ];

        if (!empty($this->additionalInfo)) {
            $data['additionalInfo'] = $this->additionalInfo;
        }

        if (!empty($this->products)) {
            $data['products'] = $this->products;
        }

        return $data;
    }

    /**
     * Set additional customer information to prefill the payment form.
     *
     * @param array<string, mixed> $additionalInfo
     *      Associative array of additional customer details such as
     *      firstName, lastName, address, state, city, zip, country, phoneNo, cardNumber, cvvNumber, etc.
     */
    public function setAdditionalInfo(array $additionalInfo): void
    {
        // Keep the original field names as specified in the format
        $this->additionalInfo = $additionalInfo;
    }

    /**
     * Set the product list.
     *
     * @param array<int, array{name: string, quantity: string|int, price: string|float, imageUrl: string}> $productList
     *      List of products to be displayed on the checkout page.
     */
    public function setProducts(array $productList): void
    {
        $this->products = $productList;
    }
} 