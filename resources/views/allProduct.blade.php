<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('/logo.jpeg') }}" type="image/png">
    <title> Semua Produk - Fishery Hub</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,700;1,700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
</head>

<body class="bg-gray-50 min-h-screen pb-24">

    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <header class="sticky top-0 bg-white shadow-sm px-4 py-3 flex items-center justify-between">
            <a href="{{ route('home') }}">
                <span class="iconify" data-icon="weui:back-outlined" data-width="24"></span>
            </a>

            <h1 class="font-bold text-lg">Semua Produk</h1>

            <a href="{{ route('cart') }}" class="relative">
                <span class="iconify" data-icon="mdi:cart-outline" data-width="24"></span>
            </a>
        </header>

        <!-- SEARCH -->
        <div class="p-4">
            <form method="GET" action="{{ route('allProduct.show') }}"
                class="flex items-center bg-white border rounded-full px-4 py-2">
                <span class="iconify text-gray-400" data-icon="mdi:magnify"></span>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk..."
                    class="flex-1 outline-none text-sm ml-2">
            </form>
        </div>

        <!-- TITLE -->
        <div class="px-4 mb-3">
            <h2 class="text-lg font-bold">
                @if(request('q'))
                    Hasil: "{{ request('q') }}"
                @else
                    Semua Produk
                @endif
            </h2>
        </div>

        <!-- GRID -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 px-4">

            @forelse ($products as $product)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">

                    <!-- IMAGE -->
                    <a href="{{ route('detailProduct.show', $product->id) }}">
                        <img src="{{ asset(file_exists(public_path('storage/' . $product->photo)) ? 'storage/' . $product->photo : 'assets/pasar-ikan.png') }}"
                            class="w-full h-36 object-cover">
                    </a>

                    <!-- CONTENT -->
                    <div class="p-3">

                        <h3 class="text-sm font-semibold truncate">
                            {{ $product->name }}
                        </h3>

                        <p class="text-cyan-600 font-bold text-sm mt-1">
                            Rp{{ number_format($product->price, 0, ',', '.') }}
                        </p>

                        <!-- ACTION -->
                        <div class="flex gap-2 mt-3">

                            <!-- PESAN -->
                            <form action="{{ route('checkout') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="selected_products[{{ $product->id }}]"
                                    value="{{ $product->id }}">
                                <input type="hidden" name="quantity[{{ $product->id }}]" value="1">
                                <input type="hidden" name="restaurant_id" value="{{ $product->restaurant_id }}">

                                <button class="w-full bg-cyan-600 text-white text-xs py-2 rounded-lg">
                                    Pesan
                                </button>
                            </form>

                            <!-- CART -->
                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <input type="hidden" name="restaurant_id" value="{{ $product->restaurant_id }}">

                                <button class="w-9 h-9 bg-amber-400 text-white rounded-lg flex items-center justify-center">
                                    <span class="iconify" data-icon="mdi:cart-plus"></span>
                                </button>
                            </form>

                        </div>

                    </div>
                </div>

            @empty
                <div class="col-span-full text-center py-10">
                    <p class="text-gray-400">Produk tidak ditemukan</p>
                </div>
            @endforelse

        </div>

    </div>

</body>

</html>