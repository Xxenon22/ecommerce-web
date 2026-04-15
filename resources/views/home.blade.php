<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - FisheryHub</title>
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

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Carousel */
        .carousel-inner {
            transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        /* Product card */
        .product-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        /* Category pill */
        .cat-pill {
            transition: all 0.2s ease;
        }

        .cat-pill:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(8, 145, 178, 0.2);
            border-color: var(--cyan);
        }

        /* Resto card */
        .resto-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .resto-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.1);
        }

        /* Sidebar */
        #sidebar {
            transition: transform 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        #overlay {
            transition: opacity 0.3s ease;
        }

        /* Fade in up animation */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-up {
            animation: fadeUp 0.5s ease forwards;
        }

        .fade-up-1 {
            animation-delay: 0.05s;
        }

        .fade-up-2 {
            animation-delay: 0.1s;
        }

        .fade-up-3 {
            animation-delay: 0.15s;
        }

        .fade-up-4 {
            animation-delay: 0.2s;
        }

        /* Section title accent */
        .section-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--cyan);
        }

        /* Search bar */
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

        /* Add to cart button pulse */
        .cart-btn {
            transition: all 0.15s ease;
        }

        .cart-btn:active {
            transform: scale(0.92);
        }

        /* Gradient overlay */
        .gradient-overlay {
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.2) 50%, transparent 100%);
        }

        /* Edu card */
        .edu-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .edu-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        }

        /* Nav badge */
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

        {{-- ═══════════════════════════════════════
        SIDEBAR
        ═══════════════════════════════════════ --}}
        <div id="sidebar"
            class="fixed inset-0 bg-[#0a1628] text-white transform -translate-x-full z-50 flex flex-col md:hidden">
            <div class="p-6 flex flex-col h-full">

                {{-- Close --}}
                <button id="close-sidebar"
                    class="self-end w-9 h-9 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition mb-6">
                    <span class="iconify" data-icon="mdi:close" data-width="20"></span>
                </button>

                {{-- User --}}
                <div class="flex items-center gap-4 mb-8 p-4 bg-white/5 rounded-2xl">
                    @if (Auth::check() && Auth::user()->photo)
                    <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="User"
                        class="w-12 h-12 rounded-full border-2 border-cyan-400 object-cover">
                    @else
                    <div class="w-12 h-12 rounded-full bg-cyan-500/20 flex items-center justify-center">
                        <span class="iconify text-cyan-400" data-icon="mdi:account" data-width="28"></span>
                    </div>
                    @endif
                    <div>
                        <p class="text-xs text-gray-400">Selamat datang</p>
                        <p class="font-semibold text-white">{{ Auth::user()->name ?? 'Username' }}</p>
                    </div>
                </div>

                {{-- Nav --}}
                <nav class="flex-1 space-y-1">
                    @php
                    $navItems = [
                    ['href' => route('home'), 'icon' => 'mdi:home-outline', 'label' => 'Home'],
                    ['href' => '#', 'icon' => 'mdi:bell-outline', 'label' => 'Notifikasi'],
                    ['href' => '#', 'icon' => 'mdi:star-outline', 'label' => 'Beri Rating'],
                    ['href' => '#', 'icon' => 'mdi:ticket-percent-outline', 'label' => 'Kupon'],
                    ['href' => '#', 'icon' => 'mdi:help-circle-outline', 'label' => 'Pusat Bantuan'],
                    ];
                    @endphp
                    @if (Auth::check() && Auth::user()->role === 'Admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition text-sm font-medium">
                        <span class="iconify text-cyan-400" data-icon="mdi:office-building" data-width="20"></span>
                        Admin Page
                    </a>
                    @endif
                    @foreach ($navItems as $item)
                    <a href="{{ $item['href'] }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition text-sm font-medium">
                        <span class="iconify text-cyan-400" data-icon="{{ $item['icon'] }}" data-width="20"></span>
                        {{ $item['label'] }}
                    </a>
                    @endforeach
                </nav>

                {{-- Logout --}}
                <div class="mt-4 pt-4 border-t border-white/10">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-500/10 transition text-sm font-medium text-red-400 w-full">
                            <span class="iconify" data-icon="mdi:logout" data-width="20"></span>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Overlay --}}
        <div id="overlay" class="fixed inset-0 bg-black/50 hidden z-40"></div>

        {{-- ═══════════════════════════════════════
        MOBILE HEADER
        ═══════════════════════════════════════ --}}
        <header class="sticky top-0 z-30 bg-white border-b border-gray-100 shadow-sm md:hidden">
            <div class="flex items-center gap-3 px-4 py-3">
                <button id="open-sidebar"
                    class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-gray-100 transition flex-shrink-0">
                    <span class="iconify text-gray-700" data-icon="mdi:menu" data-width="22"></span>
                </button>

                <div class="search-bar flex items-center flex-1 px-4 py-2 gap-2">
                    <span class="iconify text-gray-400" data-icon="mdi:magnify" data-width="18"></span>
                    <input type="text" placeholder="Cari produk segar..."
                        class="bg-transparent text-sm text-gray-700 placeholder-gray-400 outline-none flex-1">
                </div>

                <a href="{{ route('cart') }}"
                    class="relative w-9 h-9 flex items-center justify-center rounded-xl hover:bg-gray-100 transition flex-shrink-0">
                    <span class="iconify text-gray-700" data-icon="mdi:cart-outline" data-width="22"></span>
                    <span class="nav-badge">{{ $cartCount ?? 0 }}</span>
                </a>
            </div>
        </header>

        {{-- ═══════════════════════════════════════
         DESKTOP HEADER
    ═══════════════════════════════════════ --}}
        <header class="hidden md:flex items-center justify-between px-8 py-4 bg-white border-b border-gray-100 shadow-sm sticky top-0 z-30">
            <div class="flex items-center gap-8">
                {{-- <img src="{{ asset('logo.jpeg') }}" alt="" width=""> --}}
                {{-- <img src="{{ asset('logo.jpeg') }}" alt="Logo" class="h-10 w-auto object-contain"> --}}
                <span class="font-display text-2xl text-cyan-600 italic">FisheryHub</span>
                <nav class="flex gap-6">
                    <a href="{{ route('home') }}" class="text-sm font-semibold text-cyan-600 border-b-2 border-cyan-600 pb-0.5">Home</a>
                    <a href="{{ route('category') }}" class="text-sm font-medium text-gray-500 hover:text-gray-800 transition">Kategori</a>
                    <a href="{{ route('home-resto') }}" class="text-sm font-medium text-gray-500 hover:text-gray-800 transition">Restoran</a>
                    @if(Auth::check() && Auth::user()->role === 'Admin')
                    <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-gray-800 transition">Admin Page</a>
                    @endif
                </nav>
            </div>

            <div class="flex items-center gap-4">
                <div class="search-bar flex items-center w-72 px-4 py-2 gap-2">
                    <span class="iconify text-gray-400" data-icon="mdi:magnify" data-width="18"></span>
                    <input type="text" placeholder="Cari produk segar..."
                        class="bg-transparent text-sm text-gray-700 placeholder-gray-400 outline-none flex-1">
                </div>

                <a href="{{ route('cart') }}"
                    class="relative w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 transition">
                    <span class="iconify text-gray-700" data-icon="mdi:cart-outline" data-width="22"></span>
                    <span class="nav-badge">{{ $cartCount ?? 0 }}</span>
                </a>
                <a href="{{ route('history') }}"
                    class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 transition">
                    <span class="iconify text-gray-700" data-icon="mdi:clipboard-text-outline" data-width="22"></span>
                </a>
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
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="text-sm font-medium text-red-400 hover:text-red-600 transition">Keluar</button>
                </form>
            </div>
        </header>

        <main class="max-w-7xl mx-auto">

            {{-- ═══════════════════════════════════════
            CAROUSEL
            ═══════════════════════════════════════ --}}
            <section class="relative overflow-hidden mt-4 mx-4 rounded-3xl shadow-xl">
                <div class="flex transition-transform duration-600 ease-out" id="carousel-slides">

                    <div class="flex-shrink-0 w-full h-56 md:h-[480px] bg-cover bg-center relative"
                        style="background-image: url('{{ asset('assets/pasar-ikan.png') }}');">
                        <div class="absolute inset-0 gradient-overlay rounded-3xl"></div>
                        <div class="absolute bottom-8 left-8 right-8">
                            <p class="section-label text-white/70 mb-2">Produk Segar</p>
                            <h2
                                class="font-display text-white text-3xl md:text-6xl italic transform translate-x-full opacity-0 transition-all duration-500">
                                Fresh Seafood Market
                            </h2>
                        </div>
                    </div>

                    <div class="flex-shrink-0 w-full h-56 md:h-[480px] relative"
                        style="background: linear-gradient(135deg, #0369a1, #0891b2, #06b6d4);">
                        <div class="absolute inset-0 opacity-10"
                            style="background-image: radial-gradient(circle at 20% 80%, white 1px, transparent 1px), radial-gradient(circle at 80% 20%, white 1px, transparent 1px); background-size: 40px 40px;">
                        </div>
                        <div class="absolute bottom-8 left-8 right-8">
                            <p class="section-label text-white/70 mb-2">Pengiriman Cepat</p>
                            <h2
                                class="font-display text-white text-3xl md:text-6xl italic transform translate-x-full opacity-0 transition-all duration-500">
                                Delivered to Your Door
                            </h2>
                        </div>
                    </div>

                    <div class="flex-shrink-0 w-full h-56 md:h-[480px] relative"
                        style="background: linear-gradient(135deg, #065f46, #059669, #34d399);">
                        <div class="absolute inset-0 opacity-10"
                            style="background-image: radial-gradient(circle at 20% 80%, white 1px, transparent 1px); background-size: 30px 30px;">
                        </div>
                        <div class="absolute bottom-8 left-8 right-8">
                            <p class="section-label text-white/70 mb-2">Terpercaya</p>
                            <h2
                                class="font-display text-white text-3xl md:text-6xl italic transform translate-x-full opacity-0 transition-all duration-500">
                                Quality You Can Trust
                            </h2>
                        </div>
                    </div>
                </div>

                {{-- Prev/Next --}}
                <button id="prev-btn"
                    class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/20 hover:bg-white/40 backdrop-blur-sm rounded-full flex items-center justify-center transition">
                    <span class="iconify text-white" data-icon="mdi:chevron-left" data-width="22"></span>
                </button>
                <button id="next-btn"
                    class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/20 hover:bg-white/40 backdrop-blur-sm rounded-full flex items-center justify-center transition">
                    <span class="iconify text-white" data-icon="mdi:chevron-right" data-width="22"></span>
                </button>

                {{-- Dots --}}
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2" id="carousel-dots">
                    <span class="w-6 h-1.5 bg-white rounded-full transition-all dot"></span>
                    <span class="w-1.5 h-1.5 bg-white/50 rounded-full transition-all dot"></span>
                    <span class="w-1.5 h-1.5 bg-white/50 rounded-full transition-all dot"></span>
                </div>
            </section>

            {{-- ═══════════════════════════════════════
            KATEGORI
            ═══════════════════════════════════════ --}}
            <section class="mt-8 px-4 md:px-8">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <p class="section-label">Jelajahi</p>
                        <h2 class="text-xl font-bold text-gray-900">Pilihan Kategori</h2>
                    </div>
                    <a href="{{ route('category') }}"
                        class="text-sm font-semibold text-cyan-600 hover:text-cyan-700 flex items-center gap-1 transition">
                        Lihat Semua
                        <span class="iconify" data-icon="mdi:chevron-right" data-width="16"></span>
                    </a>
                </div>

                <div class="flex gap-3 overflow-x-auto scrollbar-hide pb-2">
                    @foreach ($categories as $category)
                    <a href="/category/{{ $category->id }}"
                        class="cat-pill flex-shrink-0 flex flex-col items-center gap-2 bg-white border border-gray-100 rounded-2xl px-4 py-3 shadow-sm w-25">
                        <div class="w-10 h-10 bg-cyan-50 rounded-xl flex items-center justify-center">
                            <span class="iconify text-cyan-600" data-icon="{{ $category->icon }}" data-width="20"></span>
                        </div>
                        <span class="text-gray-700 text-xs font-semibold text-center leading-tight">{{ $category->name }}</span>
                    </a>
                    @endforeach
                </div>
            </section>

            {{-- ═══════════════════════════════════════
            PRODUK
            ═══════════════════════════════════════ --}}
            <section class="mt-8 px-4 md:px-8">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <p class="section-label">Terlaris</p>
                        <h2 class="text-xl font-bold text-gray-900">Pilihan Produk</h2>
                    </div>
                    <a href="#"
                        class="text-sm font-semibold text-cyan-600 hover:text-cyan-700 flex items-center gap-1 transition">
                        Lihat Semua
                        <span class="iconify" data-icon="mdi:chevron-right" data-width="16"></span>
                    </a>
                </div>

                <div class="flex gap-4 overflow-x-auto scrollbar-hide pb-4">
                    @foreach ($products as $product)
                    <div
                        class="product-card flex-shrink-0 w-52 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden fade-up">
                        <div class="relative">
                            <img src="{{ asset(file_exists(public_path('storage/' . $product->photo)) ? 'storage/' . $product->photo : 'assets/pasar-ikan.png') }}"
                                alt="{{ $product->name }}" class="w-full h-36 object-cover">
                            <div class="absolute top-2 right-2">
                                <span
                                    class="bg-white/90 backdrop-blur-sm text-cyan-700 text-xs font-bold px-2 py-1 rounded-full shadow-sm">
                                    Segar
                                </span>
                            </div>
                        </div>
                        <div class="p-3">
                            <h3 class="font-semibold text-gray-900 text-sm truncate mb-0.5">{{ $product->name }}</h3>
                            <p class="text-gray-400 text-xs truncate mb-2">{{ $product->description }}</p>
                            <p class="text-cyan-600 font-bold text-sm mb-3">
                                Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                            <div class="flex gap-2">

                                <form action="{{ route('checkout') }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="selected_products[{{ $product->id}}]"
                                        value="{{ $product->id }}">
                                    <input type="hidden" name="quantity[{{ $product->id }}]" value="1">
                                    <input type="hidden" name="restaurant_id" value="{{ $product->restaurant_id }}">
                                    <button type="submit"
                                        class="w-full bg-cyan-600 hover:bg-cyan-700 text-white text-xs font-semibold py-2 rounded-xl transition">
                                        Pesan
                                    </button>
                                </form>

                                <form action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="restaurant_id" value="{{ $product->restaurant_id }}">
                                    <button type="submit"
                                        class="cart-btn w-9 h-9 bg-amber-400 hover:bg-amber-500 text-white rounded-xl flex items-center justify-center transition">
                                        <span class="iconify" data-icon="mdi:cart-plus" data-width="16"></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

            {{-- ═══════════════════════════════════════
            SPESIAL HARI INI
            ═══════════════════════════════════════ --}}
            <section class="mt-8 px-4 md:px-8">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <p class="section-label">Promo</p>
                        <h2 class="text-xl font-bold text-gray-900">Spesial Hari Ini</h2>
                    </div>
                    <span class="text-sm font-semibold text-cyan-600 cursor-pointer hover:text-cyan-700">Lihat
                        Semua</span>
                </div>

                <div class="relative rounded-3xl overflow-hidden h-64 md:h-96 shadow-xl">
                    <img src="{{ asset('assets/bg-pasar-ikan.jpg') }}" alt="Banner" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/30 to-transparent"></div>

                    <div class="absolute inset-0 flex items-center justify-between px-8">
                        <div>
                            <p class="section-label text-white/60 mb-1">Rekomendasi Chef</p>
                            <h1 class="font-display text-white text-4xl md:text-6xl italic leading-tight mb-2">
                                The Best<br>Dinner
                            </h1>
                            <p class="text-white/70 text-sm md:text-base">Hidangan laut segar terbaik</p>
                        </div>

                        <a href="{{ route('produk', 'Cumi Krispy') }}"
                            class="bg-white rounded-2xl overflow-hidden shadow-xl w-36 md:w-48 flex-shrink-0 hover:shadow-2xl transition transform hover:-translate-y-1">
                            <img src="{{ asset(file_exists(public_path('assets/cumi-krispy.jpg')) ? 'assets/cumi-krispy.jpg' : 'assets/pasar-ikan.png') }}"
                                alt="Cumi Krispy" class="w-full h-24 md:h-32 object-cover">
                            <div class="p-3">
                                <h2 class="font-semibold text-gray-900 text-sm">Cumi Krispy</h2>
                                <p class="text-cyan-600 font-bold text-sm">Rp15.000</p>
                                <button
                                    class="bg-cyan-600 text-white text-xs font-semibold mt-2 py-1.5 rounded-xl w-full hover:bg-cyan-700 transition">
                                    Tambah
                                </button>
                            </div>
                        </a>
                    </div>
                </div>
            </section>

            {{-- ═══════════════════════════════════════
            EDUKASI & RESEP
            ═══════════════════════════════════════ --}}
            <section class="mt-8 px-4 md:px-8">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <p class="section-label">Belajar</p>
                        <h2 class="text-xl font-bold text-gray-900">Edukasi & Resep</h2>
                    </div>
                    <a href="#" class="text-sm font-semibold text-cyan-600 hover:text-cyan-700 flex items-center gap-1">
                        Lihat Semua <span class="iconify" data-icon="mdi:chevron-right" data-width="16"></span>
                    </a>
                </div>

                <div class="grid md:grid-cols-2 gap-3">
                    <a href="{{ route('education') }}"
                        class="edu-card flex bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <img src="{{ asset(file_exists(public_path('assets/edukasi-ikan.jpg')) ? 'assets/edukasi-ikan.jpg' : 'assets/pasar-ikan.png') }}"
                            alt="Edukasi Ikan" class="w-28 h-full object-cover flex-shrink-0">
                        <div class="p-4 flex flex-col justify-between flex-1">
                            <div>
                                <span
                                    class="text-xs font-bold text-cyan-600 bg-cyan-50 px-2 py-0.5 rounded-full">Edukasi</span>
                                <h2 class="font-semibold text-gray-900 text-sm mt-1 leading-tight">Cara menangkap ikan
                                    yang benar</h2>
                                <p class="text-gray-400 text-xs mt-0.5">Sesuai peraturan yang ada</p>
                            </div>
                            <span class="text-xs font-semibold text-cyan-600 flex items-center gap-1 mt-2">
                                Baca selengkapnya <span class="iconify" data-icon="mdi:arrow-right"
                                    data-width="14"></span>
                            </span>
                        </div>
                    </a>

                    <a href="{{ route('edukasi') }}"
                        class="edu-card flex bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <img src="{{ asset(file_exists(public_path('assets/edukasi-gizi.jpg')) ? 'assets/edukasi-gizi.jpg' : 'assets/pasar-ikan.png') }}"
                            alt="Gizi" class="w-28 h-full object-cover flex-shrink-0">
                        <div class="p-4 flex flex-col justify-between flex-1">
                            <div>
                                <span
                                    class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Nutrisi</span>
                                <h2 class="font-semibold text-gray-900 text-sm mt-1 leading-tight">Pentingnya Gizi
                                    Makanan Laut</h2>
                                <p class="text-gray-400 text-xs mt-0.5">Apa saja kelebihannya?</p>
                            </div>
                            <span class="text-xs font-semibold text-cyan-600 flex items-center gap-1 mt-2">
                                Baca selengkapnya <span class="iconify" data-icon="mdi:arrow-right"
                                    data-width="14"></span>
                            </span>
                        </div>
                    </a>
                </div>
            </section>

            {{-- ═══════════════════════════════════════
            REKOMENDASI RESTO
            ═══════════════════════════════════════ --}}
            <section class="mt-8 px-4 md:px-8 mb-10">
                <div class="mb-4">
                    <p class="section-label">Pilihan</p>
                    <h2 class="text-xl font-bold text-gray-900">Rekomendasi Restoran</h2>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($restaurants as $resto)
                    <a href="{{ route('restaurant', $resto->id) }}"
                        class="resto-card bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="relative h-36 overflow-hidden">
                            <img src="{{ $resto->photo != NULL ? 'assets/' . $resto->photo : asset('assets/pasar-ikan.png') }}"
                                alt="{{ $resto->name }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                        </div>
                        <div class="p-4">
                            <h2 class="font-bold text-gray-900 text-base mb-1">{{ $resto->name }}</h2>
                            <p class="text-gray-500 text-xs flex items-start gap-1 mb-3">
                                <span class="iconify text-gray-400 flex-shrink-0 mt-0.5"
                                    data-icon="mdi:map-marker-outline" data-width="14"></span>
                                {{ $resto->address }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span
                                    class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                    Buka
                                </span>
                                <span class="text-xs font-semibold text-cyan-600 flex items-center gap-1">
                                    Kunjungi <span class="iconify" data-icon="mdi:arrow-right" data-width="14"></span>
                                </span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </section>

        </main>

        <x-navbar :cart-count="$cartCount ?? 0" :active-route="'home'" class="block md:hidden" />

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        // ── Carousel ──────────────────────────────────────────────────
        const slides = document.getElementById('carousel-slides');
        const dots = document.querySelectorAll('.dot');
        const totalSlides = slides.children.length;
        let current = 0;

        function goTo(index) {
            current = (index + totalSlides) % totalSlides;
            slides.style.transform = `translateX(-${current * 100}%)`;

            // Animate heading
            document.querySelectorAll('#carousel-slides h2').forEach((h, i) => {
                h.classList.remove('translate-x-0', 'opacity-100');
                h.classList.add('translate-x-full', 'opacity-0');
            });
            setTimeout(() => {
                const h = slides.children[current].querySelector('h2');
                h.classList.remove('translate-x-full', 'opacity-0');
                h.classList.add('translate-x-0', 'opacity-100');
            }, 100);

            // Dots
            dots.forEach((d, i) => {
                d.className = i === current ?
                    'w-6 h-1.5 bg-white rounded-full transition-all dot' :
                    'w-1.5 h-1.5 bg-white/50 rounded-full transition-all dot';
            });
        }

        document.getElementById('prev-btn').addEventListener('click', () => goTo(current - 1));
        document.getElementById('next-btn').addEventListener('click', () => goTo(current + 1));
        setInterval(() => goTo(current + 1), 5000);
        goTo(0);

        // ── Sidebar ───────────────────────────────────────────────────
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        document.getElementById('open-sidebar').addEventListener('click', openSidebar);
        document.getElementById('close-sidebar').addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);
    </script>
</body>

</html>