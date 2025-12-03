    @extends('admin.layout')

    @section('content')
        <div class="p-6">
            <h1 class="text-2xl font-bold text-[#0A2540]">Users</h1>

            <!-- Form 25% & Table 75% -->
            <div class="mt-6 flex gap-6 items-start">
                <!-- Form Input 25% -->
                <div class="w-1/4 bg-white rounded-xl shadow-md p-6 space-y-4">
                    <form action="/admin/user" method="POST">
                        @csrf
                        <div class="mt-3">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input type="text" id="name" name="name" placeholder="Enter user name"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A2540] focus:border-transparent transition"
                                required />
                        </div>
                        <div class="mt-3">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="text" id="email" name="email" placeholder="Enter user email"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A2540] focus:border-transparent transition"
                                required />
                        </div>
                        <div class="mt-3">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="text" id="password" name="password" placeholder="Enter user password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A2540] focus:border-transparent transition"
                                required />
                        </div>
                        <div class="mt-3">
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                            <select id="role" name="role"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A2540] focus:border-transparent transition"
                                required>
                                <option value="" hidden>-- Select Role --</option>
                                <option value="User">User</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                            <input type="text" id="phone" name="phone" placeholder="Enter user phone"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A2540] focus:border-transparent transition"
                                required />
                        </div>
                        <div class="mt-3">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <input type="text" id="address" name="address" placeholder="Enter user address"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A2540] focus:border-transparent transition"
                                required />
                        </div>
                        <div class="mt-3">
                            <label for="resto_name" class="block text-sm font-medium text-gray-700 mb-1">Resto Name</label>
                            <input type="text" id="resto_name" name="resto_name" placeholder="Enter resto name"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A2540] focus:border-transparent transition"
                                required />
                        </div>
                        <button type="submit"
                            class="w-full bg-[#0A2540] text-white py-2 my-2 px-4 rounded-lg hover:bg-opacity-90 transition duration-200 font-medium">
                            Save
                        </button>
                    </form>
                </div>

                <!-- Searchable User Table 75% -->
                <div class="flex-1 bg-white rounded-xl shadow-md overflow-hidden">
                    <!-- Search Bar -->
                    <div class="px-6 py-4 border-b border-gray-200">
                        <input type="text" id="searchUser" placeholder="Search user..."
                            class="w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A2540] focus:border-transparent transition" />
                    </div>
                    <div class="overflow-x-auto">
                        <table id="userTable" class="min-w-full divide-y divide-gray-200 table-fixed">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Password</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Phone</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Address</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Resto Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($users as $user)
                                    <tr class="show" data-id="{{ $user->id }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->password }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->role }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->phone }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->address }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->resto_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                            <a href="#"
                                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded cursor-pointer btn-edit">Edit</a>
                                            <form action="{{ url('/admin/category', $user->id) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded cursor-pointer">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr class="edit" style="display: none;" data-id="{{ $user->id }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $loop->iteration }}</td>
                                        <td
                                            class="w-[15rem] min-w-[15rem] px-6 py-4 whitespace-nowrap text-sm text-gray-900 w">
                                            <input type="text" name="name" value="{{ $user->name }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A2540] focus:border-transparent transition" />
                                        </td>
                                        <td class="w-[15rem] min-w-[15rem] px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <input type="text" name="email" value="{{ $user->email }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A2540] focus:border-transparent transition" />
                                        </td>
                                        <td class="w-[15rem] min-w-[15rem] px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <input type="text" name="password" value="{{ $user->password }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A2540] focus:border-transparent transition" />
                                        </td>
                                        <td class="w-[15rem] min-w-[15rem] px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <select name="role" id="role"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A2540] focus:border-transparent transition">
                                                <option value="User" {{ $user->role == 'User' ? 'selected' : '' }}>User
                                                </option>
                                                <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>
                                                    Admin
                                                </option>
                                            </select>
                                        </td>
                                        <td class="w-[15rem] min-w-[15rem] px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <input type="text" name="phone" value="{{ $user->phone }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A2540] focus:border-transparent transition" />
                                        </td>
                                        <td class="w-[15rem] min-w-[15rem] px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <input type="text" name="address" value="{{ $user->address }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A2540] focus:border-transparent transition" />
                                        </td>
                                        <td class="w-[15rem] min-w-[15rem] px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <input type="text" name="resto_name" value="{{ $user->resto_name }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A2540] focus:border-transparent transition" />
                                        </td>
                                        <td class="w-[15rem] min-w-[15rem] px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                            <button
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded cursor-pointer btn-update">Update</button>
                                            <button
                                                class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded cursor-pointer btn-cancel">Cancel</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">No users found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

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
                            const email = editRow.find('input[name="email"]').val();
                            const password = editRow.find('input[name="password"]').val();
                            const role = editRow.find('select[name="role"]').val();
                            const phone = editRow.find('input[name="phone"]').val();
                            const address = editRow.find('input[name="address"]').val();
                            const resto_name = editRow.find('input[name="resto_name"]').val();

                            $.ajax({
                                url: `/admin/user/${id}`,
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    _method: 'PUT',
                                    name: name,
                                    email: email,
                                    password: password,
                                    role: role,
                                    phone: phone,
                                    address: address,
                                    resto_name: resto_name,
                                },
                                success: function() {
                                    // Update the display row with new values
                                    const showRow = editRow.prev('tr.show');
                                    showRow.find('td:eq(1)').text(name);
                                    showRow.find('td:eq(2)').text(email);
                                    showRow.find('td:eq(3)').text(password);
                                    showRow.find('td:eq(4)').text(role);
                                    showRow.find('td:eq(5)').text(phone);
                                    showRow.find('td:eq(6)').text(address);
                                    showRow.find('td:eq(7)').text(resto_name);
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
                    document.getElementById('searchUser').addEventListener('input', function() {
                        const filter = this.value.toLowerCase();
                        const rows = document.querySelectorAll('#userTable tbody tr');

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
