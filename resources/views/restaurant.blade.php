<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurant['name'] }} - Fishery Hub</title>
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

        <!-- Restaurant Header -->
        <section class="mt-6 px-6">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <img src="{{ asset($restaurant['image']) }}" alt="{{ $restaurant['name'] }}"
                    class="w-full h-64 md:h-96 object-cover">
                <div class="p-6">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $restaurant['name'] }}</h1>
                    <p class="text-gray-600 mt-2">{{ $restaurant['address'] }}</p>
                </div>
            </div>
        </section>

        <!-- Products Section -->
        <section class="mt-6 px-6">
            <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-4">Produk yang Dijual</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($restaurant['products'] as $product)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                        <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}"
                            class="w-full h-32 md:h-40 object-cover">
                        <div class="p-4">
                            <h3 class="text-sm md:text-base font-semibold">{{ $product['name'] }}</h3>
                            <p class="text-red-500 font-bold text-sm md:text-base">{{ $product['price'] }}</p>
                            <a href="{{ route('produk', $product['name']) }}"
                                class="bg-cyan-600 text-white text-sm mt-2 px-3 py-1 rounded w-full hover:bg-cyan-700 transition inline-block text-center">
                                Beli
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Bottom Navigation -->
        <x-navbar :cart-count="5" :active-route="'restaurant'" class="block md:hidden" />

    </div>
</body>

</html>