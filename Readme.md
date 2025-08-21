# Payomatix PHP SDK

A comprehensive PHP SDK for integrating Payomatix payment gateway services into your applications. This SDK provides easy-to-use interfaces for hosted payments, seamless payments, and transaction status checking.

## Requirements

- PHP 7.4 or higher
- Composer
- Guzzle HTTP Client (automatically installed via Composer)

## Installation

Install the SDK via Composer:

```bash
composer require payomatix-sdk/payomatix-php-sdk
```

## Quick Start

### 1. Initialize the Client

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use PayomatixSDK\PayomatixClient;

// Initialize with your secret key
$client = new PayomatixClient('YOUR-PAYOMATIX-SECRET-KEY');
```

### 2. Available Services

The SDK provides three main services:

- **Hosted Transactions**: Redirect customers to Payomatix's hosted payment page
- **Seamless Transactions**: Process payments directly through your application
- **Transaction Status**: Check the status of existing transactions

## API Reference

### PayomatixClient

The main client class that provides access to all payment services.

```php
$client = new PayomatixClient(string $secretKey, ?string $baseUrl = null);
```

**Parameters:**
- `$secretKey` (string, required): Your Payomatix API secret key from the merchant portal
- `$baseUrl` (string, optional): Custom API base URL (uses default if not provided)

**Available Services:**
- `$client->hostedTransactions` - Hosted payment processing
- `$client->seamlessTransactions` - Seamless payment processing
- `$client->transactionStatus` - Transaction status checking

---

## 1. Hosted Payment Integration

Hosted payments redirect customers to Payomatix's secure payment page where they can complete their transaction.

### Basic Example

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use PayomatixSDK\PayomatixClient;
use PayomatixSDK\Requests\HostedPaymentRequest;

// Initialize client
$client = new PayomatixClient('YOUR-PAYOMATIX-SECRET-KEY');

// Create payment request
$transactionData = new HostedPaymentRequest();

// Required fields
$transactionData->email = 'customer@example.com';
$transactionData->amount = 100.00;
$transactionData->merchantReturnUrl = 'https://your-domain.com/success';
$transactionData->webhookCallbackUrl = 'https://your-domain.com/webhook';

// Optional: Set currency (default: INR)
$transactionData->currency = 'USD';

// Process the payment
$response = $client->hostedTransactions->process($transactionData);

// Redirect to payment page
if (isset($response['status']) && $response['status'] === 'redirect' && isset($response['redirect_url'])) {
    header('Location: ' . $response['redirect_url']);
    exit;
}
```

### Advanced Example with Additional Features

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use PayomatixSDK\PayomatixClient;
use PayomatixSDK\Requests\HostedPaymentRequest;

$client = new PayomatixClient('YOUR-PAYOMATIX-SECRET-KEY');

$transactionData = new HostedPaymentRequest();

// Basic required fields
$transactionData->email = 'customer@example.com';
$transactionData->amount = 150.00;
$transactionData->currency = 'USD';
$transactionData->merchantReturnUrl = 'https://your-domain.com/success';
$transactionData->webhookCallbackUrl = 'https://your-domain.com/webhook';

// Set customer information (optional)
$transactionData->setAdditionalInfo([
    'firstName' => 'John',
    'lastName'  => 'Doe',
    'address'   => '123 Main Street',
    'state'     => 'NY',
    'city'      => 'New York',
    'zip'       => '10001',
    'country'   => 'US',
    'phoneNo'   => '9876543210'
]);

// Set product details (optional)
$transactionData->setProducts([
    [
        'name'     => 'Premium Headphones',
        'quantity' => '1',
        'price'    => '100.00',
        'imageUrl' => 'https://yourstore.com/images/headphones.jpg'
    ],
    [
        'name'     => 'Wireless Mouse',
        'quantity' => '1',
        'price'    => '50.00',
        'imageUrl' => 'https://yourstore.com/images/mouse.jpg'
    ]
]);

$response = $client->hostedTransactions->process($transactionData);

