<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white">
                    � Dashboard Peminjam
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Papan Informasi Buku - Kelola Peminjaman & Pelanggaran Anda
                </p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    {{ now()->format('l, d M Y') }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Welcome Banner & Quick Stats -->
            <div class="space-y-6">
                <!-- Welcome Banner -->
                <div class="bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/30 dark:to-cyan-900/30 rounded-xl border border-blue-200 dark:border-blue-700 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">
                                Selamat datang kembali, {{ auth()->user()->name }}! 👋
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Berikut adalah ringkasan aktivitas peminjaman buku Anda
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Active Borrowings Count -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 hover:shadow-md transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Buku Sedang Dipinjam</p>
                                <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $activeBorrowings->count() }}</p>
                            </div>
                            <div class="text-4xl">📖</div>
                        </div>
                    </div>

                    <!-- Violations Count -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 hover:shadow-md transition {{ $unpaidFines->isNotEmpty() ? 'ring-1 ring-orange-200 dark:ring-orange-700/30' : '' }}">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Pelanggaran Menunggu</p>
                                <p class="text-3xl font-bold {{ $unpaidFines->isNotEmpty() ? 'text-orange-600 dark:text-orange-400' : 'text-green-600 dark:text-green-400' }}">
                                    {{ $unpaidFines->count() }}
                                </p>
                            </div>
                            <div class="text-4xl">{{ $unpaidFines->isNotEmpty() ? '⚠️' : '✅' }}</div>
                        </div>
                    </div>

                    <!-- Available Books -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 hover:shadow-md transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Aksi Cepat</p>
                                <a href="{{ route('books.available') }}" class="inline-block text-green-600 dark:text-green-400 hover:underline font-semibold text-sm mt-2">
                                    Lihat Buku Tersedia →
                                </a>
                            </div>
                            <div class="text-4xl">📚</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content - Two Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Active Borrowings Section -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-5 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                            <span class="text-lg">📚</span> Buku Sedang Dipinjam
                        </h3>
                        <span class="text-xs font-bold text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-900/30 px-3 py-1 rounded-full">
                            {{ $activeBorrowings->count() }} buku
                        </span>
                    </div>
                    <div>
                        @forelse($activeBorrowings as $borrowing)
                            <a href="{{ route('borrowings.show', $borrowing) }}" class="block p-5 border-b border-gray-100 dark:border-gray-700 hover:bg-blue-50 dark:hover:bg-blue-900/10 transition">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-bold">
                                        📖
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                            {{ $borrowing->book->title }}
                                        </h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $borrowing->book->author ?? 'Penulis tidak diketahui' }}</p>
                                        <div class="mt-3 flex items-center justify-between text-xs">
                                            @if($borrowing->isOverdue())
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 font-bold rounded-full">
                                                    <span class="w-1.5 h-1.5 bg-red-600 rounded-full animate-pulse"></span>
                                                    TERLAMBAT
                                                </span>
                                            @else
                                                <span class="text-gray-600 dark:text-gray-400">
                                                    📅 Jatuh tempo: <strong>{{ $borrowing->due_date?->format('d M Y') ?? '-' }}</strong>
                                                </span>
                                            @endif
                                            <span class="text-blue-600 dark:text-blue-400 font-bold">Lihat →</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="p-8 text-center">
                                <div class="text-5xl mb-3">📖</div>
                                <p class="text-sm font-semibold text-gray-600 dark:text-gray-400">Tidak ada buku yang dipinjam</p>
                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">Mulai pinjam buku untuk memperluas wawasan Anda</p>
                                <a href="{{ route('borrowings.create') }}" class="inline-block text-blue-600 dark:text-blue-400 hover:underline text-sm mt-3 font-bold">
                                    Pinjam Buku Sekarang →
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Violations Section -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border {{ $unpaidFines->isNotEmpty() ? 'border-orange-300 dark:border-orange-700' : 'border-gray-200 dark:border-gray-700' }} overflow-hidden {{ $unpaidFines->isNotEmpty() ? 'ring-1 ring-orange-100 dark:ring-orange-900/30' : '' }}">
                    <div class="px-6 py-5 {{ $unpaidFines->isNotEmpty() ? 'bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20' : 'bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20' }} border-b {{ $unpaidFines->isNotEmpty() ? 'border-orange-200 dark:border-orange-700' : 'border-green-200 dark:border-green-700' }} flex items-center justify-between">
                        <h3 class="text-sm font-semibold {{ $unpaidFines->isNotEmpty() ? 'text-orange-900 dark:text-orange-200' : 'text-green-900 dark:text-green-200' }} uppercase tracking-wider flex items-center gap-2">
                            <span class="text-lg">{{ $unpaidFines->isNotEmpty() ? '⚠️' : '✅' }}</span> Pelanggaran
                        </h3>
                        <span class="text-xs font-bold {{ $unpaidFines->isNotEmpty() ? 'text-orange-600 dark:text-orange-400 bg-orange-100 dark:bg-orange-900/30' : 'text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900/30' }} px-3 py-1 rounded-full">
                            {{ $unpaidFines->count() }} {{ $unpaidFines->isNotEmpty() ? 'menunggu' : 'bersih' }}
                        </span>
                    </div>
                    <div>
                        @forelse($unpaidFines as $fine)
                            <a href="{{ route('fines.show', $fine) }}" class="block p-5 border-b border-gray-100 dark:border-gray-700 hover:bg-orange-50 dark:hover:bg-orange-900/10 transition">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-gradient-to-br from-orange-400 to-red-600 flex items-center justify-center text-white font-bold">
                                        ⚠
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                            {{ $fine->borrowing->book->title }}
                                        </h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 line-clamp-1">
                                            {{ $fine->description ?? 'Tidak ada deskripsi' }}
                                        </p>
                                        <div class="mt-3 flex items-center justify-between">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 text-xs font-bold rounded-full">
                                                <span class="w-1.5 h-1.5 bg-orange-600 rounded-full animate-pulse"></span>
                                                Menunggu Tindakan
                                            </span>
                                            <span class="text-blue-600 dark:text-blue-400 font-bold text-xs">Lihat →</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="p-8 text-center">
                                <div class="text-5xl mb-3">✨</div>
                                <p class="text-sm font-semibold text-green-600 dark:text-green-400">Tidak ada pelanggaran</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Sempurna! Anda sudah mematuhi semua aturan perpustakaan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Borrowing History Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-5 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <span class="text-lg">📖</span> Riwayat Peminjaman
                    </h3>
                    <span class="text-xs font-bold text-purple-600 dark:text-purple-400 bg-purple-100 dark:bg-purple-900/30 px-3 py-1 rounded-full">
                        {{ $pastBorrowings->count() }} riwayat
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-900 sticky top-0">
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Buku</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Tanggal Peminjaman</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Tanggal Pengembalian</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Durasi</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($pastBorrowings as $borrowing)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $borrowing->book->title }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $borrowing->book->author ?? '-' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        {{ $borrowing->borrowed_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        {{ $borrowing->returned_at?->format('d M Y') ?? '—' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-center">
                                        @if($borrowing->returned_at)
                                            <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">
                                                {{ $borrowing->returned_at->diffInDays($borrowing->borrowed_at) }} hari
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-500 dark:text-gray-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-center">
                                        <a href="{{ route('borrowings.show', $borrowing) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-full hover:bg-purple-100 dark:hover:bg-purple-900/30 text-purple-600 dark:text-purple-400 transition font-semibold">
                                            →
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <span class="text-4xl">📭</span>
                                            <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">Tidak ada riwayat peminjaman</span>
                                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">Anda belum pernah meminjam buku sebelumnya</p>
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
