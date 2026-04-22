<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white">
                    ⚙️ Edit Peminjaman Buku
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Kelola durasi dan status peminjaman
                </p>
            </div>
            <a href="{{ route('borrowings.show', $borrowing) }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-white rounded-lg font-semibold transition">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Book & Borrower Information Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-8 py-6 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white uppercase tracking-widest flex items-center gap-2">
                        <span class="text-2xl">📚</span> Informasi Peminjaman
                    </h3>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Book Information -->
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-900/10 rounded-lg p-6 border border-purple-200 dark:border-purple-700">
                            <p class="text-xs font-bold text-purple-700 dark:text-purple-400 uppercase tracking-wider mb-3">📖 Judul Buku</p>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-3">{{ $borrowing->book->title }}</h4>
                            <div class="space-y-2 text-sm">
                                <p><span class="font-semibold text-gray-700 dark:text-gray-300">Penulis:</span> <span class="text-gray-600 dark:text-gray-400">{{ $borrowing->book->author ?? 'Tidak diketahui' }}</span></p>
                                <p><span class="font-semibold text-gray-700 dark:text-gray-300">ISBN:</span> <span class="text-gray-600 dark:text-gray-400">{{ $borrowing->book->isbn ?? '-' }}</span></p>
                                <p><span class="font-semibold text-gray-700 dark:text-gray-300">Kategori:</span> <span class="text-gray-600 dark:text-gray-400">{{ $borrowing->book->category ?? '-' }}</span></p>
                            </div>
                        </div>

                        <!-- Borrower Information -->
                        <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-900/10 rounded-lg p-6 border border-green-200 dark:border-green-700">
                            <p class="text-xs font-bold text-green-700 dark:text-green-400 uppercase tracking-wider mb-3">👤 Data Peminjam</p>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-3">{{ $borrowing->user->name }}</h4>
                            <div class="space-y-2 text-sm">
                                <p><span class="font-semibold text-gray-700 dark:text-gray-300">Email:</span> <span class="text-gray-600 dark:text-gray-400">{{ $borrowing->user->email }}</span></p>
                                <p><span class="font-semibold text-gray-700 dark:text-gray-300">Role:</span> <span class="text-gray-600 dark:text-gray-400">{{ ucfirst($borrowing->user->role) }}</span></p>
                                <p><span class="font-semibold text-gray-700 dark:text-gray-300">ID Peminjaman:</span> <span class="text-gray-600 dark:text-gray-400">#{{ $borrowing->id }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline Information -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-8 py-6 bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white uppercase tracking-widest flex items-center gap-2">
                        <span class="text-2xl">📅</span> Timeline Peminjaman
                    </h3>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Start Date -->
                        <div class="relative">
                            <div class="absolute left-0 top-0 w-1 h-full bg-gradient-to-b from-blue-500 to-cyan-500 rounded"></div>
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6 pl-6 border border-blue-200 dark:border-blue-700">
                                <p class="text-xs font-bold text-blue-700 dark:text-blue-400 uppercase tracking-wider mb-2">📍 Tanggal Mulai</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $borrowing->borrowed_at?->format('d M Y') ?? 'Belum dimulai' }}</p>
                                @if($borrowing->borrowed_at)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $borrowing->borrowed_at->format('H:i') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Duration -->
                        <div class="relative">
                            <div class="absolute left-0 top-0 w-1 h-full bg-gradient-to-b from-purple-500 to-pink-500 rounded"></div>
                            <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-6 pl-6 border border-purple-200 dark:border-purple-700">
                                <p class="text-xs font-bold text-purple-700 dark:text-purple-400 uppercase tracking-wider mb-2">⏱️ Durasi</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                    @if($borrowing->due_date && $borrowing->borrowed_at)
                                        {{ $borrowing->borrowed_at->diffInDays($borrowing->due_date) }} hari
                                    @else
                                        -
                                    @endif
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Max: 14 hari</p>
                            </div>
                        </div>

                        <!-- Due Date -->
                        <div class="relative">
                            <div class="absolute left-0 top-0 w-1 h-full bg-gradient-to-b from-red-500 to-orange-500 rounded"></div>
                            <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-6 pl-6 border border-red-200 dark:border-red-700">
                                <p class="text-xs font-bold text-red-700 dark:text-red-400 uppercase tracking-wider mb-2">🏁 Jatuh Tempo</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $borrowing->due_date?->format('d M Y') ?? 'Belum ditentukan' }}</p>
                                @if($borrowing->due_date)
                                    <p class="text-sm font-semibold mt-2 {{ $borrowing->isOverdue() ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                        {{ $borrowing->isOverdue() ? '⚠️ Terlambat ' . $borrowing->getDaysLate() . ' hari' : '✓ On track' }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <form method="POST" action="{{ route('borrowings.update', $borrowing) }}" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                @csrf
                @method('PUT')

                <div class="px-8 py-6 bg-gradient-to-r from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/20 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white uppercase tracking-widest flex items-center gap-2">
                        <span class="text-2xl">✏️</span> Ubah Status & Durasi
                    </h3>
                </div>

                <div class="p-8 space-y-6">
                    <!-- Status Selection -->
                    <div>
                        <label for="status" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3 uppercase tracking-wider">
                            📋 Status Peminjaman
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all {{ old('status', $borrowing->status) === 'approved' ? 'border-green-500 bg-green-50 dark:bg-green-900/20' : 'border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700' }}">
                                <input type="radio" name="status" value="approved" {{ old('status', $borrowing->status) === 'approved' ? 'checked' : '' }} class="w-5 h-5 text-green-600">
                                <div class="ml-4">
                                    <p class="font-semibold text-gray-900 dark:text-white">📖 Sedang Dipinjam</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Peminjaman masih berjalan</p>
                                </div>
                            </label>

                            <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all {{ old('status', $borrowing->status) === 'returned' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700' }}">
                                <input type="radio" name="status" value="returned" {{ old('status', $borrowing->status) === 'returned' ? 'checked' : '' }} class="w-5 h-5 text-blue-600">
                                <div class="ml-4">
                                    <p class="font-semibold text-gray-900 dark:text-white">✓ Dikembalikan</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Buku sudah dikembalikan</p>
                                </div>
                            </label>
                        </div>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Info Box -->
                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/10 rounded-lg p-6 border-l-4 border-amber-500">
                        <p class="text-sm text-amber-900 dark:text-amber-300">
                            <span class="font-bold">💡 Catatan:</span> Durasi maksimal peminjaman adalah <strong>14 hari</strong>. Setiap hari keterlambatan akan dikenakan denda sebesar Rp 5.000.
                        </p>
                    </div>
                </div>

                <!-- Form Buttons -->
                <div class="px-8 py-6 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-4">
                    <a href="{{ route('borrowings.show', $borrowing) }}" class="px-6 py-3 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-800 dark:text-white font-semibold rounded-lg transition shadow-sm">
                        ← Batal
                    </a>
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white font-bold rounded-lg transition shadow-md hover:shadow-lg transform hover:scale-105">
                        ✓ Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
