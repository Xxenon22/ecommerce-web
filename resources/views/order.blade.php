<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>order - Fishery Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tab switching
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // Remove active class from all buttons
                    tabButtons.forEach(btn => {
                        btn.classList.remove('border-cyan-600', 'text-cyan-600');
                        btn.classList.add('border-transparent', 'text-gray-500');
                    });

                    // Add active class to clicked button
                    this.classList.remove('border-transparent', 'text-gray-500');
                    this.classList.add('border-cyan-600', 'text-cyan-600');

                    // Hide all tab contents
                    tabContents.forEach(content => content.classList.add('hidden'));

                    // Show selected tab content
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(tabId).classList.remove('hidden');
                });
            });

            // Order actions
            const actionButtons = document.querySelectorAll('.order-action-btn');
            actionButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const action = this.getAttribute('data-action');
                    const orderId = this.closest('.order-card').getAttribute('data-order-id');

                    switch (action) {
                        case 'cancel':
                            if (confirm('Apakah Anda yakin ingin membatalkan order ini?')) {
                                alert('order berhasil dibatalkan');
                                this.closest('.order-card').remove();
                            }
                            break;
                        case 'track':
                            alert('Fitur tracking sedang dalam pengembangan');
                            break;
                        case 'review':
                            alert('Fitur ulasan sedang dalam pengembangan');
                            break;
                        case 'reorder':
                            alert('order akan ditambahkan ke cart');
                            break;
                    }
                });
            });
        });
    </script>
</head>

<body class="bg-gray-100 min-h-screen pb-20">
    <div class="header flex items-center justify-between p-4 bg-white shadow-md">
        <div class="flex items-center space-x-2">
            <a href="{{ route('home') }}">
                <span class="iconify cursor-pointer" data-icon="weui:back-outlined" data-width="38"
                    data-height="38"></span>
            </a>
            <h1 class="font-bold text-xl text-gray-700">order Saya</h1>
        </div>
    </div>

    <main class="max-w-4xl mx-auto p-4">
        <!-- Order Tabs -->
        <div class="bg-white rounded-lg shadow-md mb-4">
            <div class="flex border-b border-gray-200">
                <button
                    class="tab-btn flex-1 py-3 px-4 text-center border-b-2 border-cyan-600 text-cyan-600 font-medium"
                    data-tab="semua">
                    Semua
                </button>
                <button
                    class="tab-btn flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-500 font-medium"
                    data-tab="diproses">
                    Diproses
                </button>
                <button
                    class="tab-btn flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-500 font-medium"
                    data-tab="dikirim">
                    Dikirim
                </button>
                <button
                    class="tab-btn flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-500 font-medium"
                    data-tab="selesai">
                    Selesai
                </button>
            </div>
        </div>

        <!-- Tab Content -->
        <div id="semua" class="tab-content">
            @if(isset($orders) && count($orders) > 0)
                @foreach($orders as $order)
                    <div class="order-card bg-white rounded-lg shadow-md p-4 mb-4" data-order-id="{{ $order['id'] }}">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="font-semibold text-gray-800">order #{{ $order['id'] }}</h3>
                                <p class="text-sm text-gray-500">{{ $order['date'] }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                                        @if($order['status'] == 'Diproses') bg-yellow-100 text-yellow-800
                                                        @elseif($order['status'] == 'Dikirim') bg-blue-100 text-blue-800
                                                        @elseif($order['status'] == 'Selesai') bg-green-100 text-green-800
                                                        @else bg-gray-100 text-gray-800 @endif">
                                {{ $order['status'] }}
                            </span>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            @foreach($order['items'] as $item)
                                <div class="flex items-center justify-between py-2">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}"
                                            class="w-12 h-12 object-cover rounded">
                                        <div>
                                            <h4 class="font-medium text-gray-800">{{ $item['name'] }}</h4>
                                            <p class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</p>
                                        </div>
                                    </div>
                                    <span class="font-semibold text-red-500">{{ $item['price'] }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-200 pt-4 mt-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Total Pembayaran</span>
                                <span class="text-lg font-bold text-red-500">{{ $order['total'] }}</span>
                            </div>

                            <div class="flex space-x-2">
                                @if($order['status'] == 'Diproses')
                                    <button
                                        class="order-action-btn flex-1 bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg text-sm font-medium transition"
                                        data-action="cancel">
                                        Batalkan
                                    </button>
                                    <button
                                        class="order-action-btn flex-1 bg-cyan-600 hover:bg-cyan-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition"
                                        data-action="track">
                                        Lacak
                                    </button>
                                @elseif($order['status'] == 'Dikirim')
                                    <button
                                        class="order-action-btn flex-1 bg-cyan-600 hover:bg-cyan-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition"
                                        data-action="track">
                                        Lacak Pengiriman
                                    </button>
                                @elseif($order['status'] == 'Selesai')
                                    <button
                                        class="order-action-btn flex-1 bg-cyan-600 hover:bg-cyan-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition"
                                        data-action="review">
                                        Beri Ulasan
                                    </button>
                                    <button
                                        class="order-action-btn flex-1 bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition"
                                        data-action="reorder">
                                        Pesan Lagi
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <span class="iconify block mx-auto mb-4 text-gray-400" data-icon="mdi:clipboard-text-outline"
                        data-width="64" data-height="64"></span>
                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada order</h2>
                    <p class="text-gray-500 mb-4">Anda belum memiliki order. Mulai berbelanja sekarang!</p>
                    <a href="{{ route('home') }}"
                        class="bg-cyan-600 hover:bg-cyan-700 text-white font-semibold py-2 px-4 rounded-lg inline-block transition duration-300">
                        Mulai Belanja
                    </a>
                </div>
            @endif
        </div>

        <!-- Other tabs (initially hidden) -->
        <div id="diproses" class="tab-content hidden">
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <span class="iconify block mx-auto mb-4 text-yellow-400" data-icon="mdi:cog-outline" data-width="64"
                    data-height="64"></span>
                <h2 class="text-xl font-semibold text-gray-700 mb-2">order Diproses</h2>
                <p class="text-gray-500">Tidak ada order yang sedang diproses</p>
            </div>
        </div>

        <div id="dikirim" class="tab-content hidden">
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <span class="iconify block mx-auto mb-4 text-blue-400" data-icon="mdi:truck-outline" data-width="64"
                    data-height="64"></span>
                <h2 class="text-xl font-semibold text-gray-700 mb-2">order Dikirim</h2>
                <p class="text-gray-500">Tidak ada order yang sedang dikirim</p>
            </div>
        </div>

        <div id="selesai" class="tab-content hidden">
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <span class="iconify block mx-auto mb-4 text-green-400" data-icon="mdi:check-circle-outline"
                    data-width="64" data-height="64"></span>
                <h2 class="text-xl font-semibold text-gray-700 mb-2">order Selesai</h2>
                <p class="text-gray-500">Tidak ada order yang sudah selesai</p>
            </div>
        </div>
    </main>

    <x-navbar :cart-count="0" :active-route="'order'" class="block md:hidden" />
</body>

</html>