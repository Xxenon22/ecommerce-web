@extends('admin.layout')

@section('content')
<div class="p-6">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Overview</h1>
        <p class="text-gray-600">Selamat datang kembali, {{ Auth::user()->name }}!</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
                    <span class="iconify" data-icon="mdi:account-group" data-width="24"></span>
                </div>
                <div class="text-right">
                    <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded-full">Total</span>
                </div>
            </div>
            <h3 class="text-gray-500 text-sm font-medium">Total Pengguna</h3>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalUsers) }}</p>
        </div>

        <!-- Total Restaurants -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-50 rounded-lg text-green-600">
                    <span class="iconify" data-icon="mdi:store" data-width="24"></span>
                </div>
                <div class="text-right">
                    <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full">Total</span>
                </div>
            </div>
            <h3 class="text-gray-500 text-sm font-medium">Total Restoran</h3>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalRestaurants) }}</p>
        </div>

        <!-- Total Transactions Today -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-purple-50 rounded-lg text-purple-600">
                    <span class="iconify" data-icon="mdi:cart" data-width="24"></span>
                </div>
                <div class="text-right">
                    <span class="text-xs font-medium text-purple-600 bg-purple-50 px-2 py-1 rounded-full">Hari Ini</span>
                </div>
            </div>
            <h3 class="text-gray-500 text-sm font-medium">Transaksi Hari Ini</h3>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($todayTransactions) }}</p>
        </div>

        <!-- Total Revenue Today -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-yellow-50 rounded-lg text-yellow-600">
                    <span class="iconify" data-icon="mdi:currency-usd" data-width="24"></span>
                </div>
                <div class="text-right">
                    <span class="text-xs font-medium text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">Hari Ini</span>
                </div>
            </div>
            <h3 class="text-gray-500 text-sm font-medium">Pendapatan Hari Ini</h3>
            <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Transactions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-800">Transaksi Terbaru</h2>
                <a href="/admin/history" class="text-blue-600 text-sm font-medium hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                            <th class="px-6 py-3 font-semibold">User</th>
                            <th class="px-6 py-3 font-semibold">Total</th>
                            <th class="px-6 py-3 font-semibold">Status</th>
                            <th class="px-6 py-3 font-semibold">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentTransactions as $transaction)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-800">{{ $transaction->user->name ?? 'Unknown' }}</div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($transaction->status == 'success')
                                    <span class="px-2 py-1 text-xs font-medium bg-green-50 text-green-600 rounded-full">Success</span>
                                @elseif($transaction->status == 'pending')
                                    <span class="px-2 py-1 text-xs font-medium bg-yellow-50 text-yellow-600 rounded-full">Pending</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium bg-red-50 text-red-600 rounded-full">{{ $transaction->status }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $transaction->created_at->diffForHumans() }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-400">Belum ada transaksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-800">Pengguna Baru</h2>
                <a href="/admin/user" class="text-blue-600 text-sm font-medium hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                            <th class="px-6 py-3 font-semibold">Nama</th>
                            <th class="px-6 py-3 font-semibold">Email</th>
                            <th class="px-6 py-3 font-semibold">Bergabung</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentUsers as $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="font-medium text-gray-800">{{ $user->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $user->created_at }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-10 text-center text-gray-400">Belum ada pengguna</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
