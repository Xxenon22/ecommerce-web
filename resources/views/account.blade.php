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
        <div class="flex flex-col items-center ">
            <h1 class="font-bold text-2xl text-white">Produk Segar</h1>
            <p class="text-white">Produk segar dari nelayan lokal, langsung ke tempat anda</p>
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('daftar') }}" class="">
                <Button class="bg-white text-cyan-600 p-2 px-10 rounded">Daftar</Button>
            </a>

            <a href="{{ route('masuk') }}">
                <Button class="bg-cyan-600 text-white p-2 px-10 rounded">Masuk</Button>
            </a>
        </div>
    </div>


    <x-navbar :cart-count="5" :active-route="'account'" class="block md:hidden" />
</body>

</html>