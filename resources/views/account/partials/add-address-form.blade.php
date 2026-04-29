<form id="add-address-form" action="{{ route('addresses.store') }}" method="POST"
    class="hidden border rounded-lg p-4 space-y-4 bg-gray-50">
    @csrf

    <div>
        <label class="text-sm font-medium">Recipient Name</label>
        <input type="text" name="recipient_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
    </div>

    <div>
        <label class="text-sm font-medium">Phone</label>
        <input type="text" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
    </div>

    <div>
        <label class="text-sm font-medium">Address Detail</label>
        <textarea name="address_detail" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required></textarea>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-sm font-medium">District</label>
            <input type="text" name="district" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
        </div>
        <div>
            <label class="text-sm font-medium">City</label>
            <input type="text" name="city" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-sm font-medium">Province</label>
            <input type="text" name="province" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
        </div>
        <div>
            <label class="text-sm font-medium">Postal Code</label>
            <input type="text" name="postal_code" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- LOKASI: Leaflet Map Picker                                    --}}
    {{-- ============================================================ --}}
    <div class="border border-gray-200 rounded-xl overflow-hidden">

        {{-- Header --}}
        <div class="flex items-center justify-between bg-gray-50 px-4 py-3 border-b border-gray-200">
            <div class="flex items-center gap-2">
                <span class="iconify text-cyan-600" data-icon="mdi:map-marker" data-width="18"></span>
                <span class="text-sm font-semibold text-gray-700">Lokasi Pengiriman</span>
            </div>
            <button type="button" id="btn-detect-add-address"
                class="flex items-center gap-1.5 text-xs font-semibold text-cyan-600 hover:text-cyan-700
                       bg-cyan-50 hover:bg-cyan-100 px-3 py-1.5 rounded-lg transition">
                <span class="iconify" data-icon="mdi:crosshairs-gps" data-width="14"></span>
                Deteksi Otomatis
            </button>
        </div>

        {{-- Map --}}
        <div id="add-address-map" class="w-full" style="height: 280px; z-index: 0;"></div>
        <p class="text-xs text-gray-400 text-center py-1.5 bg-gray-50 border-t border-gray-100">
            <span class="iconify inline" data-icon="mdi:gesture-tap" data-width="13"></span>
            Klik pada peta untuk menentukan titik lokasi
        </p>

        {{-- Input Manual --}}
        <div class="grid grid-cols-2 gap-3 p-4 border-t border-gray-200">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Latitude</label>
                <input type="text" id="add-addr-lat" name="latitude"
                    placeholder="-6.200000"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm
                           focus:outline-none focus:ring-2 focus:ring-cyan-300 focus:border-cyan-400
                           font-mono">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Longitude</label>
                <input type="text" id="add-addr-lng" name="longitude"
                    placeholder="106.816666"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm
                           focus:outline-none focus:ring-2 focus:ring-cyan-300 focus:border-cyan-400
                           font-mono">
            </div>
        </div>

        {{-- Status bar --}}
        <div id="add-address-status"
            class="hidden mx-4 mb-4 px-3 py-2 rounded-lg text-xs font-medium flex items-center gap-2">
        </div>
    </div>
    {{-- ============================================================ --}}

    <div class="flex justify-end gap-2">
        <button type="button" onclick="this.closest('form').classList.add('hidden')"
            class="px-4 py-2 border rounded-lg">
            Cancel
        </button>
        <button type="submit" class="px-4 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700">
            Save Address
        </button>
    </div>
</form>