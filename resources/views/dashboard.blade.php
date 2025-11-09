<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-700 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Deskripsi Catatan Keuangan -->
            <div class="bg-pink-50 overflow-hidden shadow-lg sm:rounded-3xl p-10 text-center animate-fadeIn">
                <h3 class="text-3xl font-bold text-pink-600 mb-4">Catatan Keuangan </h3>
                <p class="text-pink-700 text-lg">
                    Selamat datang di catatan keuangan! <br>
                    Di sini anda bisa mencatat semua pemasukan dan pengeluaran dengan rapi dan terstruktur.<br>
                    Jangan lupa selalu mengecek catatanmu agar keuangan tetap terdata!
                </p>
            </div>

        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 1s ease-out;
        }
    </style>
</x-app-layout>
