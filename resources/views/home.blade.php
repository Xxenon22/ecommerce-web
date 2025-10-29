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

        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const openBtn = document.getElementById('open-sidebar');
            const closeBtn = document.getElementById('close-sidebar');
            const overlay = document.getElementById('overlay');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden'); // biar tidak bisa scroll
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            openBtn.addEventListener('click', openSidebar);
            closeBtn.addEventListener('click', closeSidebar);
            overlay.addEventListener('click', closeSidebar);
        });
    </script>
</head>

<body class="bg-gray-100 min-h-screen relative">

    <!-- Sidebar -->
    <div id="sidebar" class="fixed inset-0 bg-[#0A2540] text-white transform -translate-x-full transition-transform duration-300 z-50 flex
    flex-col justify-between">
        <div class="p-6 relative h-full flex flex-col justify-between">
            <!-- Header -->
            <div>
                <div class="flex items-center justify-between mb-8">
                    <div class="flex flex-col items-center space-x-3">
                        @if(Auth::user()->photo)
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="User"
                                class="w-14 h-14 rounded-full border-2 border-white">
                        @else
                            <span class="iconify w-14 h-14 rounded-full border-2 border-white"
                                data-icon="mdi:account-circle" data-width="56" data-height="56"></span>
                        @endif
                        <div>
                            <p class="text-sm text-gray-300">Welcome-!!</p>
                            <h2 class="text-lg font-semibold">{{ Auth::user()->name ?? 'Username' }}</h2>
                        </div>
                    </div>
                    <button id="close-sidebar" class="absolute top-6 right-6">
                        <span class="iconify" data-icon="mdi:close" data-width="28"></span>
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="space-y-10 text-sm">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 hover:text-cyan-400">
                        <span class="iconify" data-icon="mdi:home-outline" data-width="22"></span>
                        <span>Home</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 hover:text-cyan-400">
                        <span class="iconify" data-icon="mdi:history" data-width="22"></span>
                        <span>History</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 hover:text-cyan-400">
                        <span class="iconify" data-icon="mdi:bell-outline" data-width="22"></span>
                        <span>Notification</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 hover:text-cyan-400">
                        <span class="iconify" data-icon="mdi:star-outline" data-width="22"></span>
                        <span>Rate Us</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 hover:text-cyan-400">
                        <span class="iconify" data-icon="mdi:ticket-percent-outline" data-width="22"></span>
                        <span>Coupon</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 hover:text-cyan-400">
                        <span class="iconify" data-icon="mdi:help-circle-outline" data-width="22"></span>
                        <span>Help Center</span>
                    </a>

                    <hr class="my-4 border-gray-600">

                    <form id="logout-form" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left flex items-center space-x-3 hover:text-red-400">
                            <span class="iconify" data-icon="mdi:logout" data-width="22"></span>
                            <span>Log Out</span>
                        </button>
                    </form>
                </nav>
            </div>
        </div>
    </div>

    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40 transition-opacity duration-300"></div>

    <!-- Header -->
    <header class="flex items-center justify-between p-4 bg-white shadow-md sticky top-0 z-20">
        <button id="open-sidebar">
            <span class="iconify" data-icon="mdi:menu" data-width="32" data-height="32"></span>
        </button>

        <div class="relative flex-1 max-w-md mx-4">
            <input type="text" placeholder="Cari produk segar disini..."
                class="w-full px-4 py-2 pl-10 pr-4 text-gray-700 bg-gray-50 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <span class="iconify absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"
                data-icon="mdi:magnify" data-width="20" data-height="20"></span>
        </div>
    </header>

    <main class="max-w-7xl mx-auto">
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

    </main>
    <x-navbar :cart-count="5" :active-route="'home'" class="block md:hidden" />
</body>

</html>