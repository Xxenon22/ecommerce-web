<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('/logo.jpeg') }}" type="image/png">

    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mau cari apa ?</title>
</head>

<body class="bg-gray-50 min-h-screen">
    <section class="bg-white min-h-screen max-w-5xl mx-auto">

        <!-- HEADER -->
        <header>
            <div class="flex items-center justify-between p-4 bg-white shadow-md sticky top-0 z-20">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                    <span class="iconify text-gray-700" data-icon="weui:back-outlined" data-width="18"></span>
                    <span>Kembali</span>
                </a>

                <!-- SEARCH -->
                <form action="{{ route('search') }}" method="GET" class="relative flex-1 max-w-md mx-4">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari sesuatu..."
                        class="w-full px-4 py-2 pl-10 pr-4 text-gray-700 bg-gray-50 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <span class="iconify absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"
                        data-icon="mdi:magnify"></span>
                </form>
            </div>
        </header>

        <!-- CONTENT -->
        <div class="p-6">

            @if(request()->has('q') && request('q') != '')
                <!-- TITLE -->
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">
                    Hasil Pencarian untuk "{{ request('q') }}"
                </h1>

                <!-- RESULT GRID -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    {{-- ================== PRODUK ================== --}}
                    @forelse ($products as $product)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('logo.jpeg') }}"
                                class="w-full h-48 object-cover">

                            <div class="p-4">
                                <span class="text-xs font-bold text-cyan-600 bg-cyan-50 px-2 py-0.5 rounded-full">
                                    Produk
                                </span>

                                <div class="p-3">
                                    <h3 class="font-semibold text-gray-900 text-sm truncate mb-0.5">{{ $product->name }}
                                    </h3>
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
                        </div>
                    @empty
                    @endforelse


                    {{-- ================== EDUKASI ================== --}}
                    @forelse ($edukasis as $edu)
                        <a href="{{ route('education.show', $edu->id) }}">
                            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                                <img src="{{ $edu->image ? asset('storage/' . $edu->image) : asset('logo.jpeg') }}"
                                    class="w-full h-48 object-cover">

                                <div class="p-4">
                                    <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">
                                        Edukasi
                                    </span>

                                    <h2 class="text-lg font-semibold text-gray-900 mt-2">
                                        {{ $edu->judul }}
                                    </h2>

                                    <p class="text-sm text-gray-600 line-clamp-2">
                                        {!! \Illuminate\Support\Str::limit(strip_tags($edu->content), 60) !!}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @empty
                    @endforelse


                    {{-- ================== RESTORAN ================== --}}
                    @forelse ($restaurants as $resto)
                        <a href="{{ route('restaurant.show', $resto->id) }}">
                            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                                <img src="{{ $resto->image ? asset('storage/' . $resto->image) : asset('logo.jpeg') }}"
                                    class="w-full h-48 object-cover">

                                <div class="p-4">
                                    <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">
                                        Restoran
                                    </span>

                                    <h2 class="text-lg font-semibold text-gray-900 mt-2">
                                        {{ $resto->name }}
                                    </h2>

                                    <p class="text-sm text-gray-600">
                                        {{ $resto->address }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @empty
                    @endforelse

                </div>

                {{-- EMPTY STATE --}}
                @if ($products->isEmpty() && $edukasis->isEmpty() && $restaurants->isEmpty())
                    <div class="flex justify-center items-center text-center mt-10 space-x-1.5">
                        <p class="text-gray-500 text-lg">
                            Tidak ada hasil ditemukan
                        </p>
                        <span class="iconify text-gray-300" data-icon="mdi:robot-confused" data-width="30"></span>
                    </div>
                @endif

            @else

                {{-- ================== BELUM SEARCH ================== --}}
                <div class="flex items-center justify-center text-center mt-20 space-x-1">
                    <span class="iconify text-gray-300" data-icon="mdi:magnify" data-width="25"></span>
                    <p class="text-gray-400 text-lg">
                        Silakan cari sesuatu...
                    </p>
                </div>

            @endif
        </div>

    </section>
</body>

</html>