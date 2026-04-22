<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pinjam Buku Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Info Box -->
            <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-lg">
                <p class="text-sm text-blue-700 dark:text-blue-200">
                    <strong>ℹ️ Informasi:</strong> Pilih buku dari tabel di bawah untuk membuat permintaan peminjaman. Admin akan memeriksanya dan menetapkan tanggal jatuh tempo. Periksa status permintaan Anda secara berkala.
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        📚 Daftar Buku Tersedia
                    </h3>
                </div>

                @forelse($books as $book)
                    @if($loop->first)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300">JUDUL BUKU</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300">PENGARANG</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300">KATEGORI</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300">PENERBIT</th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300">TERSEDIA</th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @endif

                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ $book->title }}</p>
                                            @if($book->description)
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-1">{{ $book->description }}</p>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $book->author }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        <span class="inline-block px-3 py-1 text-xs font-medium rounded-full bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300">
                                            {{ $book->category ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $book->publisher ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($book->available_quantity > 0)
                                            <div class="flex flex-col items-center">
                                                <span class="text-lg font-bold text-green-600 dark:text-green-400">{{ $book->available_quantity }}</span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">dari {{ $book->quantity }}</span>
                                            </div>
                                        @else
                                            <span class="text-sm font-semibold text-red-600 dark:text-red-400">Habis</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($book->available_quantity > 0)
                                            <form method="POST" action="{{ route('borrowings.store') }}" class="inline">
                                                @csrf
                                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-lg transition">
                                                    <span>📖</span>
                                                    Pinjam
                                                </button>
                                            </form>
                                        @else
                                            <button disabled class="inline-flex items-center gap-2 px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 font-medium text-sm rounded-lg cursor-not-allowed">
                                                Tidak Tersedia
                                            </button>
                                        @endif
                                    </td>
                                </tr>

                    @if($loop->last)
                            </tbody>
                        </table>
                    </div>
                    @endif
                @empty
                    <div class="p-12 text-center">
                        <p class="text-gray-500 dark:text-gray-400 text-lg">📚 Tidak ada buku yang tersedia saat ini</p>
                    </div>
                @endforelse
            </div>

            <!-- Back Button -->
            <div class="mt-6">
                <a href="{{ route('borrowings.index') }}" class="inline-flex items-center px-6 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
