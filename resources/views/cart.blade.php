<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('/logo.jpeg') }}" type="image/png">
    <title>Cart - Fishery Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .cart-item {
            transition: background 0.15s ease;
        }

        .cart-item:hover {
            background: #f9fafb;
            border-radius: 12px;
        }

        .qty-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1.5px solid #e5e7eb;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 500;
            color: #374151;
            cursor: pointer;
            transition: all 0.15s ease;
            line-height: 1;
        }

        .qty-btn:hover {
            border-color: #0891b2;
            color: #0891b2;
            background: #ecfeff;
        }

        .custom-checkbox {
            width: 18px;
            height: 18px;
            border-radius: 5px;
            border: 2px solid #d1d5db;
            appearance: none;
            -webkit-appearance: none;
            cursor: pointer;
            transition: all 0.15s ease;
            flex-shrink: 0;
        }

        .custom-checkbox:checked {
            background: #0891b2;
            border-color: #0891b2;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3E%3C/svg%3E");
        }

        .divider {
            height: 1px;
            background: #f3f4f6;
            margin: 10px 0;
        }

        .checkout-btn:hover {
            background: #0e7490;
        }

        .checkout-btn:disabled {
            background: #94a3b8;
            cursor: not-allowed;
            pointer-events: none;
            transform: none;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .restaurant-card {
            animation: fadeInUp 0.3s ease forwards;
        }

        .restaurant-card:nth-child(2) {
            animation-delay: 0.05s;
        }

        .restaurant-card:nth-child(3) {
            animation-delay: 0.1s;
        }

        .checkout-btn {
            background: #0891b2;
            color: white;
            width: 100%;
            padding: 14px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 15px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .checkout-btn:hover {
            background: #0e7490;
            transform: translateY(-1px);
        }

        .checkout-btn:active {
            transform: scale(0.98);
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen pb-28">

    {{-- Header --}}
    <div class="sticky top-0 z-50 bg-white border-b border-gray-100 px-4 py-3 flex items-center gap-3 shadow-sm">
        <a href="{{ route('home') }}"
            class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-gray-100 transition">
            <span class="iconify" data-icon="weui:back-outlined" data-width="22" data-height="22"></span>
        </a>
        <div>
            <h1 class="font-bold text-gray-900 text-lg leading-tight">Keranjang Belanja</h1>
            <p class="text-xs text-gray-400">Pilih produk yang ingin dipesan</p>
        </div>
    </div>

    <main class="max-w-2xl mx-auto px-4 pt-4">

        @if (count($carts) > 0)
            <form action="{{ route('checkout') }}" method="POST">
                @csrf

                {{-- Restaurant Cards --}}
                @foreach ($restaurants as $restaurant)
                    @php
                        $restaurantCarts = $carts->where('restaurant_id', $restaurant->id);
                    @endphp

                    @if ($restaurantCarts->count() > 0)
                        <div class="restaurant-card bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-3">

                            {{-- Restaurant Header --}}
                            <div class="flex items-center gap-3 mb-3 pb-3 border-b border-gray-100">
                                <input type="checkbox" class="custom-checkbox restaurant-checkbox"
                                    data-restaurant-id="{{ $restaurant->id }}">
                                <div class="flex items-center gap-2 flex-1">
                                    <span class="iconify text-cyan-600" data-icon="mdi:storefront-outline" data-width="18"></span>
                                    <h2 class="font-semibold text-gray-800 text-sm">{{ $restaurant->name }}</h2>
                                </div>
                            </div>

                            {{-- Products --}}
                            <div class="space-y-1">
                                @foreach ($restaurantCarts as $cart)
                                    <div class="cart-item flex items-center gap-3 py-3 px-1 border-b border-gray-50 last:border-b-0">

                                        <input type="checkbox" class="custom-checkbox product-checkbox"
                                            name="selected_products[{{ $cart->product->id }}]" value="{{ $cart->product->id }}"
                                            data-restaurant-id="{{ $restaurant->id }}">

                                        <img src="{{ asset(file_exists(public_path('storage/' . $cart->product->photo)) ? 'storage/' . $cart->product->photo : 'assets/pasar-ikan.png') }}"
                                            class="w-14 h-14 rounded-xl object-cover border border-gray-100 flex-shrink-0">

                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-semibold text-gray-800 text-sm truncate">{{ $cart->product->name }}</h3>
                                            @if($cart->product->description)
                                                <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $cart->product->description }}</p>
                                            @endif
                                            <p class="font-bold text-cyan-600 text-sm mt-1 item-price"
                                                data-price="{{ $cart->product->price }}">
                                                Rp {{ number_format($cart->product->price, 0, ',', '.') }}
                                            </p>
                                        </div>

                                        {{-- Quantity --}}
                                        <div class="flex items-center gap-2 flex-shrink-0">
                                            <button type="button" class="minus-btn qty-btn">−</button>
                                            <input type="number" name="quantity[{{ $cart->product->id }}]" value="{{ $cart->quantity }}"
                                                min="1"
                                                class="quantity-input w-10 text-center text-sm font-semibold text-gray-800 border-0 bg-transparent focus:outline-none">
                                            <button type="button" class="plus-btn qty-btn">+</button>
                                        </div>

                                    </div>
                                @endforeach
                            </div>

                        </div>
                    @endif
                @endforeach

                {{-- Summary --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mt-2">
                    <h3 class="font-semibold text-gray-800 mb-3 text-sm">Ringkasan Belanja</h3>

                    <div class="space-y-2 mb-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Subtotal</span>
                            <span class="text-sm font-semibold text-gray-800" id="subtotal">Rp 0</span>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <div class="flex justify-between items-center mb-4">
                        <span class="font-bold text-gray-800">Total</span>
                        <span class="font-bold text-lg text-cyan-600" id="total">Rp 0</span>
                    </div>

                    <button type="submit" id="checkOutBtn" class="checkout-btn" disabled>
                        <span class="iconify" data-icon="mdi:shopping-outline" data-width="20"></span>
                        Checkout
                    </button>
                </div>

            </form>

        @else
            {{-- Empty State --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                        <span class="iconify text-gray-300" data-icon="mdi:cart-outline" data-width="40"></span>
                    </div>
                    <h2 class="font-bold text-gray-700 text-lg mb-1">Keranjang Kosong</h2>
                    <p class="text-gray-400 text-sm mb-5">Belum ada produk di keranjang Anda</p>
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center gap-2 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold py-2.5 px-5 rounded-xl transition duration-200 text-sm">
                        <span class="iconify" data-icon="mdi:storefront-outline" data-width="16"></span>
                        Mulai Belanja
                    </a>
                </div>
            </div>
        @endif

    </main>

    <script>
        /* Restaurant checkbox -> products */
        document.querySelectorAll('.restaurant-checkbox').forEach(r => {
            r.addEventListener('change', function () {
                const id = this.dataset.restaurantId;
                document.querySelectorAll(
                    `.product-checkbox[data-restaurant-id="${id}"]`
                ).forEach(p => p.checked = this.checked);
                updateTotals();
            });
        });

        /* Product checkbox -> restaurant */
        document.querySelectorAll('.product-checkbox').forEach(p => {
            p.addEventListener('change', function () {
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
                updateTotals();
            };
        });

        /* Calculate totals (only checked products) */
        function updateTotals() {
            let subtotal = 0;

            const checkedProducts = document.querySelectorAll('.product-checkbox:checked')

            checkedProducts.forEach(cb => {
                const item = cb.closest('.cart-item');
                const price = parseInt(item.querySelector('.item-price').dataset.price);
                const qty = parseInt(item.querySelector('.quantity-input').value);
                subtotal += price * qty;
            });

            const tax = subtotal * 0.1;
            const total = subtotal;

            const rupiah = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });

            document.getElementById('subtotal').innerText = rupiah.format(subtotal);
            document.getElementById('total').innerText = rupiah.format(total);

            const checkOutBtn = document.getElementById('checkOutBtn');

            if (checkedProducts.length > 0) {
                checkOutBtn.disabled = false;
                checkOutBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                checkOutBtn.disabled = true;
                checkOutBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        updateTotals();
    </script>

</body>

</html>