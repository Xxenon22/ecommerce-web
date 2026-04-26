<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('/logo.jpeg') }}" type="image/png">

    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <title>Edit Menu - Fishery Hub</title>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home-resto') }}" class="flex items-center text-gray-600 hover:text-gray-900">
                        <span class="iconify mr-2" data-icon="weui:back-outlined" data-width="24"
                            data-height="24"></span>

                    </a>
                </div>
                <h1 class="text-lg font-semibold text-gray-900">Tambah Menu Baru</h1>
                <div class="w-20"></div> <!-- Spacer for centering -->
            </div>
        </div>
    </header>

    <main class="max-w-2xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow">

            <h2 class="text-xl font-bold mb-4">Edit Product</h2>

            <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- NAME -->
                <div class="mb-4">
                    <label class="block text-sm">Name</label>
                    <input type="text" name="name" value="{{ $product->name }}" class="w-full border px-3 py-2 rounded">
                </div>

                <!-- CATEGORY -->
                <div class="mb-4">
                    <label class="block text-sm">Category</label>
                    <select name="category_product_id" class="w-full border px-3 py-2 rounded">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_product_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- PRICE -->
                <div class="mb-4">
                    <label class="block text-sm">Price</label>
                    <input type="number" name="price" value="{{ $product->price }}"
                        class="w-full border px-3 py-2 rounded">
                </div>

                <!-- STOCK -->
                <div class="mb-4">
                    <label class="block text-sm">Stock</label>
                    <input type="number" name="stock" value="{{ $product->stock }}"
                        class="w-full border px-3 py-2 rounded">
                </div>

                <!-- DESCRIPTION -->
                <div class="mb-4">
                    <label class="block text-sm">Description</label>
                    <textarea name="description"
                        class="w-full border px-3 py-2 rounded">{{ $product->description }}</textarea>
                </div>

                <!-- PHOTO -->
                <div class="mb-4">
                    <label class="block text-sm">Photo</label>

                    <img src="{{ asset('storage/' . $product->photo) }}" class="w-32 mb-2 rounded">

                    <input type="file" name="photo">
                </div>

                <!-- BUTTON -->
                <button class="bg-cyan-600 text-white px-4 py-2 rounded">
                    Update Product
                </button>
            </form>

        </div>
    </main>
</body>

</html>