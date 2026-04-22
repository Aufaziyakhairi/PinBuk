<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white">
                    📚 Detail Peminjaman
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Lihat informasi lengkap tentang peminjaman buku
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <!-- Borrowing Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <span>📖</span> Informasi Peminjaman
                    </h3>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Book & Borrower Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                            <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Buku</h4>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $borrowing->book->title }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">oleh {{ $borrowing->book->author }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                            <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Peminjam</h4>
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold">{{ strtoupper(substr($borrowing->user->name, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $borrowing->user->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $borrowing->user->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div>
                        <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Timeline</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-base">📅</span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold">TANGGAL PINJAM</p>
                                </div>
                                <p class="text-gray-900 dark:text-white font-bold">{{ $borrowing->borrowed_at?->format('d M Y') ?? '-' }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-base">⏰</span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold">JATUH TEMPO</p>
                                </div>
                                <p class="text-gray-900 dark:text-white font-bold @if($borrowing->isOverdue() && $borrowing->status === 'approved') text-red-600 dark:text-red-400 @endif">
                                    {{ $borrowing->due_date?->format('d M Y') ?? '-' }}
                                    @if($borrowing->isOverdue() && $borrowing->status === 'approved')
                                        <span class="text-xs block mt-1 text-red-600 dark:text-red-400">⚠ TERLAMBAT</span>
                                    @endif
                                </p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-base">
                                        @if($borrowing->status === 'borrowed')
                                            🔵
                                        @else
                                            ✓
                                        @endif
                                    </span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold">STATUS</p>
                                </div>
                                @if($borrowing->status === 'approved')
                                    <p class="text-sm font-bold text-blue-600 dark:text-blue-400">Sedang Dipinjam</p>
                                @else
                                    <p class="text-sm font-bold text-green-600 dark:text-green-400">Dikembalikan</p>
                                    @if($borrowing->returned_at)
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $borrowing->returned_at->format('d M Y') }}</p>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Return Button (if still borrowed) -->
            @if($borrowing->status === 'approved' && auth()->user()->id === $borrowing->user_id)
                <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 rounded-lg p-4 mb-6">
                    <p class="text-sm font-medium text-blue-700 dark:text-blue-300">
                        ℹ️ Untuk mengembalikan buku, gunakan tombol di bawah
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                    <a href="{{ route('borrowings.edit', $borrowing) }}" class="block w-full bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-semibold py-3 px-4 rounded-lg transition shadow-sm hover:shadow-md text-center">
                        ✓ Kembalikan Buku
                    </a>
                </div>
            @endif

            <!-- Overdue & No Fine Notice (Admin only) -->
            @if($borrowing->status === 'returned' && $borrowing->isOverdue() && !$fine && auth()->user()->isAdmin())
                <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-lg p-4 mb-6">
                    <p class="text-sm font-medium text-red-700 dark:text-red-300 mb-3">
                        🚨 Buku dikembalikan <strong>{{ $borrowing->getDaysLate() }} hari</strong> setelah jatuh tempo. Belum ada pelanggaran/denda yang dibuat.
                    </p>
                    <a href="{{ route('fines.create') }}" class="inline-flex items-center gap-2 px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded transition">
                        ➕ Buat Pelanggaran
                    </a>
                </div>
            @endif

            <!-- Fine Information -->
            @if($fine)
                <div class="bg-orange-50 dark:bg-orange-900/20 border-l-4 border-orange-500 rounded-lg p-4 mb-6">
                    <p class="text-sm font-medium text-orange-700 dark:text-orange-300">
                        ⚠️ Peminjaman ini memiliki <strong>pelanggaran</strong>. Lihat detail di bawah.
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                            <span>📋</span> Informasi Pelanggaran
                        </h3>
                    </div>

                    <div class="p-6 space-y-6">
                        <!-- Fine Description -->
                        <div class="bg-orange-50 dark:bg-orange-900/20 border-l-4 border-orange-500 rounded-lg p-6">
                            <h4 class="text-xs font-semibold text-orange-700 dark:text-orange-300 uppercase tracking-wider mb-3">Keterangan Pelanggaran</h4>
                            <p class="text-base text-orange-900 dark:text-orange-100 leading-relaxed font-medium">{{ $fine->description ?? 'Tidak ada keterangan' }}</p>
                        </div>

                        <!-- Status -->
                        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                            <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Status Pelanggaran</h4>
                            @if($fine->isPaid())
                                <div class="flex items-center gap-3">
                                    <span class="text-2xl">✓</span>
                                    <div>
                                        <p class="font-semibold text-green-700 dark:text-green-300">Terselesaikan</p>
                                        <p class="text-xs text-green-600 dark:text-green-400">Pelanggaran telah ditandai selesai</p>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center gap-3">
                                    <span class="text-2xl">⧗</span>
                                    <div>
                                        <p class="font-semibold text-orange-700 dark:text-orange-300">Menunggu Tindakan</p>
                                        <p class="text-xs text-orange-600 dark:text-orange-400">Pelanggaran masih perlu ditindaklanjuti</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Action Link -->
                        @if(!$fine->isPaid())
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('fines.show', $fine) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-lg transition shadow-sm hover:shadow-md">
                                    📋 Lihat Detail Pelanggaran
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Back Button -->
            <div class="mt-6">
                <a href="{{ route('borrowings.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-white rounded-lg transition font-medium">
                    ← Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
