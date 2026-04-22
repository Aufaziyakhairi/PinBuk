<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Denda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($overdueBorrowings->isEmpty())
                        <div class="text-center py-12">
                            <p class="text-lg text-gray-500 dark:text-gray-400 mb-4">Tidak ada peminjaman yang terlambat dan belum memiliki denda</p>
                            <a href="{{ route('borrowings.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                                Kembali ke Peminjaman
                            </a>
                        </div>
                    @else
                        <form method="POST" action="{{ route('fines.store') }}" class="space-y-6">
                            @csrf

                            <!-- Borrowing Selection -->
                            <div>
                                <label for="borrowing_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Pilih Peminjaman Terlambat
                                </label>
                                <select name="borrowing_id" id="borrowing_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('borrowing_id') border-red-500 @enderror" required onchange="updateBorrowingInfo()">
                                    <option value="">-- Pilih Peminjaman --</option>
                                    @foreach($overdueBorrowings as $borrowing)
                                        <option value="{{ $borrowing->id }}" data-user="{{ $borrowing->user->name }}" data-book="{{ $borrowing->book->title }}" data-due="{{ $borrowing->due_date?->format('d M Y') ?? '-' }}" data-returned="{{ $borrowing->returned_at?->format('d M Y') ?? '-' }}">
                                            {{ $borrowing->user->name }} - {{ $borrowing->book->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('borrowing_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Borrowing Details (Read-only) -->
                            <div id="borrowingDetails" class="hidden space-y-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Peminjam</p>
                                        <p id="borrowerName" class="font-medium text-gray-900 dark:text-white"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Buku</p>
                                        <p id="bookTitle" class="font-medium text-gray-900 dark:text-white"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Jatuh Tempo</p>
                                        <p id="dueDate" class="font-medium text-gray-900 dark:text-white"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Tanggal Pengembalian</p>
                                        <p id="returnedDate" class="font-medium text-gray-900 dark:text-white"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Fine Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Deskripsi Denda
                                </label>
                                <textarea name="description" id="description" rows="6" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('description') border-red-500 @enderror" required placeholder="Misalnya: Keterlambatan pengembalian 5 hari, atau alasan lainnya...">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Maksimal 1000 karakter</p>
                            </div>

                            <!-- Buttons -->
                            <div class="flex items-center gap-3">
                                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition font-medium">
                                    Buat Denda
                                </button>
                                <a href="{{ route('fines.index') }}" class="px-6 py-2 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-900 dark:text-white rounded-lg transition font-medium">
                                    Batal
                                </a>
                            </div>
                        </form>

                        <script>
                            function updateBorrowingInfo() {
                                const select = document.getElementById('borrowing_id');
                                const selectedOption = select.options[select.selectedIndex];
                                const details = document.getElementById('borrowingDetails');

                                if (select.value === '') {
                                    details.classList.add('hidden');
                                    return;
                                }

                                document.getElementById('borrowerName').textContent = selectedOption.dataset.user;
                                document.getElementById('bookTitle').textContent = selectedOption.dataset.book;
                                document.getElementById('dueDate').textContent = selectedOption.dataset.due;
                                document.getElementById('returnedDate').textContent = selectedOption.dataset.returned;

                                details.classList.remove('hidden');
                            }
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
