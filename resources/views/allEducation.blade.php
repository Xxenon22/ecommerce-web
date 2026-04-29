<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('/logo.jpeg') }}" type="image/png">
    <title> Semua Produk - Fishery Hub</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,700;1,700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
</head>

<body class="bg-gray-50 min-h-screen pb-24">

    <div class="max-w-4xl mx-auto">

        <!-- HEADER -->
        <header class="sticky top-0 bg-white shadow-sm px-4 py-3 flex items-center gap-3">
            <a href="{{ route('home') }}">
                <span class="iconify" data-icon="weui:back-outlined"></span>
            </a>
            <h1 class="font-bold text-lg">Semua Edukasi</h1>
        </header>

        <!-- SEARCH -->
        <div class="p-4">
            <form method="GET" action="{{ route('education.all') }}"
                class="flex items-center bg-white border rounded-full px-4 py-2">

                <span class="iconify text-gray-400" data-icon="mdi:magnify"></span>

                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari edukasi..."
                    class="flex-1 outline-none text-sm ml-2">
            </form>
        </div>

        <!-- LIST -->
        <div class="px-4 space-y-3">

            @forelse ($edukasis as $item)

                <a href="{{ route('education.show', $item->id) }}"
                    class="flex bg-white rounded-2xl border shadow-sm overflow-hidden">

                    <!-- IMAGE -->
                    <img src="{{ asset('storage/' . $item->image) }}" class="w-28 object-cover">

                    <!-- CONTENT -->
                    <div class="p-4 flex flex-col justify-between">

                        <div>
                            <span class="text-xs text-cyan-600 font-bold bg-cyan-50 px-2 py-1 rounded-full">
                                Edukasi
                            </span>

                            <h2 class="font-semibold text-gray-900 text-sm mt-1">
                                {{ $item->judul }}
                            </h2>

                            <p class="text-gray-400 text-xs mt-1">
                                {{ \Illuminate\Support\Str::limit(strip_tags($item->content), 80) }}
                            </p>
                        </div>

                        <span class="text-xs text-cyan-600 mt-2 flex items-center gap-1">
                            Baca
                            <span class="iconify" data-icon="mdi:arrow-right"></span>
                        </span>

                    </div>
                </a>

            @empty
                <div class="text-center py-10">
                    <p class="text-gray-400">Belum ada edukasi</p>
                </div>
            @endforelse

        </div>

    </div>

</body>

</html>