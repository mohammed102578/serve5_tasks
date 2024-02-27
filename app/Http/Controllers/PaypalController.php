<?php

namespace App\Http\Controllers;

use App\Repository\PaypalRepository;
use Illuminate\Http\Request;

class PaypalController extends Controller
{
   public $paypal;
   public function __construct(PaypalRepository $paypal)
   {

      $this->paypal = $paypal;
   }
   public function showPaymentForm()
   {

      return $this->paypal->showPaymentForm();
   }
   public function processPayment(Request $request)
   {
      return $this->paypal->processPayment($request);
   }

   public function PaymentCallback(Request $request)
   {
      return $this->paypal->PaymentCallback($request);
   }


   public function PaymentSuccess()
   {
      return $this->paypal->paymentSuccess();
   }

   public function PaymentFailed()
   {
      return $this->paypal->paymentFailed();
   }
}
