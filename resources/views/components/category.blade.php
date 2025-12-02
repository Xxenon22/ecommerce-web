<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categoriesSlides = document.getElementById('categories-slides');
            const categoriesPrevBtn = document.getElementById('categories-prev-btn');
            const categoriesNextBtn = document.getElementById('categories-next-btn');

            let currentScroll = 0;
            const scrollAmount = 160; // Sesuaikan sesuai lebar tiap item (w-32 + margin)

            categoriesNextBtn.addEventListener('click', function () {
                const maxScroll = categoriesSlides.scrollWidth - categoriesSlides.clientWidth;
                currentScroll = Math.min(currentScroll + scrollAmount, maxScroll);
                categoriesSlides.style.transform = `translateX(-${currentScroll}px)`;
            });

            categoriesPrevBtn.addEventListener('click', function () {
                currentScroll = Math.max(currentScroll - scrollAmount, 0);
                categoriesSlides.style.transform = `translateX(-${currentScroll}px)`;
            });

            // Filter functionality
            const categoryItems = document.querySelectorAll('.category-slide');
            const productSections = document.querySelectorAll('.product-section');

            categoryItems.forEach(item => {
                item.addEventListener('click', function () {
                    const categoryName = this.querySelector('h3').textContent;
                    // Redirect to category page with path parameter
                    window.location.href = `/category/${encodeURIComponent(categoryName)}`;
                });
            });

            function showCategorySection(kategori) {
                productSections.forEach(section => {
                    if (kategori === 'Semua') {
                        section.style.display = 'block';
                    } else if (section.getAttribute('data-category') === kategori) {
                        section.style.display = 'block';
                    } else {
                        section.style.display = 'none';
                    }
                });
            }

            // Initialize carousels for each product section
            productSections.forEach((section, index) => {
                const slides = section.querySelector(`#product-slides-${index}`);
                const prevBtn = section.querySelector(`#product-prev-btn-${index}`);
                const nextBtn = section.querySelector(`#product-next-btn-${index}`);

                if (slides && prevBtn && nextBtn) {
                    let currentIndex = 0;
                    const totalSlides = slides.children.length;
                    const visibleSlides = 2;

                    function updateCarousel() {
                        const maxIndex = totalSlides - visibleSlides;
                        currentIndex = Math.max(0, Math.min(currentIndex, maxIndex));
                        slides.style.transform = `translateX(-${currentIndex * (100 / visibleSlides)}%)`;
                    }

                    prevBtn.addEventListener('click', function () {
                        currentIndex = Math.max(0, currentIndex - 1);
                        updateCarousel();
                    });

                    nextBtn.addEventListener('click', function () {
                        const maxIndex = totalSlides - visibleSlides;
                        currentIndex = Math.min(maxIndex, currentIndex + 1);
                        updateCarousel();
                    });
                }
            });
        });
    </script>

</head>

<body>
    <div class="categories-carousel relative overflow-hidden mx-5">
        <div class="categories-inner flex flex-nowrap transition-transform duration-500 ease-in-out"
            id="categories-slides">
            <div class="category-slide flex-shrink-0 w-32 mx-2">
                <div
                    class="bg-white rounded-lg shadow-md p-4 text-center hover:shadow-lg transition-shadow duration-300">
                    <span class="iconify block mx-auto mb-2 text-gray-500" data-icon="mdi:shape-outline" data-width="48"
                        data-height="48"></span>
                    <h3 class="text-sm font-semibold text-gray-700">Semua</h3>
                </div>
            </div>
            <div class="category-slide flex-shrink-0 w-32 mx-2">
                <div
                    class="bg-white rounded-lg shadow-md p-4 text-center hover:shadow-lg transition-shadow duration-300">
                    <span class="iconify block mx-auto mb-2 text-blue-500" data-icon="tabler:fish" data-width="48"
                        data-height="48"></span>
                    <h3 class="text-sm font-semibold text-gray-700">Ikan segar</h3>
                </div>
            </div>
            <div class="category-slide flex-shrink-0 w-32 mx-2">
                <div
                    class="bg-white rounded-lg shadow-md p-4 text-center hover:shadow-lg transition-shadow duration-300">
                    <span class="iconify block mx-auto mb-2 text-red-500" data-icon="lucide-lab:crab" data-width="48"
                        data-height="48"></span>
                    <h3 class="text-sm font-semibold text-gray-700">Kepiting</h3>
                </div>
            </div>
            <div class="category-slide flex-shrink-0 w-32 mx-2">
                <div
                    class="bg-white rounded-lg shadow-md p-4 text-center hover:shadow-lg transition-shadow duration-300">
                    <span class="iconify block mx-auto mb-2 text-purple-500" data-icon="hugeicons:octopus"
                        data-width="48" data-height="48"></span>
                    <h3 class="text-sm font-semibold text-gray-700">Cumi - Cumi</h3>
                </div>
            </div>
            <div class="category-slide flex-shrink-0 w-32 mx-2">
                <div
                    class="bg-white rounded-lg shadow-md p-4 text-center hover:shadow-lg transition-shadow duration-300">
                    <span class="iconify block mx-auto mb-2 text-orange-500" data-icon="lucide:shrimp" data-width="48"
                        data-height="48"></span>
                    <h3 class="text-sm font-semibold text-gray-700">Udang</h3>
                </div>
            </div>
            <div class="category-slide flex-shrink-0 w-32 mx-2">
                <div
                    class="bg-white rounded-lg shadow-md p-4 text-center hover:shadow-lg transition-shadow duration-300">
                    <span class="iconify block mx-auto mb-2 text-green-500" data-icon="hugeicons:shellfish"
                        data-width="48" data-height="48"></span>
                    <h3 class="text-sm font-semibold text-gray-700">Kerang</h3>
                </div>
            </div>

        </div>
        <button
            class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-75 hover:bg-opacity-100 rounded-full p-2 shadow-md"
            id="categories-prev-btn">
            <span class="iconify" data-icon="mdi:chevron-left" data-width="20" data-height="20"></span>
        </button>
        <button
            class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-75 hover:bg-opacity-100 rounded-full p-2 shadow-md"
            id="categories-next-btn">
            <span class="iconify" data-icon="mdi:chevron-right" data-width="20" data-height="20"></span>
        </button>
    </div>
</body>

</html>