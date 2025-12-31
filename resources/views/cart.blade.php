<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cart - Fishery Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Quantity adjustment
            const quantityInputs = document.querySelectorAll('.quantity-input');
            quantityInputs.forEach(input => {
                const minusBtn = input.parentElement.querySelector('.minus-btn');
                const plusBtn = input.parentElement.querySelector('.plus-btn');

                minusBtn.addEventListener('click', function () {
                    let value = parseInt(input.value);
                    if (value > 1) {
                        input.value = value - 1;
                        updateTotals();
                    }
                });

                plusBtn.addEventListener('click', function () {
                    let value = parseInt(input.value);
                    input.value = value + 1;
                    updateTotals();
                });

                input.addEventListener('change', updateTotals);
            });

            // Remove item
            const removeBtns = document.querySelectorAll('.remove-btn');
            removeBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    const item = this.closest('.cart-item');
                    item.remove();
                    updateTotals();
                });
            });

            function updateTotals() {
                let subtotal = 0;
                const items = document.querySelectorAll('.cart-item');
                items.forEach(item => {
                    const price = parseFloat(item.querySelector('.item-price').textContent.replace('Rp', '').replace('.', ''));
                    const quantity = parseInt(item.querySelector('.quantity-input').value);
                    subtotal += price * quantity;
                });

                const tax = subtotal * 0.1; // 10% tax
                const total = subtotal + tax;

                document.getElementById('subtotal').textContent = 'Rp' + subtotal.toLocaleString('id-ID');
                document.getElementById('tax').textContent = 'Rp' + tax.toLocaleString('id-ID');
                document.getElementById('total').textContent = 'Rp' + total.toLocaleString('id-ID');
            }

            updateTotals(); // Initial calculation
        });
    </script>
</head>

<body class="bg-gray-100 min-h-screen pb-20">
    <div class="header flex items-center justify-between p-4 bg-white shadow-md">
        <div class="flex items-center space-x-2">
            <a href="{{ route('home') }}">
                <span class="iconify cursor-pointer" data-icon="weui:back-outlined" data-width="38"
                    data-height="38"></span>
            </a>
            <h1 class="font-bold text-xl text-gray-700">cart Belanja</h1>
        </div>
    </div>

    <main class="max-w-4xl mx-auto p-4">
        @if(count($cart ?? []) > 0)
            <div class="bg-white rounded-lg shadow-md p-4 mb-4">
                @foreach($cart as $item)
                    <div class="cart-item flex items-center justify-between py-4 border-b border-gray-200 last:border-b-0">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset(file_exists(public_path($item['image'])) ? $item['image'] : 'assets/pasar-ikan.png') }}" alt="{{ $item['name'] }}"
                                class="w-16 h-16 object-cover rounded-lg">
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $item['name'] }}</h3>
                                <p class="text-sm text-gray-500">{{ $item['description'] ?? 'Deskripsi produk' }}</p>
                                <p class="text-lg font-bold text-red-500 item-price">{{ $item['price'] }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button
                                class="minus-btn bg-gray-200 hover:bg-gray-300 rounded-full w-8 h-8 flex items-center justify-center">
                                <span class="iconify" data-icon="mdi:minus" data-width="16" data-height="16"></span>
                            </button>
                            <input type="number" value="{{ $item['quantity'] }}" min="1"
                                class="quantity-input w-12 text-center border border-gray-300 rounded">
                            <button
                                class="plus-btn bg-gray-200 hover:bg-gray-300 rounded-full w-8 h-8 flex items-center justify-center">
                                <span class="iconify" data-icon="mdi:plus" data-width="16" data-height="16"></span>
                            </button>
                            <button class="remove-btn text-red-500 hover:text-red-700 ml-4">
                                <span class="iconify" data-icon="mdi:delete-outline" data-width="24" data-height="24"></span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-600">Subtotal</span>
                    <span id="subtotal" class="font-semibold">Rp0</span>
                </div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-600">Pajak (10%)</span>
                    <span id="tax" class="font-semibold">Rp0</span>
                </div>
                <hr class="my-2">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-lg font-bold text-gray-800">Total</span>
                    <span id="total" class="text-lg font-bold text-red-500">Rp0</span>
                </div>
                <a href="{{ route('checkout') }}"
                    class="w-full bg-cyan-600 hover:bg-cyan-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-300 text-center block">
                    Checkout
                </a>
            </div>
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

    <x-navbar :cart-count="2" :active-route="'cart'" />
</body>

</html>