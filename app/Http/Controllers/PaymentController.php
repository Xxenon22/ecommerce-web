<?php

namespace App\Http\Controllers;

use App\Service\BiteshipService;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionProduct;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function createTransaction(Request $request, BiteshipService $biteship)
    {
        // dd($request->all());
        $transaction = Transaction::create([
            'user_id' => $request->id,
            'expedition_id' => NULL,
            'address_id' => $request->address_id,
            'restaurant_id' => 1,
            'expedition_price' => $request->ongkir,
            'total_price' => $request->amount,
            'status' => 'Belum di Bayar',
            'payment_method_id' => NULL,
        ]);

        if ($transaction) {
            $items = [];
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
                $items[] = [
                    'name' => $product->name, // pastikan sesuai field di tabel product
                    'value' => $product->price,
                    'quantity' => $products['quantity'],
                    'weight' => $product->weight ?? 1000, // default kalau tidak ada
                ];
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
        $orderId = $transaction->transaction_code;
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
        if ($snapToken) {
            $data = [
                'origin_contact_name' => 'Gudang Utama',
                'origin_contact_phone' => '08123456789',
                'origin_address' => 'Jl. Contoh No. 1 Jakarta',
                'origin_coordinate' => [
                    'latitude' => -6.200000,
                    'longitude' => 106.816666,
                ],
                'destination_contact_name' => $transaction->address->recipient_name,
                'destination_contact_phone' => $transaction->address->phone,
                'destination_address' => $transaction->address->address_detail,
                'destination_postal_code' => $transaction->address->postal_code,
                'destination_coordinate' => [
                    'latitude' => $transaction->address->latitude,
                    'longitude' => $transaction->address->longitude,
                ],
                'courier_company' => $request->courier,
                'courier_type' => $request->courier_name,
                'delivery_type' => 'now',
                'items' => $items
            ];
            $response = $biteship->createOrder($data);
            Log::info('Biteship Order Response', $response);

            $orderId = $response['id'] ?? null;
            if ($orderId) {
                $transaction->update([
                    'biteship_order_id' => $orderId
                ]);
            }
        }
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

        $transaction = Transaction::where('transaction_code', $request->order_id)->first();

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

    public function webhook_biteship(Request $request, BiteshipService $biteship)
    {
        // ambil semua payload dari biteship
        $payload = $request->all();

        // log semua request (WAJIB buat debug)
        Log::info('Biteship Webhook Masuk', $payload);

        try {
            // ambil data penting dari payload
            $orderId = $payload['order_id'] ?? null;
            $status = $payload['status'] ?? null;

            if (!$orderId) {
                Log::error('Webhook gagal: order_id kosong', $payload);
                return response()->json(['message' => 'order_id kosong'], 400);
            }

            // 🔍 cari transaksi berdasarkan biteship_order_id
            $transaction = Transaction::where('biteship_order_id', $orderId)->first();

            if (!$transaction) {
                Log::error('Transaksi tidak ditemukan', [
                    'order_id' => $orderId
                ]);
                return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
            }

            // mapping status biteship ke status app kamu
            $mappedStatus = $biteship->mapBiteshipStatus($status);

            // 🔄 update transaksi
            $transaction->update([
                'status' => $mappedStatus
            ]);

            Log::info('Status berhasil diupdate', [
                'transaction_id' => $transaction->id,
                'biteship_status' => $status,
                'mapped_status' => $mappedStatus
            ]);

            return response()->json(['message' => 'OK'], 200);

        } catch (\Exception $e) {
            Log::error('Webhook Error', [
                'message' => $e->getMessage(),
                'payload' => $payload
            ]);

            return response()->json(['message' => 'Error'], 500);
        }
    }
}
