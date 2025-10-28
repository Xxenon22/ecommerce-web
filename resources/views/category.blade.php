<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori - AquaTech Fresh</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Handle category filtering from URL parameter
            const urlParams = new URLSearchParams(window.location.search);
            const selectedCategory = urlParams.get('category');
            if (selectedCategory) {
                showCategorySection(selectedCategory);
            }

            // Handle "Lihat Semua" links
            const lihatSemuaLinks = document.querySelectorAll('.lihat-semua-link');
            lihatSemuaLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    const section = this.closest('.product-section');
                    const carousel = section.querySelector('.product-carousel');
                    const productInner = section.querySelector('.product-inner');
                    const buttons = section.querySelectorAll('.carousel-btn');

                    // Toggle between carousel and grid view
                    if (productInner.classList.contains('flex')) {
                        // Switch to grid view
                        productInner.classList.remove('flex', 'transition-transform', 'duration-500', 'ease-in-out');
                        productInner.classList.add('grid', 'grid-cols-2', 'gap-4');
                        productInner.style.transform = 'none';
                        buttons.forEach(btn => btn.style.display = 'none');
                        this.textContent = 'Kembali';
                    } else {
                        // Switch back to carousel view
                        productInner.classList.remove('grid', 'grid-cols-2', 'gap-4');
                        productInner.classList.add('flex', 'transition-transform', 'duration-500', 'ease-in-out');
                        buttons.forEach(btn => btn.style.display = 'block');
                        this.textContent = 'Lihat Semua';
                    }
                });
            });
        });

        function showCategorySection(category) {
            const productSections = document.querySelectorAll('.product-section');
            productSections.forEach(section => {
                if (category === 'Semua') {
                    section.style.display = 'block';
                } else if (section.getAttribute('data-category') === category) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });
        }
    </script>

</head>

<body class="bg-gray-200">
    <div class="header flex items-center justify-between p-4 ">
        <a href="{{ route('home') }}">
            <span class="iconify cursor-pointer" data-icon="weui:back-outlined" data-width="38" data-height="38"
                class="cursor-pointer"></span>
        </a>
        <div class="relative flex-1 max-w-md mx-4">
            <input type="text" placeholder="Cari produk segar disini..."
                class="w-full px-4 py-2 pl-10 pr-4 text-gray-700 bg-gray-50 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <span class="iconify absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"
                data-icon="mdi:magnify" data-width="20" data-height="20"></span>
        </div>
    </div>


    <x-navbar :cart-count="5" :active-route="'category'" />
    <x-category :cart-count="5" />

    <div id="product-sections">
        @foreach($products as $category => $categoryProducts)
            <!-- Filter Card untuk {{ $category }} -->
            <div class="bg-white p-1 mt-5 product-section" data-category="{{ $category }}" style="display: block">
                <div class="mt-3">
                    <div class="flex justify-between m-2">
                        <h1 class="text-neutral-300 font-bold">{{ $category }}</h1>
                        <a href="#" class="text-cyan-600 lihat-semua-link">Lihat Semua</a>
                    </div>

                    <!-- Product Carousel -->
                    <div class="product-carousel relative overflow-hidden mx-2">
                        <div class="product-inner flex transition-transform duration-500 ease-in-out"
                            id="product-slides-{{ $loop->index }}">
                            @foreach($categoryProducts as $product)
                                <div class="product-slide flex-shrink-0 w-40 mx-1">
                                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                                        <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}"
                                            class="w-full h-24 object-cover">
                                        <div class="p-3">
                                            <h2 class="text-sm font-semibold">{{ $product['name'] }}</h2>
                                            <p class="text-red-500 font-bold text-sm">{{ $product['price'] }}</p>
                                            <button
                                                class="bg-cyan-600 text-white text-sm mt-2 px-3 py-1 rounded w-full">Tambah</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button
                            class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-75 hover:bg-opacity-100 rounded-full p-2 shadow-md carousel-btn"
                            id="product-prev-btn-{{ $loop->index }}">
                            <span class="iconify" data-icon="mdi:chevron-left" data-width="20" data-height="20"></span>
                        </button>
                        <button
                            class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-75 hover:bg-opacity-100 rounded-full p-2 shadow-md carousel-btn"
                            id="product-next-btn-{{ $loop->index }}">
                            <span class="iconify" data-icon="mdi:chevron-right" data-width="20" data-height="20"></span>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</body>

</html>