<?php

namespace App\Interface;


interface PaypalInterface
{
   public function showPaymentForm();

   public function processPayment($request);

   public function PaymentCallback($request);
   public function PaymentSuccess();

   public function PaymentFailed();
}
