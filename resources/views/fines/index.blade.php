<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white">
                    📋 Pelanggaran Pengguna
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Kelola dan monitor semua pelanggaran yang terdaftar</p>
            </div>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('fines.create') }}" class="inline-flex items-center gap-2 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-sm">
                    + Buat Denda
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Admin Unpaid Fines Alert -->
            @if(auth()->user()->isAdmin())
                @php
                    $unpaidCount = $fines->where('status', 'unpaid')->count();
                @endphp
                @if($unpaidCount > 0)
                    <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-lg p-4">
                        <p class="text-sm font-medium text-red-700 dark:text-red-300">
                            ⚠️ Ada <strong>{{ $unpaidCount }}</strong> pelanggaran yang masih menunggu tindakan
                        </p>
                    </div>
                @else
                    <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 rounded-lg p-4">
                        <p class="text-sm font-medium text-green-700 dark:text-green-300">
                            ✓ Semua pelanggaran telah ditandai selesai
                        </p>
                    </div>
                @endif
            @endif

            <!-- Filter Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter Data
                    </h3>
                </div>
                <div class="p-6">
                    <form method="GET" action="{{ route('fines.index') }}" class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Status Pelanggaran</label>
                            <select name="status"
                                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="">✦ Semua Status</option>
                                <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>⧗ Menunggu Tindakan</option>
                                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>✓ Terselesaikan</option>
                            </select>
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-lg transition shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                Filter
                            </button>
                            @if(request('status'))
                                <a href="{{ route('fines.index') }}" class="px-4 py-2.5 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg transition">Reset</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Fines Table -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <span>📋</span> Daftar Pelanggaran ({{ $fines->total() }} Total)
                    </h3>
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
                                                <span class="text-white font-bold text-sm">{{ strtoupper(substr($fine->user->name, 0, 1)) }}</span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white">{{ $fine->user->name }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $fine->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $fine->borrowing->book->title }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">oleh {{ $fine->borrowing->book->author ?? '—' }}</p>
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
                                            <p class="text-gray-600 dark:text-gray-400 font-semibold">Tidak ada pelanggaran</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-500">Silakan sesuaikan filter atau periksa kembali</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($fines->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                        {{ $fines->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
