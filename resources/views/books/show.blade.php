<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $book->title }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('books.edit', $book) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Ubah
                </a>
                <a href="{{ route('books.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Book Details -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Penulis</h3>
                            <p class="text-gray-900 dark:text-white">{{ $book->author }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">ISBN</h3>
                            <p class="text-gray-900 dark:text-white">{{ $book->isbn ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Penerbit</h3>
                            <p class="text-gray-900 dark:text-white">{{ $book->publisher ?? '-' }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Tahun Terbit</h3>
                            <p class="text-gray-900 dark:text-white">{{ $book->publication_year ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Kategori</h3>
                            <p class="text-gray-900 dark:text-white">{{ $book->category ?? '-' }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Lokasi</h3>
                            <p class="text-gray-900 dark:text-white">{{ $book->location ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-6 mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Stok</h3>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $book->quantity }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Tersedia</h3>
                            <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $book->available_quantity }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Dipinjam</h3>
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $book->quantity - $book->available_quantity }}</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Status</h3>
                        @if($book->status === 'ready')
                            <span class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full">
                                Siap
                            </span>
                        @else
                            <span class="px-3 py-1 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-full">
                                Tidak Siap
                            </span>
                        @endif
                    </div>

                    @if($book->description)
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Deskripsi</h3>
                            <p class="text-gray-900 dark:text-white whitespace-pre-wrap">{{ $book->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Borrowing History -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Riwayat Peminjaman
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Peminjam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tanggal Pinjam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Jatuh Tempo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($borrowings as $borrowing)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        {{ $borrowing->user->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $borrowing->borrowed_at?->format('d-m-Y') ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $borrowing->due_date?->format('d-m-Y') ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if($borrowing->status === 'approved')
                                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs rounded">
                                                Dipinjam
                                            </span>
                                        @else
                                            <span class="px-2 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs rounded">
                                                Dikembalikan ({{ $borrowing->returned_at?->format('d-m-Y') ?? '-' }})
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        Belum ada riwayat peminjaman
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($borrowings->hasPages())
                    <div class="p-4">
                        {{ $borrowings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