if (isset($response['status']) && $response['status'] === 'redirect' && isset($response['redirect_url'])) {
    header('Location: ' . $response['redirect_url']);
    exit;
}
```

### HostedPaymentRequest Properties

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| `email` | string | Yes | Customer's email address |
| `amount` | float | Yes | Transaction amount |
| `currency` | string | No | Currency code (default: INR) |
| `merchantReturnUrl` | string | Yes | URL to redirect after payment |
| `webhookCallbackUrl` | string | Yes | URL for webhook notifications |

### Additional Features

#### Customer Information
Use `setAdditionalInfo()` to pre-fill customer details:

```php
$transactionData->setAdditionalInfo([
    'firstName' => 'John',
    'lastName'  => 'Doe',
    'address'   => '123 Main Street',
    'state'     => 'NY',
    'city'      => 'New York',
    'zip'       => '10001',
    'country'   => 'US',
    'phoneNo'   => '9876543210'
]);
```

#### Product Details
Use `setProducts()` to display products on the payment page:

```php
$transactionData->setProducts([
    [
        'name'     => 'Product Name',
        'quantity' => '1',
        'price'    => '100.00',
        'imageUrl' => 'https://example.com/image.jpg'
    ]
]);
```
---

## 2. Seamless Payment Integration

Seamless payments allow you to process payments directly through your application without redirecting customers to an external payment page.

### Basic Example

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use PayomatixSDK\PayomatixClient;
use PayomatixSDK\Requests\SeamlessPaymentRequest;

$client = new PayomatixClient('YOUR-PAYOMATIX-SECRET-KEY');

$transactionData = new SeamlessPaymentRequest();

// Required fields
$transactionData->email = 'customer@example.com';
$transactionData->amount = 100.00;
$transactionData->paymentMethodType = 1; // Credit Card
$transactionData->merchantReturnUrl = 'https://your-domain.com/success';
$transactionData->webhookCallbackUrl = 'https://your-domain.com/webhook';

// Card details (required for card payments)
$transactionData->cardNumber = '4242424242424242';
$transactionData->cvvNumber = '123';
$transactionData->expiryMonth = '12';
$transactionData->expiryYear = '2025';

// Optional merchant reference
$transactionData->merchantRef = 'order-12345';

$response = $client->seamlessTransactions->process($transactionData);

print_r($response);
```

### UPI Payment Example

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use PayomatixSDK\PayomatixClient;
use PayomatixSDK\Requests\SeamlessPaymentRequest;

$client = new PayomatixClient('YOUR-PAYOMATIX-SECRET-KEY');

$transactionData = new SeamlessPaymentRequest();

// Basic fields
$transactionData->email = 'customer@example.com';
$transactionData->amount = 100.00;
$transactionData->paymentMethodType = 3; // UPI
$transactionData->merchantReturnUrl = 'https://your-domain.com/success';
$transactionData->webhookCallbackUrl = 'https://your-domain.com/webhook';

// UPI VPA (required for UPI payments)
$transactionData->upiAddress = 'customer@upi';

$response = $client->seamlessTransactions->process($transactionData);

print_r($response);
```

### SeamlessPaymentRequest Properties

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| `email` | string | Yes | Customer's email address |
| `amount` | float | Yes | Transaction amount |
| `currency` | string | No | Currency code (default: INR) |
| `paymentMethodType` | int | Yes | Payment method type (see table below) |
| `merchantReturnUrl` | string | Yes | URL to redirect after payment |
| `webhookCallbackUrl` | string | Yes | URL for webhook notifications |
| `cardNumber` | string | Conditional | Card number (required for card payments) |
| `cvvNumber` | string | Conditional | CVV (required for card payments) |
| `expiryMonth` | string | Conditional | Expiry month (required for card payments) |
| `expiryYear` | string | Conditional | Expiry year (required for card payments) |
| `upiAddress` | string | Conditional | UPI VPA (required for UPI payments) |
| `merchantRef` | string | No | Merchant reference for tracking |

### Payment Method Types

| Value | Payment Method |
|-------|----------------|
| 1 | Credit Card |
| 2 | Debit Card |
| 3 | UPI |
| 4 | Wallet |
| 5 | Net Banking |
| 8 | Buy Now Pay Later |
| 9 | EMI |
| 10 | E-Challan |

### Additional Customer Information

```php
$transactionData->setAdditionalInfo([
    'firstName' => 'John',
    'lastName'  => 'Doe',
    'address'   => '123 Main Street',
    'state'     => 'NY',
    'city'      => 'New York',
    'zip'       => '10001',
    'country'   => 'US',
    'phoneNo'   => '9876543210'
]);
```

---

## 3. Transaction Status Checking

Check the status of a transaction using its order ID.

### Example

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use PayomatixSDK\PayomatixClient;
use PayomatixSDK\Requests\TransactionStatusRequest;

$client = new PayomatixClient('YOUR-PAYOMATIX-SECRET-KEY');

$transactionData = new TransactionStatusRequest();
$transactionData->orderId = 'YOUR-ORDER-ID';

$response = $client->transactionStatus->check($transactionData);

print_r($response);
```

### TransactionStatusRequest Properties

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| `orderId` | string | Yes | Transaction order ID |

---

## Response Handling

### Success Response (Hosted Payment)

