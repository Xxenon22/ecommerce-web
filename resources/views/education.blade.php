<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('/logo.jpeg') }}" type="image/png">
    <title>{{ $edukasi->judul }} - Fishery Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@tailwindcss/typography/dist/typography.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
</head>

<style>
    .font-display {
        font-family: 'Fraunces', serif;
        font-weight: 800;
    }
</style>

<body class="bg-gray-100 min-h-screen pb-20">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <header class="flex items-center justify-between p-4 bg-white shadow-md sticky top-0 z-20">
            <a href="{{ route('home') }}">
                <span class="iconify cursor-pointer" data-icon="weui:back-outlined" data-width="32"
                    data-height="32"></span>
            </a>

            <span class="font-display text-2xl text-cyan-600 italic">FisheryHub</span>
        </header>

        <!-- Education Content -->
        <section class="mt-6 px-6">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">

                <!-- IMAGE -->
                <img src="{{ asset('storage/' . $edukasi->image) }}" alt="{{ $edukasi->judul }}"
                    class="w-full h-64 md:h-96 object-cover">

                <!-- CONTENT -->
                <div class="p-6">

                    <!-- TITLE -->
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
                        {{ $edukasi->judul }}
                    </h1>

                    <!-- DATE (optional) -->
                    <p class="text-sm text-gray-400 mb-4">
                        {{ $edukasi->created_at->format('d M Y') }}
                    </p>

                    <!-- CONTENT -->
                    <div class="prose max-w-none text-gray-700">
                        {!! $edukasi->content !!}
                    </div>

                </div>
            </div>
        </section>

        <!-- Bottom Navigation -->
        <x-navbar :cart-count="5" :active-route="'edukasi'" class="block md:hidden" />

    </div>
</body>

</html>