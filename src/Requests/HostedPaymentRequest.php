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
     * @var string|null $overridePaymentCategory
     *
     * Optional. If set to one of the predefined values ('Rent', 'Vendor', 'Ecommerce', 'Education', 'Utility'),
     * this will override all default routing, cascading, and transaction limits, and force the transaction
     * to be processed using the specified payment gateway category.
     */
    public ?string $overridePaymentCategory = null;


    /**
     * @var string|null $onlyShowPaymentMethod
     *
     * Optional. Defines the specific payment method type to show on the checkout page.
     * If set, only the corresponding payment method will be displayed and all others will be hidden.
     *
     * Accepted values:
     *   1  => Credit Card
     *   2  => Debit Card
     *   3  => UPI
     *   4  => Wallet
     *   5  => Net Banking
     *   8  => Buy Now Pay Later
     *   9  => EMI
     *   10 => E-Challan
     */
    public ?string $onlyShowPaymentMethod = null;

    /**
     * @var string|null $splitPaymentVendors
     *
     * Optional. JSON string specifying vendor-wise split payment details.
     * Use this if you want to split the transaction amount across multiple vendors at runtime.
     *
     * - You must first create vendors in the merchant portal.
     * - Use the vendor's label as the key and amount as the value.
     * - The sum of all vendor amounts must exactly match the full transaction amount.
     *
     * Example:
     *   '{"vendor_label_1": 400, "vendor_label_2": 200}'
     */
    public ?string $splitPaymentVendors = null;

    /**
     * @var array $additionalInfo
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
     * Converts TransactionData to an array format expected by the API
     *
     * @return array
     */
    public function toArray(): array
    {
        $data = [
            'email'        => $this->email,
            'amount'       => $this->amount,
            'currency'     => $this->currency,
        ];

        if (!empty($this->merchantReturnUrl)) {
            $data['return_url'] = $this->merchantReturnUrl;
        }

        if (!empty($this->webhookCallbackUrl)) {
            $data['notify_url'] = $this->webhookCallbackUrl;
        }

        if (!empty($this->overridePaymentCategory)) {
            $data['search_key'] = $this->overridePaymentCategory;
        }

        if (!empty($this->onlyShowPaymentMethod)) {
            $data['select_type_id'] = $this->onlyShowPaymentMethod;
        }

        if (!empty($this->splitPaymentVendors)) {
            $data['split_payment_vendors'] = $this->splitPaymentVendors;
        }

        if (!empty($this->additionalInfo)) {
            $otherData = Helpers::convertToSnakeCase($this->additionalInfo);
            $data['other_data'] = $otherData;
        }

        if (!empty($this->products)) {
            $otherData['products'] = array_map([Helpers::class, 'convertToSnakeCase'], $this->products);
            $data['other_data'] = $otherData;
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
        // Map cardNumber to card_no
        if(isset($additionalInfo['cardNumber'])) {
            $additionalInfo['card_no'] = $additionalInfo['cardNumber'];
            unset($additionalInfo['cardNumber']);
        }

        // Map upiAddress to customer_vpa
        if(isset($additionalInfo['upiAddress'])) {
            $additionalInfo['customer_vpa'] = $additionalInfo['upiAddress'];
            unset($additionalInfo['upiAddress']);
        }

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
