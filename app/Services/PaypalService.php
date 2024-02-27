<?php

namespace App\Services;


use Srmklive\PayPal\Services\PayPal as PayPalClient;


class PaypalService
{

    public function paybalPayment($amount)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('payment.callback'),
                "cancel_url" => route('payment.failed'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $amount
                    ]
                ]
            ]

        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return $link['href'];
                }
            }
        } else {
            return redirect()->route('payment.failed');
        }
    }
}
