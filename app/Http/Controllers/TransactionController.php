<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Service\BiteshipService;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with('transactionProducts')->get();
        return view('admin.history.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    public function checkout(Request $request, BiteshipService $biteship)
    {
        $products = [];

        foreach ($request['selected_products'] as $a => $product) {
            $products[$a]['product_id'] = $product;
        }

        foreach ($request['quantity'] as $a => $qty) {
            $products[$a]['quantity'] = $qty;
        }

        // Get user's saved addresses
        $addresses = [];
        if (auth()->check()) {
            $addresses = auth()->user()->addresses()->get();
        }

        // Ambil courier dari Biteship
        $courierResponse = $biteship->getCouriers();

        $couriers = $courierResponse['couriers'] ?? [];
        // dd($products);
        return view('checkout', compact(
            'products',
            'addresses',
            'couriers'
        ));
    }

    public function getRates(Request $request, BiteshipService $biteship)
    {
        $totalWeight = 0;

        foreach ($request->products as $item) {
            $product = \App\Models\Product::find($item['product_id']);
            $totalWeight += $product->weight * $item['quantity']; // pastikan ada kolom weight (gram)
        }

        $payload = [
            "origin_postal_code" => "15143", // ganti dengan postal resto
            "destination_postal_code" => $request->destination_postal_code,
            "couriers" => $request->courier,
            "items" => [
                [
                    "name" => "Order Fishery",
                    "value" => $request->total,
                    "weight" => $totalWeight,
                    "quantity" => 1
                ]
            ]
        ];

        $rates = $biteship->getRates($payload);

        return response()->json($rates);
    }

    public function history()
    {
        $orders = Transaction::with('transactionProducts')->where('user_id', auth()->user()->id)->latest()->get();
        return view('history', compact('orders'));
    }
}
