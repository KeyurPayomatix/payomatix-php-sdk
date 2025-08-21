<?php

require __DIR__ . '/../vendor/autoload.php';

use PayomatixSDK\PayomatixClient;
use PayomatixSDK\Requests\TransactionStatusRequest;

/**
 * Initialize the Payomatix client
 * @param  string  $secretKey  Your Payomatix API secret key (found in Portal > API Keys)
 */
$client = new PayomatixClient(
    '<YOUR_PAYOMATIX_SECRET_KEY>' // Replace with your actual secret key
);

/**
 * Create a new transaction status request instance
 */
$transactionData = new TransactionStatusRequest();

/**
 * Required: Transaction Order ID
 */
$transactionData->orderId = '<YOUR_ORDER_ID>'; // Replace with the actual order ID you received after initiating the payment

// Send the transaction request using V2 API
$response = $client->transactionStatus->check($transactionData);

// For debugging purposes, you can print the response
echo "API Response:\n";
print_r($response); 