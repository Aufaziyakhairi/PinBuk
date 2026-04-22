<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white">
                    📊 Laporan Pelanggaran Bulanan
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Analisis dan statistik pelanggaran pengguna per bulan
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <span>🔍</span> Filter Periode Laporan
                    </h3>
                </div>
                <div class="p-6">
                    <form method="GET" action="{{ route('fines.monthly-report') }}" class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-2 uppercase tracking-wider">Bulan</label>
                            <select name="month" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                                @for($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::createFromDate(2024, $m, 1)->format('F (M)') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="flex-1 min-w-[150px]">
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-2 uppercase tracking-wider">Tahun</label>
                            <select name="year" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                                @for($y = 2020; $y <= date('Y'); $y++)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-2.5 px-6 rounded-lg transition shadow-sm hover:shadow-md">
                                🔍 Filter
                            </button>
                            <a href="{{ route('fines.monthly-report') }}" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold py-2.5 px-6 rounded-lg transition">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Total Fines -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 rounded-xl shadow-sm border border-blue-200 dark:border-blue-700 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-semibold text-blue-700 dark:text-blue-300 uppercase tracking-wider">Total Pelanggaran</h3>
                            <span class="text-3xl">📋</span>
                        </div>
                        <p class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">{{ $totalFines }}</p>
                        <p class="text-xs text-blue-600 dark:text-blue-400">kasus dalam periode ini</p>
                    </div>
                </div>

                <!-- Resolved Fines -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/30 rounded-xl shadow-sm border border-green-200 dark:border-green-700 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-semibold text-green-700 dark:text-green-300 uppercase tracking-wider">Terselesaikan</h3>
                            <span class="text-3xl">✓</span>
                        </div>
                        <p class="text-4xl font-bold text-green-600 dark:text-green-400 mb-2">{{ $totalPaid }}</p>
                        <p class="text-xs text-green-600 dark:text-green-400">sudah ditandai selesai</p>
                    </div>
                </div>

                <!-- Pending Fines -->
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/30 dark:to-orange-800/30 rounded-xl shadow-sm border border-orange-200 dark:border-orange-700 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-semibold text-orange-700 dark:text-orange-300 uppercase tracking-wider">Menunggu Tindakan</h3>
                            <span class="text-3xl">⧗</span>
                        </div>
                        <p class="text-4xl font-bold text-orange-600 dark:text-orange-400 mb-2">{{ $totalUnpaid }}</p>
                        <p class="text-xs text-orange-600 dark:text-orange-400">masih dalam proses</p>
                    </div>
                </div>
            </div>

            <!-- Fines Table Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <span>📋</span> Daftar Pelanggaran — {{ \Carbon\Carbon::createFromDate($year, $month, 1)->format('F Y') }}
                    </h3>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">Total {{ $totalFines }} kasus pelanggaran dalam periode ini</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-900 sticky top-0">
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Peminjam</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Buku</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Keterangan</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($fines as $fine)
                                <tr class="hover:bg-blue-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center flex-shrink-0">
                                                <span class="text-white font-bold">{{ strtoupper(substr($fine->user->name, 0, 1)) }}</span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white">{{ $fine->user->name }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $fine->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $fine->borrowing->book->title }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">oleh {{ $fine->borrowing->book->author }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-200 max-w-xs">
                                        <p class="line-clamp-2">{{ $fine->description ?? '—' }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if($fine->isPaid())
                                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-semibold rounded-full border border-green-200 dark:border-green-700">
                                                <span class="w-2 h-2 bg-green-600 dark:bg-green-400 rounded-full"></span>
                                                Terselesaikan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 text-xs font-semibold rounded-full border border-orange-200 dark:border-orange-700">
                                                <span class="w-2 h-2 bg-orange-600 dark:bg-orange-400 rounded-full"></span>
                                                Menunggu
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-center">
                                        <a href="{{ route('fines.show', $fine) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-full hover:bg-blue-100 dark:hover:bg-blue-900/30 text-blue-600 dark:text-blue-400 transition" title="Lihat detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <p class="text-gray-600 dark:text-gray-400 font-semibold">Tidak ada data pelanggaran</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-500">untuk periode {{ \Carbon\Carbon::createFromDate($year, $month, 1)->format('F Y') }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 flex flex-wrap gap-3">
                <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-lg transition shadow-sm hover:shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4H7a2 2 0 01-2-2v-4a2 2 0 012-2h10a2 2 0 012 2v4a2 2 0 01-2 2zm0 0h6a2 2 0 002-2v-4a2 2 0 00-2-2H9"></path>
                    </svg>
                    Cetak Laporan
                </button>
                <button onclick="window.history.back()" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-white font-semibold rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
