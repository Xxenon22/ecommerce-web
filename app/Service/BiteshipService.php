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
            ->withoutVerifying() // kalau masih dev
            ->post($this->baseUrl . '/v1/rates/couriers', $data);

        return $response->json();
    }
}