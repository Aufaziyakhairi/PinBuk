<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white">
                    📊 Dashboard Admin Perpustakaan
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Papan Informasi Buku - Ringkasan Manajemen Perpustakaan
                </p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('analytics') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold text-sm transition">
                    📊 Laporan & Analitik
                </a>
                <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center">
                    {{ now()->format('l, d M Y') }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Key Metrics Header -->
            <div class="bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 rounded-xl border border-blue-200 dark:border-blue-700 p-6 mb-2">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-4">📈 Metrik Utama</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    Ringkasan statistik pengelolaan perpustakaan untuk membantu Anda membuat keputusan yang tepat.
                </p>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Books -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center flex-shrink-0">
                                    <span class="text-white text-xl">📚</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Buku</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalBooks }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center text-xs text-blue-600 dark:text-blue-400 mt-3 pt-3 border-t border-gray-100 dark:border-gray-700">
                            <span>Koleksi perpustakaan Anda</span>
                        </div>
                    </div>
                </div>

                <!-- Active Borrowings -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center flex-shrink-0">
                                    <span class="text-white text-xl">📖</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Peminjaman Aktif</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $activeBorrowings }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-1.5 mb-2">
                            <div class="bg-green-600 h-1.5 rounded-full" style="width: {{ min(($activeBorrowings / ($totalBooks ?: 1)) * 100, 100) }}%"></div>
                        </div>
                        <div class="flex items-center text-xs text-green-600 dark:text-green-400">
                            <span>{{ number_format(($activeBorrowings / ($totalBooks ?: 1)) * 100, 1) }}% dari koleksi</span>
                        </div>
                    </div>
                </div>

                <!-- Violations -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center flex-shrink-0">
                                    <span class="text-white text-xl">⚠️</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pelanggaran</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalFines ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center text-xs text-orange-600 dark:text-orange-400 pt-3 border-t border-gray-100 dark:border-gray-700">
                            <span>Masalah yang perlu diperhatikan</span>
                        </div>
                    </div>
                </div>

                <!-- Overdue - Critical -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-red-200 dark:border-red-700 overflow-hidden hover:shadow-md transition-shadow ring-1 ring-red-100 dark:ring-red-900/20">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-red-400 to-red-600 flex items-center justify-center flex-shrink-0">
                                    <span class="text-white text-xl">🚨</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-semibold text-red-600 dark:text-red-400 uppercase tracking-wider font-bold">TERLAMBAT</p>
                                    <p class="text-2xl font-bold text-red-600 dark:text-red-400 mt-1">{{ $overdueBorrowings->count() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center text-xs text-red-600 dark:text-red-400 pt-3 border-t border-red-100 dark:border-red-700">
                            <span class="font-semibold">⚡ Butuh tindakan segera</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Overdue Borrowings Alert & Details -->
            @if($overdueBorrowings->isNotEmpty())
                <div class="space-y-6">
                    <!-- Alert Banner -->
                    <div class="bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/30 dark:to-orange-900/30 border-l-4 border-red-500 rounded-lg p-5 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="text-3xl">🚨</div>
                            <div>
                                <p class="text-sm font-bold text-red-700 dark:text-red-300 uppercase tracking-wider">Perhatian Segera Diperlukan</p>
                                <p class="text-red-600 dark:text-red-400 text-sm mt-1">
                                    Ada <strong class="text-lg">{{ $overdueBorrowings->count() }}</strong> peminjaman yang <strong>melampaui tanggal jatuh tempo</strong>. Segera hubungi peminjam.
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('borrowings.index') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold text-sm whitespace-nowrap transition">
                            Lihat Semua →
                        </a>
                    </div>

                    <!-- Overdue Borrowings Table -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-5 bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                                <span class="text-lg">⏰</span> Daftar Peminjaman Terlambat
                            </h3>
                            <span class="text-xs font-bold text-red-600 dark:text-red-400 bg-red-100 dark:bg-red-900/30 px-3 py-1 rounded-full">
                                {{ $overdueBorrowings->count() }} item
                            </span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 dark:bg-gray-900 sticky top-0">
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Peminjam</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Buku</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Jatuh Tempo</th>
                                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($overdueBorrowings as $borrowing)
                                        <tr class="hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white text-xs font-bold">
                                                        {{ substr($borrowing->user->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ $borrowing->user->name }}</p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $borrowing->user->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $borrowing->book->title }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $borrowing->book->author ?? '-' }}</p>
                                            </td>
                                            <td class="px-6 py-4 text-sm">
                                                <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-xs font-bold rounded-lg border border-red-300 dark:border-red-700">
                                                    {{ $borrowing->due_date?->format('d M Y') ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-xs font-bold rounded-full">
                                                    <span class="w-2 h-2 bg-red-600 rounded-full animate-pulse"></span>
                                                    TERLAMBAT
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <a href="{{ route('borrowings.show', $borrowing) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-full hover:bg-blue-100 dark:hover:bg-blue-900/30 text-blue-600 dark:text-blue-400 transition font-semibold">
                                                    →
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-200 dark:border-green-700 rounded-xl p-6 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="text-3xl">✅</div>
                        <div>
                            <p class="text-sm font-semibold text-green-700 dark:text-green-300 uppercase tracking-wider">Sempurna!</p>
                            <p class="text-green-600 dark:text-green-400 text-sm mt-1">Tidak ada peminjaman yang terlambat. Perpustakaan Anda dalam kondisi baik.</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Recent Activity Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-5 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <span class="text-lg">⚡</span> Aktivitas Terbaru
                    </h3>
                    <a href="{{ route('borrowings.index') }}" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                        Lihat Semua →
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-900 sticky top-0">
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Peminjam</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Buku</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Tanggal Peminjaman</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Jatuh Tempo</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($recentBorrowings as $borrowing)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white text-xs font-bold">
                                                {{ substr($borrowing->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ $borrowing->user->name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $borrowing->book->title }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        {{ $borrowing->borrowed_at?->format('d M Y') ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        <span class="text-xs">{{ $borrowing->due_date?->format('d M Y') ?? '-' }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-center">
                                        @if($borrowing->status === 'borrowed')
                                            @if($borrowing->isOverdue())
                                                <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-xs font-bold rounded-lg border border-red-300 dark:border-red-700">
                                                    <span class="w-2 h-2 bg-red-600 rounded-full animate-pulse"></span>
                                                    TERLAMBAT
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-bold rounded-lg border border-blue-300 dark:border-blue-700">
                                                    <span class="w-2 h-2 bg-blue-600 rounded-full"></span>
                                                    AKTIF
                                                </span>
                                            @endif
                                        @else
                                            <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-bold rounded-lg border border-green-300 dark:border-green-700">
                                                <span class="w-2 h-2 bg-green-600 rounded-full"></span>
                                                DIKEMBALIKAN
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-center">
                                        <a href="{{ route('borrowings.show', $borrowing) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-full hover:bg-blue-100 dark:hover:bg-blue-900/30 text-blue-600 dark:text-blue-400 transition font-semibold">
                                            →
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <span class="text-4xl">📭</span>
                                            <span class="text-gray-500 dark:text-gray-400 font-medium">Tidak ada data peminjaman</span>
                                        </div>
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
