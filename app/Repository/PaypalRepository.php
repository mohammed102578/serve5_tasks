<?php

namespace App\Repository;

use App\Interface\PaypalInterface;
use App\Services\PaypalService;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalRepository implements PaypalInterface
{
    public function showPaymentForm()
    {
        return view("paypal");
    }

    public function processPayment($request)
    {
        try {
            $paypalService = new PaypalService();
            $linkPaypal =  $paypalService->paybalPayment($request->amount);
            return [
                'status' => 'Success',
                'message' => 'link_paypal',
                'data' => ['paypal_link' => $linkPaypal],
            ];
        } catch (\Exception $e) {
            // Log or handle the exception
            return [
                'status' => 'Error',
                'message' => 'Failed to process payment',
                'error' => $e->getMessage(),
            ];
        }
    }

    public function PaymentCallback($request)
    {
        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();
            $response = $provider->capturePaymentOrder($request->token);

            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                return redirect()->route('payment.success');
            } else {
                return redirect()->route('payment.failed');
            }
        } catch (\Exception $e) {
            // Log or handle the exception
            return $e->getMessage();
        }
    }

    public function PaymentSuccess()
    {
        return view("paypal_success");
    }

    public function PaymentFailed()
    {
        return view("paypal_failed");
    }
}
