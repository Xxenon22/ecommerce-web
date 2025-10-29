<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun - Fishery Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
</head>

<body class="min-h-screen flex flex-col justify-between backdrop-brightness-50" style="background-image: url('{{ asset('assets/bg-akun.jpg') }}');
         background-size: cover;
         background-repeat: no-repeat;
         background-position: center;
         background-attachment: fixed;">

    <div class="flex flex-col justify-center min-h-screen gap-20 mx-7">

        {{-- Bagian Header --}}
        <div class="flex flex-col items-center text-center">
            <h1 class="font-bold text-2xl text-white">Produk Segar</h1>
            <p class="text-white">Produk segar dari nelayan lokal, langsung ke tempat anda</p>
        </div>

<<<<<<< HEAD
        {{-- Jika BELUM login --}}
        @guest
            <div class="flex items-center justify-between">
                <a href="{{ route('registration') }}">
                    <button class="bg-white text-cyan-600 p-2 px-10 rounded">Daftar</button>
                </a>

                <a href="{{ route('login') }}">
                    <button class="bg-cyan-600 text-white p-2 px-10 rounded">Masuk</button>
                </a>
            </div>
        @endguest

        {{-- Jika SUDAH login --}}
        @auth
            <div class="flex flex-col items-center gap-5 text-white">
                <div class="bg-white/20 backdrop-blur-sm p-6 rounded-2xl w-full max-w-md text-center">
                    <h2 class="text-xl font-semibold mb-3">Halo, {{ Auth::user()->name }} 👋</h2>
                    <p class="text-gray-200">Email: {{ Auth::user()->email }}</p>

                    <div class="mt-5">
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <button class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600">Keluar</button>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        @endauth
=======
        <div class="flex items-center justify-between">
            <a href="{{ route('daftar') }}" class="">
                <Button class="bg-white text-cyan-600 p-2 px-10 rounded">Daftar</Button>
            </a>

            <a href="{{ route('masuk') }}">
                <Button class="bg-cyan-600 text-white p-2 px-10 rounded">Masuk</Button>
            </a>
        </div>
>>>>>>> style
    </div>

    {{-- Navbar bawah --}}
    <x-navbar :cart-count="5" :active-route="'account'" class="block md:hidden" />
</body>

</html>