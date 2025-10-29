<!doctype html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fishery Hub</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
    <div class="flex justify-around items-center min-h-screen flex-col">

        <div class="">
            <img src="{{ asset('assets/pasar-ikan.png') }}" alt="" width="300">
        </div>
        <div class="flex flex-col items-center">
            <h1 class="font-bold text-4xl">Fishery Hub</h1>
            <p>Fresh from sea. Delivered to you.</p>
        </div>

        <div class="btn">
            <a href="{{ route('beranda') }}" class="rounded bg-blue-400 p-3 flex justify-center no-underline">
                <h1 class="font-bold text-white text-xl">Get Started</h1>
            </a>
        </div>
    </div>


</body>

</html>