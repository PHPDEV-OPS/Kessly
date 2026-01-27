<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PesapalService
{
    protected $consumerKey;
    protected $consumerSecret;
    protected $baseUrl;

    public function __construct()
    {
        $this->consumerKey = config('services.pesapal.consumer_key');
        $this->consumerSecret = config('services.pesapal.consumer_secret');
        $this->baseUrl = config('services.pesapal.base_url', 'https://sandbox.pesapal.com');
    }

    public function getAccessToken()
    {
        $url = rtrim($this->baseUrl, '/') . '/v3/api/Auth/RequestToken';
        $response = Http::withBasicAuth($this->consumerKey, $this->consumerSecret)
            ->post($url);
        \Log::info('Pesapal getAccessToken response', ['body' => $response->body(), 'status' => $response->status()]);
        if ($response->successful()) {
            return $response->json('token');
        }
        return null;
    }

    public function initiatePayment($amount, $reference, $desc, $callback = null)
    {
        $token = $this->getAccessToken();
        if (!$token) {
            \Log::error('Pesapal initiatePayment: No access token');
            return null;
        }

        $callbackUrl = $callback ?? config('services.pesapal.callback_url');
        $payload = [
            'id' => $reference,
            'currency' => 'KES',
            'amount' => $amount,
            'description' => $desc,
            'callback_url' => $callbackUrl,
        ];

        $url = rtrim($this->baseUrl, '/') . '/v3/api/Transactions/SubmitOrderRequest';
        $response = \Illuminate\Support\Facades\Http::withToken($token)
            ->post($url, $payload);
        \Log::info('Pesapal initiatePayment response', ['body' => $response->body(), 'status' => $response->status(), 'payload' => $payload]);

        if ($response->successful() && isset($response['redirect_url'])) {
            return $response['redirect_url'];
        }
        return null;
    }
}
