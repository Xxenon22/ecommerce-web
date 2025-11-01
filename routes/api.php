<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::post('/midtrans/transaction', [PaymentController::class, 'createTransaction'])->name('mid.pay');
Route::post('/midtrans/callback', [PaymentController::class, 'callback']);