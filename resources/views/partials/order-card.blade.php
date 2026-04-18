@php
    $status = $order['status'] ?? $order->status;
    $badgeConfig = match ($status) {
        'Sudah di Bayar' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'dot' => 'bg-emerald-500'],
        'Belum di Bayar' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'dot' => 'bg-amber-400'],
        'Diproses' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'dot' => 'bg-blue-500'],
        'Dikirim' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'dot' => 'bg-indigo-500'],
        'Selesai' => ['bg' => 'bg-teal-50', 'text' => 'text-teal-700', 'dot' => 'bg-teal-500'],
        'Ditolak' => ['bg' => 'bg-red-50', 'text' => 'text-red-600', 'dot' => 'bg-red-500'],
        'Kadaluarsa' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'dot' => 'bg-orange-400'],
        'Dibatalkan' => ['bg' => 'bg-red-50', 'text' => 'text-red-600', 'dot' => 'bg-red-400'],
        default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'dot' => 'bg-gray-400'],
    };
@endphp

<div class="order-card bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-3"
    data-order-id="{{ $order['id'] ?? $order->id }}" data-order-link="{{ $order->courier_link }}">

    {{-- Header kartu --}}
    <div class="flex justify-between items-start mb-3">
        <div>
            <p class="text-xs text-gray-400 mb-0.5">
                {{ isset($order['date']) ? $order['date'] : $order->created_at->format('d M Y') }}
            </p>
            <h3 class="font-semibold text-gray-800 text-sm">{{ $order->restaurant->name }}</h3>
        </div>
        <span class="badge {{ $badgeConfig['bg'] }} {{ $badgeConfig['text'] }}">
            <span class="badge-dot {{ $badgeConfig['dot'] }}"></span>
            {{ $status }}
        </span>
    </div>

    <div class="divider"></div>

    {{-- Produk --}}
    <div class="space-y-3">
        @foreach ($order->transactionProducts as $item)
            <div class="flex items-center gap-3">
                <img src="{{ asset('/storage/' . $item->product->photo) }}" alt="{{ $item->product->name }}"
                    class="product-img" onerror="this.src='{{ asset('assets/pasar-ikan.png') }}'">
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-gray-800 text-sm truncate">{{ $item->product->name }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $item->qty }} barang</p>
                </div>
                <span class="text-sm font-semibold text-gray-800">
                    Rp {{ number_format($item->price, 0, ',', '.') }}
                </span>
            </div>
        @endforeach
    </div>

    <div class="divider"></div>

    {{-- Total & Aksi --}}
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs text-gray-400">Total Pembayaran</p>
            <p class="text-base font-bold text-cyan-600">
                Rp {{ number_format($order['total_price'] ?? $order->total_price, 0, ',', '.') }}
            </p>
        </div>

        <div class="flex gap-2">
            @if ($status == 'Belum di Bayar')
                <button class="btn-action btn-primary order-action-btn" data-action="pay"
                    data-id="{{ $order['id'] ?? $order->id }}" data-token="{{ $order->snap_token ?? '' }}"> {{-- jika sudah
                    ada token --}}
                    <span class="iconify" data-icon="mdi:credit-card-outline" data-width="15"></span>
                    Bayar
                </button>
                <button class="btn-action btn-danger order-action-btn" data-action="cancel">
                    Batal
                </button>
            @elseif ($status == 'Diproses')
                <button class="btn-action btn-danger order-action-btn" data-action="cancel">
                    Batalkan
                </button>
                <button class="btn-action btn-primary order-action-btn" data-action="track">
                    <span class="iconify" data-icon="mdi:map-marker-outline" data-width="15"></span>
                    Lacak
                </button>
            @elseif ($status == 'Dikirim')
                <button class="btn-action btn-primary order-action-btn" data-action="track">
                    <span class="iconify" data-icon="mdi:truck-outline" data-width="15"></span>
                    Lacak
                </button>
            @elseif ($status == 'Selesai')
                <button class="btn-action btn-gray order-action-btn" data-action="reorder">
                    <span class="iconify" data-icon="mdi:refresh" data-width="15"></span>
                    Pesan Lagi
                </button>
                <button class="btn-action btn-primary order-action-btn" data-action="review">
                    <span class="iconify" data-icon="mdi:star-outline" data-width="15"></span>
                    Ulasan
                </button>
            @endif
        </div>
    </div>
</div>