<?php

namespace App\Services;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\File;
use Katorymnd\PesapalPhpSdk\Api\PesapalClient;
use Katorymnd\PesapalPhpSdk\Config\PesapalConfig;
use Katorymnd\PesapalPhpSdk\Exceptions\PesapalException;

class PesapalService
{
    private PesapalClient $client;
    private PesapalConfig $config;
    private string $environment;
    private bool $sslVerify;
    private string $callbackUrl;
    private string $ipnUrl;
    private string $currency;
    private string $baseApiUrl;

    public function __construct()
    {
        $consumerKey = (string) config('services.pesapal.consumer_key');
        $consumerSecret = (string) config('services.pesapal.consumer_secret');
        $dynamicPath = (string) config('services.pesapal.dynamic_config_path', storage_path('app/pesapal_dynamic.json'));

        $dynamicDir = dirname($dynamicPath);
        if (!File::exists($dynamicDir)) {
            File::makeDirectory($dynamicDir, 0755, true);
        }
        if (!File::exists($dynamicPath)) {
            File::put($dynamicPath, json_encode(new \stdClass()));
        }

        $this->environment = strtolower((string) config('services.pesapal.environment', 'sandbox'));
        $this->sslVerify = (bool) config('services.pesapal.ssl_verify', false);
        $this->callbackUrl = (string) (config('services.pesapal.callback_url') ?? url('/pesapal/callback'));
        $this->ipnUrl = (string) (config('services.pesapal.ipn_url') ?? $this->callbackUrl);
        $this->currency = (string) config('services.pesapal.currency', 'KES');

        $this->config = new PesapalConfig($consumerKey, $consumerSecret, $dynamicPath);
        $this->client = new PesapalClient($this->config, $this->environment, $this->sslVerify);
        $this->baseApiUrl = rtrim((string) $this->config->getApiUrl($this->environment), '/');
    }

    public function initiatePayment(
        float $amount,
        string $reference,
        string $desc,
        ?string $callback = null,
        array $billing = []
    ): ?string {
        try {
            $this->ensureFreshToken();
            $notificationId = $this->ensureIpnId();

            if (!$notificationId) {
                \Log::error('Pesapal initiatePayment: missing notification id');
                return null;
            }

            $payload = [
                'id' => $reference,
                'currency' => $this->currency,
                'amount' => round($amount, 2),
                'description' => $desc,
                'callback_url' => $callback ?? $this->callbackUrl,
                'notification_id' => $notificationId,
                'billing_address' => $this->buildBillingAddress($billing),
            ];

            $response = $this->client->submitOrderRequest($payload);

            \Log::info('Pesapal submitOrderRequest response', $response);

            $redirect = $response['response']['redirect_url'] ?? null;

            if (($response['status'] ?? 0) === 200 && $redirect) {
                return $redirect;
            }

            \Log::error('Pesapal initiatePayment failed', ['response' => $response]);
        } catch (PesapalException $e) {
            \Log::error('Pesapal initiatePayment error', [
                'message' => $e->getMessage(),
                'details' => $e->getErrorDetails(),
            ]);
        } catch (\Throwable $e) {
            \Log::error('Pesapal initiatePayment unexpected error', ['message' => $e->getMessage()]);
        }

        return null;
    }

    public function getPaymentStatus(string $orderTrackingId): ?array
    {
        try {
            $this->ensureFreshToken();
            $response = $this->client->getTransactionStatus($orderTrackingId);

            return $response['response'] ?? null;
        } catch (PesapalException $e) {
            \Log::error('Pesapal getPaymentStatus error', [
                'message' => $e->getMessage(),
                'details' => $e->getErrorDetails(),
            ]);
        } catch (\Throwable $e) {
            \Log::error('Pesapal getPaymentStatus unexpected error', ['message' => $e->getMessage()]);
        }

        return null;
    }

