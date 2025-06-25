# Payomatix PHP SDK Integration Guide

## Requirements

- PHP 7.4 or higher
- Composer
- Payomatix PHP SDK (installed via Composer)

## Installation

Install the SDK via Composer:

```bash
composer require payomatix/payomatix-sdk
```

<hr>

## 1. Payomatix Hosted Payment Integration (PHP Example)

This PHP example demonstrates how to integrate Payomatix's Hosted Payment Page using the official Payomatix SDK.


## Usage
1. Update and run the following PHP script to initiate a hosted payment transaction:
2. Run the script to initiate a hosted payment transaction.

```php
<?php

require __DIR__ . '/../vendor/autoload.php';

use PayomatixSDK\PayomatixClient;
use PayomatixSDK\Requests\HostedPaymentRequest;

/**
 * Initialize the Payomatix client
 * @param  string  $secretKey  Your Payomatix API secret key (found in Portal > API Keys)
 */
$client = new PayomatixClient(
    'YOUR-PAYOMATIX-SECRET-KEY' // Base URL
);

/**
 * Create a new hosted payment request instance
 */
$transactionData = new HostedPaymentRequest();

/**
 * @var string $email Customer email address
 *
 * Required: Customer's email address
 * Used for sending receipts or identifying the customer (e.g., test@example.com)
 */
$transactionData->email = 'test@example.com';

/**
 * @var float $amount Transaction amount
 *
 * Required: Total transaction amount without currency (e.g., 600)
 */
$transactionData->amount = 600;

/**
 * @var string $currency Transaction currency (default: INR)
 *
 * Optional: Transaction currency  (e.g., INR)
 * Default: INR
 */
// $transactionData->currency = "INR";

/**
 * @var string $merchantReturnUrl URL to redirect the customer after transaction
 *
 * Required: URL where the customer will be redirected after completing the payment
 * This URL will receive a GET request with transaction details as query parameters
 */
$transactionData->merchantReturnUrl = 'https://your-domain.com/return-url';

/**
 * @var string $webhookCallbackUrl URL to receive server-side webhook notification
 *
 * Required: URL that will receive server-to-server notifications about the transaction status
 * This URL will receive a POST request with transaction data in the request body
 */
$transactionData->webhookCallbackUrl = 'https://your-domain.com/webhook-url';

/**
 * @var string|null $overridePaymentCategory
 *
 * Optional. If set to one of the predefined values ('Rent', 'Vendor', 'Ecommerce', 'Education', 'Utility'),
 * this will override all default routing, cascading, and transaction limits, and force the transaction
 * to be processed using the specified payment gateway category.
 */
$transactionData->overridePaymentCategory = "Ecommerce";

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
// $transactionData->onlyShowPaymentMethod = 1;

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
// $transactionData->splitPaymentVendors = '{"vendor_label": 400,"vendor_label": 200}';


/**
 * @var array $additionalInfo
 *
 * Optional. Pre-fills the checkout form with customer information
 * (e.g., firstName, lastName, address, state, city, zip, country, phoneNo, cardNo, customerVpa, etc.) if provided.
 */
$transactionData->setAdditionalInfo([
    'firstName' => 'John', // Customer's first name
    'lastName'  => 'Doe', // Customer's last name
    'address'   => '456 Elm Street', // Full street address
    'state'     => 'NY', // State code (2-letter)
    'city'      => 'New York', // City name
    'zip'       => '100010', // Must be exactly 6 characters long
    'country'   => 'US', // Country code (2-letter)
    'phoneNo'   => '9876543210', // Must be 10 characters long without country code
    'cardNumber' => '4111111111111111', // For seamless integration: pre-fills the card number field for card payments
    'upiAddress' => 'dummy@upi' // For seamless integration: pre-fills the UPI VPA (Virtual Payment Address) for UPI payments
]);

/**
 * Optional. Contains a list of products to be displayed on the checkout page.
 * Each product includes the name, quantity, price, and an image URL.
 */
$transactionData->setProducts([
    [
        'name'     => 'Wireless Headphones',                // Product name
        'quantity' => '1',                                  // Quantity as string
        'price'    => '120.00',                             // Price per unit
        'imageUrl' => 'https://yourstore.com/images/headphones.jpg' // Product image URL
    ],
    [
        'name'     => 'Gaming Laptop',
        'quantity' => '1',
        'price'    => '1500.00',
        'imageUrl' => 'https://yourstore.com/images/laptop.jpg'
    ],
    [
        'name'     => 'Smartwatch',
        'quantity' => '2',
        'price'    => '75.50',
        'imageUrl' => 'https://yourstore.com/images/smartwatch.jpg'
    ]
]);

// Send the transaction request
$response = $client->hostedTransactions->process($transactionData);

// Redirect user to the checkout page
if (isset($response['status']) && $response['status'] === 'redirect' && isset($response['redirect_url'])) {
    header('Location: ' . $response['redirect_url']);
    exit;
}
```

## Notes
- Replace API keys and URLs with your actual credentials.

- The customer and product details are optional but recommended for a seamless checkout experience.

- Use the `merchantReturnUrl` and `webhookCallbackUrl` to handle payment success/failure and webhook notifications.

- Ensure you handle the response correctly, especially for error handling and logging.

- Always validate all responses from the API before further processing.

- `overridePaymentCategory` is optional and can be used to override rules, transaction limit, routing and cascading for transaction (e.g., "Ecommerce", "Rent", etc.).

- `showPaymentMethod` is optional and can be used to show specific payment methods on the hosted payment page (e.g., "Card", "UPI", etc.).


<hr>

## 2. Check Transaction Status

Check the current status of a transaction using the order ID returned after initiating a payment.


```php
<?php

require __DIR__ . '/../vendor/autoload.php';

use PayomatixSDK\PayomatixClient;
use PayomatixSDK\Requests\TransactionStatusRequest;

/**
 * Initialize the Payomatix client
 * @param  string  $secretKey  Your Payomatix API secret key (found in Portal > API Keys)
 */
$client = new PayomatixClient(
    'YOUR-PAYOMATIX-SECRET-KEY' // Replace with your actual secret key
);

/**
 * Create a new hosted payment request instance
 */
$transactionData = new TransactionStatusRequest();

/**
 * Required: Transaction Order ID
 */
$transactionData->orderId = 'YOUR-TRANSACTION-ORDER-ID'; // Replace with the actual order ID you received after initiating the payment

// Send the transaction request
$response = $client->transactionStatus->check($transactionData);


print_r($response);
exit;

```


## License
This code is for demo purposes only. Use it responsibly and always validate all responses from the API before further processing.
