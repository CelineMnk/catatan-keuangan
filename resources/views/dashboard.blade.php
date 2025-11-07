<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium mb-4">Menu Cepat</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('transactions.create') }}" class="block p-6 bg-green-50 rounded-lg hover:bg-green-100">
                            <h4 class="font-semibold text-green-700">➕ Tambah Transaksi</h4>
                            <p class="text-sm text-green-600">Catat pemasukan atau pengeluaran baru</p>
                        </a>
                        <a href="{{ route('transactions.index') }}" class="block p-6 bg-blue-50 rounded-lg hover:bg-blue-100">
                            <h4 class="font-semibold text-blue-700">📋 Daftar Transaksi</h4>
                            <p class="text-sm text-blue-600">Lihat semua catatan transaksi</p>
                        </a>
                        <a href="{{ route('transactions.stats') }}" class="block p-6 bg-purple-50 rounded-lg hover:bg-purple-100">
                            <h4 class="font-semibold text-purple-700">📊 Statistik</h4>
                            <p class="text-sm text-purple-600">Lihat grafik dan ringkasan keuangan</p>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Transaksi Terbaru</h3>
                        <a href="{{ route('transactions.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">Lihat Semua →</a>
                    </div>
                    @php
                    $recentTransactions = \App\Models\Transaction::where('user_id', auth()->id())
                        ->orderBy('transaction_date', 'desc')
                        ->take(5)
                        ->get();
                    @endphp
                    
                    @if($recentTransactions->isEmpty())
                        <p class="text-gray-500 text-center py-4">Belum ada transaksi</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($recentTransactions as $transaction)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            {{ $transaction->transaction_date }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            {{ $transaction->title }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $transaction->type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Summary -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium mb-4">Ringkasan Bulan Ini</h3>
                    @php
                    $thisMonth = \App\Models\Transaction::where('user_id', auth()->id())
                        ->whereMonth('transaction_date', now()->month)
                        ->whereYear('transaction_date', now()->year)
                        ->selectRaw('
                            SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as total_income,
                            SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as total_expense
                        ')
                        ->first();
                    @endphp
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-4 bg-green-50 rounded-lg">
                            <h4 class="text-sm font-medium text-green-600">Total Pemasukan</h4>
                            <p class="text-2xl font-bold text-green-700">
                                Rp {{ number_format($thisMonth->total_income ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="p-4 bg-red-50 rounded-lg">
                            <h4 class="text-sm font-medium text-red-600">Total Pengeluaran</h4>
                            <p class="text-2xl font-bold text-red-700">
                                Rp {{ number_format($thisMonth->total_expense ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="p-4 bg-blue-50 rounded-lg">
                            <h4 class="text-sm font-medium text-blue-600">Saldo</h4>
                            <p class="text-2xl font-bold text-blue-700">
                                Rp {{ number_format(($thisMonth->total_income ?? 0) - ($thisMonth->total_expense ?? 0), 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
