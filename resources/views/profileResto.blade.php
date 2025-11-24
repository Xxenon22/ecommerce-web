<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Restoran - Fishery Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home-resto') }}" class="flex items-center text-gray-600 hover:text-gray-900">
                        <span class="iconify mr-2" data-icon="weui:back-outlined" data-width="24"
                            data-height="24"></span>
                        Kembali ke Dashboard
                    </a>
                </div>
                <h1 class="text-xl font-semibold text-gray-900">Profil Restoran</h1>
                <div class="w-20"></div> <!-- Spacer for centering -->
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-sm p-8">
            <form action="{{ route('profileResto.update') }}" method="POST" enctype="multipart/form-data"
                class="space-y-8">
                @csrf

                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Restaurant Photo Section -->
                <div class="text-center">
                    <div class="relative inline-block">
                        @if(Auth::user()->photo)
                            <img src="{{ asset('storage/restaurant_photos/' . Auth::user()->photo) }}" alt="Foto Restoran"
                                class="w-32 h-32 object-cover rounded-full border-4 border-cyan-200">
                        @else
                            <div
                                class="w-32 h-32 bg-gray-200 rounded-full flex items-center justify-center border-4 border-cyan-200">
                                <span class="iconify text-gray-400" data-icon="mdi:storefront" data-width="48"
                                    data-height="48"></span>
                            </div>
                        @endif
                        <label for="photo"
                            class="absolute bottom-0 right-0 bg-cyan-600 text-white p-2 rounded-full cursor-pointer hover:bg-cyan-700 transition-colors">
                            <span class="iconify" data-icon="mdi:camera" data-width="20" data-height="20"></span>
                            <input id="photo" name="photo" type="file" accept="image/*" class="hidden">
                        </label>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">Klik ikon kamera untuk mengubah foto</p>
                </div>

                <!-- Personal Information Section -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                        <span class="iconify mr-3 text-cyan-600" data-icon="mdi:account" data-width="24"
                            data-height="24"></span>
                        Informasi Pemilik
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Owner Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                placeholder="Masukkan nama lengkap" required>
                        </div>

                        <!-- Owner Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                placeholder="nama@email.com" required>
                        </div>

                        <!-- Owner Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Telepon <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                placeholder="+62 8xx-xxxx-xxxx" required>
                        </div>

                        <!-- Owner Address -->
                        <div class="md:col-span-1">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat Lengkap <span class="text-red-500">*</span>
                            </label>
                            <textarea id="address" name="address" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                placeholder="Jl. Contoh No. 123, Kota, Provinsi"
                                required>{{ old('address', Auth::user()->address) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Restaurant Information Section -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                        <span class="iconify mr-3 text-cyan-600" data-icon="mdi:storefront" data-width="24"
                            data-height="24"></span>
                        Informasi Restoran
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Restaurant Name -->
                        <div>
                            <label for="resto_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Restoran <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="resto_name" name="resto_name"
                                value="{{ old('resto_name', Auth::user()->resto_name) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                placeholder="Nama restoran Anda" required>
                        </div>

                        <!-- Business Type -->
                        <div>
                            <label for="business_type" class="block text-sm font-medium text-gray-700 mb-2">
                                Tipe Bisnis <span class="text-red-500">*</span>
                            </label>
                            <select id="business_type" name="business_type"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                required>
                                <option value="">Pilih tipe bisnis</option>
                                <option value="restaurant" {{ old('business_type', Auth::user()->business_type) == 'restaurant' ? 'selected' : '' }}>Restoran</option>
                                <option value="cafe" {{ old('business_type', Auth::user()->business_type) == 'cafe' ? 'selected' : '' }}>Kafe</option>
                                <option value="food_truck" {{ old('business_type', Auth::user()->business_type) == 'food_truck' ? 'selected' : '' }}>Food Truck</option>
                                <option value="other" {{ old('business_type', Auth::user()->business_type) == 'other' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>

                        <!-- Restaurant Address -->
                        <div class="md:col-span-2">
                            <label for="resto_address" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat Restoran <span class="text-red-500">*</span>
                            </label>
                            <textarea id="resto_address" name="resto_address" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                placeholder="Jl. Restoran No. 123, Kota, Provinsi"
                                required>{{ old('resto_address', Auth::user()->resto_address) }}</textarea>
                        </div>

                        <!-- Opening Hours -->
                        <div>
                            <label for="opening_hours" class="block text-sm font-medium text-gray-700 mb-2">
                                Jam Operasional
                            </label>
                            <input type="text" id="opening_hours" name="opening_hours"
                                value="{{ old('opening_hours', Auth::user()->opening_hours) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                placeholder="Senin-Jumat: 08:00-22:00">
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Restoran
                            </label>
                            <textarea id="description" name="description" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                placeholder="Ceritakan tentang restoran Anda, menu spesial, dan apa yang membuat restoran Anda unik...">{{ old('description', Auth::user()->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('home-resto') }}"
                        class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-3 bg-cyan-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Statistics Section -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                <div class="text-2xl font-bold text-cyan-600">{{ Auth::user()->products->count() }}</div>
                <div class="text-gray-600">Menu</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                <div class="text-2xl font-bold text-cyan-600">0</div>
                <div class="text-gray-600">Pesanan Hari Ini</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                <div class="text-2xl font-bold text-cyan-600">4.5</div>
                <div class="text-gray-600">Rating</div>
            </div>
        </div>
    </main>

    <script>
        // Photo preview functionality
        const photoInput = document.getElementById('photo');
        const profilePhoto = document.querySelector('.relative.inline-block img') || document.querySelector('.relative.inline-block .bg-gray-200');

        photoInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    if (profilePhoto.tagName === 'IMG') {
                        profilePhoto.src = e.target.result;
                    } else {
                        // Replace placeholder with image
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = 'Foto Restoran';
                        img.className = 'w-32 h-32 object-cover rounded-full border-4 border-cyan-200';
                        profilePhoto.parentNode.replaceChild(img, profilePhoto);
                    }
                };
                reader.readAsDataURL(file);
            }
        });

        // Phone number formatting
        const phoneInput = document.getElementById('phone');
        phoneInput.addEventListener('input', function (e) {
            // Remove all non-numeric characters except +
            let value = e.target.value.replace(/[^\d+]/g, '');
            // Ensure + is only at the beginning
            if (value.includes('+') && !value.startsWith('+')) {
                value = value.replace(/\+/g, '') + '+';
            }
            e.target.value = value;
        });

        // Auto-save draft (optional enhancement)
        let autoSaveTimeout;
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input, textarea, select');

        inputs.forEach(input => {
            input.addEventListener('input', function () {
                clearTimeout(autoSaveTimeout);
                autoSaveTimeout = setTimeout(() => {
                    // Could implement auto-save to localStorage here
                    console.log('Form changed - auto-save could be implemented');
                }, 1000);
            });
        });
    </script>
</body>

</html>