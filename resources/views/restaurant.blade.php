<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('/logo.jpeg') }}" type="image/png">
    <title>{{ $restaurant->name }} - Fishery Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
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

        .product-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
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
                <a href="{{ route('restaurant.index') }}" class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-gray-100 transition flex-shrink-0">
                    <span class="iconify text-gray-700" data-icon="weui:back-outlined" data-width="22"></span>
                </a>

                <div class="font-semibold text-gray-900 text-sm truncate flex-1 text-center pr-9">
                    {{ $restaurant->name }}
                </div>
            </div>
        </header>

        {{-- DESKTOP HEADER --}}
        <header class="hidden md:flex items-center justify-between px-8 py-4 bg-white border-b border-gray-100 shadow-sm sticky top-0 z-30">
            <div class="flex items-center gap-8">
                <span class="font-display text-2xl text-cyan-600 italic">FisheryHub</span>
                <nav class="flex gap-6">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-gray-500 hover:text-gray-800 transition">Home</a>
                    <a href="{{ route('category') }}" class="text-sm font-medium text-gray-500 hover:text-gray-800 transition">Kategori</a>
                    <a href="{{ route('restaurant.index') }}" class="text-sm font-semibold text-cyan-600 border-b-2 border-cyan-600 pb-0.5">Restoran</a>
                </nav>
            </div>

            <div class="flex items-center gap-4">
                <div class="search-bar flex items-center w-72 px-4 py-2 gap-2">
                    <span class="iconify text-gray-400" data-icon="mdi:magnify" data-width="18"></span>
                    <input type="text" placeholder="Cari di restoran ini..." class="bg-transparent text-sm text-gray-700 placeholder-gray-400 outline-none flex-1">
                </div>

                <a href="{{ route('cart') }}" class="relative w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 transition">
                    <span class="iconify text-gray-700" data-icon="mdi:cart-outline" data-width="22"></span>
                    <span class="nav-badge">{{ $cartCount ?? 0 }}</span>
                </a>
            </div>
        </header>

        <main class="md:px-8 mt-4 md:mt-8 mb-10">
            {{-- RESTO HERO --}}
            <section class="max-w-7xl mx-auto rounded-none md:rounded-3xl overflow-hidden shadow-xl mb-8 border border-gray-100 bg-white">
                <div class="relative h-48 md:h-72">
                    <img src="{{ !is_null($restaurant->photo) ? asset('storage/'. $restaurant->photo) : '/assets/pasar-ikan.png' }}"
                        alt="{{ $restaurant->name }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

                    <div class="absolute bottom-0 left-0 right-0 p-6 md:p-10 flex items-end justify-between">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50/90 backdrop-blur-sm px-2.5 py-1 rounded-lg flex items-center gap-1.5 shadow-sm">
                                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                    Buka Sekarang
                                </span>
                                <span class="bg-white/20 backdrop-blur-md text-white text-xs font-semibold px-2.5 py-1 rounded-lg flex items-center gap-1">
                                    <span class="iconify text-yellow-400" data-icon="mdi:star" data-width="14"></span>
                                    5.0 (120+ ulasan)
                                </span>
                            </div>
                            <h1 class="text-2xl md:text-5xl font-display font-bold text-white mb-2 md:mb-3">
                                {{ $restaurant->name }}
                            </h1>
                            <p class="text-white/80 text-sm md:text-base flex items-center gap-1.5">
                                <span class="iconify flex-shrink-0" data-icon="mdi:map-marker-outline" data-width="18"></span>
                                {{ $restaurant->address }}
                            </p>
                        </div>

                        <div class="hidden md:flex gap-3">
                            <button class="bg-white/20 hover:bg-white/30 backdrop-blur-md text-white w-12 h-12 rounded-xl flex items-center justify-center transition">
                                <span class="iconify" data-icon="mdi:share-variant-outline" data-width="24"></span>
                            </button>
                            <button class="bg-white/20 hover:bg-white/30 backdrop-blur-md text-white w-12 h-12 rounded-xl flex items-center justify-center transition">
                                <span class="iconify" data-icon="mdi:heart-outline" data-width="24"></span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Resto Info Banner --}}
                <div class="px-6 py-4 flex flex-wrap gap-6 bg-white shrink-0 border-t border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-cyan-50 rounded-xl flex items-center justify-center">
                            <span class="iconify text-cyan-600" data-icon="mdi:clock-outline" data-width="20"></span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Jam Operasional</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $restaurant->open_time ?? '08:00' }} - {{ $restaurant->close_time ?? '22:00' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-cyan-50 rounded-xl flex items-center justify-center">
                            <span class="iconify text-cyan-600" data-icon="mdi:phone-outline" data-width="20"></span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Kontak</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $restaurant->phone ?? '-' }}</p>
                        </div>
                    </div>

                    @if($restaurant->description)
                    <div class="flex-1 min-w-[200px]">
                        <p class="text-xs text-gray-500 mb-1">Tentang Restoran</p>
                        <p class="text-sm text-gray-700 line-clamp-2">{{ $restaurant->description }}</p>
                    </div>
                    @endif
                </div>
            </section>

            {{-- MENU GRID --}}
            <section class="mb-10 px-4 md:px-0">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="iconify text-cyan-600" data-icon="mdi:silverware-fork-knife" data-width="24"></span>
                    Produk Tersedia
                </h2>

                @if($products->isEmpty())
                <div class="text-center py-12 bg-white rounded-3xl border border-gray-100 shadow-sm mx-4 md:mx-0">
                    <span class="iconify mx-auto text-gray-300 mb-4" data-icon="mdi:flask-empty-outline" data-width="64"></span>
                    <h3 class="text-lg font-semibold text-gray-900">Belum ada menu</h3>
                    <p class="text-gray-500 mt-2">Restoran ini belum menambahkan menu.</p>
                </div>
                @else
                <div class="grid grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6">
                    @foreach ($products as $product)
                    <div class="product-card bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
                        <div class="relative flex-shrink-0">
                            <img src="{{ asset(file_exists(public_path('storage/' . $product->photo)) ? 'storage/' . $product->photo : 'assets/pasar-ikan.png') }}"
                                alt="{{ $product->name }}" class="w-full h-40 object-cover">
                        </div>
                        <div class="p-4 flex flex-col flex-1">
                            <h3 class="font-semibold text-gray-900 text-sm md:text-base truncate mb-1">{{ $product->name }}</h3>
                            <p class="text-gray-400 text-xs line-clamp-2 mb-3 flex-1">{{ $product->description }}</p>
                            <p class="text-cyan-600 font-bold text-sm md:text-base mb-3">Rp{{ number_format($product->price, 0, ',', '.') }}</p>

                            <div class="flex gap-2 mt-auto">
                                <form action="{{ route('checkout') }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="selected_products[{{ $product->id}}]" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity[{{ $product->id }}]" value="1">
                                    <input type="hidden" name="restaurant_id" value="{{ $product->restaurant_id }}">
                                    <button type="submit" class="w-full bg-cyan-600 hover:bg-cyan-700 text-white text-xs font-semibold py-2.5 rounded-xl transition">
                                        Pesan
                                    </button>
                                </form>

                                <form action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="restaurant_id" value="{{ $product->restaurant_id }}">
                                    <button type="submit" class="w-10 h-10 bg-amber-400 hover:bg-amber-500 text-white rounded-xl flex items-center justify-center transition active:scale-95">
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

        {{-- MOBILE NAVBAR COMPONENT FALLBACK (Assuming similar to others) --}}
        <x-navbar :cart-count="$cartCount ?? 0" :active-route="'restaurant'" class="block md:hidden" />

    </div>
</body>

</html>