<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white">
                    👋 Dashboard Peminjam
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Kelola peminjaman buku dan pelanggaran Anda
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Banner -->
            <div class="mb-8 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/30 dark:to-cyan-900/30 rounded-xl shadow-sm border border-blue-200 dark:border-blue-700 overflow-hidden">
                <div class="p-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                Selamat datang, {{ auth()->user()->name }}! 👋
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300">
                                Anda memiliki <strong class="text-blue-600 dark:text-blue-400">{{ $activeBorrowings->count() }} buku</strong> yang sedang dipinjam 
                                @if($unpaidFines->isNotEmpty())
                                    dan <strong class="text-orange-600 dark:text-orange-400">{{ $unpaidFines->count() }} pelanggaran</strong> yang menunggu tindakan.
                                @else
                                    dan tidak ada pelanggaran. ✓
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('books.available') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-sm hover:shadow-md whitespace-nowrap">
                            📚 Lihat Buku Tersedia
                        </a>
                    </div>
                </div>
            </div>

            <!-- Unpaid Fines Alert -->
            @if($unpaidFines->isNotEmpty())
                <div class="mb-8 bg-orange-50 dark:bg-orange-900/20 border-l-4 border-orange-500 rounded-lg p-4">
                    <p class="text-sm font-medium text-orange-700 dark:text-orange-300">
                        ⚠️ Anda memiliki <strong>{{ $unpaidFines->count() }} pelanggaran</strong> yang menunggu tindakan. Silakan lihat detail di bawah.
                    </p>
                </div>
            @endif

            <!-- Two Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Active Borrowings -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                            <span>📚</span> Buku Yang Sedang Dipinjam
                        </h3>
                    </div>
                    <div>
                        @forelse($activeBorrowings as $borrowing)
                            <a href="{{ route('borrowings.show', $borrowing) }}" class="block p-5 border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                                        <span class="text-white text-sm font-bold">📖</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                            {{ $borrowing->book->title }}
                                        </h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $borrowing->book->author }}</p>
                                        <div class="mt-2 flex items-center justify-between text-xs">
                                            <span class="text-gray-500 dark:text-gray-400">
                                                @if($borrowing->isOverdue())
                                                    <span class="text-red-600 dark:text-red-400 font-semibold">⚠️ TERLAMBAT</span>
                                                @else
                                                    Jatuh tempo: {{ $borrowing->due_date?->format('d M Y') ?? '-' }}
                                                @endif
                                            </span>
                                            <span class="text-blue-600 dark:text-blue-400 font-medium">Lihat →</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="p-8 text-center">
                                <div class="text-4xl mb-3">📖</div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Tidak ada buku yang dipinjam</p>
                                <a href="{{ route('borrowings.create') }}" class="inline-block text-blue-600 dark:text-blue-400 hover:underline text-sm mt-3 font-medium">
                                    Pinjam buku sekarang →
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Unpaid Violations -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                            <span>⧗</span> Pelanggaran Menunggu Tindakan
                        </h3>
                    </div>
                    <div>
                        @forelse($unpaidFines as $fine)
                            <a href="{{ route('fines.show', $fine) }}" class="block p-5 border-b border-gray-100 dark:border-gray-700 hover:bg-orange-50 dark:hover:bg-orange-900/10 transition">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-gradient-to-br from-orange-400 to-red-600 flex items-center justify-center">
                                        <span class="text-white text-sm font-bold">⚠</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                            {{ $fine->borrowing->book->title }}
                                        </h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-1">
                                            {{ $fine->description ?? 'Tidak ada deskripsi' }}
                                        </p>
                                        <div class="mt-2 flex items-center justify-between">
                                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 text-xs font-semibold rounded-full">
                                                <span class="w-2 h-2 bg-orange-600 rounded-full"></span>
                                                Menunggu
                                            </span>
                                            <span class="text-blue-600 dark:text-blue-400 font-medium text-xs">Lihat →</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="p-8 text-center">
                                <div class="text-4xl mb-3">✓</div>
                                <p class="text-sm font-medium text-green-600 dark:text-green-400">Tidak ada pelanggaran</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Sempurna! Anda sudah mengatasi semua pelanggaran.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Borrowing History -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900/20 dark:to-gray-800/20 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <span>📖</span> Riwayat Peminjaman
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-900 sticky top-0">
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Buku</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Tanggal Pinjam</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Tanggal Kembali</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($pastBorrowings as $borrowing)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $borrowing->book->title }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        {{ $borrowing->borrowed_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        {{ $borrowing->returned_at?->format('d M Y') ?? '—' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="inline-flex items-center gap-2 px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-semibold rounded-full border border-green-200 dark:border-green-700">
                                            <span class="w-2 h-2 bg-green-600 rounded-full"></span>
                                            Dikembalikan
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-center">
                                        <a href="{{ route('borrowings.show', $borrowing) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-full hover:bg-blue-100 dark:hover:bg-blue-900/30 text-blue-600 dark:text-blue-400 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-sm text-gray-500 dark:text-gray-400 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <span class="text-2xl">📖</span>
                                            <span>Tidak ada riwayat peminjaman</span>
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
