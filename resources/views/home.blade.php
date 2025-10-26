<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - AquaTech Fresh</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const carouselSlides = document.getElementById('carousel-slides');
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');
            let currentIndex = 0;
            const totalSlides = carouselSlides.children.length;

            function updateCarousel() {
                carouselSlides.style.transform = `translateX(-${currentIndex * 100}%)`;
                // Reset all text animations
                const texts = carouselSlides.querySelectorAll('h2');
                texts.forEach(text => {
                    text.classList.remove('translate-x-0', 'opacity-100');
                    text.classList.add('translate-x-full', 'opacity-0');
                });
                // Animate current slide text
                setTimeout(() => {
                    const currentText = carouselSlides.children[currentIndex].querySelector('h2');
                    currentText.classList.remove('translate-x-full', 'opacity-0');
                    currentText.classList.add('translate-x-0', 'opacity-100');
                }, 100);
            }

            prevBtn.addEventListener('click', function () {
                currentIndex = (currentIndex > 0) ? currentIndex - 1 : totalSlides - 1;
                updateCarousel();
            });

            nextBtn.addEventListener('click', function () {
                currentIndex = (currentIndex < totalSlides - 1) ? currentIndex + 1 : 0;
                updateCarousel();
            });

            // Auto-play carousel
            setInterval(function () {
                currentIndex = (currentIndex < totalSlides - 1) ? currentIndex + 1 : 0;
                updateCarousel();
            }, 5000);

            // Categories carousel functionality
            const categoriesSlides = document.getElementById('categories-slides');
            const categoriesPrevBtn = document.getElementById('categories-prev-btn');
            const categoriesNextBtn = document.getElementById('categories-next-btn');
            let categoriesCurrentIndex = 0;
            const categoriesTotalSlides = categoriesSlides.children.length;
            const categoriesVisibleSlides = 3; // Number of slides visible at once

            function updateCategoriesCarousel() {
                const maxIndex = categoriesTotalSlides - categoriesVisibleSlides;
                categoriesCurrentIndex = Math.max(0, Math.min(categoriesCurrentIndex, maxIndex));
                categoriesSlides.style.transform = `translateX(-${categoriesCurrentIndex * (100 / categoriesVisibleSlides)}%)`;
            }

            categoriesPrevBtn.addEventListener('click', function () {
                categoriesCurrentIndex = Math.max(0, categoriesCurrentIndex - 1);
                updateCategoriesCarousel();
            });

            categoriesNextBtn.addEventListener('click', function () {
                const maxIndex = categoriesTotalSlides - categoriesVisibleSlides;
                categoriesCurrentIndex = Math.min(maxIndex, categoriesCurrentIndex + 1);
                updateCategoriesCarousel();
            });
        });
    </script>
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="header flex items-center justify-between p-4 bg-white shadow-md">
        <span class="iconify" data-icon="fe:bar" data-width="38" data-height="38" class="cursor-pointer"></span>
        <div class="relative flex-1 max-w-md mx-4">
            <input type="text" placeholder="Cari produk segar disini..."
                class="w-full px-4 py-2 pl-10 pr-4 text-gray-700 bg-gray-50 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <span class="iconify absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"
                data-icon="mdi:magnify" data-width="20" data-height="20"></span>
        </div>
        <span class="iconify" data-icon="mynaui:envelope" data-width="38" data-height="38"
            class="cursor-pointer"></span>
    </div>

    <!-- Carousel -->
    <div class="carousel relative overflow-hidden">
        <div class="carousel-inner flex transition-transform duration-500 ease-in-out" id="carousel-slides">
            <div class="carousel-slide flex-shrink-0 w-full h-64 bg-cover bg-center"
                style="background-image: url('{{ asset('assets/pasar-ikan.png') }}');">
                <div class="flex items-center justify-center h-full bg-black bg-opacity-50">
                    <h2
                        class="text-white text-3xl font-bold transform translate-x-full opacity-0 transition-all duration-500">
                        Fresh Seafood Market</h2>
                </div>
            </div>
            <div class="carousel-slide flex-shrink-0 w-full h-64 bg-gradient-to-r from-blue-400 to-blue-600">
                <div class="flex items-center justify-center h-full">
                    <h2
                        class="text-white text-3xl font-bold transform translate-x-full opacity-0 transition-all duration-500">
                        Delivered to Your Door</h2>
                </div>
            </div>
            <div class="carousel-slide flex-shrink-0 w-full h-64 bg-gradient-to-r from-green-400 to-green-600">
                <div class="flex items-center justify-center h-full">
                    <h2
                        class="text-white text-3xl font-bold transform translate-x-full opacity-0 transition-all duration-500">
                        Quality You Can Trust</h2>
                </div>
            </div>
        </div>
        <button
            class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-50 hover:bg-opacity-75 rounded-full p-2"
            id="prev-btn">
            <span class="iconify" data-icon="mdi:chevron-left" data-width="24" data-height="24"></span>
        </button>
        <button
            class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-50 hover:bg-opacity-75 rounded-full p-2"
            id="next-btn">
            <span class="iconify" data-icon="mdi:chevron-right" data-width="24" data-height="24"></span>
        </button>
    </div>
    <div class="flex justify-between m-5">
        <h1 class="font-bold text-neutral-400">Pilihan Kategori</h1>
        <a href="{{ route('category') }}" class="text-indigo-500 cursor-pointer">Lihat Semua</a>
    </div>

    <!-- Categories Carousel -->
    <x-category :cart-count="5" />

    <div class="m-5">
        <div class="flex justify-between">
            <h1 class="font-extrabold">Spesial Hari ini </h1>
            <p class="text-indigo-500 cursor-pointer ">Lihat Semua</p>
        </div>
        <p class="font-bold text-neutral-400">Promo menarik dari AquaTech Fresh untuk kamu</p>
    </div>

    <div class="relative w-full h-80 overflow-hidden shadow-lg">
        <!-- Background -->
        <img src="{{ asset('assets/bg-pasar-ikan.jpg') }}" alt="Banner Ikan"
            class="w-full h-full object-cover brightness-50">

        <!-- Overlay konten -->
        <div class="absolute inset-0 flex justify-between items-center px-8 ">
            <!-- Kiri: Teks -->
            <div class="flex flex-col items-start">
                <h1 class="text-white text-4xl md:text-5xl italic font-semibold leading-tight mb-4"
                    style="font-family: 'Caveat', cursive;">
                    The Best<br>Dinner
                </h1>
                /
            </div>

            <!--  Card Produk -->
            <div class="flex space-x-4">
                <!-- Card 1 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden w-40">
                    <img src="{{ asset('assets/cumi-krispy.jpg') }}" alt="Cumi Krispy" class="w-full h-24 object-cover">
                    <div class="p-3">
                        <h2 class="text-sm font-semibold">Cumi Krispy</h2>
                        <p class="text-red-500 font-bold text-sm">Rp15.000</p>
                        <button class="bg-cyan-600 text-white text-sm mt-2 px-3 py-1 rounded w-full">Tambah</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h1 class="font-bold m-5">Berlangganan tanpa harus memesan setiap hari </h1>
    <!-- Banner 2 -->
    <div class="relative w-full h-80 overflow-hidden shadow-lg">
        <img src="{{ asset('assets/bg-pasar-ikan2.jpg') }}" alt="" class="w-full h-full object-cover brightness-50">
        <div class="absolute inset-0 flex flex-col justify-center items-center text-center">
            <h1 class="font-extrabold text-white text-lg leading-relaxed drop-shadow-lg">
                Ayo berlangganan sekarang dan atur <br>
                tanggal setiap pengiriman nya
            </h1>
            <button
                class="mt-4 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold px-6 py-2 rounded-full shadow-md transition">
                Klik Disini
            </button>
        </div>
    </div>


    <!-- Edukasi dan Resep Untuk Kamu -->
    <div class="px-5 mt-6">
        <div class="flex justify-between items-center mb-3">
            <h1 class="font-extrabold text-lg">Edukasi dan Resep Untuk Kamu</h1>
            <a href="#" class="text-cyan-600 font-medium hover:underline">Lihat Semua</a>
        </div>

        <!-- Card 1 -->
        <div class="flex bg-white rounded-lg shadow-md p-3 mb-4 hover:shadow-lg transition">
            <img src="{{ asset('assets/edukasi-ikan.jpg') }}" alt="Cara Menangkap Ikan"
                class="w-32 h-24 rounded-md object-cover mr-4">
            <div class="flex flex-col justify-between">
                <div>
                    <h2 class="font-semibold text-gray-900 text-base">Cara menangkap ikan yang benar</h2>
                    <p class="text-gray-500 text-sm leading-tight">Gimana sih caranya?<br>sesuai peraturan yang ada</p>
                </div>
                <button
                    class="bg-cyan-600 text-white text-sm font-medium px-4 py-1 rounded-md w-fit mt-2 hover:bg-cyan-700">
                    Klik Disini
                </button>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="flex bg-white rounded-lg shadow-md p-3 mb-6 hover:shadow-lg transition">
            <img src="{{ asset('assets/edukasi-gizi.jpg') }}" alt="Gizi Makanan Laut"
                class="w-32 h-24 rounded-md object-cover mr-4">
            <div class="flex flex-col justify-between">
                <div>
                    <h2 class="font-semibold text-gray-900 text-base">Pentingnya Gizi Makanan Laut seperti....</h2>
                    <p class="text-gray-500 text-sm leading-tight">Apa saja sih kelebihan kita<br>mengonsumsi nya?...
                    </p>
                </div>
                <button
                    class="bg-cyan-600 text-white text-sm font-medium px-4 py-1 rounded-md w-fit mt-2 hover:bg-cyan-700">
                    Klik Disini
                </button>
            </div>
        </div>
    </div>

    <!-- Rekomendasi Resto -->
    <div class="px-5 mb-10">
        <h1 class="font-extrabold text-lg mb-3">Rekomendasi Resto</h1>

        <!-- Resto 1 -->
        <div class="flex bg-white rounded-lg shadow-md p-3 mb-4 hover:shadow-lg transition">
            <img src="{{ asset('assets/resto1.jpg') }}" alt="Layar Seafood 99"
                class="w-32 h-24 rounded-md object-cover mr-4">
            <div>
                <h2 class="font-semibold text-gray-900 text-base">Layar Seafood 99</h2>
                <p class="text-gray-500 text-sm leading-snug">
                    Jalan Pesanggrahan Raya No.80,<br>
                    Meruya Utara, West Jakarta 11620
                </p>
            </div>
        </div>

        <!-- Resto 2 -->
        <div class="flex bg-white rounded-lg shadow-md p-3 hover:shadow-lg transition">
            <img src="{{ asset('assets/resto2.jpg') }}" alt="Tepian Rasa"
                class="w-32 h-24 rounded-md object-cover mr-4">
            <div>
                <h2 class="font-semibold text-gray-900 text-base">Tepian Rasa</h2>
                <p class="text-gray-500 text-sm leading-snug">
                    Jalan Lombok Nomor 45, Bandung
                </p>
            </div>
        </div>
    </div>


    <!-- Bottom Navigation Bar -->
    <x-navbar :cart-count="5" :active-route="'home'" />
</body>

</html>