<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- WAJIB -->
    <script src="https://cdn.tiny.cloud/1/w4ptjrhogjjhd2oblsb8kkgjh5p1s2nbr6dq16xtirwa94am/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <title>Admin</title>
</head>

<body>


    @extends('admin.layout')

    @section('content')
        <div class="p-6">
            <h1 class="text-2xl font-bold text-[#0A2540]">Education Content</h1>

            <div class="mt-6 flex gap-6 items-start">

                <!-- FORM -->
                <div class="w-2/5 bg-white rounded-xl shadow-md p-6 space-y-4">
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
                                class="tinymce w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea>
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
                            class="w-3/5 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0A2540]">
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
                                        <img src="{{ asset('storage/' . $item->image) }}"
                                            class="w-16 h-12 object-cover rounded">
                                    </td>

                                    <td class="px-6 py-4 text-sm">{{ $item->judul }}</td>

                                    <td class="px-6 py-4 text-sm">
                                        {!! \Illuminate\Support\Str::limit(strip_tags($item->content, '<strong><em><u>'), 40) !!}
                                    </td>

                                    <td class="px-6 py-4 space-x-2">
                                        <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded btn-edit">
                                            Edit
                                        </button>

                                        <button class="bg-red-500 text-white px-3 py-1 rounded btn-delete"
                                            data-id="{{ $item->id }}">
                                            Delete
                                        </button>
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
                                        <textarea id="content-{{ $item->id }}" name="content"
                                            class="tinymce-edit w-full px-2 py-1 border rounded">{{ $item->content }}</textarea>
                                    </td>

                                    <td class="px-6 py-4 space-x-2">
                                        <button
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded btn-update">
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

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <script>
            function initTiny(selector) {
                tinymce.init({
                    selector: selector,
                    height: 300,
                    menubar: false,
                    plugins: [
                        'lists', 'link', 'image', 'table', 'code', 'wordcount'
                    ],
                    toolbar: 'undo redo | bold italic underline | bullist numlist | link image | code',
                    branding: false
                });
            }

            function initEditTiny() {
                tinymce.remove('.tinymce-edit');
                initTiny('.tinymce-edit');
            }

            $(document).ready(function () {

                // 🔥 PAKAI DELAY (biar DOM + Blade fully ready)
                setTimeout(() => {
                    initTiny('.tinymce');
                }, 300);

                // CSRF
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                // EDIT
                $(document).on('click', '.btn-edit', function () {
                    let row = $(this).closest('tr');
                    row.hide();

                    let editRow = row.next('.edit');
                    editRow.show();

                    // 🔥 delay juga biar element muncul dulu
                    setTimeout(() => {
                        initEditTiny();
                    }, 100);
                });

                // CANCEL
                $(document).on('click', '.btn-cancel', function () {
                    let row = $(this).closest('tr');
                    row.hide();
                    row.prev('.show').show();
                });

                // UPDATE
                $(document).on('click', '.btn-update', function () {

                    let row = $(this).closest('tr');
                    let id = row.data('id');

                    let judul = row.find('input[name="judul"]').val();

                    let textarea = row.find('textarea[name="content"]')[0];
                    let content = tinymce.get(textarea.id)?.getContent() || textarea.value;


                    $.ajax({
                        url: '/admin/education/' + id,
                        type: 'PUT',
                        data: { judul, content },
                        success: function () {

                            let showRow = row.prev('.show');

                            showRow.find('td:eq(2)').text(judul);
                            showRow.find('td:eq(3)').html(content.substring(0, 40));

                            row.hide();
                            showRow.show();
                        }
                    });
                });

                // REQUIERED
                $('form').on('submit', function (e) {
                    tinymce.triggerSave(); // 🔥 penting

                    let content = $('textarea[name="content"]').val();

                    if (!content.trim()) {
                        e.preventDefault();
                        alert('Content wajib diisi!');
                    }
                });

            });
        </script>

    @endsection

</body>

</html>