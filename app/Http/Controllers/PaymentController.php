<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
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
        // dd($request->all());
        $transaction = Transaction::create([
            'user_id' => $request->id,
            'expedition_id' => NULL,
            'restaurant_id' => 1,
            'expedition_price' => $request->ongkir,
            'total_price' => $request->amount,
            'status' => 'Belum di Bayar',
            'payment_method_id' => NULL,
        ]);

        if ($transaction) {
            foreach ($request->products as $i => $products) {
                $product = Product::find($products['product_id']);
                TransactionProduct::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'qty' => $products['quantity'],
                    'price' => $product->price
                ]);
                Cart::where('product_id', $product->id)
                    ->where('user_id', $request->id)
                    ->delete();
            }
        }

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
        $orderId = $transaction->id;
        // $orderId = 'ORDER-' . time();

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
        $transaction->update(['snap_token' => $snapToken]);
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
        \Log::info('Midtrans Callback:', $request->all());
        $serverKey = config('midtrans.server_key');

        // Validasi signature
        $signature = hash(
            'sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($signature !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $transaction = Transaction::where('id', $request->order_id)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // Mapping status Midtrans → status aplikasi
        $transactionStatus = $request->transaction_status;
        $fraudStatus = $request->fraud_status;

        if ($transactionStatus == 'capture') {
            $status = $fraudStatus == 'accept' ? 'Sudah di Bayar' : 'Ditolak';
        } elseif ($transactionStatus == 'settlement') {
            $status = 'Sudah di Bayar';
        } elseif ($transactionStatus == 'pending') {
            $status = 'Belum di Bayar';
        } elseif ($transactionStatus == 'deny') {
            $status = 'Ditolak';
        } elseif ($transactionStatus == 'expire') {
            $status = 'Belum di Bayar';
        } elseif ($transactionStatus == 'cancel') {
            $status = 'Dibatalkan';
        } else {
            $status = $transactionStatus; // fallback
        }

        $transaction->update([
            'status' => $status,
            // 'payment_method' => $request->payment_type ?? null,
        ]);

        return response()->json(['message' => 'Callback received']);
    }
    public function getSnapToken($id)
    {
        $transaction = Transaction::with('transactionProducts.product')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Jika sudah punya token, langsung return
        if ($transaction->snap_token) {
            return response()->json(['snap_token' => $transaction->snap_token]);
        }

        // Buat token baru
        $params = [
            'transaction_details' => [
                'order_id' => $transaction->id,
                'gross_amount' => $transaction->total_price,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        $transaction->update(['snap_token' => $snapToken]);

        return response()->json(['snap_token' => $snapToken]);
    }
    public function cancelOrder($id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Pastikan hanya bisa cancel jika belum dibayar
        if ($transaction->status !== 'Belum di Bayar') {
            return response()->json(['message' => 'Order tidak bisa dibatalkan'], 403);
        }

        $transaction->update(['status' => 'Dibatalkan']);

        return response()->json(['message' => 'Order berhasil dibatalkan']);
    }
}
