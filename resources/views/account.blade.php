<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('/logo.jpeg') }}" type="image/png">
    <title>My Account | Fishery Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <style>
        .font-display {
            font-family: 'Fraunces', serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gray-50">

    {{-- Top Navigation --}}
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    {{-- <span class="iconify text-cyan-600" data-icon="mdi:fish" data-width="28" data-height="28"></span> --}}
                    <span class="font-bold font-display text-2xl text-cyan-600 italic">FisheryHub</span>
                </a>
                <div class="hidden md:flex items-center space-x-6 text-sm font-medium text-gray-700">
                    <a href="/home" class="hover:text-cyan-600">Home</a>
                    {{-- <a href="" class="hover:text-cyan-600">Products</a> --}}
                    <a href="/history-transaction" class="hover:text-cyan-600">History Transaction</a>
                    <a href="/cart" class="relative hover:text-cyan-600">
                        <span class="iconify" data-icon="mdi:cart-outline" data-width="24" data-height="24"></span>
                        <span
                            class="absolute -top-2 -right-2 bg-cyan-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ $cartCount ?? 0 }}</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Account</h1>
            <p class="text-gray-600 mt-1">Manage your profile, addresses, and restaurant details</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Sidebar Navigation --}}
            <aside class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow p-6 sticky top-24">
                    <ul class="space-y-3">
                        <li>
                            <button onclick="showTab('profile')" id="tab-profile"
                                class="tab-btn w-full text-left px-4 py-3 rounded-lg bg-cyan-50 text-cyan-700 font-semibold flex items-center space-x-3">
                                <span class="iconify" data-icon="mdi:account-circle" data-width="20"
                                    data-height="20"></span>
                                <span>Profile</span>
                            </button>
                        </li>
                        <li>
                            <button onclick="showTab('addresses')" id="tab-addresses"
                                class="tab-btn w-full text-left px-4 py-3 rounded-lg hover:bg-gray-100 text-gray-700 flex items-center space-x-3">
                                <span class="iconify" data-icon="mdi:map-marker" data-width="20"
                                    data-height="20"></span>
                                <span>Addresses</span>
                            </button>
                        </li>
                        <li>
                            <button onclick="showTab('restaurant')" id="tab-restaurant"
                                class="tab-btn w-full text-left px-4 py-3 rounded-lg hover:bg-gray-100 text-gray-700 flex items-center space-x-3">
                                <span class="iconify" data-icon="mdi:store" data-width="20" data-height="20"></span>
                                <span>My Restaurant</span>
                            </button>
                        </li>
                        <li>
                            <button onclick="showTab('security')" id="tab-security"
                                class="tab-btn w-full text-left px-4 py-3 rounded-lg hover:bg-gray-100 text-gray-700 flex items-center space-x-3">
                                <span class="iconify" data-icon="mdi:lock" data-width="20" data-height="20"></span>
                                <span>Security</span>
                            </button>
                        </li>
                    </ul>
                    <div class="mt-6 pt-6 border-t">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center justify-center space-x-2 px-4 py-3 rounded-lg bg-red-50 text-red-600 hover:bg-red-100">
                                <span class="iconify" data-icon="mdi:logout" data-width="20" data-height="20"></span>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            {{-- Main Content --}}
            <section class="lg:col-span-2">
                {{-- Profile Tab --}}
                <div id="content-profile" class="tab-content">
                    <div class="bg-white rounded-xl shadow p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-semibold text-gray-800">Personal Information</h2>
                        </div>
                        <form id="profile-form" action="{{ route('account.update') }}" method="POST"
                            enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div class="flex items-center space-x-6">
                                <div class="relative">
                                    @if (Auth::user()->photo)
                                    <img id="profile-img" src="{{ asset('storage/' . Auth::user()->photo) }}"
                                        alt="Profile Photo" class="w-24 h-24 rounded-full object-cover">
                                    @else
                                    <img id="profile-img"
                                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=cyan&color=fff"
                                        alt="Profile Photo" class="w-24 h-24 rounded-full object-cover">
                                    @endif
                                    <label for="photo"
                                        class="absolute bottom-0 right-0 bg-cyan-600 text-white rounded-full p-2 cursor-pointer hover:bg-cyan-700">
                                        <span class="iconify" data-icon="mdi:camera" data-width="16"
                                            data-height="16"></span>
                                    </label>
                                    <input type="file" id="photo" name="photo" accept="image/*"
                                        class="hidden" onchange="previewImage(event)">
                                </div>
                                <div>
                                    <p class="text-gray-700 font-medium">{{ Auth::user()->name }}</p>
                                    <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-4 mt-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                    <input type="text" name="name"
                                        value="{{ old('name', Auth::user()->name) }}"
                                        class="w-full px-4 py-2 border border-gray-300" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" name="email"
                                        value="{{ old('email', Auth::user()->email) }}"
                                        class="w-full px-4 py-2 border border-gray-300" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                    <input type="text" name="phone"
                                        value="{{ old('phone', Auth::user()->phone) }}"
                                        class="w-full px-4 py-2 border border-gray-300">
                                </div>
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button type="button" id="cancel-profile"
                                    class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Cancel</button>
                                <button type="submit"
                                    class="px-4 py-2 rounded-lg bg-cyan-600 text-white hover:bg-cyan-700">Save
                                    Changes</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Addresses Tab --}}
                <div id="content-addresses" class="tab-content hidden">
                    <div class="bg-white rounded-xl shadow p-6 space-y-6">

                        <div class="flex justify-between items-center">
                            <h2 class="text-xl font-semibold text-gray-800">My Addresses</h2>
                            <button onclick="document.getElementById('add-address-form').classList.remove('hidden')"
                                class="px-4 py-2 rounded-lg bg-cyan-600 text-white hover:bg-cyan-700">
                                + Add Address
                            </button>
                        </div>

                        {{-- Address List --}}
                        @if ($addresses->count())
                        <div class="space-y-4">
                            @foreach ($addresses as $address)
                            <div class="border rounded-lg p-4 space-y-3">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-semibold">{{ $address->recipient_name }}</p>
                                        <p class="text-sm text-gray-600">{{ $address->phone }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $address->address_detail }},
                                            {{ $address->district }},
                                            {{ $address->city }},
                                            {{ $address->province }},
                                            {{ $address->postal_code }},
                                        </p>
                                    </div>

                                    @if ($address->is_default)
                                    <span class="text-xs bg-cyan-100 text-cyan-700 px-2 py-1 rounded-full">Default</span>
                                    @endif
                                </div>

                                {{-- ACTION BUTTON --}}
                                <div class="flex gap-2">
                                    <button
                                        onclick="document.getElementById('edit-form-{{ $address->id }}').classList.toggle('hidden')"
                                        class="text-sm px-3 py-1 border rounded-lg hover:bg-gray-100">
                                        Edit
                                    </button>

                                    <form action="{{ route('addresses.destroy', $address) }}" method="POST"
                                        onsubmit="return confirm('Delete this address?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-sm px-3 py-1 border border-red-300 text-red-600 rounded-lg hover:bg-red-50">
                                            Delete
                                        </button>
                                    </form>
                                </div>

                                {{-- EDIT FORM --}}
                                <form id="edit-form-{{ $address->id }}"
                                    action="{{ route('addresses.update', $address) }}"
                                    method="POST"
                                    class="hidden border-t pt-4 space-y-3">
                                    @csrf
                                    @method('PUT')

                                    <input type="text" name="recipient_name" value="{{ $address->recipient_name }}" class="w-full px-3 py-2 border rounded-lg">
                                    <input type="text" name="phone" value="{{ $address->phone }}" class="w-full px-3 py-2 border rounded-lg">
                                    <textarea name="address_detail" class="w-full px-3 py-2 border rounded-lg">{{ $address->address_detail }}</textarea>

                                    <div class="grid grid-cols-2 gap-2">
                                        <input type="text" name="district" value="{{ $address->district }}" class="px-3 py-2 border rounded-lg">
                                        <input type="text" name="city" value="{{ $address->city }}" class="px-3 py-2 border rounded-lg">
                                    </div>

                                    <div class="grid grid-cols-2 gap-2">
                                        <input type="text" name="province" value="{{ $address->province }}" class="px-3 py-2 border rounded-lg">
                                        <input type="text" name="postal_code" value="{{ $address->postal_code }}" class="px-3 py-2 border rounded-lg">
                                    </div>

                                    {{-- ======================================================== --}}
                                    {{-- LOKASI: Leaflet Map Picker (Edit Address)               --}}
                                    {{-- ======================================================== --}}
                                    <div class="border border-gray-200 rounded-xl overflow-hidden">

                                        {{-- Header --}}
                                        <div class="flex items-center justify-between bg-gray-50 px-4 py-3 border-b border-gray-200">
                                            <div class="flex items-center gap-2">
                                                <span class="iconify text-cyan-600" data-icon="mdi:map-marker" data-width="18"></span>
                                                <span class="text-sm font-semibold text-gray-700">Lokasi Pengiriman</span>
                                            </div>
                                            <button type="button"
                                                data-detect-edit-address="{{ $address->id }}"
                                                class="flex items-center gap-1.5 text-xs font-semibold text-cyan-600 hover:text-cyan-700
                                                       bg-cyan-50 hover:bg-cyan-100 px-3 py-1.5 rounded-lg transition">
                                                <span class="iconify" data-icon="mdi:crosshairs-gps" data-width="14"></span>
                                                Deteksi Otomatis
                                            </button>
                                        </div>

                                        {{-- Map --}}
                                        <div id="edit-address-map-{{ $address->id }}" class="w-full" style="height: 280px; z-index: 0;"></div>
                                        <p class="text-xs text-gray-400 text-center py-1.5 bg-gray-50 border-t border-gray-100">
                                            <span class="iconify inline" data-icon="mdi:gesture-tap" data-width="13"></span>
                                            Klik pada peta untuk menentukan titik lokasi
                                        </p>

                                        {{-- Input Manual --}}
                                        <div class="grid grid-cols-2 gap-3 p-4 border-t border-gray-200">
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-1">Latitude</label>
                                                <input type="text"
                                                    id="edit-addr-lat-{{ $address->id }}"
                                                    name="latitude"
                                                    value="{{ $address->latitude }}"
                                                    placeholder="-6.200000"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm
                                                           focus:outline-none focus:ring-2 focus:ring-cyan-300 focus:border-cyan-400
                                                           font-mono">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-1">Longitude</label>
                                                <input type="text"
                                                    id="edit-addr-lng-{{ $address->id }}"
                                                    name="longitude"
                                                    value="{{ $address->longitude }}"
                                                    placeholder="106.816666"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm
                                                           focus:outline-none focus:ring-2 focus:ring-cyan-300 focus:border-cyan-400
                                                           font-mono">
                                            </div>
                                        </div>

                                        {{-- Status bar --}}
                                        <div id="edit-address-status-{{ $address->id }}"
                                            class="hidden mx-4 mb-4 px-3 py-2 rounded-lg text-xs font-medium flex items-center gap-2">
                                        </div>
                                    </div>
                                    {{-- ======================================================== --}}

                                    <div class="flex justify-end gap-2">
                                        <button type="button"
                                            onclick="document.getElementById('edit-form-{{ $address->id }}').classList.add('hidden')"
                                            class="px-3 py-1 border rounded-lg">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                            class="px-3 py-1 bg-cyan-600 text-white rounded-lg">
                                            Update
                                        </button>
                                    </div>
                                </form>
                            </div>
                            @endforeach

                        </div>
                        @else
                        <p class="text-gray-500 text-center">No addresses added yet.</p>
                        @endif

                        {{-- Add Address Form --}}
                        @include('account.partials.add-address-form')
                    </div>
                </div>

                {{-- Restaurant Tab --}}
                <div id="content-restaurant" class="tab-content hidden">
                    <div class="bg-white rounded-xl shadow p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-semibold text-gray-800">My Restaurant</h2>
                            @if (Auth::user()->restaurant)
                            <button id="edit-restaurant-btn"
                                class="text-sm text-cyan-600 hover:underline">Edit</button>
                            @else
                            <button class="text-sm text-cyan-600 hover:underline">Register Restaurant</button>
                            @endif
                        </div>

                        @if (Auth::user()->restaurant)
                        {{-- View Mode --}}
                        <div id="restaurant-view" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="md:col-span-1">
                                    <img src="{{ !is_null(Auth::user()->restaurant->photo) ? asset('storage/' . Auth::user()->restaurant->photo) : '/assets/pasar-ikan.jpg' }}" alt="Restaurant Logo" class="w-full h-40 object-cover rounded-lg">
                                </div>
                                <div class="md:col-span-2 space-y-3">
                                    <p class="text-lg font-semibold text-gray-800">
                                        {{ Auth::user()->restaurant->name }}
                                    </p>
                                    <p class="text-sm text-gray-600">{{ Auth::user()->restaurant->description }}
                                    </p>
                                    <div class="flex items-center space-x-2 text-sm text-gray-600">
                                        <span class="iconify" data-icon="mdi:map-marker" data-width="16"
                                            data-height="16"></span>
                                        <span>{{ Auth::user()->restaurant->address }}, {{ Auth::user()->restaurant->district }},{{ Auth::user()->restaurant->city }}, {{ Auth::user()->restaurant->province }}, {{ Auth::user()->restaurant->postal_code }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-gray-600">
                                        <span class="iconify" data-icon="mdi:phone" data-width="16"
                                            data-height="16"></span>
                                        <span>{{ Auth::user()->restaurant->phone }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm text-gray-600">
                                        <span class="iconify" data-icon="mdi:clock" data-width="16"
                                            data-height="16"></span>
                                        <span>{{ Auth::user()->restaurant->open }} -
                                            {{ Auth::user()->restaurant->close }}</span>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-2xl font-bold text-gray-800">
                                        {{ Auth::user()->restaurant->products()->count() }}
                                    </p>
                                    <p class="text-xs text-gray-500">Products</p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-2xl font-bold text-gray-800">{{ Auth::user()->restaurant->transactions()->count() }}</p>
                                    <p class="text-xs text-gray-500">Orders</p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-2xl font-bold text-gray-800">4.8</p>
                                    <p class="text-xs text-gray-500">Rating</p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    {{-- <p class="text-2xl font-bold text-gray-800">{{ Auth::user()->restaurant->balance }}</p> --}}
                                    <p class="text-2xl font-bold text-gray-800">Rp {{ number_format(Auth::user()->restaurant->balance, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500">Balance</p>
                                </div>
                            </div> -->
                        </div>

                        {{-- Edit Mode --}}
                        <form id="restaurant-form"
                            action="{{ url('/restaurant/' . Auth::user()->restaurant->id) }}" method="POST"
                            enctype="multipart/form-data" class="hidden space-y-4">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="md:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Photo</label>
                                    <input type="file" name="photo" accept="image/*" class="w-full">
                                </div>
                                <div class="md:col-span-2 space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Restaurant Name</label>
                                        <input type="text" name="name"
                                            value="{{ old('name', Auth::user()->restaurant->name) }}"
                                            class="w-full px-4 py-2 border border-gray-300" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                        <textarea name="description" rows="3"
                                            class="w-full px-4 py-2 border border-gray-300">{{ old('description', Auth::user()->restaurant->description) }}</textarea>
                                    </div>

                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">District</label>
                                            <input type="text" name="district"
                                                value="{{ Auth::user()->restaurant->district }}"
                                                class="w-full px-3 py-2 border rounded-lg">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                            <input type="text" name="city"
                                                value="{{ Auth::user()->restaurant->city }}"
                                                class="w-full px-3 py-2 border rounded-lg">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Province</label>
                                            <input type="text" name="province"
                                                value="{{ Auth::user()->restaurant->province }}"
                                                class="w-full px-3 py-2 border rounded-lg">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                                            <input type="text" name="postal_code"
                                                value="{{ Auth::user()->restaurant->postal_code }}"
                                                class="w-full px-3 py-2 border rounded-lg">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                        <input type="text" name="address"
                                            value="{{ old('address', Auth::user()->restaurant->address) }}"
                                            class="w-full px-4 py-2 border border-gray-300" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                        <input type="text" name="phone"
                                            value="{{ old('phone', Auth::user()->restaurant->phone) }}"
                                            class="w-full px-4 py-2 border border-gray-300" required>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Open Time</label>
                                            <input type="time" name="open"
                                                value="{{ old('open', Auth::user()->restaurant->open) }}"
                                                class="w-full px-4 py-2 border border-gray-300" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Close Time</label>
                                            <input type="time" name="close"
                                                value="{{ old('close', Auth::user()->restaurant->close) }}"
                                                class="w-full px-4 py-2 border border-gray-300" required>
                                        </div>
                                    </div>

                                    {{-- ============================================================ --}}
                                    {{-- LOKASI: Latitude & Longitude                                  --}}
                                    {{-- ============================================================ --}}
                                    <div class="border border-gray-200 rounded-xl overflow-hidden">

                                        {{-- Header --}}
                                        <div class="flex items-center justify-between bg-gray-50 px-4 py-3 border-b border-gray-200">
                                            <div class="flex items-center gap-2">
                                                <span class="iconify text-cyan-600" data-icon="mdi:map-marker" data-width="18"></span>
                                                <span class="text-sm font-semibold text-gray-700">Lokasi Toko</span>
                                            </div>
                                            <button type="button" id="btn-detect-location"
                                                class="flex items-center gap-1.5 text-xs font-semibold text-cyan-600 hover:text-cyan-700
                               bg-cyan-50 hover:bg-cyan-100 px-3 py-1.5 rounded-lg transition">
                                                <span class="iconify" data-icon="mdi:crosshairs-gps" data-width="14"></span>
                                                Deteksi Otomatis
                                            </button>
                                        </div>

                                        {{-- Map --}}
                                        <div id="location-map" class="w-full" style="height: 280px; z-index: 0;"></div>
                                        <p class="text-xs text-gray-400 text-center py-1.5 bg-gray-50 border-t border-gray-100">
                                            <span class="iconify inline" data-icon="mdi:gesture-tap" data-width="13"></span>
                                            Klik pada peta untuk menentukan titik lokasi
                                        </p>

                                        {{-- Input Manual --}}
                                        <div class="grid grid-cols-2 gap-3 p-4 border-t border-gray-200">
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-1">Latitude</label>
                                                <input type="text" id="input-lat" name="latitude"
                                                    value="{{ old('latitude', Auth::user()->restaurant->latitude) }}"
                                                    placeholder="-6.200000"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm
                                   focus:outline-none focus:ring-2 focus:ring-cyan-300 focus:border-cyan-400
                                   font-mono">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-1">Longitude</label>
                                                <input type="text" id="input-lng" name="longitude"
                                                    value="{{ old('longitude', Auth::user()->restaurant->longitude) }}"
                                                    placeholder="106.816666"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm
                                   focus:outline-none focus:ring-2 focus:ring-cyan-300 focus:border-cyan-400
                                   font-mono">
                                            </div>
                                        </div>

                                        {{-- Status bar --}}
                                        <div id="location-status"
                                            class="hidden mx-4 mb-4 px-3 py-2 rounded-lg text-xs font-medium flex items-center gap-2">
                                        </div>
                                    </div>
                                    {{-- ============================================================ --}}

                                </div>
                            </div>

                            <div class="flex justify-end space-x-3">
                                <button type="button" id="cancel-restaurant"
                                    class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Cancel</button>
                                <button type="submit"
                                    class="px-4 py-2 rounded-lg bg-cyan-600 text-white hover:bg-cyan-700">Save Changes</button>
                            </div>
                        </form>

                        {{-- Products Section --}}
                        <div class="bg-white rounded-xl shadow p-6 mt-8">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-xl font-semibold text-gray-800">My Products</h2>
                                <a href="{{ route('tambah-menu') }}"
                                    class="text-sm text-cyan-600 hover:underline">
                                    + Add New Product
                                </a>
                            </div>

                            @if (Auth::user()->restaurant && Auth::user()->restaurant->products->count())
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach (Auth::user()->restaurant->products as $product)
                                <div
                                    class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition-shadow">
                                    <img src="{{ $product->photo != NULL ? asset('storage/'. $product->photo) : 'assets/pasar-ikan.png' }}" alt="{{ $product->name }}"
                                        class="w-full h-40 object-cover rounded-lg mb-3">
                                    <div class="space-y-2">
                                        <h3 class="font-semibold text-gray-800 truncate">
                                            {{ $product->name }}
                                        </h3>
                                        <p class="text-sm text-gray-600 line-clamp-2">
                                            {{ $product->description }}
                                        </p>
                                        <div class="flex items-center justify-between">
                                            <span class="text-cyan-600 font-bold">Rp
                                                {{ number_format($product->price, 0, ',', '.') }}</span>
                                            <span
                                                class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded-full">{{ $product->stock }}
                                                left</span>
                                        </div>
                                        <div class="flex items-center justify-between mt-3">
                                            <span
                                                class="text-xs text-gray-500">{{ $product->category->name ?? 'Uncategorized' }}</span>
                                            <div class="flex space-x-2">
                                                <a href="{{ route('product.edit', $product->id) }}"
                                                    class="text-gray-400 hover:text-cyan-600">
                                                    <span class="iconify" data-icon="mdi:pencil" data-width="18"></span>
                                                </a>
                                                <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                                                    onsubmit="return confirm('Yakin mau hapus produk ini?')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="text-gray-400 hover:text-red-600">
                                                        <span class="iconify" data-icon="mdi:delete" data-width="18"></span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-10">
                                <span class="iconify text-gray-300" data-icon="mdi:package-variant"
                                    data-width="64" data-height="64"></span>
                                <p class="mt-4 text-gray-600">No products added yet.</p>
                                <a href="{{ route('tambah-menu') }}"
                                    class="mt-4 px-4 py-2 rounded-lg bg-cyan-600 text-white hover:bg-cyan-700">
                                    Add Your First Product
                                </a>

                            </div>
                            @endif
                        </div>
                        @else
                        <div class="text-center py-10">
                            <span class="iconify text-gray-300" data-icon="mdi:store-off" data-width="64"
                                data-height="64"></span>
                            <p class="mt-4 text-gray-600">You haven't registered a restaurant yet.</p>
                            <button
                                class="mt-4 px-4 py-2 rounded-lg bg-cyan-600 text-white hover:bg-cyan-700">Register
                                Now</button>
                        </div>
                        <script>
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
                        </script>
                        @endif
                    </div>
                </div>

                <script>
                    document.getElementById('edit-restaurant-btn')?.addEventListener('click', () => {
                        document.getElementById('restaurant-view').classList.add('hidden');
                        document.getElementById('restaurant-form').classList.remove('hidden');
                    });
                    document.getElementById('cancel-restaurant')?.addEventListener('click', () => {
                        document.getElementById('restaurant-form').classList.add('hidden');
                        document.getElementById('restaurant-view').classList.remove('hidden');
                    });
                </script>

                {{-- Security Tab --}}
                <div id="content-security" class="tab-content hidden">
                    <div class="bg-white rounded-xl shadow p-6 space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Change Password</h3>
                            <form action="" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Current
                                        Password</label>
                                    <input type="password" name="current_password"
                                        class="w-full px-4 py-2 border border-gray-300" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                    <input type="password" name="password"
                                        class="w-full px-4 py-2 border border-gray-300" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New
                                        Password</label>
                                    <input type="password" name="password_confirmation"
                                        class="w-full px-4 py-2 border border-gray-300" required>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="px-4 py-2 rounded-lg bg-cyan-600 text-white hover:bg-cyan-700">Update
                                        Password</button>
                                </div>
                            </form>
                        </div>
                        {{-- <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Two-Factor Authentication</h3>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Secure your account with 2FA.</p>
                                    <p class="text-xs text-gray-500">We'll send a code to your phone.</p>
                                </div>
                                <button
                                    class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Enable</button>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </section>
        </div>
    </main>

    {{-- Mobile Bottom Navigation --}}
    <x-navbar :cart-count="$cartCount ?? 0" :active-route="'account'" class="md:hidden" />

    <style>
        .w-full px-4 py-2 border border-gray-300 {
            @apply w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // ======================
            // TAB SWITCHING
            // ======================
            window.showTab = function(tab) {
                document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));

                document.querySelectorAll('.tab-btn').forEach(btn => {
                    btn.classList.remove('bg-cyan-50', 'text-cyan-700', 'font-semibold');
                    btn.classList.add('hover:bg-gray-100', 'text-gray-700');
                });

                const content = document.getElementById('content-' + tab);
                const button = document.getElementById('tab-' + tab);

                if (content) content.classList.remove('hidden');
                if (button) {
                    button.classList.add('bg-cyan-50', 'text-cyan-700', 'font-semibold');
                    button.classList.remove('hover:bg-gray-100', 'text-gray-700');
                }
            };

            // ======================
            // PREVIEW IMAGE PROFILE
            // ======================
            window.previewImage = function(event) {
                const file = event.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('profile-img');
                    if (img) img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            };

            // ======================
            // PROFILE CANCEL BUTTON
            // ======================
            const cancelProfile = document.getElementById('cancel-profile');
            if (cancelProfile) {
                cancelProfile.addEventListener('click', () => {
                    document.querySelectorAll('#profile-form input, #profile-form textarea')
                        .forEach(el => el.disabled = true);

                    cancelProfile.classList.add('hidden');
                });
            }

            // ======================
            // RESTAURANT EDIT TOGGLE
            // ======================
            const editRestaurantBtn = document.getElementById('edit-restaurant-btn');
            const cancelRestaurantBtn = document.getElementById('cancel-restaurant');

            if (editRestaurantBtn) {
                editRestaurantBtn.addEventListener('click', () => {
                    document.getElementById('restaurant-view')?.classList.add('hidden');
                    document.getElementById('restaurant-form')?.classList.remove('hidden');
                });
            }

            if (cancelRestaurantBtn) {
                cancelRestaurantBtn.addEventListener('click', () => {
                    document.getElementById('restaurant-form')?.classList.add('hidden');
                    document.getElementById('restaurant-view')?.classList.remove('hidden');
                });
            }

            // ======================
            // GET LOCATION (GLOBAL)
            // ======================
            window.getLocation = function() {
                if (!navigator.geolocation) {
                    alert("Browser tidak mendukung geolocation");
                    return;
                }

                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        const latInput = document.getElementById("latitude");
                        const lngInput = document.getElementById("longitude");

                        if (latInput) latInput.value = lat;
                        if (lngInput) lngInput.value = lng;

                        alert("Lokasi berhasil diambil!\nLat: " + lat + "\nLng: " + lng);
                    },
                    function(error) {
                        alert("Gagal mengambil lokasi: " + error.message);
                    }
                );
            };

        });
    </script>
    <script>
        (function() {
            // Tunggu sampai form tidak hidden (bisa juga dipanggil manual via initMap())
            // Kita inisialisasi saat form pertama kali ditampilkan
            let mapInstance = null;
            let marker = null;

            // Koordinat awal: ambil dari value input jika ada, fallback ke Jakarta
            const savedLat = parseFloat('{{ Auth::user()->restaurant->latitude ?? "" }}') || -6.2;
            const savedLng = parseFloat('{{ Auth::user()->restaurant->longitude ?? "" }}') || 106.8166;

            function initMap() {
                if (mapInstance) return; // sudah diinisialisasi

                mapInstance = L.map('location-map').setView([savedLat, savedLng], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
                    maxZoom: 19,
                }).addTo(mapInstance);

                // Custom icon
                const pinIcon = L.divIcon({
                    className: '',
                    html: `<div style="
                width:32px;height:32px;
                background:#0891b2;
                border:3px solid white;
                border-radius:50% 50% 50% 0;
                transform:rotate(-45deg);
                box-shadow:0 2px 8px rgba(0,0,0,0.3);
            "></div>`,
                    iconSize: [32, 32],
                    iconAnchor: [16, 32],
                });

                // Pasang marker jika ada koordinat tersimpan
                if ('{{ Auth::user()->restaurant->latitude ?? "" }}') {
                    marker = L.marker([savedLat, savedLng], {
                        icon: pinIcon,
                        draggable: true
                    }).addTo(mapInstance);
                    bindMarkerEvents(marker);
                }

                // Klik peta → pindahkan / buat marker
                mapInstance.on('click', function(e) {
                    const {
                        lat,
                        lng
                    } = e.latlng;
                    setCoords(lat, lng);

                    if (marker) {
                        marker.setLatLng([lat, lng]);
                    } else {
                        marker = L.marker([lat, lng], {
                            icon: pinIcon,
                            draggable: true
                        }).addTo(mapInstance);
                        bindMarkerEvents(marker);
                    }
                    showStatus('success', 'Titik lokasi berhasil ditentukan');
                });
            }

            function bindMarkerEvents(m) {
                m.on('dragend', function() {
                    const pos = m.getLatLng();
                    setCoords(pos.lat, pos.lng);
                    showStatus('success', 'Titik lokasi diperbarui');
                });
            }

            function setCoords(lat, lng) {
                document.getElementById('input-lat').value = lat.toFixed(7);
                document.getElementById('input-lng').value = lng.toFixed(7);
                if (mapInstance) mapInstance.setView([lat, lng], mapInstance.getZoom());
            }

            function showStatus(type, msg) {
                const el = document.getElementById('location-status');
                el.classList.remove('hidden', 'bg-green-50', 'text-green-700', 'bg-red-50', 'text-red-600', 'bg-blue-50', 'text-blue-700');
                const styles = {
                    success: ['bg-green-50', 'text-green-700', 'mdi:check-circle', '#16a34a'],
                    error: ['bg-red-50', 'text-red-600', 'mdi:alert-circle', '#dc2626'],
                    loading: ['bg-blue-50', 'text-blue-700', 'mdi:loading', '#0891b2'],
                };
                const [bg, text, icon, color] = styles[type];
                el.classList.add(bg, text);
                el.innerHTML = `<span class="iconify ${type === 'loading' ? 'animate-spin' : ''}"
            data-icon="${icon}" data-width="14" style="color:${color}"></span> ${msg}`;
                el.classList.remove('hidden');
                if (type === 'success') setTimeout(() => el.classList.add('hidden'), 3000);
            }

            // Sync input manual → peta
            function syncFromInput() {
                const lat = parseFloat(document.getElementById('input-lat').value);
                const lng = parseFloat(document.getElementById('input-lng').value);
                if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                    setCoords(lat, lng);

                    const pinIcon = L.divIcon({
                        className: '',
                        html: `<div style="
                    width:32px;height:32px;
                    background:#0891b2;
                    border:3px solid white;
                    border-radius:50% 50% 50% 0;
                    transform:rotate(-45deg);
                    box-shadow:0 2px 8px rgba(0,0,0,0.3);
                "></div>`,
                        iconSize: [32, 32],
                        iconAnchor: [16, 32],
                    });

                    if (marker) {
                        marker.setLatLng([lat, lng]);
                    } else if (mapInstance) {
                        marker = L.marker([lat, lng], {
                            icon: pinIcon,
                            draggable: true
                        }).addTo(mapInstance);
                        bindMarkerEvents(marker);
                    }
                    showStatus('success', 'Koordinat diperbarui dari input');
                }
            }

            // Deteksi lokasi GPS
            document.getElementById('btn-detect-location').addEventListener('click', function() {
                if (!navigator.geolocation) {
                    showStatus('error', 'Browser tidak mendukung geolocation');
                    return;
                }
                showStatus('loading', 'Mendeteksi lokasi...');
                navigator.geolocation.getCurrentPosition(
                    function(pos) {
                        const lat = pos.coords.latitude;
                        const lng = pos.coords.longitude;
                        setCoords(lat, lng);
                        if (mapInstance) mapInstance.setView([lat, lng], 17);

                        const pinIcon = L.divIcon({
                            className: '',
                            html: `<div style="
                        width:32px;height:32px;
                        background:#0891b2;
                        border:3px solid white;
                        border-radius:50% 50% 50% 0;
                        transform:rotate(-45deg);
                        box-shadow:0 2px 8px rgba(0,0,0,0.3);
                    "></div>`,
                            iconSize: [32, 32],
                            iconAnchor: [16, 32],
                        });

                        if (marker) {
                            marker.setLatLng([lat, lng]);
                        } else if (mapInstance) {
                            marker = L.marker([lat, lng], {
                                icon: pinIcon,
                                draggable: true
                            }).addTo(mapInstance);
                            bindMarkerEvents(marker);
                        }
                        showStatus('success', 'Lokasi berhasil terdeteksi');
                    },
                    function(err) {
                        const msgs = {
                            1: 'Izin lokasi ditolak',
                            2: 'Lokasi tidak tersedia',
                            3: 'Waktu deteksi habis',
                        };
                        showStatus('error', msgs[err.code] || 'Gagal mendeteksi lokasi');
                    }, {
                        enableHighAccuracy: true,
                        timeout: 10000
                    }
                );
            });

            // Input manual: update peta saat blur / Enter
            ['input-lat', 'input-lng'].forEach(id => {
                const el = document.getElementById(id);
                el.addEventListener('blur', syncFromInput);
                el.addEventListener('keydown', e => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        syncFromInput();
                    }
                });
            });

            // Inisialisasi peta:
            // Jika form langsung visible, init sekarang.
            // Jika form awalnya hidden (toggle), init saat ditampilkan.
            const form = document.getElementById('restaurant-form');

            function tryInit() {
                if (!form.classList.contains('hidden')) {
                    initMap();
                    // Invalidate ukuran peta agar tile muncul sempurna
                    setTimeout(() => mapInstance && mapInstance.invalidateSize(), 200);
                }
            }

            // Observer untuk mendeteksi saat form muncul (hidden dihapus)
            const observer = new MutationObserver(tryInit);
            observer.observe(form, {
                attributes: true,
                attributeFilter: ['class']
            });

            // Coba langsung (jika form sudah visible)
            tryInit();
        })();
    </script>

    {{-- ============================================================ --}}
    {{-- ADDRESS MAP SCRIPTS (Add + Edit)                             --}}
    {{-- ============================================================ --}}
    <script>
    (function () {

        // ── Shared helpers ──────────────────────────────────────────
        function makePinIcon() {
            return L.divIcon({
                className: '',
                html: `<div style="
                    width:32px;height:32px;
                    background:#0891b2;
                    border:3px solid white;
                    border-radius:50% 50% 50% 0;
                    transform:rotate(-45deg);
                    box-shadow:0 2px 8px rgba(0,0,0,0.3);
                "></div>`,
                iconSize: [32, 32],
                iconAnchor: [16, 32],
            });
        }

        function showAddrStatus(elId, type, msg) {
            const el = document.getElementById(elId);
            if (!el) return;
            el.classList.remove('hidden', 'bg-green-50', 'text-green-700',
                                'bg-red-50', 'text-red-600', 'bg-blue-50', 'text-blue-700');
            const map = {
                success: ['bg-green-50', 'text-green-700', 'mdi:check-circle', '#16a34a'],
                error:   ['bg-red-50',   'text-red-600',   'mdi:alert-circle', '#dc2626'],
                loading: ['bg-blue-50',  'text-blue-700',  'mdi:loading',      '#0891b2'],
            };
            const [bg, text, icon, color] = map[type];
            el.classList.add(bg, text);
            el.innerHTML = `<span class="iconify ${type === 'loading' ? 'animate-spin' : ''}"
                data-icon="${icon}" data-width="14" style="color:${color}"></span> ${msg}`;
            el.classList.remove('hidden');
            if (type === 'success') setTimeout(() => el.classList.add('hidden'), 3000);
        }

        function initAddressMap({ mapId, latId, lngId, statusId, detectBtnSel, savedLat, savedLng }) {
            let mapInstance = null;
            let marker     = null;

            function init() {
                if (mapInstance) return;

                const centerLat = savedLat || -6.2;
                const centerLng = savedLng || 106.8166;

                mapInstance = L.map(mapId).setView([centerLat, centerLng], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
                    maxZoom: 19,
                }).addTo(mapInstance);

                if (savedLat && savedLng) {
                    marker = L.marker([savedLat, savedLng], { icon: makePinIcon(), draggable: true }).addTo(mapInstance);
                    bindDrag(marker);
                }

                mapInstance.on('click', function (e) {
                    const { lat, lng } = e.latlng;
                    setCoords(lat, lng);
                    if (marker) {
                        marker.setLatLng([lat, lng]);
                    } else {
                        marker = L.marker([lat, lng], { icon: makePinIcon(), draggable: true }).addTo(mapInstance);
                        bindDrag(marker);
                    }
                    showAddrStatus(statusId, 'success', 'Titik lokasi berhasil ditentukan');
                });

                // Sync manual input → map
                [latId, lngId].forEach(id => {
                    const el = document.getElementById(id);
                    if (!el) return;
                    el.addEventListener('blur', syncInput);
                    el.addEventListener('keydown', e => { if (e.key === 'Enter') { e.preventDefault(); syncInput(); } });
                });

                // Detect GPS button
                const detectBtn = document.querySelector(detectBtnSel);
                if (detectBtn) {
                    detectBtn.addEventListener('click', function () {
                        if (!navigator.geolocation) {
                            showAddrStatus(statusId, 'error', 'Browser tidak mendukung geolocation');
                            return;
                        }
                        showAddrStatus(statusId, 'loading', 'Mendeteksi lokasi...');
                        navigator.geolocation.getCurrentPosition(
                            function (pos) {
                                const lat = pos.coords.latitude;
                                const lng = pos.coords.longitude;
                                setCoords(lat, lng);
                                if (mapInstance) mapInstance.setView([lat, lng], 17);
                                if (marker) {
                                    marker.setLatLng([lat, lng]);
                                } else {
                                    marker = L.marker([lat, lng], { icon: makePinIcon(), draggable: true }).addTo(mapInstance);
                                    bindDrag(marker);
                                }
                                showAddrStatus(statusId, 'success', 'Lokasi berhasil terdeteksi');
                            },
                            function (err) {
                                const msgs = { 1: 'Izin lokasi ditolak', 2: 'Lokasi tidak tersedia', 3: 'Waktu deteksi habis' };
                                showAddrStatus(statusId, 'error', msgs[err.code] || 'Gagal mendeteksi lokasi');
                            },
                            { enableHighAccuracy: true, timeout: 10000 }
                        );
                    });
                }
            }

            function bindDrag(m) {
                m.on('dragend', function () {
                    const pos = m.getLatLng();
                    setCoords(pos.lat, pos.lng);
                    showAddrStatus(statusId, 'success', 'Titik lokasi diperbarui');
                });
            }

            function setCoords(lat, lng) {
                const latEl = document.getElementById(latId);
                const lngEl = document.getElementById(lngId);
                if (latEl) latEl.value = lat.toFixed(7);
                if (lngEl) lngEl.value = lng.toFixed(7);
                if (mapInstance) mapInstance.setView([lat, lng], mapInstance.getZoom());
            }

            function syncInput() {
                const lat = parseFloat(document.getElementById(latId)?.value);
                const lng = parseFloat(document.getElementById(lngId)?.value);
                if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                    setCoords(lat, lng);
                    if (!marker && mapInstance) {
                        marker = L.marker([lat, lng], { icon: makePinIcon(), draggable: true }).addTo(mapInstance);
                        bindDrag(marker);
                    } else if (marker) {
                        marker.setLatLng([lat, lng]);
                    }
                    showAddrStatus(statusId, 'success', 'Koordinat diperbarui dari input');
                }
            }

            return { init };
        }

        // ── Add Address Map ──────────────────────────────────────────
        (function () {
            const formEl = document.getElementById('add-address-form');
            if (!formEl) return;

            const { init } = initAddressMap({
                mapId:        'add-address-map',
                latId:        'add-addr-lat',
                lngId:        'add-addr-lng',
                statusId:     'add-address-status',
                detectBtnSel: '#btn-detect-add-address',
                savedLat:     null,
                savedLng:     null,
            });

            let initialized = false;
            function tryInit() {
                if (!formEl.classList.contains('hidden') && !initialized) {
                    initialized = true;
                    init();
                    setTimeout(() => {
                        const m = document.getElementById('add-address-map')?._leaflet_id;
                        // invalidate via stored leaflet instance (accessed differently)
                        // We trigger a resize event so Leaflet tiles re-render
                        window.dispatchEvent(new Event('resize'));
                    }, 200);
                }
            }

            // Watch for the hidden class being removed ("+ Add Address" button click)
            new MutationObserver(tryInit).observe(formEl, { attributes: true, attributeFilter: ['class'] });
            tryInit();
        })();

        // ── Edit Address Maps ────────────────────────────────────────
        // Each address edit form has a unique ID, stored in data attribute on button
        document.querySelectorAll('[data-detect-edit-address]').forEach(function (btn) {
            const id = btn.getAttribute('data-detect-edit-address');
            const formEl = document.getElementById('edit-form-' + id);
            if (!formEl) return;

            const { init } = initAddressMap({
                mapId:        'edit-address-map-' + id,
                latId:        'edit-addr-lat-' + id,
                lngId:        'edit-addr-lng-' + id,
                statusId:     'edit-address-status-' + id,
                detectBtnSel: `[data-detect-edit-address="${id}"]`,
                savedLat:     parseFloat(document.getElementById('edit-addr-lat-' + id)?.value) || null,
                savedLng:     parseFloat(document.getElementById('edit-addr-lng-' + id)?.value) || null,
            });

            let initialized = false;
            function tryInit() {
                if (!formEl.classList.contains('hidden') && !initialized) {
                    initialized = true;
                    init();
                    setTimeout(() => window.dispatchEvent(new Event('resize')), 200);
                }
            }

            new MutationObserver(tryInit).observe(formEl, { attributes: true, attributeFilter: ['class'] });
            tryInit();
        });

    })();
    </script>
</body>

</html>