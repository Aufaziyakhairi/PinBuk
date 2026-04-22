<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel Persetujuan Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if($pendingBorrowings->isEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8 text-center">
                    <p class="text-lg text-gray-500 dark:text-gray-400 mb-4">✓ Tidak ada permintaan peminjaman yang menunggu persetujuan</p>
                    <a href="{{ route('borrowings.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                        Kembali ke Daftar Peminjaman
                    </a>
                </div>
            @else
                <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 rounded-lg p-4 mb-6">
                    <p class="text-sm font-medium text-blue-700 dark:text-blue-300">
                        📋 Ada <strong>{{ $pendingBorrowings->count() }}</strong> permintaan peminjaman yang menunggu persetujuan
                    </p>
                </div>

                <div class="grid gap-6">
                    @foreach($pendingBorrowings as $borrowing)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-yellow-500">
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <!-- Book Info -->
                                    <div>
                                        <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">📚 Buku</h3>
                                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $borrowing->book->title }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">oleh {{ $borrowing->book->author }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Stok tersedia: <span class="font-semibold">{{ $borrowing->book->available_quantity }}/{{ $borrowing->book->quantity }}</span></p>
                                        </div>
                                    </div>

                                    <!-- Borrower Info -->
                                    <div>
                                        <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">👤 Peminjam</h3>
                                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                            <div class="flex items-center gap-3 mb-3">
                                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center flex-shrink-0">
                                                    <span class="text-white font-bold text-sm">{{ strtoupper(substr($borrowing->user->name, 0, 1)) }}</span>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $borrowing->user->name }}</p>
                                                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ $borrowing->user->email }}</p>
                                                </div>
                                            </div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Permintaan pada: <span class="font-semibold">{{ $borrowing->created_at->format('d M Y H:i') }}</span></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Approval/Rejection Form -->
                                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Pilih aksi:</p>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <!-- Approve Form -->
                                        <form method="POST" action="{{ route('borrowings.update', $borrowing) }}" class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border-l-4 border-green-500">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="approved">
                                            
                                            <label for="due_date_{{ $borrowing->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Atur Jatuh Tempo:
                                            </label>
                                            <input type="date" 
                                                   name="due_date" 
                                                   id="due_date_{{ $borrowing->id }}"
                                                   class="w-full px-3 py-2 border border-green-300 dark:border-green-600 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white mb-3"
                                                   value="{{ now()->addDays(7)->format('Y-m-d') }}"
                                                   min="{{ now()->format('Y-m-d') }}"
                                                   required>
                                            
                                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                                                ✓ Setujui & Tetapkan Jatuh Tempo
                                            </button>
                                        </form>

                                        <!-- Reject Form -->
                                        <form method="POST" action="{{ route('borrowings.update', $borrowing) }}" class="bg-red-50 dark:bg-red-900/20 rounded-lg p-4 border-l-4 border-red-500" onsubmit="return confirm('Yakin ingin menolak permintaan ini?')">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="rejected">
                                            
                                            <p class="text-sm text-gray-700 dark:text-gray-300 mb-3">Tolak permintaan peminjaman</p>
                                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                                                ✗ Tolak Permintaan
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
