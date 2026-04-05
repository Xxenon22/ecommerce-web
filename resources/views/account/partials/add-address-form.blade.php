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
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-sm font-medium">Latitude</label>
            <input type="text" id="latitude" name="latitude" class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                required>
        </div>
        <div>
            <label class="text-sm font-medium">Longitude</label>
            <input type="text" id="longitude" name="longitude"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
        </div>
    </div>

    <div class="flex items-center gap-2">
        <button type="button" onclick="getLocation()"
            class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
            📍 Ambil Lokasi Otomatis
        </button>
        <span class="text-xs text-gray-500">Isi otomatis dari GPS</span>
    </div>

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