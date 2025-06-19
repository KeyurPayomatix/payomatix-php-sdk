<?php

require __DIR__ . '/../vendor/autoload.php';

use PayomatixSDK\PayomatixClient;
use PayomatixSDK\Requests\TransactionStatusRequest;

/**
 * Initialize the Payomatix client
 * @param  string  $secretKey  Your Payomatix API secret key (found in Portal > API Keys)
 */
$client = new PayomatixClient(
    'PAY308H8MLNVI7SQXGJUT1725355473.K87G29SECKEY',
    'http://localhost:8000' // Base URL
);

/**
 * Create a new hosted payment request instance
 */
$transactionData = new TransactionStatusRequest();

/**
 * Required: Transaction Order ID
 */
$transactionData->orderId = 'f8VQOcjr-A7xR-7Shz-1740667143iq';

// Send the transaction request
$response = $client->transactionStatus->check($transactionData);


print_r($response);
exit;
