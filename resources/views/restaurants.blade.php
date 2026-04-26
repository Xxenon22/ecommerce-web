<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restoran - Fishery Hub</title>
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

        .resto-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .resto-card:hover {
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
                <a href="{{ route('home') }}" class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-gray-100 transition flex-shrink-0">
                    <span class="iconify text-gray-700" data-icon="weui:back-outlined" data-width="22"></span>
                </a>

                <div class="search-bar flex items-center flex-1 px-4 py-2 gap-2">
                    <span class="iconify text-gray-400" data-icon="mdi:magnify" data-width="18"></span>
                    <input type="text" placeholder="Cari restoran..." class="bg-transparent text-sm text-gray-700 placeholder-gray-400 outline-none flex-1">
                </div>

                <a href="{{ route('cart') }}" class="relative w-9 h-9 flex items-center justify-center rounded-xl hover:bg-gray-100 transition flex-shrink-0">
                    <span class="iconify text-gray-700" data-icon="mdi:cart-outline" data-width="22"></span>
                    <span class="nav-badge">{{ $cartCount ?? 0 }}</span>
                </a>
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
                    <input type="text" placeholder="Cari restoran..." class="bg-transparent text-sm text-gray-700 placeholder-gray-400 outline-none flex-1">
                </div>

                <a href="{{ route('cart') }}" class="relative w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 transition">
                    <span class="iconify text-gray-700" data-icon="mdi:cart-outline" data-width="22"></span>
                    <span class="nav-badge">{{ $cartCount ?? 0 }}</span>
                </a>
            </div>
        </header>

        <main class="px-4 md:px-8 mt-8 mb-10">
            <div class="mb-6 flex justify-between items-end">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Daftar Restoran</h1>
                    <p class="text-gray-500 text-sm mt-1">Temukan kualitas laut terbaik dari mitra kami.</p>
                </div>
            </div>

            @if($restaurants->isEmpty())
            <div class="text-center py-16 bg-white rounded-3xl border border-gray-100 shadow-sm">
                <span class="iconify mx-auto text-gray-300 mb-4" data-icon="mdi:store-off-outline" data-width="64"></span>
                <h3 class="text-lg font-semibold text-gray-900">Belum ada restoran</h3>
                <p class="text-gray-500 mt-2">Daftar restoran belum tersedia saat ini.</p>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($restaurants as $resto)
                <a href="{{ route('restaurant.show', $resto->id) }}" class="resto-card bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
                    <div class="relative h-48 overflow-hidden flex-shrink-0">
                        <img src="{{ !is_null($resto->photo) ? asset('storage/'. $resto->photo) : 'assets/pasar-ikan.png' }}"
                            alt="{{ $resto->name }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between">
                            <span class="bg-white/90 backdrop-blur-sm text-gray-900 text-xs font-bold px-2 py-1 rounded-lg flex items-center gap-1 shadow-sm">
                                <span class="iconify text-yellow-500" data-icon="mdi:star" data-width="14"></span>
                                5.0
                            </span>
                            <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg flex items-center gap-1">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                Buka
                            </span>
                        </div>
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <h2 class="font-bold text-gray-900 text-lg mb-1">{{ $resto->name }}</h2>
                        <p class="text-gray-500 text-sm flex items-start gap-1 mb-4 flex-1">
                            <span class="iconify text-gray-400 flex-shrink-0 mt-0.5" data-icon="mdi:map-marker-outline" data-width="16"></span>
                            <span class="line-clamp-2">{{ $resto->address }}</span>
                        </p>

                        <div class="flex gap-4 pt-4 border-t border-gray-100 mt-auto">
                            <div class="text-center flex-1 border-r border-gray-100">
                                <p class="text-gray-400 text-xs">Buka</p>
                                <p class="text-gray-900 text-sm font-semibold mt-0.5">{{ $resto->open_time ?? '08:00' }}</p>
                            </div>
                            <div class="text-center flex-1">
                                <p class="text-gray-400 text-xs">Tutup</p>
                                <p class="text-gray-900 text-sm font-semibold mt-0.5">{{ $resto->close_time ?? '22:00' }}</p>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
        </main>

        {{-- MOBILE NAVBAR COMPONENT FALLBACK (Assuming similar to others) --}}
        <x-navbar :cart-count="$cartCount ?? 0" :active-route="'restaurant'" class="block md:hidden" />

    </div>
</body>

</html>