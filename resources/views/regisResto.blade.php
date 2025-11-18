<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftarkan Restoranmu - Fishery Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
</head>

<body class="from-cyan-50 to-blue-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('started') }}" class="flex items-center text-gray-600 hover:text-gray-900">
                        <span class="iconify mr-2" data-icon="weui:back-outlined" data-width="24"
                            data-height="24"></span>
                    </a>
                </div>
                <h1 class="text-xl font-semibold text-gray-900">Daftarkan Restoranmu</h1>
                <div class="w-20"></div> <!-- Spacer for centering -->
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Hero Section -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Bergabunglah dengan Fishery Hub</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Mulai jualan produk seafood segar Anda dan dapatkan pelanggan dari seluruh Indonesia.
                Daftar sekarang dan kelola restoran Anda dengan mudah!
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8">
            <form action="{{ route('register.restaurant.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-8">
                @csrf

                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                        {{ session('success') }}
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
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                placeholder="Masukkan nama lengkap" required>
                        </div>

                        <!-- Owner Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                placeholder="nama@email.com" required>
                        </div>

                        <!-- Owner Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Telepon <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
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
                                placeholder="Jl. Contoh No. 123, Kota, Provinsi">{{ old('address') }}</textarea>
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
                            <input type="text" id="resto_name" name="resto_name" value="{{ old('resto_name') }}"
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
                                <option value="restaurant" {{ old('business_type') == 'restaurant' ? 'selected' : '' }}>
                                    Restoran</option>
                                <option value="cafe" {{ old('business_type') == 'cafe' ? 'selected' : '' }}>Kafe</option>
                                <option value="food_truck" {{ old('business_type') == 'food_truck' ? 'selected' : '' }}>
                                    Food Truck</option>
                                <option value="other" {{ old('business_type') == 'other' ? 'selected' : '' }}>Lainnya
                                </option>
                            </select>
                        </div>

                        <!-- Restaurant Address -->
                        <div class="md:col-span-2">
                            <label for="resto_address" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat Restoran <span class="text-red-500">*</span>
                            </label>
                            <textarea id="resto_address" name="resto_address" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                placeholder="Jl. Restoran No. 123, Kota, Provinsi">{{ old('resto_address') }}</textarea>
                        </div>

                        <!-- Opening Hours -->
                        <div>
                            <label for="opening_hours" class="block text-sm font-medium text-gray-700 mb-2">
                                Jam Operasional
                            </label>
                            <input type="text" id="opening_hours" name="opening_hours"
                                value="{{ old('opening_hours') }}"
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
                                placeholder="Ceritakan tentang restoran Anda, menu spesial, dan apa yang membuat restoran Anda unik...">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Account Security Section -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                        <span class="iconify mr-3 text-cyan-600" data-icon="mdi:shield-lock" data-width="24"
                            data-height="24"></span>
                        Keamanan Akun
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Kata Sandi <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="password" name="password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                placeholder="Minimal 8 karakter" required>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Konfirmasi Kata Sandi <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                placeholder="Ulangi kata sandi" required>
                        </div>
                    </div>
                </div>

                <!-- Photo Upload Section -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                        <span class="iconify mr-3 text-cyan-600" data-icon="mdi:camera" data-width="24"
                            data-height="24"></span>
                        Foto Restoran
                    </h3>
                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                            Unggah Foto Restoran
                        </label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-cyan-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <div id="photo-preview" class="hidden">
                                    <img id="preview-image" class="mx-auto h-32 w-48 object-cover rounded-lg" src=""
                                        alt="Preview">
                                </div>
                                <div id="upload-placeholder">
                                    <span class="iconify mx-auto h-12 w-12 text-gray-400" data-icon="mdi:image-plus"
                                        data-width="48" data-height="48"></span>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="photo"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-cyan-600 hover:text-cyan-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-cyan-500">
                                            <span>Unggah foto</span>
                                            <input id="photo" name="photo" type="file" accept="image/*" class="sr-only">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="terms" name="terms" type="checkbox"
                                class="h-4 w-4 text-cyan-600 focus:ring-cyan-500 border-gray-300 rounded" required>
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="terms" class="text-gray-700">
                                Saya menyetujui <a href="#" class="text-cyan-600 hover:text-cyan-500">Syarat dan
                                    Ketentuan</a>
                                serta <a href="#" class="text-cyan-600 hover:text-cyan-500">Kebijakan Privasi</a>
                                Fishery Hub
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('started') }}"
                        class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-3 bg-cyan-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500">
                        Daftarkan Restoran
                    </button>
                </div>
            </form>
        </div>

        <!-- Additional Info -->
        <div class="mt-8 text-center">
            <p class="text-gray-600">
                Sudah punya akun?
                <a href="{{ route('loginResto') }}" class="text-cyan-600 hover:text-cyan-500 font-medium">Masuk di
                    sini</a>
            </p>
        </div>
    </main>

    <script>
        // Photo preview functionality
        const photoInput = document.getElementById('photo');
        const photoPreview = document.getElementById('photo-preview');
        const previewImage = document.getElementById('preview-image');
        const uploadPlaceholder = document.getElementById('upload-placeholder');

        photoInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    photoPreview.classList.remove('hidden');
                    uploadPlaceholder.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                photoPreview.classList.add('hidden');
                uploadPlaceholder.classList.remove('hidden');
            }
        });

        // Password confirmation validation
        const password = document.getElementById('password');
        const passwordConfirmation = document.getElementById('password_confirmation');

        function validatePassword() {
            if (password.value !== passwordConfirmation.value) {
                passwordConfirmation.setCustomValidity('Kata sandi tidak cocok');
            } else {
                passwordConfirmation.setCustomValidity('');
            }
        }

        password.addEventListener('change', validatePassword);
        passwordConfirmation.addEventListener('keyup', validatePassword);

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
    </script>
</body>

</html>