<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Fishery Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        .section-card {
            background: white;
            border-radius: 20px;
            border: 0.5px solid #f3f4f6;
            box-shadow: 0 1px 8px rgba(0,0,0,0.05);
            padding: 1.25rem;
            margin-bottom: 0.75rem;
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .address-card {
            background: #f0fdff;
            border: 1.5px solid #a5f3fc;
            border-radius: 14px;
            padding: 14px;
        }

        .custom-select {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            font-size: 13px;
            color: #374151;
            background: white;
            outline: none;
            transition: border-color 0.2s;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 36px;
        }
        .custom-select:focus { border-color: #0891b2; }
        .custom-select:disabled { background: #f9fafb; color: #9ca3af; cursor: not-allowed; }

        .custom-textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            font-size: 13px;
            color: #374151;
            outline: none;
            resize: none;
            transition: border-color 0.2s;
        }
        .custom-textarea:focus { border-color: #0891b2; }

        .product-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .product-row:last-of-type { border-bottom: none; }

        .divider { height: 1px; background: #f3f4f6; margin: 12px 0; }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
        }

        .checkout-btn {
            width: 100%;
            background: #0891b2;
            color: white;
            padding: 15px;
            border-radius: 16px;
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
        .checkout-btn:hover:not(:disabled) { background: #0e7490; transform: translateY(-1px); }
        .checkout-btn:active:not(:disabled) { transform: scale(0.98); }
        .checkout-btn:disabled {
            background: #e5e7eb;
            color: #9ca3af;
            cursor: not-allowed;
            transform: none;
        }

        .label-sm {
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 6px;
            display: block;
        }

        .courier-loading {
            display: none;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #6b7280;
            padding: 10px 0;
        }

        @keyframes spin { to { transform: rotate(360deg); } }
        .spin { animation: spin 0.8s linear infinite; display: inline-block; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .section-card { animation: fadeInUp 0.3s ease forwards; }
        .section-card:nth-child(2) { animation-delay: 0.05s; }
        .section-card:nth-child(3) { animation-delay: 0.1s; }
    </style>
</head>

<body class="bg-gray-50 min-h-screen pb-8">

    {{-- Header --}}
    <div class="sticky top-0 z-50 bg-white border-b border-gray-100 px-4 py-3 flex items-center gap-3 shadow-sm">
        <a href="{{ route('cart') }}"
            class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-gray-100 transition">
            <span class="iconify" data-icon="weui:back-outlined" data-width="22" data-height="22"></span>
        </a>
        <div>
            <h1 class="font-bold text-gray-900 text-lg leading-tight">Checkout</h1>
            <p class="text-xs text-gray-400">Selesaikan pesanan Anda</p>
        </div>
    </div>

    <main class="max-w-2xl mx-auto px-4 pt-4">

        {{-- Delivery Info (outside form) --}}
        <div class="section-card">
            <div class="section-title">
                <span class="iconify text-cyan-600" data-icon="mdi:map-marker-outline" data-width="18"></span>
                Informasi Pengiriman
            </div>

            {{-- Address Selector --}}
            @if (isset($addresses) && count($addresses) > 0)
                <div class="mb-3">
                    <label class="label-sm">Pilih Alamat</label>
                    <select id="saved_address" class="custom-select">
                        @foreach ($addresses as $addr)
                            <option value="{{ $addr->id }}"
                                data-name="{{ $addr->recipient_name }}"
                                data-phone="{{ $addr->phone }}"
                                data-address="{{ $addr->address_detail }}, {{ $addr->district }}, {{ $addr->city }}, {{ $addr->province }} {{ $addr->postal_code }}">
                                {{ $addr->recipient_name }} — {{ $addr->address_detail }}, {{ $addr->district }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            {{-- Address Preview --}}
            <div id="address_preview" class="address-card">
                <div class="flex items-start gap-3">
                    <span class="iconify text-cyan-500 mt-0.5 flex-shrink-0" data-icon="mdi:map-marker" data-width="20"></span>
                    <div>
                        <p id="preview_name" class="font-semibold text-gray-800 text-sm"></p>
                        <p id="preview_phone" class="text-gray-500 text-xs mt-0.5"></p>
                        <p id="preview_address" class="text-gray-600 text-xs mt-1 leading-relaxed"></p>
                    </div>
                </div>
            </div>

            {{-- Default Address (fallback jika tidak ada saved address) --}}
            <div id="default_address" class="address-card hidden">
                <div class="flex items-start gap-3">
                    <span class="iconify text-cyan-500 mt-0.5 flex-shrink-0" data-icon="mdi:map-marker" data-width="20"></span>
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">{{ Auth::user()->name ?? '' }}</p>
                        <p class="text-gray-500 text-xs mt-0.5">{{ Auth::user()->phone ?? '' }}</p>
                        <p class="text-gray-600 text-xs mt-1">{{ Auth::user()->address ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Hidden fields --}}
            <input type="hidden" id="name" value="{{ isset($addresses[0]) ? $addresses[0]->recipient_name : (Auth::user()->name ?? '') }}">
            <input type="hidden" id="phone" value="{{ isset($addresses[0]) ? $addresses[0]->phone : (Auth::user()->phone ?? '') }}">
            <input type="hidden" id="address" value="{{ isset($addresses[0]) ? $addresses[0]->address_detail.', '.$addresses[0]->district.', '.$addresses[0]->city.', '.$addresses[0]->province.' '.$addresses[0]->postal_code : (Auth::user()->address ?? '-') }}">

            {{-- Notes --}}
            <div class="mt-3">
                <label class="label-sm">Catatan (Opsional)</label>
                <textarea id="notes" rows="2" class="custom-textarea"
                    placeholder="Catatan tambahan untuk pengiriman..."></textarea>
            </div>
        </div>

        <form id="checkout-form">

            {{-- Order Summary --}}
            <div class="section-card">
                <div class="section-title">
                    <span class="iconify text-cyan-600" data-icon="mdi:shopping-outline" data-width="18"></span>
                    Ringkasan Pesanan
                </div>

                @if (isset($products) && count($products) > 0)
                    @php $total = 0; @endphp

                    {{-- Product List --}}
                    @foreach ($products as $item)
                        @php
                            $product = App\Models\Product::find($item['product_id']);
                            $total += $item['quantity'] * $product['price'];
                        @endphp
                        <div class="product-row">
                            <img src="{{ asset(file_exists(public_path('storage/'.$product['photo'])) ? 'storage/'.$product['photo'] : 'assets/pasar-ikan.png') }}"
                                alt="{{ $product['name'] }}"
                                class="w-12 h-12 object-cover rounded-xl border border-gray-100 flex-shrink-0">
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-800 text-sm truncate">{{ $product['name'] }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ number_format($item['quantity']) }} barang</p>
                            </div>
                            <span class="font-bold text-gray-800 text-sm flex-shrink-0">
                                Rp {{ number_format($product['price'], 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach

                    <div class="divider"></div>

                    {{-- Shipping Options --}}
                    <div class="section-title mt-2">
                        <span class="iconify text-cyan-600" data-icon="mdi:truck-outline" data-width="18"></span>
                        Opsi Pengiriman
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="label-sm">Pilih Kurir</label>
                            <select name="courier" id="courier" class="custom-select">
                                <option value="">-- Pilih Kurir --</option>
                                @foreach ($couriers as $courier)
                                    <option value="{{ $courier['courier_code'] }}">
                                        {{ $courier['courier_name'] }} {{ $courier['courier_service_name'] }}
                                        {{ $courier['shipment_duration_range'] }}
                                        {{ $courier['shipment_duration_unit'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="label-sm">Pilih Service</label>
                            <div id="courier-loading" class="courier-loading">
                                <span class="iconify spin text-cyan-500" data-icon="mdi:loading" data-width="16"></span>
                                Memuat layanan pengiriman...
                            </div>
                            <select id="service-dropdown" class="custom-select" disabled>
                                <option value="">-- Pilih kurir terlebih dahulu --</option>
                            </select>
                        </div>
                    </div>

                    <div class="divider"></div>

                    {{-- Totals --}}
                    <div class="space-y-1">
                        <div class="total-row">
                            <span class="text-sm text-gray-500">Total Pesanan</span>
                            <span id="order-total" class="text-sm font-semibold text-gray-800"
                                data-total="{{ $total }}">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="total-row">
                            <span class="text-sm text-gray-500">Ongkir</span>
                            <span id="ongkir" class="text-sm font-semibold text-gray-800">Rp 0</span>
                            <input type="hidden" name="price-ongkir" id="price-ongkir" value="">
                        </div>
                    </div>

                    <div class="divider"></div>

                    <div class="total-row">
                        <span class="font-bold text-gray-900">Grand Total</span>
                        <span id="grand-total" class="font-bold text-lg text-cyan-600">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </span>
                        <input type="hidden" name="total" id="total" value="{{ $total }}">
                    </div>
                @endif
            </div>

            {{-- Submit Button --}}
            <button type="submit" id="pay-button" class="checkout-btn" disabled>
                <span class="iconify" data-icon="mdi:lock-outline" data-width="18"></span>
                Pilih kurir & service terlebih dahulu
            </button>

        </form>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        // ── Auto-select first address on load ──────────────────────────────
        (function () {
            const select = document.getElementById('saved_address');
            if (!select) {
                // No saved addresses — show default
                document.getElementById('default_address')?.classList.remove('hidden');
                document.getElementById('address_preview')?.classList.add('hidden');
                return;
            }

            const firstOpt = select.options[0];
            if (firstOpt) {
                select.value = firstOpt.value;
                fillAddress(firstOpt);
            }
        })();

        function fillAddress(option) {
            document.getElementById('name').value    = option.dataset.name    || '';
            document.getElementById('phone').value   = option.dataset.phone   || '';
            document.getElementById('address').value = option.dataset.address || '';

            document.getElementById('preview_name').textContent    = option.dataset.name    || '';
            document.getElementById('preview_phone').textContent   = option.dataset.phone   || '';
            document.getElementById('preview_address').textContent = option.dataset.address || '';

            document.getElementById('address_preview').classList.remove('hidden');
            document.getElementById('default_address')?.classList.add('hidden');
        }

        // ── Address selector change ────────────────────────────────────────
        document.getElementById('saved_address')?.addEventListener('change', function () {
            const opt = this.options[this.selectedIndex];
            if (opt.value) {
                fillAddress(opt);
            } else {
                document.getElementById('address_preview').classList.add('hidden');
                document.getElementById('default_address')?.classList.remove('hidden');
            }
        });

        // ── Checkout button state ──────────────────────────────────────────
        function updateCheckoutBtn() {
            const courierVal = $('#courier').val();
            const serviceVal = $('#service-dropdown').val();
            const btn        = document.getElementById('pay-button');

            if (courierVal && serviceVal) {
                btn.disabled = false;
                btn.innerHTML = '<span class="iconify" data-icon="mdi:credit-card-outline" data-width="18"></span> Buat Order & Bayar';
            } else if (courierVal && !serviceVal) {
                btn.disabled = true;
                btn.innerHTML = '<span class="iconify" data-icon="mdi:lock-outline" data-width="18"></span> Pilih service pengiriman';
            } else {
                btn.disabled = true;
                btn.innerHTML = '<span class="iconify" data-icon="mdi:lock-outline" data-width="18"></span> Pilih kurir & service terlebih dahulu';
            }
        }

        // ── Courier change → fetch rates ──────────────────────────────────
        $('#courier').change(function () {
            const courier = $(this).val();
            if (!courier) {
                $('#service-dropdown').html('<option value="">-- Pilih kurir terlebih dahulu --</option>').prop('disabled', true);
                updateCheckoutBtn();
                return;
            }

            $('#courier-loading').css('display', 'flex');
            $('#service-dropdown').prop('disabled', true).html('<option value="">Memuat layanan...</option>');

            $.post("{{ route('get.rates') }}", {
                _token: "{{ csrf_token() }}",
                courier: courier,
                destination_postal_code: "{{ $addresses[0]->postal_code ?? '' }}",
                total: $('#order-total').data('total'),
                products: @json($products)
            }, function (response) {
                $('#courier-loading').hide();

                if (!response.success || !response.pricing || response.pricing.length === 0) {
                    $('#service-dropdown').html('<option value="">Tidak ada layanan tersedia</option>').prop('disabled', false);
                    updateCheckoutBtn();
                    return;
                }

                let options = '<option value="">-- Pilih Service --</option>';
                response.pricing.forEach(function (rate) {
                    const price    = Number(rate.price) || 0;
                    const duration = rate.duration || '-';
                    options += `<option value="${rate.courier_service_code}" data-price="${price}">
                        ${rate.courier_name} - ${rate.courier_service_name} (${duration}) - Rp ${price.toLocaleString('id-ID')}
                    </option>`;
                });

                $('#service-dropdown').html(options).prop('disabled', false);
                updateCheckoutBtn();
            }).fail(function () {
                $('#courier-loading').hide();
                $('#service-dropdown').html('<option value="">Gagal memuat layanan</option>').prop('disabled', false);
                updateCheckoutBtn();
            });
        });

        // ── Service change → update totals ────────────────────────────────
        $('#service-dropdown').on('change', function () {
            const price      = Number($(this).find(':selected').data('price')) || 0;
            const orderTotal = Number($('#order-total').data('total')) || 0;
            const grandTotal = orderTotal + price;

            $('#ongkir').text('Rp ' + price.toLocaleString('id-ID'));
            $('#price-ongkir').val(price);
            $('#grand-total').text('Rp ' + grandTotal.toLocaleString('id-ID'));
            $('#total').val(grandTotal);

            updateCheckoutBtn();
        });

        // ── Form submit ───────────────────────────────────────────────────
        document.getElementById('checkout-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const btn = document.getElementById('pay-button');
            btn.disabled = true;
            btn.innerHTML = '<span class="iconify spin" data-icon="mdi:loading" data-width="18"></span> Memproses...';

            $.post("{{ route('mid.pay') }}", {
                _token:   '{{ csrf_token() }}',
                id:       {{ auth()->user()->id }},
                name:     $('#name').val(),
                phone:    $('#phone').val(),
                address:  $('#address').val(),
                notes:    $('#notes').val(),
                amount:   $('#total').val(),
                courier:  $('#courier').val(),
                ongkir:   $('#price-ongkir').val(),
                products: @json($products),
            }, function (data) {
                snap.pay(data.snap_token, {
                    onSuccess: function () { location.href = '{{ route('history') }}'; },
                    onPending: function () { location.href = '{{ route('history') }}'; },
                    onError:   function () {
                        alert('Pembayaran gagal, silakan coba lagi.');
                        btn.disabled = false;
                        btn.innerHTML = '<span class="iconify" data-icon="mdi:credit-card-outline" data-width="18"></span> Buat Order & Bayar';
                    },
                    onClose:   function () {
                        btn.disabled = false;
                        btn.innerHTML = '<span class="iconify" data-icon="mdi:credit-card-outline" data-width="18"></span> Buat Order & Bayar';
                    },
                });
            }).fail(function () {
                alert('Gagal membuat transaksi, silakan coba lagi.');
                btn.disabled = false;
                btn.innerHTML = '<span class="iconify" data-icon="mdi:credit-card-outline" data-width="18"></span> Buat Order & Bayar';
            });
        });
    </script>
</body>
</html>