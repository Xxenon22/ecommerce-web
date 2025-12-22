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
        document.addEventListener('DOMContentLoaded', function() {
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

            prevBtn.addEventListener('click', function() {
                currentIndex = (currentIndex > 0) ? currentIndex - 1 : totalSlides - 1;
                updateCarousel();
            });

            nextBtn.addEventListener('click', function() {
                currentIndex = (currentIndex < totalSlides - 1) ? currentIndex + 1 : 0;
                updateCarousel();
            });

            setInterval(function() {
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
                    categoriesSlides.style.transform =
                        `translateX(-${categoriesCurrentIndex * (100 / categoriesVisibleSlides)}%)`;
                }

                categoriesPrevBtn.addEventListener('click', function() {
                    categoriesCurrentIndex = Math.max(0, categoriesCurrentIndex - 1);
                    updateCategoriesCarousel();
                });

                categoriesNextBtn.addEventListener('click', function() {
                    const maxIndex = categoriesTotalSlides - categoriesVisibleSlides;
                    categoriesCurrentIndex = Math.min(maxIndex, categoriesCurrentIndex + 1);
                    updateCategoriesCarousel();
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
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

<body class="bg-gray-100 min-h-screen pb-20">
    <div class="w-full mx-auto">
        <!-- Sidebar -->
        <div id="sidebar"
            class="fixed top-0 left-0 h-full bg-[#0A2540] text-white w-4/5 md:w-1/5 transform -translate-x-full transition-transform duration-300 z-50 flex flex-col justify-between">
            <div class="p-6 relative h-full flex flex-col justify-between">
                <!-- Header -->
                <div>
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex flex-col items-center space-x-3">
                            @if (Auth::user()->photo)
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

                        {{-- Admin Page --}}
                        <a href="/admin/user"
                            class="flex items-center space-x-3 hover:text-cyan-400">
                            <span class="iconify" data-icon="mdi:account-group-outline" data-width="22"></span>
                            <span>User</span>
                        </a>
                        <a href="/admin/category"
                            class="flex items-center space-x-3 hover:text-cyan-400">
                            <span class="iconify" data-icon="mdi:folder-multiple-outline" data-width="22"></span>
                            <span>Category Product</span>
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
                            <button type="submit"
                                class="w-full text-left flex items-center space-x-3 hover:text-red-400">
                                <span class="iconify" data-icon="mdi:logout" data-width="22"></span>
                                <span>Log Out</span>
                            </button>
                        </form>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Overlay -->
        <div id="overlay" class="fixed inset-0 bg-black-0 bg-opacity-50 hidden z-40 transition-opacity duration-300">
        </div>

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
            @yield('content')
        </main>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</body>

</html>
