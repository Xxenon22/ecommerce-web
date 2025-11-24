@extends('admin.layout')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold text-[#0A2540]">Category Product</h1>

        <!-- Form 25% & Table 75% -->
        <div class="mt-6 flex gap-6 items-start">
            <!-- Form Input 25% -->
            <div class="w-1/4 bg-white rounded-xl shadow-md p-6 space-y-4">
                <form action="#" method="POST">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter category name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A2540] focus:border-transparent transition"
                            required />
                    </div>
                    <button type="submit"
                        class="w-full bg-[#0A2540] text-white py-2 my-2 px-4 rounded-lg hover:bg-opacity-90 transition duration-200 font-medium">
                        Save
                    </button>
                </form>
            </div>

            <!-- Searchable Category Table 75% -->
            <div class="flex-1 bg-white rounded-xl shadow-md overflow-hidden">
                <!-- Search Bar -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <input type="text" id="searchCategory" placeholder="Search category..."
                        class="w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A2540] focus:border-transparent transition" />
                </div>

                <table id="categoryTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Category Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($categories as $category)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                <button class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                <button class="text-red-600 hover:text-red-900">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">No categories found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination links -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $categories->links() }}
                </div>
            </div>

            <!-- Simple client-side search script -->
            <script>
                document.getElementById('searchCategory').addEventListener('input', function() {
                    const filter = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#categoryTable tbody tr');
                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(filter) ? '' : 'none';
                    });
                });
            </script>
        </div>
    </div>
@endsection
