<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Resto kamu</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
</head>

<body>
    <header class="flex items-center justify-between p-4 bg-white shadow-md sticky top-0 z-20">
        <a href="{{ route('home') }}">
            <span class="iconify cursor-pointer" data-icon="weui:back-outlined" data-width="38" data-height="38"></span>
        </a>

        <div class="relative flex-1 max-w-md mx-4">
            <input type="text" placeholder="Cari produk segar disini..."
                class="w-full px-4 py-2 pl-10 pr-4 text-gray-700 bg-gray-50 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <span class="ico=nify absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"
                data-icon="mdi:magnify" data-width="20" data-height="20"></span>
        </div>

        <div class="relative ml-4">
            <button id="dropdownButton" class="flex items-center">
                <span class="iconify cursor-pointer text-gray-600 hover:text-cyan-600" data-icon="mdi:cog"
                    data-width="32" data-height="32"></span>
            </button>

            <!-- Dropdown Menu -->
            <div id="dropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50 hidden">
                <div class="py-1">
                    <a href="{{ route('profileResto') }}"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <span class="iconify mr-3" data-icon="mdi:account" data-width="20" data-height="20"></span>
                        Profile
                    </a>
                    <a href="{{ route('tambah-menu') }}"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <span class="iconify mr-3" data-icon="mdi:plus" data-width="20" data-height="20"></span>
                        Tambah Menu
                    </a>
                    <hr class="my-1">
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            <span class="iconify mr-3" data-icon="mdi:logout" data-width="20" data-height="20"></span>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="p-4">
        <h1 class="text-2xl font-bold mb-6">Menu Restoran Saya</h1>

        @if($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="aspect-w-16 aspect-h-9">
                            @if($product->photo)
                                <img src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->name }}"
                                    class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="iconify text-gray-400" data-icon="mdi:image-off" data-width="48"
                                        data-height="48"></span>
                                </div>
                            @endif
                        </div>

                        <div class="p-4">
                            <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $product->name }}</h2>
                            <p class="text-cyan-600 font-bold text-lg mb-2">Rp{{ number_format($product->price, 0, ',', '.') }}
                            </p>

                            @if($product->description)
                                <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $product->description }}</p>
                            @endif

                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">{{ $product->category->name ?? 'Kategori' }}</span>
                                <span class="text-sm text-gray-500">Stok: {{ $product->stock }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <span class="iconify text-gray-400 mb-4" data-icon="mdi:food-off" data-width="64" data-height="64"></span>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada menu</h3>
                <p class="text-gray-500">Tambahkan menu pertama Anda untuk memulai</p>
            </div>
        @endif
    </main>

    <script>
        // Dropdown toggle functionality
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');

        dropdownButton.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdownMenu.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function (e) {
            if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });

        // Close dropdown when pressing Escape
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                dropdownMenu.classList.add('hidden');
            }
        });
    </script>
</body>

</html>