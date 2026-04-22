<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white">
                    📋 Detail Pelanggaran
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Lihat informasi lengkap tentang pelanggaran pengguna
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <!-- Main Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                <!-- Header with gradient -->
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                            <span class="text-white font-bold text-lg">
                                {{ strtoupper(substr($fine->user->name, 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Peminjam
                            </h3>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $fine->user->name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $fine->user->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6 space-y-6">
                    <!-- Book Info Card -->
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                        <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Buku yang Dipinjam</h4>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $fine->borrowing->book->title }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">oleh {{ $fine->borrowing->book->author }}</p>
                    </div>

                    <!-- Violation Description -->
                    <div class="bg-orange-50 dark:bg-orange-900/20 border-l-4 border-orange-500 rounded-lg p-6">
                        <h4 class="text-xs font-semibold text-orange-700 dark:text-orange-300 uppercase tracking-wider mb-3">Keterangan Pelanggaran</h4>
                        <p class="text-base text-orange-900 dark:text-orange-100 leading-relaxed font-medium">
                            {{ $fine->description ?? 'Tidak ada keterangan' }}
                        </p>
                    </div>

                    <!-- Timeline -->
                    <div>
                        <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Timeline Peminjaman</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-base">📅</span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold">TANGGAL PINJAM</p>
                                </div>
                                <p class="text-gray-900 dark:text-white font-bold">{{ $fine->borrowing->borrowed_at?->format('d M Y') ?? '-' }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-base">⏰</span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold">JATUH TEMPO</p>
                                </div>
                                <p class="text-gray-900 dark:text-white font-bold">{{ $fine->borrowing->due_date?->format('d M Y') ?? '-' }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-base">✓</span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold">DIKEMBALIKAN</p>
                                </div>
                                <p class="text-gray-900 dark:text-white font-bold">
                                    @if($fine->borrowing->returned_at)
                                        {{ $fine->borrowing->returned_at->format('d M Y') }}
                                    @else
                                        <span class="text-orange-600 dark:text-orange-400">Belum dikembalikan</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div>
                        <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Status Saat Ini</h4>
                        @if($fine->isPaid())
                            <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 rounded-lg p-4 flex items-center gap-3">
                                <span class="text-2xl">✓</span>
                                <div>
                                    <p class="font-semibold text-green-700 dark:text-green-300">Terselesaikan</p>
                                    <p class="text-xs text-green-600 dark:text-green-400">Pelanggaran telah ditandai sebagai selesai</p>
                                </div>
                            </div>
                        @else
                            <div class="bg-orange-50 dark:bg-orange-900/20 border-l-4 border-orange-500 rounded-lg p-4 flex items-center gap-3">
                                <span class="text-2xl">⧗</span>
                                <div>
                                    <p class="font-semibold text-orange-700 dark:text-orange-300">Menunggu Tindakan</p>
                                    <p class="text-xs text-orange-600 dark:text-orange-400">Pelanggaran masih perlu ditindaklanjuti</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Admin Action Section -->
            @if(!$fine->isPaid() && auth()->user()->isAdmin())
                <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 rounded-lg p-4 mb-6">
                    <p class="text-sm font-medium text-blue-700 dark:text-blue-300">
                        👤 Sebagai admin, Anda dapat menandai pelanggaran ini sebagai terselesaikan
                    </p>
                </div>

                <form method="POST" action="{{ route('fines.mark-paid', $fine) }}" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6" data-confirm="Tandai pelanggaran ini sebagai terselesaikan?">
                    @csrf
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-semibold py-3 px-4 rounded-lg transition shadow-sm hover:shadow-md">
                        ✓ Tandai Sebagai Terselesaikan
                    </button>
                </form>
            @endif

            <!-- Back Button -->
            <div class="flex gap-3">
                <a href="{{ route('fines.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-white rounded-lg transition font-medium">
                    ← Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
