<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('/logo.jpeg') }}" type="image/png">
    <title>{{ $product->name }} - FisheryHub</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,700;1,700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <style>
        :root {
            --cyan: #0891b2;
            --cyan-dark: #0e7490;
            --cyan-light: #ecfeff;
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

        .cart-btn {
            transition: all 0.15s ease;
        }

        .cart-btn:active {
            transform: scale(0.92);
        }

        .section-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--cyan);
        }

        .qty-btn {
            transition: all 0.15s ease;
        }

        .qty-btn:hover {
            background: var(--cyan);
            color: white;
            border-color: var(--cyan);
        }

        .qty-btn:active {
            transform: scale(0.92);
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-up {
            animation: fadeUp 0.5s ease forwards;
        }

        .img-zoom {
            transition: transform 0.4s ease;
        }

        .img-zoom:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen pb-24">
    <div class="max-w-7xl mx-auto">

        {{-- MOBILE HEADER --}}
        <header class="sticky top-0 z-30 bg-white border-b border-gray-100 shadow-sm md:hidden">
            <div class="flex items-center gap-3 px-4 py-3">
                <a href="{{ url()->previous() }}"
                    class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-gray-100 transition flex-shrink-0">
                    <span class="iconify text-gray-700" data-icon="weui:back-outlined" data-width="22"></span>
                </a>

                <div class="font-semibold text-gray-900 text-sm truncate flex-1 text-center pr-9">
                    Detail Produk
                </div>
            </div>
        </header>

        {{-- DESKTOP HEADER --}}
        <header
            class="hidden md:flex items-center justify-between px-8 py-4 bg-white border-b border-gray-100 shadow-sm sticky top-0 z-30">
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}">
                    <span class="font-display text-2xl text-cyan-600 italic">FisheryHub</span>
                </a>
                <nav class="flex gap-6">
                    <a href="{{ route('home') }}"
                        class="text-sm font-medium text-gray-500 hover:text-gray-800 transition">Beranda</a>
                    <a href="{{ route('category') }}"
                        class="text-sm font-medium text-gray-500 hover:text-gray-800 transition">Kategori</a>
                    <a href="{{ url('/restaurant') }}"
                        class="text-sm font-medium text-gray-500 hover:text-gray-800 transition">Restoran</a>
                </nav>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('cart') }}"
                    class="relative w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 transition">
                    <span class="iconify text-gray-700" data-icon="mdi:cart-outline" data-width="22"></span>
                    <span class="nav-badge">{{ $cartCount ?? 0 }}</span>
                </a>
                <a href="{{ route('history') }}"
                    class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 transition">
                    <span class="iconify text-gray-700" data-icon="mdi:clipboard-text-outline" data-width="22"></span>
                </a>
                @auth
                    <a href="{{ route('account') }}" class="flex items-center gap-2">
                        @if (Auth::user()->photo)
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="User"
                                class="w-8 h-8 rounded-full object-cover border-2 border-cyan-200">
                        @else
                            <div class="w-8 h-8 rounded-full bg-cyan-100 flex items-center justify-center">
                                <span class="iconify text-cyan-600" data-icon="mdi:account" data-width="18"></span>
                            </div>
                        @endif
                        <span class="text-sm font-semibold text-gray-700">{{ Auth::user()->name ?? 'User' }}</span>
                    </a>
                @endauth
            </div>
        </header>

        <main class="md:px-8 mt-4 md:mt-8 mb-10">

            {{-- BREADCRUMB (desktop) --}}
            <nav class="hidden md:flex items-center gap-2 text-sm text-gray-400 mb-6 px-4 md:px-0">
                <a href="{{ route('home') }}" class="hover:text-cyan-600 transition">Beranda</a>
                <span class="iconify" data-icon="mdi:chevron-right" data-width="16"></span>
                @if($product->restaurant)
                    <a href="{{ route('restaurant.show', $product->restaurant_id) }}"
                        class="hover:text-cyan-600 transition">{{ $product->restaurant->name }}</a>
                    <span class="iconify" data-icon="mdi:chevron-right" data-width="16"></span>
                @endif
                <span class="text-gray-700 font-medium">{{ $product->name }}</span>
            </nav>

            {{-- PRODUCT DETAIL CARD --}}
            <section class="bg-white rounded-none md:rounded-3xl shadow-sm border border-gray-100 overflow-hidden fade-up">
                <div class="grid grid-cols-1 md:grid-cols-2">

                    {{-- LEFT: IMAGE --}}
                    <div class="relative overflow-hidden bg-gray-100">
                        <img src="{{ asset(file_exists(public_path('storage/' . $product->photo)) ? 'storage/' . $product->photo : 'assets/pasar-ikan.png') }}"
                            alt="{{ $product->name }}"
                            class="w-full h-72 md:h-[500px] object-cover img-zoom">

                        {{-- Badge --}}
                        <div class="absolute top-4 left-4 flex gap-2">
                            @if($product->category)
                                <span class="bg-white/90 backdrop-blur-sm text-cyan-700 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">
                                    {{ $product->category->name }}
                                </span>
                            @endif
                            @if($product->stock > 0)
                                <span class="bg-emerald-500/90 backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 bg-white rounded-full"></span>
                                    Tersedia
                                </span>
                            @else
                                <span class="bg-red-500/90 backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">
                                    Habis
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- RIGHT: PRODUCT INFO --}}
                    <div class="p-6 md:p-10 flex flex-col">

                        {{-- Restaurant info --}}
                        @if($product->restaurant)
                            <a href="{{ route('restaurant.show', $product->restaurant_id) }}"
                                class="flex items-center gap-3 mb-4 p-3 bg-gray-50 rounded-2xl hover:bg-cyan-50 transition group">
                                <div class="w-10 h-10 bg-cyan-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <span class="iconify text-cyan-600" data-icon="mdi:store" data-width="20"></span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-gray-400">Dijual oleh</p>
                                    <p class="text-sm font-semibold text-gray-900 truncate group-hover:text-cyan-600 transition">
                                        {{ $product->restaurant->name }}
                                    </p>
                                </div>
                                <span class="iconify text-gray-300 group-hover:text-cyan-500 transition" data-icon="mdi:chevron-right" data-width="20"></span>
                            </a>
                        @endif

                        {{-- Title --}}
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight">
                            {{ $product->name }}
                        </h1>

                        {{-- Price --}}
                        <div class="flex items-center gap-3 mt-3">
                            <p class="text-2xl md:text-3xl text-cyan-600 font-bold">
                                Rp{{ number_format($product->price, 0, ',', '.') }}
                            </p>
                        </div>

                        {{-- Stock --}}
                        <div class="flex items-center gap-4 mt-4">
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <span class="iconify text-gray-400" data-icon="mdi:package-variant-closed" data-width="18"></span>
                                Stok: <span class="font-bold text-gray-900">{{ $product->stock }}</span>
                            </div>
                        </div>

                        {{-- Divider --}}
                        <hr class="my-5 border-gray-100">

                        {{-- Description --}}
                        <div>
                            <p class="section-label mb-2">Deskripsi</p>
                            <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                                {!! $product->description !!}
                            </div>
                        </div>

                        {{-- Spacer --}}
                        <div class="flex-1"></div>

                        {{-- Quantity --}}
                        <div class="mt-6 flex items-center gap-4">
                            <span class="text-sm font-semibold text-gray-700">Jumlah:</span>
                            <div class="flex items-center bg-gray-50 rounded-xl border border-gray-200 overflow-hidden">
                                <button type="button" id="minusBtn"
                                    class="qty-btn w-10 h-10 flex items-center justify-center text-gray-600 font-bold text-lg hover:bg-cyan-600 hover:text-white transition">
                                    −
                                </button>
                                <input type="number" id="qtyInput" value="1" min="1"
                                    class="w-14 h-10 text-center text-sm font-bold text-gray-900 bg-transparent border-x border-gray-200 outline-none">
                                <button type="button" id="plusBtn"
                                    class="qty-btn w-10 h-10 flex items-center justify-center text-gray-600 font-bold text-lg hover:bg-cyan-600 hover:text-white transition">
                                    +
                                </button>
                            </div>
                        </div>

                        {{-- CTA BUTTONS --}}
                        <div class="flex gap-3 mt-6">
                            <form action="{{ route('checkout') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="selected_products[{{ $product->id}}]" value="{{ $product->id }}">
                                <input type="hidden" id="hiddenQtyCheckout" name="quantity[{{ $product->id }}]" value="1">
                                <input type="hidden" name="restaurant_id" value="{{ $product->restaurant_id }}">
                                <button type="submit"
                                    class="w-full bg-cyan-600 hover:bg-cyan-700 text-white font-semibold py-3 rounded-xl transition flex items-center justify-center gap-2 shadow-lg shadow-cyan-600/20">
                                    <span class="iconify" data-icon="mdi:lightning-bolt" data-width="18"></span>
                                    Pesan Sekarang
                                </button>
                            </form>

                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" id="hiddenQtyCart" name="quantity" value="1">
                                <input type="hidden" name="restaurant_id" value="{{ $product->restaurant_id }}">
                                <button type="submit"
                                    class="cart-btn w-12 h-12 bg-amber-400 hover:bg-amber-500 text-white rounded-xl flex items-center justify-center transition shadow-lg shadow-amber-400/20">
                                    <span class="iconify" data-icon="mdi:cart-plus" data-width="22"></span>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </section>

            {{-- RELATED PRODUCTS --}}
            @if(isset($relatedProducts) && $relatedProducts->count() > 0)
                <section class="mt-10 px-4 md:px-0">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <p class="section-label">Lainnya</p>
                            <h2 class="text-xl font-bold text-gray-900">Produk Serupa</h2>
                        </div>
                        @if($product->restaurant)
                            <a href="{{ route('restaurant.show', $product->restaurant_id) }}"
                                class="text-sm font-semibold text-cyan-600 hover:text-cyan-700 flex items-center gap-1 transition">
                                Lihat Semua
                                <span class="iconify" data-icon="mdi:chevron-right" data-width="16"></span>
                            </a>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach ($relatedProducts as $related)
                            <a href="{{ route('detailProduct.show', $related->id) }}">
                                <div class="product-card bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                                    <div class="relative">
                                        <img src="{{ asset(file_exists(public_path('storage/' . $related->photo)) ? 'storage/' . $related->photo : 'assets/pasar-ikan.png') }}"
                                            alt="{{ $related->name }}" class="w-full h-36 object-cover">
                                    </div>
                                    <div class="p-3">
                                        <h3 class="font-semibold text-gray-900 text-sm truncate mb-0.5">{{ $related->name }}</h3>
                                        <p class="text-gray-400 text-xs truncate mb-2">{{ $related->description }}</p>
                                        <p class="text-cyan-600 font-bold text-sm">
                                            Rp{{ number_format($related->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

        </main>

        {{-- MOBILE NAVBAR --}}
        <x-navbar :cart-count="$cartCount ?? 0" :active-route="'product'" class="block md:hidden" />

    </div>

    <script>
        const qtyInput = document.getElementById('qtyInput');
        const minusBtn = document.getElementById('minusBtn');
        const plusBtn = document.getElementById('plusBtn');
        const hiddenCheckout = document.getElementById('hiddenQtyCheckout');
        const hiddenCart = document.getElementById('hiddenQtyCart');
        const maxStock = {{ $product->stock }};

        function updateQty(value) {
            if (value < 1) value = 1;
            if (value > maxStock) value = maxStock;
            qtyInput.value = value;
            hiddenCheckout.value = value;
            hiddenCart.value = value;
        }

        minusBtn.addEventListener('click', () => {
            updateQty(parseInt(qtyInput.value) - 1);
        });

        plusBtn.addEventListener('click', () => {
            updateQty(parseInt(qtyInput.value) + 1);
        });

        qtyInput.addEventListener('input', () => {
            updateQty(parseInt(qtyInput.value) || 1);
        });
    </script>
</body>

</html>