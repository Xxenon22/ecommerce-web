<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Fishery Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Payment method selection
            const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
            paymentMethods.forEach(method => {
                method.addEventListener('change', function() {
                    // Hide all payment details
                    document.querySelectorAll('.payment-details').forEach(detail => {
                        detail.classList.add('hidden');
                    });
                    // Show selected payment details
                    const selectedMethod = this.value;
                    const selectedDetails = document.getElementById(`${selectedMethod}-details`);
                    if (selectedDetails) {
                        selectedDetails.classList.remove('hidden');
                    }
                });
            });

            // Form validation
            const checkoutForm = document.getElementById('checkout-form');
            checkoutForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Basic validation
                const requiredFields = ['name', 'phone', 'address'];
                let isValid = true;

                requiredFields.forEach(field => {
                    const input = document.getElementById(field);
                    if (!input.value.trim()) {
                        input.classList.add('border-red-500');
                        isValid = false;
                    } else {
                        input.classList.remove('border-red-500');
                    }
                });

                const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
                if (!paymentMethod) {
                    alert('Silakan pilih metode pembayaran');
                    isValid = false;
                }

                if (isValid) {
                    // Show success message
                    alert('order berhasil dibuat! Terima kasih telah berbelanja.');
                    // Redirect to order page or home
                    window.location.href = '{{ route('order') }}';
                }
            });
        });
    </script>
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="header flex items-center justify-between p-4 bg-white shadow-md">
        <div class="flex items-center space-x-2">
            <a href="{{ route('cart') }}">
                <span class="iconify cursor-pointer" data-icon="weui:back-outlined" data-width="38"
                    data-height="38"></span>
            </a>
            <h1 class="font-bold text-xl text-gray-700">Checkout</h1>
        </div>
    </div>

    <main class="max-w-4xl mx-auto p-4">
        <form id="checkout-form">
            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow-md p-4 mb-4">
                <h2 class="text-lg font-semibold mb-4">Ringkasan order</h2>
                @if (isset($cart) && count($cart) > 0)
                    @foreach ($cart as $item)
                        <div class="flex items-center justify-between py-2 border-b border-gray-200 last:border-b-0">
                            <div class="flex items-center space-x-3">
                                <img src="{{ asset(file_exists(public_path($item['image'])) ? $item['image'] : 'assets/pasar-ikan.png') }}" alt="{{ $item['name'] }}"
                                    class="w-12 h-12 object-cover rounded">
                                <div>
                                    <h3 class="font-medium">{{ $item['name'] }}</h3>
                                    <p class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</p>
                                </div>
                            </div>
                            <span class="font-semibold text-red-500">{{ $item['price'] }}</span>
                        </div>
                    @endforeach

                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-semibold">Rp80.000</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Pajak (10%)</span>
                            <span class="font-semibold">Rp8.000</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Ongkir</span>
                            <span class="font-semibold">Rp10.000</span>
                        </div>
                        <hr class="my-2">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold">Total</span>
                            <span class="text-lg font-bold text-red-500">Rp98.000</span>
                            <input type="hidden" name="total" value="98000" id="total">
                        </div>
                    </div>
                @endif
            </div>

            <!-- Delivery Information -->
            <div class="bg-white rounded-lg shadow-md p-4 mb-4">
                <h2 class="text-lg font-semibold mb-4">Informasi Pengiriman</h2>

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ Auth::user()->name ?? '' }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <input type="tel" id="phone" name="phone" value="{{ Auth::user()->phone ?? '' }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat
                            Lengkap</label>
                        <textarea id="address" name="address" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="loginkan alamat lengkap pengiriman" required>{{ Auth::user()->address ?? '' }}</textarea>
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan
                            (Opsional)</label>
                        <textarea id="notes" name="notes" rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Catatan tambahan untuk pengiriman"></textarea>
                    </div>
                </div>
            </div>

            <!-- Payment Method -->
            {{-- <div class="bg-white rounded-lg shadow-md p-4 mb-4">
                <h2 class="text-lg font-semibold mb-4">Metode Pembayaran</h2>

                <div class="space-y-3">
                    <!-- Transfer Bank -->
                    <div class="flex items-center">
                        <input type="radio" id="bank_transfer" name="payment_method" value="bank_transfer" class="mr-3">
                        <label for="bank_transfer" class="flex items-center cursor-pointer">
                            <span class="iconify mr-2" data-icon="mdi:bank" data-width="24" data-height="24"></span>
                            Transfer Bank
                        </label>
                    </div>

                    <!-- E-Wallet -->
                    <div class="flex items-center">
                        <input type="radio" id="ewallet" name="payment_method" value="ewallet" class="mr-3">
                        <label for="ewallet" class="flex items-center cursor-pointer">
                            <span class="iconify mr-2" data-icon="mdi:wallet" data-width="24" data-height="24"></span>
                            E-Wallet (GoPay, OVO, Dana)
                        </label>
                    </div>

                    <!-- COD -->
                    <div class="flex items-center">
                        <input type="radio" id="cod" name="payment_method" value="cod" class="mr-3">
                        <label for="cod" class="flex items-center cursor-pointer">
                            <span class="iconify mr-2" data-icon="mdi:cash" data-width="24" data-height="24"></span>
                            Bayar di Tempat (COD)
                        </label>
                    </div>
                </div>

                <!-- Payment Details -->
                <div id="bank_transfer-details" class="payment-details hidden mt-4 p-4 bg-gray-50 rounded-md">
                    <h3 class="font-medium mb-2">Transfer ke rekening:</h3>
                    <p class="text-sm">BCA: 1234567890 a.n. Fishery Hub</p>
                    <p class="text-sm">Mandiri: 0987654321 a.n. Fishery Hub</p>
                </div>

                <div id="ewallet-details" class="payment-details hidden mt-4 p-4 bg-gray-50 rounded-md">
                    <h3 class="font-medium mb-2">Pilih E-Wallet:</h3>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input type="radio" id="gopay" name="ewallet_type" value="gopay" class="mr-2">
                            <label for="gopay">GoPay</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="ovo" name="ewallet_type" value="ovo" class="mr-2">
                            <label for="ovo">OVO</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="dana" name="ewallet_type" value="dana" class="mr-2">
                            <label for="dana">Dana</label>
                        </div>
                    </div>
                </div>

                <div id="cod-details" class="payment-details hidden mt-4 p-4 bg-gray-50 rounded-md">
                    <p class="text-sm text-gray-600">Pembayaran dilakukan saat barang diterima di alamat tujuan.</p>
                </div>
            </div> --}}

            <!-- Place Order Button -->
            <button type="submit"
                class="w-full bg-cyan-600 hover:bg-cyan-700 text-white font-semibold py-4 px-4 rounded-lg transition duration-300 text-lg" id="pay-button">
                Buat order
            </button>
        </form>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        $('#pay-button').click(function(event) {
            event.preventDefault();

            $.post("{{ route('mid.pay') }}", {
                _method: 'POST',
                _token: '{{ csrf_token() }}',
                name: $('#name').val(),
                phone: $('#phone').val(),
                address: $('#address').val(),
                notes: $('#notes').val(),
                amount: $('#total').val(),
            }, function(data, status) {
                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        location.reload();
                    },
                    onPending: function(result) {
                        location.reload();
                    },
                    onError: function(result) {
                        location.reload();
                    },
                });
                return false;
            });
        });
    </script>
</body>

</html>
