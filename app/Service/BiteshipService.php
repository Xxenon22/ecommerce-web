<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;

class BiteshipService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.biteship.api_key');
        $this->baseUrl = config('services.biteship.base_url');
    }

    public function getCouriers()
    {
        $response = Http::withHeaders([
            'Authorization' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])
            ->withoutVerifying()
            ->get($this->baseUrl . '/v1/couriers');

        return $response->json();
    }

    public function getRates($data)
    {
        $response = Http::withHeaders([
            'Authorization' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])
            ->withoutVerifying()
            ->post($this->baseUrl . '/v1/rates/couriers', $data);

        return $response->json();
    }

    // 🔥 TAMBAHAN: CREATE ORDER (DINAMIS)
    public function createOrder($data)
    {
        $response = Http::withHeaders([
            'Authorization' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])
            ->withoutVerifying()
            ->post($this->baseUrl . '/v1/orders', $data);

        return $response->json();
    }
    public function mapBiteshipStatus($status)
    {
        return match ($status) {
            'confirmed',
            'scheduled',
            'allocated' => 'Diproses',
            'picking_up' => 'Kurir Menuju Pickup',
            'picked' => 'Dikirim',
            'dropping_off' => 'Dikirim',
            'on_hold' => 'Ditahan',
            'courier_not_found' => 'Kurir Tidak Ditemukan',
            'return_in_transit' => 'Retur',
            'returned' => 'Dikembalikan',
            'cancelled',
            'rejected',
            'disposed' => 'Gagal',
            'delivered' => 'Selesai',
        };
    }
}