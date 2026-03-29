<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orderan Saya - Fishery Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .tab-btn {
            transition: all 0.2s ease;
        }

        .tab-btn.active {
            color: #0891b2;
            border-bottom-color: #0891b2;
        }

        .order-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 4rem 2rem;
            text-align: center;
        }

        .tab-scroll {
            overflow-x: auto;
            scrollbar-width: none;
        }

        .tab-scroll::-webkit-scrollbar {
            display: none;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: #0891b2;
            color: white;
        }

        .btn-primary:hover {
            background: #0e7490;
        }

        .btn-danger {
            background: #fee2e2;
            color: #dc2626;
        }

        .btn-danger:hover {
            background: #fecaca;
        }

        .btn-gray {
            background: #f3f4f6;
            color: #374151;
        }

        .btn-gray:hover {
            background: #e5e7eb;
        }

        .product-img {
            width: 52px;
            height: 52px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #f3f4f6;
        }

        .divider {
            height: 1px;
            background: #f3f4f6;
            margin: 12px 0;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .order-card {
            animation: fadeInUp 0.3s ease forwards;
        }

        .order-card:nth-child(2) {
            animation-delay: 0.05s;
        }

        .order-card:nth-child(3) {
            animation-delay: 0.1s;
        }

        .order-card:nth-child(4) {
            animation-delay: 0.15s;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen pb-24">

    {{-- Header --}}
    <div class="sticky top-0 z-50 bg-white border-b border-gray-100 px-4 py-3 flex items-center gap-3 shadow-sm">
        <a href="{{ route('home') }}"
            class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-gray-100 transition">
            <span class="iconify" data-icon="weui:back-outlined" data-width="22" data-height="22"></span>
        </a>
        <div>
            <h1 class="font-bold text-gray-900 text-lg leading-tight">Orderan Saya</h1>
            <p class="text-xs text-gray-400">Riwayat transaksi Anda</p>
        </div>
    </div>

    <main class="max-w-2xl mx-auto px-4 pt-4">

        {{-- Tabs --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4 overflow-hidden">
            <div class="tab-scroll flex border-b border-gray-100">
                @php
                    $tabs = [
                        ['id' => 'semua', 'label' => 'Semua'],
                        ['id' => 'belumdibayar', 'label' => 'Belum Bayar'],
                        ['id' => 'diproses', 'label' => 'Diproses'],
                        ['id' => 'dikirim', 'label' => 'Dikirim'],
                        ['id' => 'selesai', 'label' => 'Selesai'],
                        ['id' => 'batal', 'label' => 'Batal'],
                    ];
                @endphp
                @foreach ($tabs as $tab)
                    <button
                        class="tab-btn flex-shrink-0 py-3 px-4 text-sm font-600 border-b-2 border-transparent text-gray-400 whitespace-nowrap {{ $loop->first ? 'active border-cyan-600 text-cyan-600' : '' }}"
                        data-tab="{{ $tab['id'] }}">
                        {{ $tab['label'] }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Tab: Semua --}}
        <div id="semua" class="tab-content">
            @if (isset($orders) && count($orders) > 0)
                @foreach ($orders as $order)
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
                        data-order-id="{{ $order['id'] ?? $order->id }}">

                        {{-- Header kartu --}}
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">
                                    {{ $order['date'] ?? $order->created_at->format('d M Y') }}</p>
                                <h3 class="font-700 text-gray-800 text-sm">{{ $order->restaurant->name }}</h3>
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
                                        <p class="font-600 text-gray-800 text-sm truncate">{{ $item->product->name }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $item->qty }} barang</p>
                                    </div>
                                    <span class="text-sm font-700 text-gray-800">
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
                                <p class="text-base font-700 text-cyan-600">
                                    Rp {{ number_format($order['total_price'] ?? $order->total_price, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="flex gap-2">
                                @if ($status == 'Belum di Bayar')
                                    <button class="btn-action btn-primary order-action-btn" data-action="pay">
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
                @endforeach
            @else
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
                    <div class="empty-state">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <span class="iconify text-gray-300" data-icon="mdi:clipboard-text-outline"
                                data-width="40"></span>
                        </div>
                        <h2 class="font-700 text-gray-700 text-lg mb-1">Belum Ada Order</h2>
                        <p class="text-gray-400 text-sm mb-5">Yuk mulai belanja produk segar pilihan Anda</p>
                        <a href="{{ route('home') }}" class="btn-action btn-primary">
                            <span class="iconify" data-icon="mdi:storefront-outline" data-width="16"></span>
                            Mulai Belanja
                        </a>
                    </div>
                </div>
            @endif
        </div>

        {{-- Tab: Belum Dibayar --}}
        <div id="belumdibayar" class="tab-content hidden">
            @php $filtered = isset($orders) ? $orders->filter(fn($o) => ($o['status'] ?? $o->status) == 'Belum di Bayar') : collect(); @endphp
            @if ($filtered->count() > 0)
                @foreach ($filtered as $order)
                    @include('partials.order-card', ['order' => $order])
                @endforeach
            @else
                @include('partials.empty-tab', ['icon' => 'mdi:cash-clock', 'label' => 'Tidak ada order yang belum dibayar'])
            @endif
        </div>

        {{-- Tab: Diproses --}}
        <div id="diproses" class="tab-content hidden">
            @php $filtered = isset($orders) ? $orders->filter(fn($o) => ($o['status'] ?? $o->status) == 'Diproses') : collect(); @endphp
            @if ($filtered->count() > 0)
                @foreach ($filtered as $order)
                    @include('partials.order-card', ['order' => $order])
                @endforeach
            @else
                @include('partials.empty-tab', ['icon' => 'mdi:cog-outline', 'label' => 'Tidak ada order yang sedang diproses'])
            @endif
        </div>

        {{-- Tab: Dikirim --}}
        <div id="dikirim" class="tab-content hidden">
            @php $filtered = isset($orders) ? $orders->filter(fn($o) => ($o['status'] ?? $o->status) == 'Dikirim') : collect(); @endphp
            @if ($filtered->count() > 0)
                @foreach ($filtered as $order)
                    @include('partials.order-card', ['order' => $order])
                @endforeach
            @else
                @include('partials.empty-tab', ['icon' => 'mdi:truck-outline', 'label' => 'Tidak ada order yang sedang dikirim'])
            @endif
        </div>

        {{-- Tab: Selesai --}}
        <div id="selesai" class="tab-content hidden">
            @php $filtered = isset($orders) ? $orders->filter(fn($o) => ($o['status'] ?? $o->status) == 'Selesai') : collect(); @endphp
            @if ($filtered->count() > 0)
                @foreach ($filtered as $order)
                    @include('partials.order-card', ['order' => $order])
                @endforeach
            @else
                @include('partials.empty-tab', ['icon' => 'mdi:check-circle-outline', 'label' => 'Tidak ada order yang sudah selesai'])
            @endif
        </div>

        {{-- Tab: Batal --}}
        <div id="batal" class="tab-content hidden">
            @php $filtered = isset($orders) ? $orders->filter(fn($o) => in_array($o['status'] ?? $o->status, ['Dibatalkan', 'Ditolak', 'Kadaluarsa'])) : collect(); @endphp
            @if ($filtered->count() > 0)
                @foreach ($filtered as $order)
                    @include('partials.order-card', ['order' => $order])
                @endforeach
            @else
                @include('partials.empty-tab', ['icon' => 'mdi:alpha-x-circle-outline', 'label' => 'Tidak ada order yang dibatalkan'])
            @endif
        </div>

    </main>

    <x-navbar :cart-count="0" :active-route="'history'" class="block md:hidden" />

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Tab switching
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function () {
                    tabButtons.forEach(btn => {
                        btn.classList.remove('active', 'border-cyan-600', 'text-cyan-600');
                        btn.classList.add('border-transparent', 'text-gray-400');
                    });
                    this.classList.add('active', 'border-cyan-600', 'text-cyan-600');
                    this.classList.remove('border-transparent', 'text-gray-400');

                    tabContents.forEach(c => c.classList.add('hidden'));
                    document.getElementById(this.dataset.tab).classList.remove('hidden');
                });
            });

            // Order actions
            document.querySelectorAll('.order-action-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const action = this.dataset.action;
                    const card = this.closest('.order-card');
                    const orderId = card?.dataset.orderId;

                    switch (action) {
                        case 'pay':
                            window.location.href = `/order/${orderId}/pay`;
                            break;
                        case 'cancel':
                            if (confirm('Apakah Anda yakin ingin membatalkan order ini?')) {
                                fetch(`/order/${orderId}/cancel`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json'
                                    }
                                }).then(res => {
                                    if (res.ok) {
                                        card.style.opacity = '0';
                                        card.style.transform = 'scale(0.95)';
                                        card.style.transition = 'all 0.3s ease';
                                        setTimeout(() => card.remove(), 300);
                                    }
                                }).catch(() => alert('Gagal membatalkan order'));
                            }
                            break;
                        case 'track':
                            alert('Fitur tracking sedang dalam pengembangan');
                            break;
                        case 'review':
                            alert('Fitur ulasan sedang dalam pengembangan');
                            break;
                        case 'reorder':
                            alert('Produk akan ditambahkan ke keranjang');
                            break;
                    }
                });
            });
        });
    </script>

</body>

</html>