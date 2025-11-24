<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Fishery Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
</head>

<body class="min-h-screen flex flex-col justify-between backdrop-brightness-50" style="background-image: url('{{ asset('assets/bg-akun.jpg') }}');
         background-size: cover;
         background-repeat: no-repeat;
         background-position: center;
         background-attachment: fixed;">

    <div class="flex flex-col justify-center min-h-screen mx-7 py-10">

        {{-- Bagian Header --}}
        <div class="flex flex-col items-center text-center">
            <h1 class="font-bold text-2xl text-white">My Profile</h1>
            <p class="text-white">Manage your account information</p>
        </div>

        {{-- Profile Form --}}
        <div class="bg-white bg-opacity-90 rounded-lg shadow-lg p-6 max-w-md mx-auto my-15">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Photo Upload --}}
                <div class="flex flex-col items-center mb-6">
                    <div class="relative">
                        @if(Auth::user()->photo)
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile Photo"
                                class="w-24 h-24 rounded-full border-4 border-cyan-600 object-cover">
                        @else
                            <div
                                class="w-24 h-24 rounded-full border-4 border-cyan-600 bg-gray-200 flex items-center justify-center">
                                <span class="iconify text-gray-400" data-icon="mdi:account-circle" data-width="48"
                                    data-height="48"></span>
                            </div>
                        @endif
                        <label for="photo"
                            class="absolute bottom-0 right-0 bg-cyan-600 text-white rounded-full p-2 cursor-pointer hover:bg-cyan-700">
                            <span class="iconify" data-icon="mdi:camera" data-width="16" data-height="16"></span>
                        </label>
                    </div>
                    <input type="file" id="photo" name="photo" accept="image/*" class="hidden">
                    <p class="text-sm text-gray-600 mt-2">Click to change photo</p>
                </div>

                {{-- Name --}}
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500"
                        required>
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500"
                        required>
                </div>

                {{-- Phone --}}
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 font-semibold mb-2">Phone</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                </div>

                {{-- Address --}}
                <div class="mb-4">
                    <label for="address" class="block text-gray-700 font-semibold mb-2">Address</label>
                    <textarea id="address" name="address" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">{{ old('address', Auth::user()->address) }}</textarea>
                </div>


                {{-- Buttons --}}
                <div class="flex space-x-4">
                    <button type="submit"
                        class="flex-1 bg-cyan-600 text-white py-2 px-4 rounded-md hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        Update Profile
                    </button>
                    <form id="logout-form" method="POST" action="{{ route('logout') }}" class="flex-1">
                        @csrf
                        <button type="submit"
                            class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            Logout
                        </button>
                    </form>
                </div>
            </form>
        </div>
    </div>

    {{-- Navbar bawah --}}
    <x-navbar :cart-count="5" :active-route="'account'" class="block md:hidden" />
</body>

</html>