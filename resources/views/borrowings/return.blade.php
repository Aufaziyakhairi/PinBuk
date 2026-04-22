<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kembalikan Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-6">
                    <!-- Book Info -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 rounded-lg p-4">
                        <p class="text-sm font-medium text-blue-700 dark:text-blue-300">
                            📚 {{ $borrowing->book->title }}
                        </p>
                    </div>

                    <!-- Borrowing Details -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mb-1">TANGGAL PINJAM</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $borrowing->borrowed_at?->format('d M Y') ?? '-' }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mb-1">JATUH TEMPO</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white @if($borrowing->isOverdue()) text-red-600 dark:text-red-400 @endif">{{ $borrowing->due_date?->format('d M Y') ?? '-' }}</p>
                            @if($borrowing->isOverdue())
                                <p class="text-xs text-red-600 dark:text-red-400 mt-1">⚠ TERLAMBAT {{ $borrowing->getDaysLate() }} hari</p>
                            @endif
                        </div>
                    </div>

                    <!-- Return Form -->
                    <form method="POST" action="{{ route('borrowings.update', $borrowing) }}" class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="returned">

                        <div class="mb-6">
                            <label for="returned_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tanggal Pengembalian
                            </label>
                            <input type="date" 
                                   name="returned_at" 
                                   id="returned_at"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('returned_at') border-red-500 @enderror"
                                   value="{{ now()->format('Y-m-d') }}"
                                   required>
                            @error('returned_at')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Warning if late -->
                        @if($borrowing->isOverdue())
                            <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-lg p-4 mb-6">
                                <p class="text-sm font-medium text-red-700 dark:text-red-300">
                                    ⚠️ Buku ini <strong>{{ $borrowing->getDaysLate() }} hari</strong> terlambat. Admin akan membuatkan pelanggaran setelah pengembalian.
                                </p>
                            </div>
                        @endif

                        <!-- Buttons -->
                        <div class="flex items-center gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <button type="submit" 
                                    class="flex-1 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-semibold py-3 px-4 rounded-lg transition shadow-sm hover:shadow-md"
                                    onclick="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?')">
                                ✓ Kembalikan Buku
                            </button>
                            <a href="{{ route('borrowings.show', $borrowing) }}" class="flex-1 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-900 dark:text-white font-semibold py-3 px-4 rounded-lg transition text-center">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
