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

        foreach ($request->selected_products as $key => $productId) {
            $products[] = [
                'product_id' => $productId,
                'quantity' => $request->quantity[$key] ?? 1
            ];
        }

        // Ambil alamat user
        $addresses = auth()->check()
            ? auth()->user()->addresses()->get()
            : [];

        // 🔥 OPTIONAL: filter courier di sini juga
        $courierResponse = $biteship->getCouriers();

        $couriers = collect($courierResponse['couriers'] ?? [])
            ->filter(function ($c) {
                return in_array($c['courier_code'], ['gojek', 'grab', 'deliveree']);
            })
            ->values();

        return view('checkout', compact(
            'products',
            'addresses',
            'couriers'
        ));
    }

    public function getRates(Request $request, BiteshipService $biteship)
    {
        $request->validate([
            'courier' => 'required',
            'destination_latitude' => 'required',
            'destination_longitude' => 'required',
            'products' => 'required|array'
        ]);

        $totalWeight = 0;
        $totalValue = 0;

        foreach ($request->products as $item) {
            $product = \App\Models\Product::find($item['product_id']);

            if (!$product)
                continue;

            $totalWeight += ($product->weight ?? 1000) * $item['quantity'];
            $totalValue += ($product->price ?? 0) * $item['quantity'];
        }

        // 🔥 DEBUG SEMENTARA (paksa berat besar biar cargo muncul)
        // HAPUS nanti kalau sudah normal
        if ($totalWeight < 10000) {
            $totalWeight = 15000; // 15kg
        }

        // 🔥 Ambil lokasi toko
        $restaurant = \App\Models\Restaurant::first();

        if (!$restaurant || !$restaurant->latitude || !$restaurant->longitude) {
            return response()->json([
                'success' => false,
                'message' => 'Lokasi toko belum diatur'
            ]);
        }

        // 🔥 HITUNG JARAK
        $distance = $this->calculateDistance(
            $restaurant->latitude,
            $restaurant->longitude,
            $request->destination_latitude,
            $request->destination_longitude
        );

        $payload = [
            "origin_latitude" => (float) $restaurant->latitude,
            "origin_longitude" => (float) $restaurant->longitude,
            "destination_latitude" => (float) $request->destination_latitude,
            "destination_longitude" => (float) $request->destination_longitude,

            // 🔥 PAKSA SEMUA COURIER BIAR DEBUG AMAN
            "couriers" => $request->courier,

            "items" => [
                [
                    "name" => "Fishery Order",
                    "description" => "Produk ikan",
                    "value" => $totalValue,
                    "weight" => $totalWeight,
                    "quantity" => 1
                ]
            ]
        ];

        $rates = $biteship->getRates($payload);

        // 🔥 DEBUG WAJIB (LIHAT APAKAH CARGO ADA)
        // CEK DI SINI DULU
        // dd($rates);

        $selectedCourier = strtolower($request->courier);

        if (isset($rates['pricing'])) {
            $rates['pricing'] = array_values(array_filter($rates['pricing'], function ($rate) use ($distance, $selectedCourier) {

                $serviceName = strtolower($rate['courier_service_name'] ?? '');
                $serviceCode = strtolower($rate['courier_service_code'] ?? '');
                $courierCode = strtolower($rate['courier_code'] ?? '');

                // ✅ FILTER COURIER (INI KUNCI UTAMA)
                if ($courierCode !== $selectedCourier) {
                    return false;
                }

                // ✅ DETEKSI CARGO
                $isCargo = str_contains($serviceName, 'cargo')
                    || str_contains($serviceCode, 'jtr')
                    || str_contains($serviceCode, 'gokil');

                // ✅ RULE JARAK
                if ($distance < 10 && $isCargo) {
                    return false;
                }

                return true;
            }));
        }

        return response()->json([
            'success' => true,
            'distance_km' => round($distance, 2), // 🔥 biar bisa kamu cek
            'total_weight' => $totalWeight,       // 🔥 debug
            'pricing' => $rates['pricing'] ?? []
        ]);
    }

    public function history()
    {
        $orders = Transaction::with('transactionProducts')->where('user_id', auth()->user()->id)->latest()->get();
        return view('history', compact('orders'));
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c; // hasil dalam KM
    }
}
