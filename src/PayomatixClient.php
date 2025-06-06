<?php

namespace PayomatixSDK;

use PayomatixSDK\Services\HttpService;
use PayomatixSDK\Services\HostedTransactionService;
use PayomatixSDK\Services\SeamlessTransactionService;
use PayomatixSDK\Services\TransactionStatusService;

/**
 * PayomatixClient
 *
 * This is the main SDK client used to interact with the Payomatix payment services.
 * Initialize this class with your secret API key and optional base URL.
 *
 * Example usage:
 * ```php
 * $client = new PayomatixClient('YOUR_SECRET_KEY', 'https://api.example.com');
 * $response = $client->hostedTransactions->process($transactionRequest);
 * ```
 *
 * @package PayomatixSDK
 */
class PayomatixClient
{
    /**
     * @var string Secret API key used for authentication
     */
    protected string $secretKey;

    /**
     * @var HttpService Handles HTTP communication with the API
     */
    protected HttpService $httpService;

    /**
     * @var HostedTransactionService Handles hosted payment operations
     */
    public HostedTransactionService $hostedTransactions;

    /**
     * @var SeamlessTransactionService Handles seamless (API-based) payments
     */
    public SeamlessTransactionService $seamlessTransactions;

    /**
     * @var TransactionStatusService Used to check payment status
     */
    public TransactionStatusService $transactionStatus;

    /**
     * @var string Base API URL used for requests (e.g., staging or production)
     */
    public string $baseUrl = '';

    /**
     * PayomatixClient constructor
     *
     * @param string      $secretKey Your Payomatix API secret key (get from portal)
     * @param string|null $baseUrl   Optional. If not provided, uses config default
     */
    public function __construct(string $secretKey, ?string $baseUrl = null)
    {
        $this->secretKey = $secretKey;

        $config = require __DIR__ . '/config/payomatix.php';
        $this->baseUrl = rtrim($baseUrl ?? $config['base_url'], '/');

        $this->httpService = new HttpService($secretKey, $this->baseUrl);
        $this->hostedTransactions = new HostedTransactionService($this->httpService);
        $this->seamlessTransactions = new SeamlessTransactionService($this->httpService);
        $this->transactionStatus = new TransactionStatusService($this->httpService);
    }
}
