<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Pesanan #{{ $transaction->transaction_code }} | Fishery Hub</title>
    <link rel="icon" href="{{ asset('/logo.jpeg') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ── Timeline connector ── */
        .timeline-item { position: relative; padding-left: 2.5rem; padding-bottom: 1.75rem; }
        .timeline-item:not(:last-child)::before {
            content: '';
            position: absolute;
            left: 0.6875rem; /* 11px = (30px icon / 2) - (2px line / 2) */
            top: 1.875rem;   /* below icon */
            bottom: 0;
            width: 2px;
            background: #e5e7eb;
        }
        .timeline-item.done::before   { background: linear-gradient(180deg, #0891b2 0%, #e5e7eb 100%); }
        .timeline-item.active::before { background: #e5e7eb; }

        .timeline-icon {
            position: absolute;
            left: 0;
            top: 0;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            border: 2px solid transparent;
        }
        .timeline-icon.done   { background:#0891b2; border-color:#0891b2; color:#fff; }
        .timeline-icon.active { background:#fff; border-color:#0891b2; color:#0891b2;
                                box-shadow: 0 0 0 4px rgba(8,145,178,0.15); }
        .timeline-icon.pending { background:#f9fafb; border-color:#d1d5db; color:#9ca3af; }

        /* pulse dot for active step */
        @keyframes pulse-ring {
            0%   { box-shadow: 0 0 0 0 rgba(8,145,178,0.4); }
            70%  { box-shadow: 0 0 0 8px rgba(8,145,178,0); }
            100% { box-shadow: 0 0 0 0 rgba(8,145,178,0); }
        }
        .timeline-icon.active { animation: pulse-ring 2s infinite; }

        /* progress bar */
        @keyframes progressFill {
            from { width: 0; }
        }
        .progress-bar-fill { animation: progressFill 1s ease forwards; }

        /* card float in */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.5s ease forwards; }
        .fade-up:nth-child(2) { animation-delay: 0.08s; }
        .fade-up:nth-child(3) { animation-delay: 0.16s; }
        .fade-up:nth-child(4) { animation-delay: 0.24s; }

        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 4px 10px; border-radius: 999px;
            font-size: 11px; font-weight: 700; letter-spacing: 0.03em;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen pb-24">

    {{-- ══════════════════════════════════════════════════════
         TOP NAV
    ══════════════════════════════════════════════════════ --}}
    <div class="sticky top-0 z-50 bg-white border-b border-gray-100 px-4 py-3 flex items-center gap-3 shadow-sm">
        <a href="{{ route('history') }}"
           class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-gray-100 transition">
            <span class="iconify" data-icon="weui:back-outlined" data-width="22"></span>
        </a>
        <div>
            <h1 class="font-bold text-gray-900 text-base leading-tight">Lacak Pesanan</h1>
            <p class="text-xs text-gray-400">#{{ $transaction->transaction_code }}</p>
        </div>

        {{-- Tombol refresh --}}
        <button onclick="window.location.reload()"
                class="ml-auto w-9 h-9 flex items-center justify-center rounded-full hover:bg-gray-100 transition text-gray-400">
            <span class="iconify" data-icon="mdi:refresh" data-width="20"></span>
        </button>
    </div>

    <main class="max-w-2xl mx-auto px-4 pt-5 space-y-4">

        {{-- ══════════════════════════════════════════════════════
             STATUS HEADER CARD
        ══════════════════════════════════════════════════════ --}}
        @php
            $currentStatus = $transaction->status;

            // Progress step index (0-4)
            $steps = [
                ['key' => ['Belum di Bayar'],                                         'label' => 'Pesanan Dibuat',       'icon' => 'mdi:receipt-text-outline'],
                ['key' => ['Sudah di Bayar'],                                         'label' => 'Pembayaran Lunas',     'icon' => 'mdi:check-decagram-outline'],
                ['key' => ['Diproses', 'Kurir Menuju Pickup'],                        'label' => 'Diproses Penjual',     'icon' => 'mdi:store-check-outline'],
                ['key' => ['Dikirim', 'Diperjalanan', 'Ditahan'],                     'label' => 'Dalam Pengiriman',     'icon' => 'mdi:truck-fast-outline'],
                ['key' => ['Selesai'],                                                'label' => 'Terkirim',             'icon' => 'mdi:package-variant-closed-check'],
            ];

            $activeStep = 0;
            foreach ($steps as $i => $step) {
                if (in_array($currentStatus, $step['key'])) {
                    $activeStep = $i;
                }
            }

            // cancelled / failed → show as step 0 with red color
            $isFailed = in_array($currentStatus, ['Dibatalkan', 'Ditolak', 'Gagal', 'Retur', 'Dikembalikan', 'Kurir Tidak Ditemukan']);

            $statusBadge = match(true) {
                $currentStatus === 'Belum di Bayar'                                          => ['bg-amber-50',   'text-amber-700'],
                $currentStatus === 'Sudah di Bayar'                                          => ['bg-emerald-50', 'text-emerald-700'],
                in_array($currentStatus, ['Diproses', 'Kurir Menuju Pickup'])                => ['bg-blue-50',    'text-blue-700'],
                in_array($currentStatus, ['Dikirim', 'Diperjalanan', 'Ditahan'])             => ['bg-indigo-50',  'text-indigo-700'],
                $currentStatus === 'Selesai'                                                 => ['bg-teal-50',    'text-teal-700'],
                $isFailed                                                                    => ['bg-red-50',     'text-red-600'],
                default                                                                      => ['bg-gray-100',   'text-gray-600'],
            };

            $progressPercent = $isFailed ? 0 : (int)(($activeStep / (count($steps) - 1)) * 100);
        @endphp

        <div class="fade-up bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            {{-- Gradient header --}}
            <div class="bg-gradient-to-r from-cyan-600 to-cyan-500 px-5 pt-5 pb-8 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10"
                     style="background-image: radial-gradient(circle at 80% 20%, white 0%, transparent 60%)"></div>

                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-cyan-100 text-xs font-medium mb-1">Status Pengiriman</p>
                        <h2 class="text-white font-bold text-xl leading-tight">{{ $currentStatus }}</h2>
                    </div>
                    <span class="mt-0.5 badge {{ $statusBadge[0] }} {{ $statusBadge[1] }}">
                        <span class="w-1.5 h-1.5 rounded-full" style="background:currentColor"></span>
                        {{ $currentStatus }}
                    </span>
                </div>

                {{-- Last update --}}
                @if($transaction->shipmentTrackings->count())
                    <p class="text-cyan-200 text-xs mt-2">
                        Update terakhir:
                        {{ $transaction->shipmentTrackings->last()->event_time?->locale('id')->diffForHumans() }}
                    </p>
                @endif
            </div>

            {{-- Progress Bar --}}
            <div class="px-5 -mt-3 mb-5">
                <div class="bg-white rounded-xl shadow p-4">
                    <div class="flex justify-between text-[10px] font-semibold text-gray-400 mb-2">
                        @foreach($steps as $i => $step)
                            <span class="{{ $i <= $activeStep && !$isFailed ? 'text-cyan-600' : '' }}">
                                {{ $step['label'] }}
                            </span>
                        @endforeach
                    </div>

                    <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                        <div class="progress-bar-fill h-2 rounded-full {{ $isFailed ? 'bg-red-400' : 'bg-gradient-to-r from-cyan-500 to-cyan-400' }}"
                             style="width: {{ $progressPercent }}%"></div>
                    </div>

                    {{-- Step icons --}}
                    <div class="flex justify-between mt-2">
                        @foreach($steps as $i => $step)
                            <div class="flex flex-col items-center">
                                <div class="w-7 h-7 rounded-full flex items-center justify-center
                                    {{ $isFailed ? 'bg-gray-100 text-gray-300' :
                                       ($i < $activeStep  ? 'bg-cyan-600 text-white' :
                                       ($i === $activeStep ? 'bg-white border-2 border-cyan-500 text-cyan-600' :
                                                             'bg-gray-100 text-gray-300')) }}">
                                    <span class="iconify text-xs" data-icon="{{ $step['icon'] }}" data-width="14"></span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Kurir Link --}}
            <!-- @if($transaction->courier_link)
                <div class="px-5 py-3 border-t border-gray-50">
                    <a href="{{ $transaction->courier_link }}" target="_blank"
                       class="flex items-center gap-2 text-sm text-cyan-600 font-semibold hover:underline">
                        <span class="iconify" data-icon="mdi:open-in-new" data-width="15"></span>
                        Lihat tracking resmi kurir
                    </a>
                </div>
            @endif -->
        </div>

        {{-- ══════════════════════════════════════════════════════
             TIMELINE RIWAYAT STATUS
        ══════════════════════════════════════════════════════ --}}
        <div class="fade-up bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-5 flex items-center gap-2">
                <span class="iconify text-cyan-500" data-icon="mdi:timeline-clock-outline" data-width="20"></span>
                Riwayat Status
            </h3>

            @if($transaction->shipmentTrackings->count())
                {{-- Reverse so newest on top --}}
                @php $trackings = $transaction->shipmentTrackings->sortByDesc('event_time'); @endphp

                <div>
                    @foreach($trackings as $loop_index => $tracking)
                        @php
                            $isFirst = $loop_index === 0; // newest = active
                            $state   = $isFirst ? 'active' : 'done';
                        @endphp

                        <div class="timeline-item {{ $state }}">
                            <div class="timeline-icon {{ $state }}">
                                @if($isFirst)
                                    <span class="iconify" data-icon="mdi:map-marker" data-width="13"></span>
                                @else
                                    <span class="iconify" data-icon="mdi:check-bold" data-width="12"></span>
                                @endif
                            </div>

                            <div class="{{ $isFirst ? 'font-semibold text-gray-900' : 'text-gray-600' }}">
                                <p class="text-sm {{ $isFirst ? 'font-bold' : 'font-medium' }}">
                                    {{ $tracking->mapped_status }}
                                    @if($isFirst)
                                        <span class="ml-1 text-[10px] font-semibold bg-cyan-100 text-cyan-700 px-2 py-0.5 rounded-full">Terbaru</span>
                                    @endif
                                </p>

                                @if($tracking->note)
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $tracking->note }}</p>
                                @endif

                                @if($tracking->biteship_status && $tracking->biteship_status !== $tracking->mapped_status)
                                    <p class="text-[10px] text-gray-400 mt-0.5 font-mono">{{ $tracking->biteship_status }}</p>
                                @endif

                                <p class="text-xs text-gray-400 mt-1">
                                    <span class="iconify inline" data-icon="mdi:clock-outline" data-width="11"></span>
                                    {{ $tracking->event_time?->locale('id')->isoFormat('dddd, D MMMM YYYY · HH:mm') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

            @else
                {{-- Belum ada tracking dari Biteship --}}
                <div class="py-8 text-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="iconify text-gray-300" data-icon="mdi:truck-outline" data-width="36"></span>
                    </div>
                    <p class="text-gray-500 text-sm font-medium">Belum ada update pengiriman</p>
                    <p class="text-gray-400 text-xs mt-1">Kami akan memperbarui halaman ini secara otomatis</p>
                    <button onclick="window.location.reload()"
                            class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-cyan-600 bg-cyan-50 hover:bg-cyan-100 px-4 py-2 rounded-lg transition">
                        <span class="iconify" data-icon="mdi:refresh" data-width="15"></span>
                        Refresh
                    </button>
                </div>
            @endif
        </div>

        {{-- ══════════════════════════════════════════════════════
             INFO PESANAN
        ══════════════════════════════════════════════════════ --}}
        <div class="fade-up bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span class="iconify text-cyan-500" data-icon="mdi:shopping-outline" data-width="20"></span>
                Detail Pesanan
            </h3>

            {{-- Produk --}}
            <div class="space-y-3 mb-4">
                @foreach($transaction->transactionProducts as $item)
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('/storage/' . $item->product->photo) }}"
                             alt="{{ $item->product->name }}"
                             onerror="this.src='{{ asset('assets/pasar-ikan.png') }}'"
                             class="w-14 h-14 rounded-xl object-cover border border-gray-100">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-800 text-sm truncate">{{ $item->product->name }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $item->qty }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <span class="text-sm font-bold text-gray-700">
                            Rp {{ number_format($item->qty * $item->price, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach
            </div>

            <div class="h-px bg-gray-100 my-3"></div>

            {{-- Ringkasan biaya --}}
            <div class="space-y-1.5 text-sm">
                <div class="flex justify-between text-gray-500">
                    <span>Subtotal produk</span>
                    <span>Rp {{ number_format($transaction->total_price - $transaction->expedition_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-gray-500">
                    <span>Ongkos kirim</span>
                    <span>Rp {{ number_format($transaction->expedition_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-bold text-gray-900 pt-1 border-t border-gray-100 mt-1">
                    <span>Total Pembayaran</span>
                    <span class="text-cyan-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════
             ALAMAT PENGIRIMAN
        ══════════════════════════════════════════════════════ --}}
        @if($transaction->address)
        <div class="fade-up bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                <span class="iconify text-cyan-500" data-icon="mdi:map-marker-outline" data-width="20"></span>
                Alamat Tujuan
            </h3>
            <p class="font-semibold text-gray-800 text-sm">{{ $transaction->address->recipient_name }}</p>
            <p class="text-xs text-gray-500 mt-0.5">{{ $transaction->address->phone }}</p>
            <p class="text-xs text-gray-500 mt-1">
                {{ $transaction->address->address_detail }},
                {{ $transaction->address->district }},
                {{ $transaction->address->city }},
                {{ $transaction->address->province }}
                {{ $transaction->address->postal_code }}
            </p>
        </div>
        @endif

    </main>

    {{-- Bottom nav --}}
    <x-navbar :cart-count="0" :active-route="'history'" class="block md:hidden" />

    {{-- Auto-refresh every 60s if order is still active --}}
    @if(!in_array($transaction->status, ['Selesai', 'Dibatalkan', 'Ditolak', 'Gagal', 'Dikembalikan', 'Belum di Bayar']))
    <script>
        setTimeout(() => window.location.reload(), 60000);
    </script>
    @endif

</body>
</html>
