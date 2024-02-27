<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/payment', 'App\Http\Controllers\PaypalController@showPaymentForm')->name('payment.form');
Route::post('/process-payment', 'App\Http\Controllers\PaypalController@processPayment')->name('process.payment');
Route::get('/payment_success', 'App\Http\Controllers\PaypalController@PaymentSuccess')->name('payment.success');
Route::get('/payment_callback', 'App\Http\Controllers\PaypalController@PaymentCallback')->name('payment.callback');
Route::get('/payment_failed', 'App\Http\Controllers\PaypalController@PaymentFailed')->name('payment.failed');
