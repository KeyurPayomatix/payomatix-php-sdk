<?php

namespace PayomatixSDK\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class HttpService
{
    protected Client $client;
    protected string $secretKey;
    protected string $baseUrl;

    public function __construct(string $secretKey, ?string $baseUrl = null)
    {
        $this->secretKey = $secretKey;

        $config = require(__DIR__ . '/../config/payomatix.php');
        $this->baseUrl = rtrim($baseUrl ?? $config['base_url'], '/');

        $this->client = new Client([
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => $this->secretKey,
                'Content-Type'  => 'application/json',
            ],
        ]);
    }

    public function post(string $endpointPath, array $payload, array $headers = []): array
    {
        $url = $this->baseUrl . $endpointPath;

        try {
            $response = $this->client->post($url, [
                'json'    => $payload,
                'headers' => $headers,
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (!is_array($data)) {
                throw new \Exception('Invalid JSON response');
            }

            return $data;

        } catch (GuzzleException $e) {
            throw new \Exception('HTTP Request failed: ' . $e->getMessage());
        }
    }
}
