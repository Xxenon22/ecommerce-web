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
        document.addEventListener('DOMContentLoaded', function () {
            // Payment method selection
            const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
            paymentMethods.forEach(method => {
                method.addEventListener('change', function () {
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

            // Address selection - auto-fill form fields and preview
            const savedAddressSelect = document.getElementById('saved_address');
            const addressPreview = document.getElementById('address_preview');
            const defaultAddress = document.getElementById('default_address');

            if (savedAddressSelect) {
                savedAddressSelect.addEventListener('change', function () {
                    const selectedOption = this.options[this.selectedIndex];
                    if (selectedOption.value) {
                        // Update hidden form fields
                        document.getElementById('name').value = selectedOption.dataset.name || '';
                        document.getElementById('phone').value = selectedOption.dataset.phone || '';
                        document.getElementById('address').value = selectedOption.dataset.address || '';

                        // Show preview, hide default
                        if (addressPreview && defaultAddress) {
                            addressPreview.classList.remove('hidden');
                            defaultAddress.classList.add('hidden');

                            // Update preview content
                            document.getElementById('preview_name').textContent = selectedOption.dataset.name || '';
                            document.getElementById('preview_phone').textContent = selectedOption.dataset.phone || '';
                            document.getElementById('preview_address').textContent = selectedOption.dataset.address || '';
                        }
                    } else {
                        // Reset to default address
                        if (addressPreview && defaultAddress) {
                            addressPreview.classList.add('hidden');
                            defaultAddress.classList.remove('hidden');
                        }
                    }
                });
            }

            // Form validation
            const checkoutForm = document.getElementById('checkout-form');
            checkoutForm.addEventListener('submit', function (e) {
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
                @if (isset($products) && count($products) > 0)
                    @php $total = 0; @endphp
                    @foreach ($products as $item)
                        @php
                            $product = App\Models\Product::find($item['product_id']);
                            $total += $item['quantity'] * $product['price'];
                        @endphp
                        <div class="flex items-center justify-between py-2 border-b border-gray-200 last:border-b-0">
                            <div class="flex items-center space-x-3">
                                <img src="{{ asset(file_exists(public_path($product['photo'])) ? $product['photo'] : 'assets/pasar-ikan.png') }}"
                                    alt="{{ $product['name'] }}" class="w-12 h-12 object-cover rounded">
                                <div>
                                    <h3 class="font-medium">{{ $product['name'] }}</h3>
                                    <p class="text-sm text-gray-500">Qty: {{ number_format($item['quantity']) }}</p>
                                </div>
                            </div>
                            <span class="font-semibold text-red-500">Rp {{ number_format($product['price']) }}</span>
                        </div>
                    @endforeach

                    <div class="mt-4 pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold">Total</span>
                            <span class="text-lg font-bold text-red-500">Rp {{ number_format($total) }}</span>
                            <input type="hidden" name="total" value="{{$total}}" id="total">
                        </div>
                    </div>
                @endif
            </div>

            <!-- Delivery Information -->
            <div class="bg-white rounded-lg shadow-md p-4 mb-4">
                <h2 class="text-lg font-semibold mb-4">Informasi Pengiriman</h2>

                <div class="space-y-4">
                    <!-- Select Saved Address -->
                    @if(isset($addresses) && count($addresses) > 0)
                        <div>
                            <label for="saved_address" class="block text-sm font-medium text-gray-700 mb-1">Pilih Alamat
                                Tersimpan</label>
                            <select id="saved_address"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Pilih Alamat --</option>
                                @foreach($addresses as $addr)
                                    <option value="{{ $addr->id }}" data-name="{{ $addr->recipient_name }}"
                                        data-phone="{{ $addr->phone }}"
                                        data-address="{{ $addr->address_detail }}, {{ $addr->district }}, {{ $addr->city }}, {{ $addr->province }} {{ $addr->postal_code }}">
                                        {{ $addr->recipient_name }} - {{ $addr->address_detail }}, {{ $addr->district }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <!-- Address Preview -->
                    <div id="address_preview" class="hidden bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div class="flex items-start space-x-3">
                            <span class="iconify" data-icon="mdi:map-marker" data-width="24" data-height="24"></span>
                            <div>
                                <p id="preview_name" class="font-semibold text-gray-800"></p>
                                <p id="preview_phone" class="text-gray-600 text-sm"></p>
                                <p id="preview_address" class="text-gray-700 mt-1"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Default Address (when no saved address selected) -->
                    <div id="default_address" class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div class="flex items-start space-x-3">
                            <span class="iconify" data-icon="mdi:map-marker" data-width="24" data-height="24"></span>
                            <div>
                                <p class="font-semibold text-gray-800">{{ Auth::user()->name ?? '' }}</p>
                                <p class="text-gray-600 text-sm">{{ Auth::user()->phone ?? '' }}</p>
                                <p class="text-gray-700 mt-1">{{ Auth::user()->address ?? '' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden form fields for submission -->
                    <input type="hidden" id="name" name="name" value="{{ Auth::user()->name ?? '' }}">
                    <input type="hidden" id="phone" name="phone" value="{{ Auth::user()->phone ?? '' }}">
                    <input type="hidden" id="address" name="address" value="{{ Auth::user()->address ?? '' }}">

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan
                            (Opsional)</label>
                        <textarea id="notes" name="notes" rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Catatan tambahan untuk pengiriman"></textarea>
                    </div>
                </div>
            </div>

            <!-- Place Order Button -->
            <button type="submit"
                class="w-full bg-cyan-600 hover:bg-cyan-700 text-white font-semibold py-4 px-4 rounded-lg transition duration-300 text-lg"
                id="pay-button">
                Buat order
            </button>
        </form>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        $('#pay-button').click(function (event) {
            event.preventDefault();

            $.post("{{ route('mid.pay') }}", {
                _method: 'POST',
                _token: '{{ csrf_token() }}',
                name: $('#name').val(),
                phone: $('#phone').val(),
                address: $('#address').val(),
                notes: $('#notes').val(),
                amount: $('#total').val(),
            }, function (data, status) {
                snap.pay(data.snap_token, {
                    onSuccess: function (result) {
                        location.reload();
                    },
                    onPending: function (result) {
                        location.reload();
                    },
                    onError: function (result) {
                        location.reload();
                    },
                });
                return false;
            });
        });
    </script>
</body>

</html>