```php
[
    "responseCode": 300,
    "response": "Transaction in authorization process.",
    "status": "redirect",
    "redirect_url": "https://stageadmin.payomatix.com/cashfree/otp/G4241752479185/BSL91752479186/5114919199626/350",
    "data": {
        "order_id": "YZucYQJy-dQzG-xaFL-1752479185jT",
        "merchant_ref": "wer345t-fc2e-4a43-a900-1872d9c00890",
        "email": "test@jondoe.com",
        "amount": "30.00",
        "currency": "USD",
        "test_mode": 0,
        "transaction_type": "Credit Card",
        "integration_type": "Seamless",
        "return_url": "http://localhost:8000/redirect/"
    }
]
```
### Error Response

```php
[
    "responseCode": 400,
    "response": "Transaction authentication failed from bank side.",
    "status": "declined",
    "data": {
        "order_id": "lIu3MdI0-JHOq-9yQi-1752478679Qu",
        "merchant_ref": "wer345t-fc2e-4a43-a900-1872d9c00890",
        "email": "test@jondoe.com",
        "amount": "30.00",
        "currency": "USD",
        "test_mode": 0,
        "transaction_type": "Credit Card",
        "integration_type": "Non - Seamless",
        "return_url": "http://localhost:8000/redirect/"
    }
]
```

---

## Webhook Handling

Your webhook endpoint will receive POST requests with transaction data. Here's an example of how to handle webhooks:

```php
<?php

// webhook.php
$webhookData = json_decode(file_get_contents('php://input'), true);

// Verify the webhook signature (recommended)
// $signature = $_SERVER['HTTP_X_PAYOMATIX_SIGNATURE'] ?? '';
// verifyWebhookSignature($webhookData, $signature);

// Process the webhook data
$orderId = $webhookData['order_id'] ?? '';
$status = $webhookData['status'] ?? '';
$amount = $webhookData['amount'] ?? '';

switch ($status) {
    case 'success':
        // Payment successful
        // Update your database, send confirmation email, etc.
        break;
    case 'failed':
        // Payment failed
        // Handle failure, notify customer, etc.
        break;
    case 'pending':
        // Payment pending
        // Handle pending status
        break;
}

http_response_code(200);
echo 'OK';
```

---

## Error Handling

Always implement proper error handling in your application:

```php
try {
    $response = $client->hostedTransactions->process($transactionData);
    
    if (isset($response['status'])) {
        switch ($response['status']) {
            case 'redirect':
                header('Location: ' . $response['redirect_url']);
                exit;
            case 'success':
                // Handle success
                break;
            case 'error':
                // Handle error
                $errorMessage = $response['message'] ?? 'Unknown error';
                throw new Exception($errorMessage);
        }
    }
} catch (Exception $e) {
    // Log error and handle gracefully
    error_log('Payment error: ' . $e->getMessage());
    // Show user-friendly error message
}
```

---

## Configuration

### Environment Setup

The SDK uses a configuration file located at `src/Config/Payomatix.php`. You can override the base URL when initializing the client:

```php
$client = new PayomatixClient(
    'YOUR-SECRET-KEY',
    'https://api-staging.payomatix.com' // Custom base URL
);
```

### Testing

Use the provided test examples in the `tests/` directory:

- `tests/hosted-example.php` - Hosted payment example
- `tests/seamless-example.php` - Seamless payment example
- `tests/transaction-status-example.php` - Transaction status example

---

## Notes
- Replace API keys and URLs with your actual credentials.

- The customer and product details are optional but recommended for a seamless checkout experience.

- Use the `merchantReturnUrl` and `webhookCallbackUrl` to handle payment success/failure and webhook notifications.

- Ensure you handle the response correctly, especially for error handling and logging.

- Always validate all responses from the API before further processing.

- `overridePaymentCategory` is optional and can be used to override rules, transaction limit, routing and cascading for transaction (e.g., "Ecommerce", "Rent", etc.).

- `showPaymentMethod` is optional and can be used to show specific payment methods on the hosted payment page (e.g., "Card", "UPI", etc.).

<hr>

## Best Practices

1. **Always validate responses** before processing further
2. **Implement proper error handling** for all API calls
3. **Use HTTPS** for all webhook and return URLs
4. **Store transaction IDs** for reconciliation
5. **Implement webhook signature verification** for security
6. **Test thoroughly** in staging environment before going live
7. **Log all transactions** for debugging and audit purposes

---

## Support

For technical support and questions:

- Check the test examples in the `tests/` directory
- Review the source code in the `src/` directory
- Contact Payomatix support for API-related issues

---

## License

This SDK is provided by Payomatix for integration with their payment gateway services. Use responsibly and always validate all responses from the API before further processing.
