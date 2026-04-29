<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('/logo.jpeg') }}" type="image/png">
    <title>{{ $product->name }} - Fishery Hub</title>
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
        <section class="mt-6 px-4 md:px-8">
            <div class="bg-white rounded-xl shadow-md p-4 md:p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- LEFT: IMAGE GALLERY -->
                <div>
                    <img src="{{ asset(file_exists(public_path('storage/' . $product->photo)) ? 'storage/' . $product->photo : 'assets/pasar-ikan.png') }}"
                        class="w-full h-72 md:h-96 object-cover rounded-lg">

                </div>

                <!-- RIGHT: PRODUCT INFO -->
                <div>

                    <!-- Title -->
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
                        {{ $product->name }}
                    </h1>

                    <!-- Price -->
                    <p class="text-2xl text-cyan-600 font-bold mt-2">
                        Rp{{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    <!-- Rating -->
                    <div class="flex items-center gap-1 mt-2 text-yellow-400">
                        ★★★★☆
                        <span class="text-gray-500 text-sm">(4.5)</span>
                    </div>

                    <!-- Stock -->
                    <p class="text-sm text-gray-500 mt-2">
                        Stok tersedia
                        <span class="font-bold">{{ $product->stock }}</span>
                    </p>

                    <!-- Divider -->
                    <hr class="my-4">

                    <!-- Description -->
                    <div class="prose max-w-none text-gray-700">
                        {!! $product->description !!}
                    </div>

                    <!-- Quantity -->
                    <div class="flex items-center gap-2 mt-6">
                        <span class="font-semibold">Jumlah:</span>

                        <button type="button" id="minusBtn" class="px-3 py-1 border rounded">-</button>

                        <input type="number" id="qtyInput" value="1" min="1" class="w-16 text-center border rounded">

                        <button type="button" id="plusBtn" class="px-3 py-1 border rounded">+</button>
                    </div>

                    <!-- CTA BUTTON -->
                    <div class="flex gap-3 mt-6">
                        <form action="{{ route('checkout') }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="selected_products[{{ $product->id}}]" value="{{ $product->id }}">
                            <input type="hidden" id="hiddenQtyCheckout" name="quantity[{{ $product->id }}]" value="1">
                            <input type="hidden" name="restaurant_id" value="{{ $product->restaurant_id }}">
                            <button type="submit"
                                class="w-full bg-cyan-600 hover:bg-cyan-700 text-white text-xs font-semibold py-2 rounded-xl transition">
                                pesan sekarang
                            </button>
                        </form>

                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" id="hiddenQtyCart" name="quantity" value="1">
                            <input type="hidden" name="restaurant_id" value="{{ $product->restaurant_id }}">
                            <button type="submit"
                                class="cart-btn w-9 h-9 bg-amber-400 hover:bg-amber-500 text-white rounded-xl flex items-center justify-center transition">
                                <span class="iconify" data-icon="mdi:cart-plus" data-width="16"></span>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </section>

        <!-- Bottom Navigation -->
        <x-navbar :cart-count="5" :active-route="'produc$product'" class="block md:hidden" />

    </div>
</body>

<script>
    const qtyInput = document.getElementById('qtyInput');
    const minusBtn = document.getElementById('minusBtn');
    const plusBtn = document.getElementById('plusBtn');

    const hiddenCheckout = document.getElementById('hiddenQtyCheckout');
    const hiddenCart = document.getElementById('hiddenQtyCart');

    function updateQty(value) {
        if (value < 1) value = 1;

        qtyInput.value = value;

        // sync ke form
        hiddenCheckout.value = value;
        hiddenCart.value = value;
    }

    minusBtn.addEventListener('click', () => {
        updateQty(parseInt(qtyInput.value) - 1);
    });

    plusBtn.addEventListener('click', () => {
        updateQty(parseInt(qtyInput.value) + 1);
    });

    qtyInput.addEventListener('input', () => {
        updateQty(parseInt(qtyInput.value) || 1);
    });
</script>

</html>