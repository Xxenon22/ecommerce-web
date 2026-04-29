<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    /**
     * Tampilkan halaman tracking berdasarkan biteship_order_id.
     */
    public function show($biteshipOrderId)
    {
        $transaction = Transaction::with([
            'shipmentTrackings',
            'transactionProducts.product',
            'address',
        ])
            ->where('biteship_order_id', $biteshipOrderId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('tracking', compact('transaction'));
    }
}
