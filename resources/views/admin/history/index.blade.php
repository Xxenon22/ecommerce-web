    @extends('admin.layout')

    @section('content')
        <div class="p-6">
            <h1 class="text-2xl font-bold text-[#0A2540]">Transactions</h1>

            <!-- Searchable transaction Table 75% -->
            <div class="flex-1 bg-white rounded-xl shadow-md overflow-hidden">
                <!-- Search Bar -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <input type="text" id="searchtransaction" placeholder="Search transaction..."
                        class="w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A2540] focus:border-transparent transition" />
                </div>
                <div class="overflow-x-auto">
                    <table id="transactionTable" class="min-w-full divide-y divide-gray-200 table-fixed">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Restaurant</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expetidion</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expedition Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat Pengiriman</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($transactions as $transaction)
                                <tr class="show" data-id="{{ $transaction->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction->restaurant->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction->transactionProduct->product->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction->expedition->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction->expedition_price }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction->total_price }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction->address->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction->status }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                        <a href="#"
                                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded cursor-pointer btn-edit">Edit</a>
                                        <form action="{{ url('/admin/category', $transaction->id) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded cursor-pointer">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr class="edit" style="display: none;" data-id="{{ $transaction->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $loop->iteration }}</td>
                                    <td class="w-[15rem] min-w-[15rem] px-6 py-4 whitespace-nowrap text-sm text-gray-900 w">
                                    </td>
                                    <td class="w-[15rem] min-w-[15rem] px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    </td>
                                    <td class="w-[15rem] min-w-[15rem] px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    </td>
                                    <td class="w-[15rem] min-w-[15rem] px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    </td>
                                    <td class="w-[15rem] min-w-[15rem] px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    </td>
                                    <td class="w-[15rem] min-w-[15rem] px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    </td>
                                    <td class="w-[15rem] min-w-[15rem] px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    </td>
                                    <td class="w-[15rem] min-w-[15rem] px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">No transactions
                                        found.
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
            <!-- Simple client-side search script -->
            <script>
                document.getElementById('searchtransaction').addEventListener('input', function() {
                    const filter = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#transactionTable tbody tr');

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
    @endsection
