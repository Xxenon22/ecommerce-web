<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product['name'] }} - Fishery Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen pb-20">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <header class="flex items-center justify-between p-4 bg-white shadow-md sticky top-0 z-20">
            <a href="{{ route('home') }}">
                <span class="iconify cursor-pointer" data-icon="weui:back-outlined" data-width="32"
                    data-height="32"></span>
            </a>
            <div class="relative flex-1 max-w-md mx-4">
                <input type="text" placeholder="Cari produk segar disini..."
                    class="w-full px-4 py-2 pl-10 pr-4 text-gray-700 bg-gray-50 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <span class="iconify absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"
                    data-icon="mdi:magnify" data-width="20" data-height="20"></span>
            </div>
        </header>

        <!-- Product Details -->
        <section class="mt-6 px-6">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}"
                    class="w-full h-64 md:h-96 object-cover">
                <div class="p-6">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $product['name'] }}</h1>
                    <p class="text-red-500 font-bold text-xl md:text-2xl mt-2">{{ $product['price'] }}</p>
                    <p class="text-gray-600 mt-4">{{ $product['description'] }}</p>
                    <button
                        class="bg-cyan-600 text-white text-lg mt-6 px-6 py-3 rounded w-full hover:bg-cyan-700 transition">
                        Tambah ke cart
                    </button>
                </div>
            </div>
        </section>

        <!-- Restaurant Information -->
        <section class="mt-6 px-6">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-4">Informasi Toko</h2>
                    <div class="flex items-center mb-4">
                        <img src="{{ asset($product['restaurant']['image']) }}"
                            alt="{{ $product['restaurant']['name'] }}"
                            class="w-16 h-16 md:w-20 md:h-20 rounded-lg object-cover mr-4">
                        <div>
                            <h3 class="text-lg md:text-xl font-semibold text-gray-900">
                                {{ $product['restaurant']['name'] }}
                            </h3>
                            <p class="text-gray-600 text-sm md:text-base">{{ $product['restaurant']['address'] }}</p>
                        </div>
                    </div>
                    <a href="{{ route('restaurant', 'Layar Seafood 99') }}"
                        class="bg-cyan-600 text-white text-lg px-6 py-3 rounded w-full hover:bg-cyan-700 transition">
                        Kunjungi Toko
                    </a>
                </div>
            </div>
        </section>

        <!-- Bottom Navigation -->
        <x-navbar :cart-count="5" :active-route="'produk'" class="block md:hidden" />

    </div>
</body>

</html>