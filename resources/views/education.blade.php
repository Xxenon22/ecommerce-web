<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cara Menangkap Ikan yang Benar - Fishery Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen pb-20">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <header class="flex items-center justify-between p-4 bg-white shadow-md sticky top-0 z-20">
            <a href="{{ route('home') }}">
                <span class="iconify cursor-pointer" data-icon="weui:back-outlined" data-width="32"
                    data-height="32"></span>
            </a>
            <div class="relative flex-1 max-w-md mx-4">
                <input type="text" placeholder="Cari produk segar disini..."
                    class="w-full px-4 py-2 pl-10 pr-4 text-gray-700 bg-gray-50 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <span class="iconify absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"
                    data-icon="mdi:magnify" data-width="20" data-height="20"></span>
            </div>
        </header>

        <!-- Education Content -->
        <section class="mt-6 px-6">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <img src="{{ asset('assets/edukasi-ikan.jpg') }}" alt="Cara Menangkap Ikan"
                    class="w-full h-64 md:h-96 object-cover">
                <div class="p-6">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Cara Menangkap Ikan yang Benar</h1>
                    <p class="text-gray-600 mb-4">Menangkap ikan dengan cara yang benar sangat penting untuk menjaga
                        kelestarian laut dan mematuhi peraturan yang ada. Berikut adalah panduan lengkapnya:</p>

                    <h2 class="text-xl font-semibold text-gray-900 mb-2">1. Pahami Peraturan Lokal</h2>
                    <p class="text-gray-600 mb-4">Sebelum memulai, pastikan Anda mengetahui peraturan penangkapan ikan
                        di daerah tersebut. Ini terlogin batas ukuran ikan yang boleh ditangkap, musim penangkapan, dan
                        jenis alat yang diperbolehkan.</p>

                    <h2 class="text-xl font-semibold text-gray-900 mb-2">2. Gunakan Alat yang Tepat</h2>
                    <p class="text-gray-600 mb-4">Pilih alat penangkapan yang ramah lingkungan seperti jaring yang tidak
                        merusak habitat laut. Hindari penggunaan bahan kimia atau bom yang dapat membahayakan ekosistem.
                    </p>

                    <h2 class="text-xl font-semibold text-gray-900 mb-2">3. Teknik Penangkapan yang Aman</h2>
                    <p class="text-gray-600 mb-4">Pelajari teknik penangkapan yang tidak merusak populasi ikan.
                        Misalnya, gunakan metode selektif yang hanya menangkap ikan dewasa dan biarkan ikan muda
                        berkembang biak.</p>

                    <h2 class="text-xl font-semibold text-gray-900 mb-2">4. Jaga Kebersihan Laut</h2>
                    <p class="text-gray-600 mb-4">Selalu bersihkan sampah dan hindari membuang limbah ke laut. Ini
                        membantu menjaga kualitas air dan habitat ikan.</p>

                    <p class="text-gray-600 mt-6">Dengan menangkap ikan secara bertanggung jawab, kita dapat memastikan
                        kelestarian sumber daya laut untuk generasi mendatang.</p>
                </div>
            </div>
        </section>

        <!-- Bottom Navigation -->
        <x-navbar :cart-count="5" :active-route="'edukasi'" class="block md:hidden" />

    </div>
</body>

</html>