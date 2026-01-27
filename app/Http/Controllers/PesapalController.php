<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PesapalService;
use Illuminate\Support\Str;

class PesapalController extends Controller
{
    public function pay(Request $request, PesapalService $pesapal)
    {
        $amount = $request->input('amount');
        $reference = Str::uuid();
        $desc = 'POS Payment';
        $callback = route('pesapal.callback');

        \Log::info('Pesapal payment attempt', [
            'amount' => $amount,
            'reference' => $reference,
            'desc' => $desc,
            'callback' => $callback,
        ]);

        $paymentUrl = $pesapal->initiatePayment($amount, $reference, $desc, $callback);
        \Log::info('Pesapal paymentUrl', ['paymentUrl' => $paymentUrl]);
        if ($paymentUrl) {
            return redirect($paymentUrl);
        }
        return back()->with('error', 'Failed to initiate payment.');
    }

    public function callback(Request $request, PesapalService $pesapal)
    {
        $orderTrackingId = $request->query('orderTrackingId');
        $status = null;
        if ($orderTrackingId) {
            $status = $pesapal->getPaymentStatus($orderTrackingId);
        }
        return view('sales.payment-complete', [
            'status' => $status,
        ]);
    }
}
