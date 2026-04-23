@extends('admin.layout')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold text-[#0A2540]">Education Content</h1>

        <div class="mt-6 flex gap-6 items-start">

            <!-- FORM -->
            <div class="w-1/4 bg-white rounded-xl shadow-md p-6 space-y-4">
                <form action="{{ route('education.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                        <input type="file" name="image" class="w-full px-2 py-2 border border-gray-300 rounded-lg">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="judul"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0A2540]"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                        <textarea name="content"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0A2540]"
                            required></textarea>
                    </div>

                    <button class="w-full bg-[#0A2540] text-white py-2 px-4 rounded-lg hover:bg-opacity-90">
                        Upload
                    </button>
                </form>
            </div>

            <!-- TABLE -->
            <div class="flex-1 bg-white rounded-xl shadow-md overflow-hidden">

                <!-- SEARCH -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <input type="text" id="searchEdukasi" placeholder="Search edukasi..."
                        class="w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0A2540]">
                </div>

                <table id="edukasiTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs text-gray-500">#</th>
                            <th class="px-6 py-3 text-xs text-gray-500">Image</th>
                            <th class="px-6 py-3 text-xs text-gray-500">Title</th>
                            <th class="px-6 py-3 text-xs text-gray-500">Content</th>
                            <th class="px-6 py-3 text-xs text-gray-500">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($education as $item)

                            <!-- SHOW ROW -->
                            <tr class="show" data-id="{{ $item->id }}">
                                <td class="px-6 py-4 text-sm">{{ $loop->iteration }}</td>

                                <td class="px-6 py-4">
                                    <img src="{{ asset('storage/' . $item->image) }}" class="w-16 h-12 object-cover rounded">
                                </td>

                                <td class="px-6 py-4 text-sm">{{ $item->judul }}</td>

                                <td class="px-6 py-4 text-sm">
                                    {{ \Illuminate\Support\Str::limit($item->content, 40) }}
                                </td>

                                <td class="px-6 py-4 space-x-2">
                                    <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded btn-edit">
                                        Edit
                                    </button>

                                    <form action="{{ route('education.destroy', $item->id) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Yakin hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-500 text-white px-3 py-1 rounded btn-delete"
                                            data-id="{{ $item->id }}">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- EDIT ROW -->
                            <tr class="edit hidden" data-id="{{ $item->id }}">
                                <td class="px-6 py-4 text-sm">{{ $loop->iteration }}</td>

                                <td class="px-6 py-4 text-xs text-gray-400">
                                    (tidak edit gambar)
                                </td>

                                <td class="px-6 py-4">
                                    <input type="text" name="judul" value="{{ $item->judul }}"
                                        class="w-full px-2 py-1 border rounded">
                                </td>

                                <td class="px-6 py-4">
                                    <textarea name="content"
                                        class="w-full px-2 py-1 border rounded">{{ $item->content }}</textarea>
                                </td>

                                <td class="px-6 py-4 space-x-2">
                                    <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded btn-update">
                                        Update
                                    </button>
                                    <button class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded btn-cancel">
                                        Cancel
                                    </button>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">
                                    No data found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <!-- SCRIPT -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).ready(function () {

            // EDIT
            $(document).on('click', '.btn-edit', function () {
                const row = $(this).closest('tr');
                row.hide();
                row.next('.edit').show();
            });

            // CANCEL
            $(document).on('click', '.btn-cancel', function () {
                const row = $(this).closest('tr');
                row.hide();
                row.prev('.show').show();
            });

            // UPDATE
            $(document).on('click', '.btn-update', function () {

                const row = $(this).closest('tr.edit');
                const id = row.data('id');

                console.log('UPDATE CLICKED ID:', id);

                const judul = row.find('input[name="judul"]').val();
                const content = row.find('textarea[name="content"]').val();

                $.ajax({
                    url: `/admin/education/${id}`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'PUT',
                        judul: judul,
                        content: content
                    },
                    success: function (res) {
                        console.log(res);

                        const showRow = row.prev('.show');

                        showRow.find('td:eq(2)').text(judul);
                        showRow.find('td:eq(3)').text(content.substring(0, 40));

                        row.hide();
                        showRow.show();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        alert('Update gagal');
                    }
                });
            });

            $(document).on('click', '.btn-delete', function () {

                if (!confirm('Yakin hapus?')) return;

                const id = $(this).data('id');

                $.ajax({
                    url: `/admin/education/${id}`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function () {
                        location.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        alert('Delete gagal');
                    }
                });
            });

        });
    </script>

    <script>
        document.getElementById('searchEdukasi').addEventListener('input', function () {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('#edukasiTable tbody tr');

            rows.forEach(row => {
                if (row.classList.contains('edit')) {
                    row.style.display = 'none';
                    return;
                }

                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>

@endsection