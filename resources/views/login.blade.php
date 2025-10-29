<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Fishery Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>

</head>

<body class="backdrop-brightness-30" style="background-image: url({{ asset('assets/bg-pasar-ikan2.jpg') }}); background-size: cover;
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
        <div class="flex flex-col justify-center items-center min-h-screen relative z-0">
            <div class="m-5 items-center">
                <h1 class="text-3xl font-bold text-center text-white">Selamat Datang kembali di <span
                        class="text-cyan-600">Fishery Hub</span> </h1>
            </div>
            <form action="" class="flex flex-col justify-center items-center space-y-8 m-3 w-full max-w-xs">
                <div class="flex flex-col justify-center items-center space-y-2 w-full">
                    <input type="text" placeholder="Email" class=" rounded p-2 w-full bg-white">
                    <input type="password" placeholder="Password" class=" rounded p-2 w-full bg-white">
                </div>
                <Button type="submit" class="bg-cyan-600 p-1 w-full rounded text-white cursor-pointer">
                    Masuk
                </Button>
                <p class="text-white font-bold">Belum Punya Akun? <a href="{{ route('regis') }}"
                        class="underline text-cyan-500">Daftar dulu ya
                        disini!</a></p>
            </form>

        </div>
    </div>
</body>

</html>