<?php

require __DIR__ . '/../vendor/autoload.php';

use PayomatixSDK\PayomatixClient;
use PayomatixSDK\Requests\SeamlessPaymentRequest;

/**
 * Initialize the Payomatix client
 * @param  string  $secretKey  Your Payomatix API secret key (found in Portal > API Keys)
 */
$client = new PayomatixClient(
    '<YOUR_PAYOMATIX_SECRET_KEY>' // Replace with your actual secret key
);

/**
 * Create a new seamless payment request instance
 */
$transactionData = new SeamlessPaymentRequest();

/**
 * @var string $email Customer email address
 *
 * Required: Customer's email address
 * Used for sending receipts or identifying the customer (e.g., test@jondoe.com)
 */
$transactionData->email = 'test@jondoe.com';

/**
 * @var float $amount Transaction amount
 *
 * Required: Total transaction amount without currency (e.g., 30.00)
 */
$transactionData->amount = 30.00;

/**
 * @var string $currency Transaction currency (default: INR)
 *
 * Optional: Transaction currency  (e.g., USD)
 * Default: INR
 */
$transactionData->currency = "USD";

/**
 * @var string $merchantReturnUrl URL to redirect the customer after transaction
 *
 * Required: URL where the customer will be redirected after completing the payment
 * This URL will receive a GET request with transaction details as query parameters
 */
$transactionData->merchantReturnUrl = '<YOUR_MERCHANT_RETURN_URL>';

/**
 * @var string $webhookCallbackUrl URL to receive server-side webhook notification
 *
 * Required: URL that will receive server-to-server notifications about the transaction status
 * This URL will receive a POST request with transaction data in the request body
 */
$transactionData->webhookCallbackUrl = '<YOUR_WEBHOOK_CALLBACK_URL>';

/**
 * @var int $paymentMethodType Payment method type
 *
 * Required: Defines the payment method type for the transaction
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
$transactionData->paymentMethodType = 1; // Credit Card

/**
 * @var string|null $upiAddress UPI VPA for UPI payments
 *
 * Required for UPI payments (paymentMethod: 3)
 * Must be a valid UPI VPA (e.g., john@upi)
 */
// $transactionData->upiAddress = 'success@upi';

/**
 * @var string|null $cardNumber Card number for card payments
 *
 * Required for card payments (paymentMethod: 1 or 2)
 * Must be a valid card number (e.g., 4706131211212123)
 */
$transactionData->cardNumber = '4242424242424242';

/**
 * @var string|null $cvvNumber CVV number for card payments
 *
 * Required for card payments (paymentMethod: 1 or 2)
 * Must be a valid CVV (e.g., 123)
 */
$transactionData->cvvNumber = '123';

/**
 * @var string|null $expiryMonth Card expiry month
 *
 * Required for card payments (paymentMethod: 1 or 2)
 * Must be a valid month (e.g., 03)
 */
$transactionData->expiryMonth = '03';

/**
 * @var string|null $expiryYear Card expiry year
 *
 * Required for card payments (paymentMethod: 1 or 2)
 * Must be a valid year (e.g., 2028)
 */
$transactionData->expiryYear = '2028';

/**
 * @var string|null $merchantRef Merchant reference for the transaction
 *
 * Unique: Merchant reference for tracking the transaction
 */
$transactionData->merchantRef = 'wer345t-fc2e-4a43-a900-1872d9c00890';

/**
 * @var string|null $overridePaymentCategory
 *
 * Optional. If set to one of the predefined values ('Rent', 'Vendor', 'Ecommerce', 'Education', 'Utility'),
 * this will override all default routing, cascading, and transaction limits, and force the transaction
 * to be processed using the specified payment gateway category.
 */
// $transactionData->overridePaymentCategory = "Ecommerce";

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
 * (e.g., firstName, lastName, address, state, city, zip, country, phoneNo, etc.) if provided.
 */
$transactionData->setAdditionalInfo([
    'firstName' => 'firstName', // Customer's first name
    'lastName'  => 'lastName', // Customer's last name
    'address'   => 'your-address', // Full street address
    'state'     => 'your-state', // State code (2-letter)
    'city'      => 'your-city', // City name
    'zip'       => '110001', // Must be exactly 6 characters long
    'country'   => 'IN', // Country code (2-letter)
    'phoneNo'   => '9876543210', // Must be 10 characters long without country code
]);



// Send the transaction request using V2 API
$response = $client->seamlessTransactions->process($transactionData);

// Redirect user to the checkout page
// if (isset($response['status']) && ($response['status'] === 'redirect' || $response['status'] === 2) && isset($response['redirect_url'])) {
//     header('Location: ' . $response['redirect_url']);
//     exit;
// }

// For debugging purposes, you can print the response
echo "API Response:\n";
print_r($response); 