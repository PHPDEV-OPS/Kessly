<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PesapalService;
use Illuminate\Support\Str;

class PesapalController extends Controller
{
    public function pay(Request $request, PesapalService $pesapal)
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
            'customer_name' => ['nullable', 'string', 'max:120'],
            'customer_email' => ['nullable', 'email', 'max:120'],
            'customer_phone' => ['nullable', 'string', 'max:25'],
        ]);

        $amount = (float) $validated['amount'];
        $reference = (string) Str::uuid();
        $desc = 'POS Payment ' . $reference;
        $callback = route('pesapal.callback');

        $billing = [
            'name' => $validated['customer_name'] ?? null,
            'email_address' => $validated['customer_email'] ?? null,
            'phone_number' => $validated['customer_phone'] ?? null,
        ];

        \Log::info('Pesapal payment attempt', [
            'amount' => $amount,
            'reference' => $reference,
            'desc' => $desc,
            'callback' => $callback,
            'billing' => $billing,
        ]);

        $paymentUrl = $pesapal->initiatePayment($amount, $reference, $desc, $callback, $billing);
        \Log::info('Pesapal paymentUrl', ['paymentUrl' => $paymentUrl]);

        if ($paymentUrl) {
            return redirect()->away($paymentUrl);
        }

        return back()->with('error', 'Failed to initiate payment.');
    }

    public function callback(Request $request, PesapalService $pesapal)
    {
        $orderTrackingId = $request->query('orderTrackingId')
            ?? $request->query('OrderTrackingId');
        $merchantReference = $request->query('merchantReference')
            ?? $request->query('orderMerchantReference')
            ?? $request->query('OrderMerchantReference');

        \Log::info('Pesapal callback received', [
            'orderTrackingId' => $orderTrackingId,
            'merchantReference' => $merchantReference,
            'payload' => $request->all(),
            'method' => $request->getMethod(),
        ]);

        $statusPayload = null;

        if ($orderTrackingId) {
            $statusPayload = $pesapal->getPaymentStatus($orderTrackingId);
        } elseif ($merchantReference) {
            $statusPayload = $pesapal->getPaymentStatusByMerchantReference($merchantReference);
        }

        $statusCode = is_array($statusPayload) ? ($statusPayload['status_code'] ?? null) : null;
        $statusMap = [0 => 'INVALID', 1 => 'COMPLETED', 2 => 'FAILED', 3 => 'REVERSED'];
        $status = is_array($statusPayload)
            ? ($statusPayload['payment_status_description']
                ?? $statusPayload['status']
                ?? ($statusCode !== null ? ($statusMap[$statusCode] ?? null) : null))
            : null;

        return view('sales.payment-complete', [
            'status' => $status,
            'details' => $statusPayload,
        ]);
    }
}
