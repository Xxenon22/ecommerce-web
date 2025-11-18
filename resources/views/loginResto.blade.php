<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Restoran - Fishery Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
</head>

<body class="bg-gradient-to-br from-cyan-50 to-blue-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo and Header -->
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <div class="bg-cyan-600 rounded-full p-4">
                    <span class="iconify text-white" data-icon="mdi:storefront" data-width="48" data-height="48"></span>
                </div>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang Kembali</h1>
            <p class="text-gray-600">Masuk ke akun restoran Anda</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <form action="{{ route('login.restaurant.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Restoran
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="iconify text-gray-400" data-icon="mdi:email" data-width="20"
                                data-height="20"></span>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                            placeholder="nama@email.com" required>
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="iconify text-gray-400" data-icon="mdi:lock" data-width="20"
                                data-height="20"></span>
                        </div>
                        <input type="password" id="password" name="password"
                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                            placeholder="Masukkan kata sandi" required>
                        <button type="button" id="toggle-password"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <span class="iconify text-gray-400 hover:text-gray-600" data-icon="mdi:eye-off"
                                data-width="20" data-height="20"></span>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                            class="h-4 w-4 text-cyan-600 focus:ring-cyan-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Ingat saya
                        </label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="text-cyan-600 hover:text-cyan-500 font-medium">
                            Lupa kata sandi?
                        </a>
                    </div>
                </div>

                <!-- Login Button -->
                <button type="submit"
                    class="w-full bg-cyan-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transition-colors">
                    Masuk ke Restoran
                </button>
            </form>

            <!-- Divider -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">atau</span>
                    </div>
                </div>
            </div>

            <!-- Register Link -->
            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Belum punya akun restoran?
                    <a href="{{ route('regisResto') }}" class="text-cyan-600 hover:text-cyan-500 font-medium">
                        Daftar sekarang
                    </a>
                </p>
            </div>

            <!-- Back to Customer Login -->
            <div class="mt-4 text-center">
                <p class="text-gray-600">
                    Ingin masuk sebagai pelanggan?
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                        Masuk sebagai pelanggan
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-sm text-gray-500">
                Dengan masuk, Anda menyetujui
                <a href="#" class="text-cyan-600 hover:text-cyan-500">Syarat & Ketentuan</a>
                dan
                <a href="#" class="text-cyan-600 hover:text-cyan-500">Kebijakan Privasi</a>
            </p>
        </div>
    </div>

    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');
        const toggleIcon = togglePassword.querySelector('span');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle icon
            if (type === 'password') {
                toggleIcon.setAttribute('data-icon', 'mdi:eye-off');
            } else {
                toggleIcon.setAttribute('data-icon', 'mdi:eye');
            }
        });

        // Auto-focus email field
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('email').focus();
        });

        // Form validation enhancement
        const form = document.querySelector('form');
        form.addEventListener('submit', function (e) {
            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;

            // Disable button and show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <span class="iconify mr-2" data-icon="mdi:loading" data-width="20" data-height="20"></span>
                Sedang masuk...
            `;

            // Re-enable after 5 seconds (in case of error)
            setTimeout(() => {
                submitButton.disabled = false;
                submitButton.textContent = originalText;
            }, 5000);
        });
    </script>
</body>

</html>