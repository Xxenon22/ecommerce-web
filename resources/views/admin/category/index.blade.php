@extends('admin.layout')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold text-[#0A2540]">Category Product</h1>

        <!-- Form 25% & Table 75% -->
        <div class="mt-6 flex gap-6 items-start">
            <!-- Form Input 25% -->
            <div class="w-1/4 bg-white rounded-xl shadow-md p-6 space-y-4">
                <form action="/admin/category" method="POST">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter category name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A2540] focus:border-transparent transition"
                            required />
                    </div>
                    <div>
                        <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">Icon</label>
                        <input type="text" id="icon" name="icon" placeholder="Enter icon tag (MDI)"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A2540] focus:border-transparent transition"
                            required />
                        <small class="text-xs text-gray-500">e.g. mdi:home or <a href="https://icon-sets.iconify.design/"
                                target="_blank">https://icon-sets.iconify.design/</a></small>
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
                                Icon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($categories as $category)
                            <tr class="show" data-id="{{ $category->id }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="iconify" data-icon="{{ $category->icon }}" data-width="22"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                    <a href="#"
                                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded cursor-pointer btn-edit">Edit</a>
                                    <form action="{{ url('/admin/category', $category->id) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete this category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded cursor-pointer">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <tr class="edit" style="display: none;" data-id="{{ $category->id }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <input type="text" name="name" value="{{ $category->name }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A2540] focus:border-transparent transition" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <input type="text" name="icon" value="{{ $category->icon }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A2540] focus:border-transparent transition" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                    <button
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded cursor-pointer btn-update">Update</button>
                                    <button
                                        class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded cursor-pointer btn-cancel">Cancel</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">No categories found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination links -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{-- {{ $categories->links() }} --}}
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.7.1.min.js"
                integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
            <script>
                $(document).ready(function() {
                    $('.btn-edit').click(function() {
                        $(this).closest('tr.show').hide();
                        $(this).closest('tr.show').next('tr.edit').show();
                    });
                    $('.btn-update').click(function() {
                        const editRow = $(this).closest('tr.edit');
                        const id = editRow.data('id');
                        const name = editRow.find('input[name="name"]').val();
                        const icon = editRow.find('input[name="icon"]').val();

                        $.ajax({
                            url: `/admin/category/${id}`,
                            method: 'PUT',
                            data: {
                                _token: '{{ csrf_token() }}',
                                name: name,
                                icon: icon
                            },
                            success: function() {
                                // Update the display row with new values
                                const showRow = editRow.prev('tr.show');
                                showRow.find('td:eq(1)').text(name);
                                showRow.find('td:eq(2) .iconify').attr('data-icon', icon);
                                // Toggle visibility
                                editRow.hide();
                                showRow.show();
                            },
                            error: function() {
                                alert('Update failed');
                            }
                        });
                    });
                    $('.btn-cancel').click(function() {
                        $(this).closest('tr.edit').hide();
                        $(this).closest('tr.edit').prev('tr.show').show();
                    });
                });
            </script>
            <!-- Simple client-side search script -->
            <script>
                document.getElementById('searchCategory').addEventListener('input', function() {
                    const filter = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#categoryTable tbody tr');

                    rows.forEach(row => {

                        // Jika baris ini adalah .edit → selalu sembunyikan
                        if (row.classList.contains('edit')) {
                            row.style.display = 'none';
                            return;
                        }

                        // Jika bukan .edit → jalankan filter seperti biasa
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(filter) ? '' : 'none';
                    });
                });
            </script>
        </div>
    </div>
@endsection
