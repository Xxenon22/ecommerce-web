<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account | Fishery Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
</head>

<body class="min-h-screen bg-gray-50">

    {{-- Top Navigation --}}
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <span class="iconify text-cyan-600" data-icon="mdi:fish" data-width="28" data-height="28"></span>
                    <span class="font-bold text-xl text-gray-800">Fishery Hub</span>
                </a>
                <div class="hidden md:flex items-center space-x-6 text-sm font-medium text-gray-700">
                    <a href="/home" class="hover:text-cyan-600">Home</a>
                    <a href="" class="hover:text-cyan-600">Products</a>
                    <a href="/order" class="hover:text-cyan-600">Orders</a>
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
                                            {{ $address->postal_code }}
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
                                         <img src="{{ asset('storage/' . Auth::user()->restaurant->photo) }}" alt="Restaurant Logo" class="w-full h-40 object-cover rounded-lg">
                                    </div>
                                    <div class="md:col-span-2 space-y-3">
                                        <p class="text-lg font-semibold text-gray-800">
                                            {{ Auth::user()->restaurant->name }}</p>
                                        <p class="text-sm text-gray-600">{{ Auth::user()->restaurant->description }}
                                        </p>
                                        <div class="flex items-center space-x-2 text-sm text-gray-600">
                                            <span class="iconify" data-icon="mdi:map-marker" data-width="16"
                                                data-height="16"></span>
                                            <span>{{ Auth::user()->restaurant->address }}</span>
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
                                <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <p class="text-2xl font-bold text-gray-800">
                                            {{ Auth::user()->restaurant->products()->count() }}</p>
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
                                </div>
                            </div>

                            {{-- Edit Mode --}}
                            <form id="restaurant-form"
                                action="{{ url('/restaurant/' . Auth::user()->restaurant->id) }}" method="POST"
                                enctype="multipart/form-data" class="hidden space-y-4">
                                @csrf
                                @method('PUT')
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="md:col-span-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                                        <input type="file" name="logo" accept="image/*" class="w-full">
                                    </div>
                                    <div class="md:col-span-2 space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Restaurant
                                                Name</label>
                                            <input type="text" name="name"
                                                value="{{ old('name', Auth::user()->restaurant->name) }}"
                                                class="w-full px-4 py-2 border border-gray-300" required>
                                        </div>
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                            <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300">{{ old('description', Auth::user()->restaurant->description) }}</textarea>
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
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Open
                                                    Time</label>
                                                <input type="time" name="open"
                                                    value="{{ old('open', Auth::user()->restaurant->open) }}"
                                                    class="w-full px-4 py-2 border border-gray-300" required>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Close
                                                    Time</label>
                                                <input type="time" name="close"
                                                    value="{{ old('close', Auth::user()->restaurant->close) }}"
                                                    class="w-full px-4 py-2 border border-gray-300" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end space-x-3">
                                    <button type="button" id="cancel-restaurant"
                                        class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Cancel</button>
                                    <button type="submit"
                                        class="px-4 py-2 rounded-lg bg-cyan-600 text-white hover:bg-cyan-700">Save
                                        Changes</button>
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
                                                <img src="{{ asset(file_exists(public_path($product->photo)) ? $product->photo : '/assets/pasar-ikan.png') }}" alt="{{ $product->name }}"
                                                    class="w-full h-40 object-cover rounded-lg mb-3">
                                                <div class="space-y-2">
                                                    <h3 class="font-semibold text-gray-800 truncate">
                                                        {{ $product->name }}</h3>
                                                    <p class="text-sm text-gray-600 line-clamp-2">
                                                        {{ $product->description }}</p>
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
                                                            <button class="text-gray-400 hover:text-cyan-600">
                                                                <span class="iconify" data-icon="mdi:pencil"
                                                                    data-width="18" data-height="18"></span>
                                                            </button>
                                                            <button class="text-gray-400 hover:text-red-600">
                                                                <span class="iconify" data-icon="mdi:delete"
                                                                    data-width="18" data-height="18"></span>
                                                            </button>
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
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Two-Factor Authentication</h3>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Secure your account with 2FA.</p>
                                    <p class="text-xs text-gray-500">We'll send a code to your phone.</p>
                                </div>
                                <button
                                    class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">Enable</button>
                            </div>
                        </div>
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
        function showTab(tab) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('bg-cyan-50', 'text-cyan-700', 'font-semibold');
                btn.classList.add('hover:bg-gray-100', 'text-gray-700');
            });
            document.getElementById('content-' + tab).classList.remove('hidden');
            const activeBtn = document.getElementById('tab-' + tab);
            activeBtn.classList.add('bg-cyan-50', 'text-cyan-700', 'font-semibold');
            activeBtn.classList.remove('hover:bg-gray-100', 'text-gray-700');
        }

        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => document.getElementById('profile-img').src = e.target.result;
                reader.readAsDataURL(file);
            }
        }

        document.getElementById('edit-profile-btn').addEventListener('click', () => {
            document.querySelectorAll('#profile-form input, #profile-form textarea').forEach(el => el.disabled =
                false);
            document.getElementById('cancel-profile').classList.remove('hidden');
        });

        document.getElementById('cancel-profile').addEventListener('click', () => {
            document.querySelectorAll('#profile-form input, #profile-form textarea').forEach(el => el.disabled =
                true);
            document.getElementById('cancel-profile').classList.add('hidden');
        });
    </script>
</body>

</html>
