<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Fishery Hub</title>
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
                const texts = carouselSlides.querySelectorAll('h2');
                texts.forEach(text => {
                    text.classList.remove('translate-x-0', 'opacity-100');
                    text.classList.add('translate-x-full', 'opacity-0');
                });
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

            setInterval(function () {
                currentIndex = (currentIndex < totalSlides - 1) ? currentIndex + 1 : 0;
                updateCarousel();
            }, 5000);

            const categoriesSlides = document.getElementById('categories-slides');
            if (categoriesSlides) {
                const categoriesPrevBtn = document.getElementById('categories-prev-btn');
                const categoriesNextBtn = document.getElementById('categories-next-btn');
                let categoriesCurrentIndex = 0;
                const categoriesTotalSlides = categoriesSlides.children.length;
                const categoriesVisibleSlides = 3;

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
            }
        });
    </script>
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <header class="flex items-center justify-between p-4 bg-white shadow-md sticky top-0 z-20">
            <span class="iconify" data-icon="fe:bar" data-width="32" data-height="32" class="cursor-pointer"></span>
            <div class="relative flex-1 max-w-md mx-4">
                <input type="text" placeholder="Cari produk segar disini..."
                    class="w-full px-4 py-2 pl-10 pr-4 text-gray-700 bg-gray-50 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <span class="iconify absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"
                    data-icon="mdi:magnify" data-width="20" data-height="20"></span>
            </div>
            <a href="#" class="relative">
                <span class="iconify cursor-pointer" data-icon="mdi:cart-outline" data-width="32"
                    data-height="32"></span>
                <!-- Optional badge if you want to show cart count -->
                <span
                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">5</span>
            </a>
        </header>

        <!-- Carousel -->
        <section class="carousel relative overflow-hidden rounded-2xl mt-4 shadow-md">
            <div class="carousel-inner flex transition-transform duration-500 ease-in-out" id="carousel-slides">
                <div class="carousel-slide flex-shrink-0 w-full h-64 md:h-[500px] bg-cover bg-center"
                    style="background-image: url('{{ asset('assets/pasar-ikan.png') }}');">
                    <div class="flex items-center justify-center h-full bg-black bg-opacity-50">
                        <h2
                            class="text-white text-3xl md:text-5xl font-bold transform translate-x-full opacity-0 transition-all duration-500">
                            Fresh Seafood Market</h2>
                    </div>
                </div>
                <div
                    class="carousel-slide flex-shrink-0 w-full h-64 md:h-[500px] bg-gradient-to-r from-blue-400 to-blue-600">
                    <div class="flex items-center justify-center h-full">
                        <h2
                            class="text-white text-3xl md:text-5xl font-bold transform translate-x-full opacity-0 transition-all duration-500">
                            Delivered to Your Door</h2>
                    </div>
                </div>
                <div
                    class="carousel-slide flex-shrink-0 w-full h-64 md:h-[500px] bg-gradient-to-r from-green-400 to-green-600">
                    <div class="flex items-center justify-center h-full">
                        <h2
                            class="text-white text-3xl md:text-5xl font-bold transform translate-x-full opacity-0 transition-all duration-500">
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
        </section>

        <!-- Pilihan Kategori -->
        <section class="mt-10 px-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="font-bold text-gray-500">Pilihan Kategori</h1>
                <a href="{{ route('category') }}" class="text-indigo-500 font-semibold">Lihat Semua</a>
            </div>
            <x-category :cart-count="5" />
        </section>

        <!-- Spesial Hari Ini -->
        <section class="my-10 px-6">
            <div class="flex justify-between items-center">
                <h1 class="font-extrabold text-xl md:text-2xl">Spesial Hari Ini</h1>
                <p class="text-indigo-500 font-medium cursor-pointer">Lihat Semua</p>
            </div>
            <p class="font-bold text-neutral-400 mb-4">Promo menarik dari Fishery Hub untuk kamu</p>

            <div class="relative w-full h-96 md:h-[450px] overflow-hidden shadow-lg rounded-2xl bg-white">
                <img src="{{ asset('assets/bg-pasar-ikan.jpg') }}" alt="Banner Ikan"
                    class="w-full h-full object-cover brightness-50">

                <div class="absolute inset-0 flex flex-col md:flex-row justify-between items-center px-8">
                    <div class="flex flex-col items-start text-left mb-6 md:mb-0">
                        <h1 class="text-white text-4xl md:text-5xl italic font-semibold leading-tight mb-4"
                            style="font-family: 'Caveat', cursive;">The Best<br>Dinner</h1>
                    </div>

                    <div class="flex space-x-6">
                        <div class="bg-white rounded-xl shadow-md overflow-hidden w-40 md:w-60">
                            <img src="{{ asset('assets/cumi-krispy.jpg') }}" alt="Cumi Krispy"
                                class="w-full h-28 md:h-40 object-cover">
                            <div class="p-4">
                                <h2 class="text-sm md:text-base font-semibold">Cumi Krispy</h2>
                                <p class="text-red-500 font-bold text-sm md:text-base">Rp15.000</p>
                                <button
                                    class="bg-cyan-600 text-white text-sm md:text-base mt-2 px-3 py-1 rounded w-full hover:bg-cyan-700 transition">
                                    Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Banner Langganan -->
        <section class="my-10 px-6">
            <h1 class="font-bold mb-3 text-lg md:text-xl">Berlangganan tanpa harus memesan setiap hari</h1>
            <div class="relative w-full h-80 overflow-hidden shadow-lg rounded-2xl">
                <img src="{{ asset('assets/bg-pasar-ikan2.jpg') }}" alt=""
                    class="w-full h-full object-cover brightness-50">
                <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-4">
                    <h1 class="font-extrabold text-white text-lg md:text-2xl leading-relaxed drop-shadow-lg">
                        Ayo berlangganan sekarang dan atur <br> tanggal setiap pengiriman nya
                    </h1>
                    <button
                        class="mt-4 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold px-6 py-2 rounded-full shadow-md transition">
                        Klik Disini
                    </button>
                </div>
            </div>
        </section>

        <!-- Edukasi & Resep -->
        <section class="px-6 mt-10">
            <div class="flex justify-between items-center mb-4">
                <h1 class="font-extrabold text-lg md:text-xl">Edukasi dan Resep Untuk Kamu</h1>
                <a href="#" class="text-cyan-600 font-medium hover:underline">Lihat Semua</a>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <!-- Card 1 -->
                <div class="flex bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition">
                    <img src="{{ asset('assets/edukasi-ikan.jpg') }}" alt="Cara Menangkap Ikan"
                        class="w-32 h-24 md:w-40 md:h-28 rounded-md object-cover mr-4">
                    <div class="flex flex-col justify-between">
                        <div>
                            <h2 class="font-semibold text-gray-900 text-base md:text-lg">Cara menangkap ikan yang benar
                            </h2>
                            <p class="text-gray-500 text-sm leading-tight">Gimana sih caranya? sesuai peraturan yang ada
                            </p>
                        </div>
                        <button
                            class="bg-cyan-600 text-white text-sm font-medium px-4 py-1 rounded-md w-fit mt-2 hover:bg-cyan-700">
                            Klik Disini
                        </button>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="flex bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition">
                    <img src="{{ asset('assets/edukasi-gizi.jpg') }}" alt="Gizi Makanan Laut"
                        class="w-32 h-24 md:w-40 md:h-28 rounded-md object-cover mr-4">
                    <div class="flex flex-col justify-between">
                        <div>
                            <h2 class="font-semibold text-gray-900 text-base md:text-lg">
                                Pentingnya Gizi Makanan Laut seperti....
                            </h2>
                            <p class="text-gray-500 text-sm leading-tight">Apa saja sih kelebihannya mengonsumsi nya?
                            </p>
                        </div>
                        <button
                            class="bg-cyan-600 text-white text-sm font-medium px-4 py-1 rounded-md w-fit mt-2 hover:bg-cyan-700">
                            Klik Disini
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Rekomendasi Resto -->
        <section class="px-6 my-10">
            <h1 class="font-extrabold text-lg md:text-xl mb-4">Rekomendasi Resto</h1>
            <div class="grid md:grid-cols-2 gap-4">
                <!-- Resto 1 -->
                <div class="flex bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition">
                    <img src="{{ asset('assets/resto1.jpg') }}" alt="Layar Seafood 99"
                        class="w-32 h-24 md:w-40 md:h-28 rounded-md object-cover mr-4">
                    <div>
                        <h2 class="font-semibold text-gray-900 text-base md:text-lg">Layar Seafood 99</h2>
                        <p class="text-gray-500 text-sm leading-snug">
                            Jalan Pesanggrahan Raya No.80,<br>
                            Meruya Utara, West Jakarta 11620
                        </p>
                    </div>
                </div>

                <!-- Resto 2 -->
                <div class="flex bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition">
                    <img src="{{ asset('assets/resto2.jpg') }}" alt="Tepian Rasa"
                        class="w-32 h-24 md:w-40 md:h-28 rounded-md object-cover mr-4">
                    <div>
                        <h2 class="font-semibold text-gray-900 text-base md:text-lg">Tepian Rasa</h2>
                        <p class="text-gray-500 text-sm leading-snug">
                            Jalan Lombok Nomor 45, Bandung
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Bottom Navigation -->
        <x-navbar :cart-count="5" :active-route="'home'" class="block md:hidden" />

    </div>
</body>

</html>