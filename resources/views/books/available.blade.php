<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white">
                    📚 Koleksi Buku Tersedia
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Papan Informasi Buku - Jelajahi dan Pinjam Buku
                </p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-white rounded-lg font-semibold text-sm transition">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Info Card -->
            <div class="bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 rounded-xl border border-blue-200 dark:border-blue-700 p-5">
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    🎓 <strong>Total Buku Tersedia:</strong> <span class="font-bold text-blue-600 dark:text-blue-400">{{ $books->total() }}</span> |
                    <strong>Kategori:</strong> <span class="font-bold text-blue-600 dark:text-blue-400">{{ $categories->count() }}</span>
                </p>
            </div>

            <!-- Filter & Search -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span>🔍</span> Pencarian & Filter
                    </h3>
                    <form method="GET" action="{{ route('books.available') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-2">CARI JUDUL / PENULIS</label>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Masukkan judul atau nama penulis..." 
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-2">KATEGORI</label>
                            <select name="category" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>
                                        {{ $cat ?? 'Tanpa Kategori' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex gap-2 items-end">
                            <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition flex items-center justify-center gap-2">
                                <span>🔍</span> Cari
                            </button>
                            <a href="{{ route('books.available') }}" class="px-4 py-2.5 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-900 dark:text-white font-bold rounded-lg transition">
                                ↻
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Books Grid -->
            @if($books->isEmpty())
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
                    <div class="text-5xl mb-4">📭</div>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Tidak ada buku yang tersedia</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                        Coba ubah filter pencarian atau kembali ke dashboard
                    </p>
                    <div class="flex gap-3 justify-center">
                        <a href="{{ route('books.available') }}" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition">
                            🔄 Coba Lagi
                        </a>
                        <a href="{{ route('dashboard') }}" class="px-6 py-2.5 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-900 dark:text-white font-bold rounded-lg transition">
                            ← Dashboard
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($books as $book)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-all">
                            <!-- Card Header with Gradient -->
                            <div class="p-5 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-start justify-between gap-3 mb-3">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm font-bold text-gray-900 dark:text-white line-clamp-2">
                                            {{ $book->title }}
                                        </h3>
                                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1.5 line-clamp-1">
                                            ✍️ {{ $book->author ?? 'Penulis tidak diketahui' }}
                                        </p>
                                    </div>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-bold rounded-lg flex-shrink-0 whitespace-nowrap">
                                        <span class="w-2 h-2 bg-green-600 rounded-full"></span>
                                        Siap Pinjam
                                    </span>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-5 space-y-4">
                                <!-- Ketersediaan -->
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <p class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider">📊 Ketersediaan</p>
                                        <span class="text-sm font-bold text-gray-900 dark:text-white bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-2.5 py-1 rounded-full">
                                            {{ $book->available_quantity }}/{{ $book->quantity }}
                                        </span>
                                    </div>
                                    <div class="h-2.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                        @php
                                            $percentage = ($book->available_quantity / $book->quantity) * 100;
                                        @endphp
                                        <div class="h-full bg-gradient-to-r from-green-400 to-green-600 transition-all"
                                             style="width: {{ $percentage }}%">
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">
                                        {{ round($percentage, 0) }}% tersedia ({{ $book->quantity - $book->available_quantity }} dipinjam)
                                    </p>
                                </div>

                                <!-- Category -->
                                @if($book->category)
                                    <div class="pt-2 border-t border-gray-100 dark:border-gray-700">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-bold mb-1">🏷️ KATEGORI</p>
                                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $book->category }}</p>
                                    </div>
                                @endif

                                <!-- ISBN -->
                                @if($book->isbn)
                                    <div class="pt-2 border-t border-gray-100 dark:border-gray-700">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-bold mb-1">📖 ISBN</p>
                                        <p class="text-sm text-gray-700 dark:text-gray-300 font-mono">{{ $book->isbn }}</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Card Footer -->
                            <div class="p-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700">
                                <button onclick="borrowBook({{ $book->id }}, '{{ addslashes($book->title) }}')"
                                        {{ $book->available_quantity <= 0 ? 'disabled' : '' }}
                                        class="w-full px-4 py-2.5 {{ $book->available_quantity > 0 ? 'bg-blue-600 hover:bg-blue-700 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 cursor-not-allowed' }} font-bold rounded-lg transition">
                                    {{ $book->available_quantity > 0 ? '📚 Pinjam Sekarang' : '❌ Stok Habis' }}
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($books->hasPages())
                    <div class="mt-8 flex justify-center">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                            {{ $books->links() }}
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- Quick Borrow Modal/Script -->
    <script>
        function borrowBook(bookId, bookTitle) {
            // Create a hidden form and submit to create borrowing
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('borrowings.store') }}';
            
            form.innerHTML = `
                @csrf
                <input type="hidden" name="book_id" value="${bookId}">
            `;
            
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</x-app-layout>
