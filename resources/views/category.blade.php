<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('/logo.jpeg') }}" type="image/png">
    <title>{{ isset($category) ? $category->name . ' - ' : '' }}Kategori - Fishery Hub</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,700;1,700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <style>
        :root {
            --cyan: #0891b2;
        }

        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-display {
            font-family: 'Fraunces', serif;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .product-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .cat-pill {
            transition: all 0.2s ease;
        }

        .cat-pill:hover,
        .cat-pill.active {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(8, 145, 178, 0.2);
            border-color: var(--cyan);
            background-color: var(--cyan);
        }

        .cat-pill:hover h3,
        .cat-pill.active h3 {
            color: white;
        }

        .cat-pill:hover .icon-container,
        .cat-pill.active .icon-container {
            background-color: white;
        }

        .cat-pill:hover .icon-container span,
        .cat-pill.active .icon-container span {
            color: var(--cyan);
        }

        .search-bar {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 999px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .search-bar:focus-within {
            border-color: var(--cyan);
            box-shadow: 0 0 0 3px rgba(8, 145, 178, 0.1);
        }

        .nav-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #ef4444;
            color: white;
            font-size: 10px;
            font-weight: 700;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen pb-24">
    <div class="max-w-7xl mx-auto">

        {{-- MOBILE HEADER --}}
        <header class="sticky top-0 z-30 bg-white border-b border-gray-100 shadow-sm md:hidden">
            <div class="flex items-center gap-3 px-4 py-3">
                <a href="{{ route('home') }}"
                    class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-gray-100 transition flex-shrink-0">
                    <span class="iconify text-gray-700" data-icon="weui:back-outlined" data-width="22"></span>
                </a>

                <form action="{{ isset($category) ? route('category.products', $category->id) : route('category') }}"
                    method="GET" class="search-bar flex items-center flex-1 px-4 py-2 gap-2">

                    <span class="iconify text-gray-400" data-icon="mdi:magnify" data-width="18"></span>

                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk..."
                        class="bg-transparent text-sm text-gray-700 placeholder-gray-400 outline-none flex-1">

                </form>

                <a href="{{ route('cart') }}"
                    class="relative w-9 h-9 flex items-center justify-center rounded-xl hover:bg-gray-100 transition flex-shrink-0">
                    <span class="iconify text-gray-700" data-icon="mdi:cart-outline" data-width="22"></span>
                    <span class="nav-badge">{{ $cartCount ?? 0 }}</span>
                </a>
            </div>
        </header>

        {{-- DESKTOP HEADER --}}
        <header
            class="hidden md:flex items-center justify-between px-8 py-4 bg-white border-b border-gray-100 shadow-sm sticky top-0 z-30">
            <div class="flex items-center gap-8">
                <span class="font-display text-2xl text-cyan-600 italic">FisheryHub</span>
                <nav class="flex gap-6">
                    <a href="{{ route('home') }}"
                        class="text-sm font-medium text-gray-500 hover:text-gray-800 transition">Home</a>
                    <a href="{{ route('category') }}"
                        class="text-sm font-semibold text-cyan-600 border-b-2 border-cyan-600 pb-0.5">Kategori</a>
                    <a href="{{ route('restaurant.index') }}"
                        class="text-sm font-medium text-gray-500 hover:text-gray-800 transition">Restoran</a>
                </nav>
            </div>

            <div class="flex items-center gap-4">
                <form action="{{ isset($category) ? route('category.products', $category->id) : route('category') }}"
                    method="GET" class="search-bar flex items-center w-72 px-4 py-2 gap-2">

                    <span class="iconify text-gray-400" data-icon="mdi:magnify" data-width="18"></span>

                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk..."
                        class="bg-transparent text-sm text-gray-700 placeholder-gray-400 outline-none flex-1">

                </form>

                <a href="{{ route('cart') }}"
                    class="relative w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 transition">
                    <span class="iconify text-gray-700" data-icon="mdi:cart-outline" data-width="22"></span>
                    <span class="nav-badge">{{ $cartCount ?? 0 }}</span>
                </a>
            </div>
        </header>

        <main class="px-4 md:px-8 mt-6">
            {{-- KATEGORI FILTER PILLS --}}
            <section class="mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Urut Berdasarkan Kategori</h2>
                <div class="flex gap-3  scrollbar-hide pb-2">
                    <a href="{{ route('category') }}"
                        class="cat-pill {{ !isset($category) ? 'active' : '' }} flex-shrink-0 flex flex-col items-center gap-2 bg-white border border-gray-100 rounded-2xl px-5 py-3 shadow-sm min-w-24">
                        <div
                            class="icon-container w-10 h-10 bg-cyan-50 rounded-xl flex items-center justify-center transition-colors">
                            <span class="iconify text-cyan-600" data-icon="mdi:shape-outline" data-width="20"></span>
                        </div>
                        <h3 class="text-gray-700 text-xs font-semibold text-center leading-tight transition-colors">
                            Semua</h3>
                    </a>

                    @foreach ($categories as $cat)
                        <a href="{{ route('category.products', $cat->id) }}"
                            class="cat-pill {{ isset($category) && $category->id == $cat->id ? 'active' : '' }} flex-shrink-0 flex flex-col items-center gap-2 bg-white border border-gray-100 rounded-2xl px-5 py-3 shadow-sm min-w-24">
                            <div
                                class="icon-container w-10 h-10 bg-cyan-50 rounded-xl flex items-center justify-center transition-colors">
                                <span class="iconify text-cyan-600" data-icon="{{ $cat->icon }}" data-width="20"></span>
                            </div>
                            <h3 class="text-gray-700 text-xs font-semibold text-center leading-tight transition-colors">
                                {{ $cat->name }}
                            </h3>
                        </a>
                    @endforeach
                </div>
            </section>

            {{-- PRODUCT GRID --}}
            <section class="mb-10">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    @if(request('q'))
                        Hasil pencarian "{{ request('q') }}"
                    @elseif(isset($category))
                        Produk {{ $category->name }}
                    @else
                        Semua Produk
                    @endif
                </h2>

                @if($products->isEmpty())
                    <div class="text-center py-10 bg-white rounded-3xl border border-gray-100 shadow-sm">
                        <span class="iconify mx-auto text-gray-300 mb-3" data-icon="mdi:fish-off" data-width="64"></span>
                        <h3 class="text-lg font-semibold text-gray-900">Belum ada produk</h3>
                        <p class="text-gray-500 text-sm mt-1">@if(request('q'))
    Tidak ditemukan hasil untuk "{{ request('q') }}"
@else
    Belum ada produk di kategori ini.
@endif</p>
                    </div>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6">
                        @foreach ($products as $product)
                            <div
                                class="product-card bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
                                <div class="relative flex-shrink-0">
                                    <img src="{{ asset(file_exists(public_path('storage/' . $product->photo)) ? 'storage/' . $product->photo : 'assets/pasar-ikan.png') }}"
                                        alt="{{ $product->name }}" class="w-full h-40 object-cover">
                                    <div class="absolute top-2 right-2">
                                        <span
                                            class="bg-white/90 backdrop-blur-sm text-cyan-700 text-xs font-bold px-2 py-1 rounded-full shadow-sm">
                                            Segar
                                        </span>
                                    </div>
                                </div>
                                <div class="p-4 flex flex-col flex-1">
                                    <h3 class="font-semibold text-gray-900 text-sm md:text-base truncate mb-1">
                                        {{ $product->name }}
                                    </h3>
                                    <p class="text-gray-400 text-xs line-clamp-2 mb-3 flex-1">{{ $product->description }}</p>
                                    <p class="text-cyan-600 font-bold text-sm md:text-base mb-3">
                                        Rp{{ number_format($product->price, 0, ',', '.') }}</p>

                                    <div class="flex gap-2 mt-auto">
                                        <form action="{{ route('checkout') }}" method="POST" class="flex-1">
                                            @csrf
                                            <input type="hidden" name="selected_products[{{ $product->id}}]"
                                                value="{{ $product->id }}">
                                            <input type="hidden" name="quantity[{{ $product->id }}]" value="1">
                                            <input type="hidden" name="restaurant_id" value="{{ $product->restaurant_id }}">
                                            <button type="submit"
                                                class="w-full bg-cyan-600 hover:bg-cyan-700 text-white text-xs font-semibold py-2.5 rounded-xl transition">
                                                Pesan
                                            </button>
                                        </form>

                                        <form action="{{ route('cart.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="restaurant_id" value="{{ $product->restaurant_id }}">
                                            <button type="submit"
                                                class="w-10 h-10 bg-amber-400 hover:bg-amber-500 text-white rounded-xl flex items-center justify-center transition active:scale-95">
                                                <span class="iconify" data-icon="mdi:cart-plus" data-width="18"></span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </main>

        <x-navbar :cart-count="$cartCount ?? 0" :active-route="'category'" class="block md:hidden" />

    </div>
</body>

</html>