    public function getPaymentStatusByMerchantReference(string $merchantReference): ?array
    {
        try {
            $token = $this->ensureFreshToken();
            $client = new GuzzleClient();

            $url = $this->baseApiUrl . '/Transactions/GetTransactionStatus';
            $response = $client->request('GET', $url, [
                'query' => ['orderMerchantReference' => $merchantReference],
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                ],
                'verify' => $this->sslVerify,
                'http_errors' => false,
            ]);

            $payload = json_decode((string) $response->getBody(), true) ?? [];

            if ($response->getStatusCode() === 200) {
                return $payload;
            }

            \Log::error('Pesapal getPaymentStatusByMerchantReference failed', [
                'status' => $response->getStatusCode(),
                'payload' => $payload,
            ]);
        } catch (RequestException $e) {
            \Log::error('Pesapal getPaymentStatusByMerchantReference network error', ['message' => $e->getMessage()]);
        } catch (\Throwable $e) {
            \Log::error('Pesapal getPaymentStatusByMerchantReference unexpected error', ['message' => $e->getMessage()]);
        }

        return null;
    }

    private function ensureFreshToken(): string
    {
        if ($this->config->getTokenEnvironment() !== $this->environment) {
            $this->config->clearAccessToken();
        }

        return $this->client->getAccessToken(true);
    }

    private function ensureIpnId(): ?string
    {
        $ipnUrl = $this->ipnUrl ?: $this->callbackUrl;
        $ipnDetails = $this->config->getIpnDetails();
        $notificationId = $ipnDetails['notification_id'] ?? null;
        $needsUpdate = !$notificationId || ($ipnDetails['ipn_url'] ?? '') !== $ipnUrl;

        if (!$needsUpdate) {
            try {
                $ipnList = $this->client->getRegisteredIpns();
                $validIds = array_column($ipnList['response'] ?? [], 'ipn_id');
                $needsUpdate = !in_array($notificationId, $validIds, true);
            } catch (PesapalException $e) {
                \Log::warning('Pesapal ensureIpnId: unable to verify ipn list', [
                    'message' => $e->getMessage(),
                    'details' => $e->getErrorDetails(),
                ]);
                $needsUpdate = true;
            }
        }

        if ($needsUpdate) {
            try {
                $registration = $this->client->registerIpnUrl($ipnUrl, 'POST');
                $notificationId = $registration['response']['ipn_id'] ?? null;
            } catch (PesapalException $e) {
                \Log::error('Pesapal ensureIpnId: register failed', [
                    'message' => $e->getMessage(),
                    'details' => $e->getErrorDetails(),
                ]);
                return null;
            }
        }

        return $notificationId;
    }

    private function buildBillingAddress(array $billing): array
    {
        $name = $billing['name'] ?? null;
        $first = $billing['first_name'] ?? null;
        $last = $billing['last_name'] ?? null;

        if (!$first && $name) {
            [$first, $last] = $this->splitName($name);
        }

        return [
            'email_address' => $billing['email_address'] ?? $billing['email'] ?? null,
            'phone_number' => $billing['phone_number'] ?? $billing['phone'] ?? null,
            'country_code' => $billing['country_code'] ?? 'KE',
            'first_name' => $first ?? 'Customer',
            'middle_name' => $billing['middle_name'] ?? null,
            'last_name' => $last ?? ($billing['last_name'] ?? 'Checkout'),
            'line_1' => $billing['line_1'] ?? null,
            'line_2' => $billing['line_2'] ?? null,
            'city' => $billing['city'] ?? null,
            'state' => $billing['state'] ?? null,
            'postal_code' => $billing['postal_code'] ?? null,
            'zip_code' => $billing['zip_code'] ?? null,
        ];
    }

    private function splitName(string $fullName): array
    {
        $parts = preg_split('/\s+/', trim($fullName));
        if (!$parts || count($parts) === 1) {
            return [$fullName, ''];
        }

        $first = array_shift($parts);
        $last = implode(' ', $parts);

        return [$first, $last];
    }
}
