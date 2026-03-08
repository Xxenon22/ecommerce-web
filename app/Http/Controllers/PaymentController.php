<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionProduct;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function createTransaction(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
        Config::$curlOptions = array(
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER => [],
        );
        // Data transaksi
        $orderId = 'ORDER-' . time();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $request->amount, // nominal bayar
            ],
            'customer_details' => [
                'first_name' => $request->name,
                // 'email' => auth()->user()->email,
                'phone' => $request->phone,
                'address' => $request->address,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        // Dapatkan Snap Token dari Midtrans

        // $transaction = Transaction::create([
        //     'user_id' => auth()->user()->id, 
        //     'expedition_id' => NULL,
        //     'expedition_price' => 1,
        //     'total_price' => $request->amount,
        //     'status' => 'Belum di Bayar', 
        //     'payment_method_id' => NULL,
        // ]);

        // if($transaction){
        //     TransactionProduct::create([
        //         $transaction
        //     ]);
        // }

        return response()->json([
            'order_id' => $orderId,
            'snap_token' => $snapToken,
        ]);
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $signature = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($signature === $request->signature_key) {
            // Update status di database sesuai order_id
            // contoh: Transaction::where('order_id', $request->order_id)->update(['status' => $request->transaction_status]);

            return response()->json(['message' => 'Callback received']);
        }

        return response()->json(['message' => 'Invalid signature'], 403);
    }
}
