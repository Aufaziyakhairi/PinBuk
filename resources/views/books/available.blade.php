<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('📚 Daftar Buku Tersedia') }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                ← Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter & Search -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('books.available') }}" class="flex gap-4 flex-wrap">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari judul atau penulis..." 
                               class="flex-1 min-w-64 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <select name="category" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>
                                    {{ $cat ?? 'Tanpa Kategori' }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition">
                            🔍 Cari
                        </button>
                        <a href="{{ route('books.available') }}" class="px-6 py-2 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-900 dark:text-white font-bold rounded-lg transition">
                            Reset
                        </a>
                    </form>
                </div>
            </div>

            <!-- Books Grid or Table -->
            @if($books->isEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-12 text-center">
                    <p class="text-lg text-gray-500 dark:text-gray-400 mb-4">Tidak ada buku yang tersedia</p>
                    <a href="{{ route('dashboard') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                        Kembali ke Dashboard
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($books as $book)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition">
                            <!-- Card Header with Status -->
                            <div class="p-4 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="flex-1">
                                        <h3 class="text-sm font-bold text-gray-900 dark:text-white line-clamp-2">
                                            {{ $book->title }}
                                        </h3>
                                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                            {{ $book->author }}
                                        </p>
                                    </div>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-semibold rounded-full flex-shrink-0">
                                        <span class="w-2 h-2 bg-green-600 rounded-full"></span>
                                        Siap
                                    </span>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-4 space-y-3">
                                <!-- Category -->
                                @if($book->category)
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold">KATEGORI</p>
                                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $book->category }}</p>
                                    </div>
                                @endif

                                <!-- ISBN -->
                                @if($book->isbn)
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold">ISBN</p>
                                        <p class="text-sm text-gray-700 dark:text-gray-300 font-mono">{{ $book->isbn }}</p>
                                    </div>
                                @endif

                                <!-- Stock Info -->
                                <div class="pt-2 border-t border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center justify-between mb-2">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold">KETERSEDIAAN</p>
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">
                                            {{ $book->available_quantity }}/{{ $book->quantity }}
                                        </span>
                                    </div>
                                    <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-green-400 to-green-600"
                                             style="width: {{ ($book->available_quantity / $book->quantity) * 100 }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Footer with Action -->
                            <div class="p-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700">
                                <button onclick="borrowBook({{ $book->id }}, '{{ addslashes($book->title) }}')"
                                        class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition">
                                    📖 Pinjam Buku
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($books->hasPages())
                    <div class="mt-8">
                        {{ $books->links() }}
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
