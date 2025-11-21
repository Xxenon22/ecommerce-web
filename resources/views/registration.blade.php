<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>registration - AquaTech Fresh</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>

</head>

<body class="backdrop-brightness-30" style="background-image: url({{ asset('assets/bg-pasar-ikan2.jpg') }}); background-size: cover;
         background-repeat: no-repeat;
         background-position: center;
         background-attachment: fixed;">
    <div class="absolute m-3 z-10 text-white">
        <a href="{{ route('home') }}">
            <span class="iconify cursor-pointer " data-icon="weui:back-outlined" data-width="38" data-height="38"
                class="cursor-pointer"></span>
        </a>
    </div>
    <div class="flex flex-col justify-center items-center min-h-screen relative z-0 px-4">
        <div class="m-5 items-center">
            <h1 class="text-3xl font-bold text-center text-white">Halo, Selamat Datang di <span
                    class="text-cyan-600">AquaTech
                    Fresh</span> </h1>
        </div>
        <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl shadow-2xl p-8 w-full max-w-md">
            <form action="/registration" method="POST"
                class="flex flex-col justify-center items-center space-y-8 m-3 w-full max-w-xs">
                @csrf
                @if ($errors->any())
                    <div
                        class="bg-red-100 text-red-600 p-1 mb-2 rounded text-sm w-full relative flex items-center justify-between">
                        <span>{{ $errors->first() }}</span>
                        <span class="iconify cursor-pointer" data-icon="mdi:close" data-width="18" data-height="18"
                            onclick="this.parentElement.remove()"></span>
                    </div>
                @endif
                <div class="flex flex-col justify-center items-center space-y-2 w-full">
                    <div class="space-y-4">
                        <div class="relative">
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <span class="iconify" data-icon="mdi:person" data-width="20"
                                        data-height="20"></span>
                                </span>
                                <input type="text" placeholder="Masukkan Nama anda" name="name"
                                    class=" w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-colors">
                            </div>
                        </div>

                        <div class="relative">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <span class="iconify" data-icon="mdi:email" data-width="20" data-height="20"></span>
                                </span>
                                <input type="email" placeholder="Masukkan email anda" name="email" id="email"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-colors">

                            </div>
                        </div>


                        <div class="relative">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <span class="iconify" data-icon="mdi:eye" data-width="20" data-height="20"></span>
                                </span>
                                <input type="password" placeholder="Masukkan password anda" name="password"
                                    id="password"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-colors">

                            </div>
                        </div>

                        <div class="relative">
                            <label for="password_cofirmation"
                                class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <span class="iconify" data-icon="mdi:lock" data-width="20" data-height="20"></span>
                                </span>
                                <input type="password" placeholder="Konfirmasi password anda"
                                    name="password_confirmation" id="password_confirmation"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-colors">
                            </div>
                            <small id="pass-match-msg" class="text-red-500 text-xs self-start hidden">Password tidak
                                sesuai!</small>
                        </div>
                    </div>
                </div>
                <Button type="submit" class="bg-cyan-600 p-1 w-full rounded text-white cursor-pointer">
                    Daftar
                </Button>
                <p class="text-gray-600">Sudah Punya Akun? <a href="{{ route('login') }}"
                        class="text-cyan-600 hover:text-cyan-700 font-semibold underline">Masuk kesini ya!</a></p>
            </form>

        </div>
    </div>
    <script>
        function checkPasswords() {
            const pass = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirmation').value;
            const btn = document.querySelector('button[type="submit"]');
            const msg = document.getElementById('pass-match-msg');
            if (confirm && pass !== confirm) {
                btn.disabled = true;
                msg.classList.remove('hidden');
            } else {
                btn.disabled = false;
                msg.classList.add('hidden');
            }
        }
        document.getElementById('password').addEventListener('input', checkPasswords);
        document.getElementById('password_confirmation').addEventListener('input', checkPasswords);
    </script>
</body>

</html>