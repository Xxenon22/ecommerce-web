<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Fishery Hub</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen pb-20">

    <div class="header flex items-center justify-between p-4 bg-white shadow-md">
        <div class="flex items-center space-x-2">
            <a href="{{ route('home') }}">
                <span class="iconify cursor-pointer" data-icon="weui:back-outlined" data-width="38"
                    data-height="38"></span>
            </a>
            <h1 class="font-bold text-xl text-gray-700">Cart Belanja</h1>
        </div>
    </div>

    <main class="max-w-4xl mx-auto p-4">

        @if (count($carts) > 0)
            <form action="{{ route('checkout') }}" method="POST">
                @csrf

                @foreach ($restaurants as $restaurant)
                    @php
                        $restaurantCarts = $carts->where('restaurant_id', $restaurant->id);
                    @endphp

                    @if ($restaurantCarts->count() > 0)
                        <div class="bg-white rounded-lg shadow p-4 mb-4">

                            {{-- Restaurant Header --}}
                            <div class="flex items-center space-x-2 border-b pb-2 mb-3">
                                <input type="checkbox" class="restaurant-checkbox"
                                    data-restaurant-id="{{ $restaurant->id }}">
                                <h2 class="font-bold text-gray-800">
                                    Restaurant {{ $restaurant->name }}
                                </h2>
                            </div>

                            {{-- Products --}}
                            @foreach ($restaurantCarts as $cart)
                                <div class="cart-item flex justify-between items-center py-4 border-b last:border-b-0">

                                    <div class="flex items-center space-x-4">
                                        <input type="checkbox" class="product-checkbox" name="selected_products[]"
                                            value="{{ $cart->product->id }}" data-restaurant-id="{{ $restaurant->id }}">

                                        <img src="{{ asset(file_exists(public_path($cart->product->photo)) ? $cart->product->photo : 'assets/pasar-ikan.png') }}"
                                            class="w-16 h-16 rounded object-cover">

                                        <div>
                                            <h3 class="font-semibold">{{ $cart->product->name }}</h3>
                                            <p class="text-sm text-gray-500">
                                                {{ $cart->product->description ?? '-' }}
                                            </p>
                                            <p class="font-bold text-red-500 item-price"
                                                data-price="{{ $cart->product->price }}">
                                                Rp {{ number_format($cart->product->price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        <button type="button"
                                            class="minus-btn bg-gray-200 w-8 h-8 rounded-full">-</button>

                                        <input type="number" name="quantity[{{ $cart->product->id }}]"
                                            value="{{ $cart->quantity }}" min="1"
                                            class="quantity-input w-12 text-center border rounded">

                                        <button type="button"
                                            class="plus-btn bg-gray-200 w-8 h-8 rounded-full">+</button>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    @endif
                @endforeach

                {{-- Summary --}}
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex justify-between mb-2">
                        <span>Subtotal</span>
                        <span id="subtotal">Rp0</span>
                    </div>
                    {{-- <div class="flex justify-between mb-2">
                        <span>Pajak (10%)</span>
                        <span id="tax">Rp0</span>
                    </div> --}}
                    <hr class="my-2">
                    <div class="flex justify-between font-bold">
                        <span>Total</span>
                        <span id="total" class="text-red-500">Rp0</span>
                    </div>

                    <button type="submit" class="w-full bg-cyan-600 text-white py-3 rounded mt-4">
                        Checkout
                    </button>
                </div>

            </form>
        @else
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <span class="iconify block mx-auto mb-4 text-gray-400" data-icon="mdi:cart-outline" data-width="64"
                    data-height="64"></span>
                <h2 class="text-xl font-semibold text-gray-700 mb-2">cart Kosong</h2>
                <p class="text-gray-500 mb-4">Belum ada produk di cart Anda.</p>
                <a href="{{ route('home') }}"
                    class="bg-cyan-600 hover:bg-cyan-700 text-white font-semibold py-2 px-4 rounded-lg inline-block transition duration-300">
                    Mulai Belanja
                </a>
            </div>
        @endif

    </main>

    <script>
        /* Restaurant checkbox -> products */
        document.querySelectorAll('.restaurant-checkbox').forEach(r => {
            r.addEventListener('change', function() {
                const id = this.dataset.restaurantId;
                document.querySelectorAll(
                    `.product-checkbox[data-restaurant-id="${id}"]`
                ).forEach(p => p.checked = this.checked);
                updateTotals();
            });
        });

        /* Product checkbox -> restaurant */
        document.querySelectorAll('.product-checkbox').forEach(p => {
            p.addEventListener('change', function() {
                const id = this.dataset.restaurantId;
                const products = document.querySelectorAll(
                    `.product-checkbox[data-restaurant-id="${id}"]`
                );
                const restaurant = document.querySelector(
                    `.restaurant-checkbox[data-restaurant-id="${id}"]`
                );

                restaurant.checked = [...products].every(p => p.checked);
                updateTotals();
            });
        });

        /* Quantity buttons */
        document.querySelectorAll('.cart-item').forEach(item => {
            const minus = item.querySelector('.minus-btn');
            const plus = item.querySelector('.plus-btn');
            const input = item.querySelector('.quantity-input');

            minus.onclick = () => {
                if (input.value > 1) input.value--;
                updateTotals();
            };

            plus.onclick = () => {
                input.value++;
                console.log(input.value);
                updateTotals();
            };
        });

        /* Calculate totals (only checked products) */
        function updateTotals() {
            let subtotal = 0;

            document.querySelectorAll('.product-checkbox:checked').forEach(cb => {
                const item = cb.closest('.cart-item');
                const price = parseInt(item.querySelector('.item-price').dataset.price);
                const qty = parseInt(item.querySelector('.quantity-input').value);
                subtotal += price * qty;
            });

            // const total = subtotal + tax;
            const tax = subtotal * 0.1;
            const total = subtotal;

            const rupiah = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });

            // console.log(total);
            // subtotal = subtotal.toLocaleString('id-ID');
            // tax = tax.toLocaleString('id-ID');
            // total = total.toLocaleString('id-ID');

            // document.getElementById('tax').innerText = rupiah.format(tax);
            document.getElementById('subtotal').innerText = rupiah.format(subtotal);
            document.getElementById('total').innerText = rupiah.format(total);
        }

        updateTotals();
    </script>

</body>

</html>
