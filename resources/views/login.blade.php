<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login - Fishery Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>

</head>

<body class="backdrop-brightness-30"
    style="background-image: url({{ asset('assets/bg-pasar-ikan2.jpg') }}); background-size: cover;
         background-repeat: no-repeat;
         background-position: center;
         background-attachment: fixed;">
    <div class="">
        <div class="absolute m-3 z-10">
            <a href="{{ route('home') }}">
                <span class="iconify cursor-pointer text-white" data-icon="weui:back-outlined" data-width="38"
                    data-height="38" class="cursor-pointer"></span>
            </a>
        </div>

        <div class="flex flex-col justify-center items-center min-h-screen relative z-0 px-4">
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-white">Selamat Datang kembali di <span class="text-cyan-600">Fishery
                        Hub</span> </h1>
            </div>

            <!-- Login Card -->
            <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl shadow-2xl p-8 w-full max-w-md">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Masuk ke Akun Anda</h2>
                    <p class="text-gray-600">Masukkan kredensial untuk melanjutkan</p>
                </div>

                <form action="/login" method="POST" class="space-y-6">
                    @csrf
                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                            <div class="flex items-center justify-between">
                                <span>{{ $errors->first() }}</span>
                                <button type="button" class="text-red-500 hover:text-red-700"
                                    onclick="this.parentElement.parentElement.remove()">
                                    <span class="iconify" data-icon="mdi:close" data-width="18" data-height="18"></span>
                                </button>
                            </div>
                        </div>
                    @endif

                    <div class="space-y-4">
                        <div class="relative">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <span class="iconify" data-icon="mdi:email" data-width="20" data-height="20"></span>
                                </span>
                                <input type="email" id="email" name="email"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-colors"
                                    placeholder="Masukkan email Anda" required>
                            </div>
                        </div>

                        <div class="relative">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <span class="iconify" data-icon="mdi:lock" data-width="20" data-height="20"></span>
                                </span>
                                <input type="password" id="password" name="password"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-colors"
                                    placeholder="Masukkan password Anda" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-cyan-600 hover:bg-cyan-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">
                        Masuk
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('registration') }}"
                            class="text-cyan-600 hover:text-cyan-700 font-semibold underline">
                            Daftar di sini
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
