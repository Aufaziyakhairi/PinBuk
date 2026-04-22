<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white">
                    📊 Laporan & Analitik
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Papan Informasi Buku - Analisis Komprehensif Sistem Perpustakaan
                </p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-white rounded-lg font-semibold text-sm transition">
                ← Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Books -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-2">📚 Total Koleksi</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalBooks }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Jumlah buku yang tersedia</p>
                        </div>
                        <div class="text-4xl opacity-20">📚</div>
                    </div>
                </div>

                <!-- Total Users -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-2">👥 Total Pengguna</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalUsers }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Anggota perpustakaan aktif</p>
                        </div>
                        <div class="text-4xl opacity-20">👥</div>
                    </div>
                </div>

                <!-- Total Borrowings -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-2">📖 Total Peminjaman</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalBorrowings }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Jumlah transaksi peminjaman</p>
                        </div>
                        <div class="text-4xl opacity-20">📖</div>
                    </div>
                </div>

                <!-- Return Rate -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-2">✓ Tingkat Pengembalian</p>
                            <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $returnRate }}%</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Buku yang dikembalikan tepat waktu</p>
                        </div>
                        <div class="text-4xl opacity-20">✓</div>
                    </div>
                </div>
            </div>

            <!-- Detailed Statistics -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Active Borrowings -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">📘 Peminjaman Aktif</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between p-4 bg-blue-50 dark:bg-blue-900/10 rounded-lg border border-blue-200 dark:border-blue-700">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Sedang Dipinjam</span>
                            <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $activeBorrowings }}</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-green-50 dark:bg-green-900/10 rounded-lg border border-green-200 dark:border-green-700">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Tepat Waktu</span>
                            <span class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $onTimeBorrowings }}</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-red-50 dark:bg-red-900/10 rounded-lg border border-red-200 dark:border-red-700">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Terlambat</span>
                            <span class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $overdueBorrowings }}</span>
                        </div>
                    </div>
                </div>

                <!-- Book Statistics -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">📚 Statistik Buku</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between p-4 bg-green-50 dark:bg-green-900/10 rounded-lg border border-green-200 dark:border-green-700">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Tersedia</span>
                            <span class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $availableBooks }}</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-blue-50 dark:bg-blue-900/10 rounded-lg border border-blue-200 dark:border-blue-700">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Sedang Dipinjam</span>
                            <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $borrowedBooks }}</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/10 rounded-lg border border-gray-200 dark:border-gray-700">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Ketersediaan</span>
                            <span class="text-2xl font-bold text-gray-600 dark:text-gray-400">{{ $bookAvailability }}%</span>
                        </div>
                    </div>
                </div>

                <!-- User Activity -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">👤 Aktivitas Pengguna</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between p-4 bg-purple-50 dark:bg-purple-900/10 rounded-lg border border-purple-200 dark:border-purple-700">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Peminjam Aktif</span>
                            <span class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $activeUsers }}</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-orange-50 dark:bg-orange-900/10 rounded-lg border border-orange-200 dark:border-orange-700">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Pelanggaran Tertunggu</span>
                            <span class="text-2xl font-bold text-orange-600 dark:text-orange-400">{{ $pendingViolations }}</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-indigo-50 dark:bg-indigo-900/10 rounded-lg border border-indigo-200 dark:border-indigo-700">
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Rata-rata Peminjaman</span>
                            <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $avgBorrowingsPerUser }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Books -->
            @if($topBooks->isNotEmpty())
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-amber-50 to-yellow-50 dark:from-amber-900/20 dark:to-yellow-900/20 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">⭐ Buku Paling Banyak Dipinjam</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-900 sticky top-0">
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Judul Buku</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Penulis</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Jumlah Peminjaman</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($topBooks as $book)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white text-sm">{{ $book->title }}</td>
                                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 text-sm">{{ $book->author ?? '-' }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 text-sm font-bold rounded-full">
                                                <span>⭐</span> {{ $book->borrowings_count }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Recent Activity -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">⚡ Aktivitas Terbaru</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-900 sticky top-0">
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Buku</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Pengguna</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Waktu</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($recentActivities as $activity)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white text-sm">{{ $activity->book->title }}</td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300 text-sm">{{ $activity->user->name }}</td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300 text-sm">{{ $activity->created_at->diffForHumans() }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($activity->status === 'pending')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 text-xs font-bold rounded-full">⏳ Menunggu</span>
                                        @elseif($activity->status === 'approved')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-bold rounded-full">📖 Dipinjam</span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-bold rounded-full">✓ Dikembalikan</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        Tidak ada aktivitas terbaru
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
