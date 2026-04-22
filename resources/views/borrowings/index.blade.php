<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white">
                    📖 Manajemen Peminjaman Buku
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Papan Informasi Buku - Kelola Semua Transaksi Peminjaman
                </p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-white rounded-lg font-semibold text-sm transition">
                ← Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Admin Approval Panel -->
            @if(auth()->user()->isAdmin())
                @php
                    $pendingBorrowings = \App\Models\Borrowing::where('status', 'pending')->with(['user', 'book'])->latest()->get();
                @endphp
                
                @if($pendingBorrowings->isNotEmpty())
                    <!-- Alert Banner -->
                    <div class="bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/30 dark:to-orange-900/30 border-l-4 border-red-500 rounded-lg p-5 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="text-3xl">🔔</div>
                            <div>
                                <p class="text-sm font-bold text-red-700 dark:text-red-300 uppercase tracking-wider">Persetujuan Diperlukan</p>
                                <p class="text-red-600 dark:text-red-400 text-sm mt-1">
                                    Ada <strong class="text-lg">{{ $pendingBorrowings->count() }}</strong> permintaan peminjaman yang menunggu persetujuan Anda.
                                </p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full animate-pulse">
                            <span class="w-2 h-2 bg-white rounded-full"></span>
                            {{ $pendingBorrowings->count() }}
                        </span>
                    </div>

                    <!-- Approval Cards -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-5 bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                                <span class="text-lg">⏳</span> Permintaan Menunggu Persetujuan
                            </h3>
                        </div>
                        <div class="grid gap-4 p-6">
                            @foreach($pendingBorrowings as $borrowing)
                                <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg p-5 hover:shadow-md transition">
                                    <!-- Info Grid -->
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                        <div>
                                            <p class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-1">📚 Buku</p>
                                            <p class="font-semibold text-gray-900 dark:text-white">{{ $borrowing->book->title }}</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">✍️ {{ $borrowing->book->author ?? 'Penulis tidak diketahui' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-1">👤 Peminjam</p>
                                            <p class="font-semibold text-gray-900 dark:text-white">{{ $borrowing->user->name }}</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">{{ $borrowing->user->email }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-1">📅 Permintaan</p>
                                            <p class="font-semibold text-gray-900 dark:text-white">{{ $borrowing->created_at->format('d M Y') }}</p>
                                            <p class="text-xs text-orange-600 dark:text-orange-400 font-bold mt-0.5">{{ $borrowing->created_at->diffForHumans() }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-1">📊 Ketersediaan</p>
                                            <p class="font-semibold text-green-600 dark:text-green-400">{{ $borrowing->book->available_quantity }}/{{ $borrowing->book->quantity }} tersedia</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">{{ $borrowing->book->quantity - $borrowing->book->available_quantity }} sedang dipinjam</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="border-t border-gray-200 dark:border-gray-600 pt-4 flex gap-3">
                                        <form method="POST" action="{{ route('borrowings.update', $borrowing) }}" class="flex-1">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="approved">
                                            <input type="hidden" name="due_date" value="{{ now()->addDays(7)->format('Y-m-d') }}">
                                            <button type="submit" class="w-full px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-bold text-sm rounded-lg transition flex items-center justify-center gap-2">
                                                <span>✓</span> Setujui
                                            </button>
                                        </form>
                                        
                                        <a href="{{ route('borrowings.edit', $borrowing) }}" class="flex-1 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-lg transition text-center flex items-center justify-center gap-2">
                                            <span>⚙️</span> Edit
                                        </a>
                                        
                                        <form method="POST" action="{{ route('borrowings.update', $borrowing) }}" class="flex-1" onsubmit="return confirm('Yakin ingin menolak permintaan ini?')">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="w-full px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold text-sm rounded-lg transition flex items-center justify-center gap-2">
                                                <span>✗</span> Tolak
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-200 dark:border-green-700 rounded-xl p-5 flex items-center gap-4">
                        <div class="text-3xl">✅</div>
                        <div>
                            <p class="text-sm font-bold text-green-700 dark:text-green-300 uppercase tracking-wider">Semua Terproses</p>
                            <p class="text-green-600 dark:text-green-400 text-sm mt-1">Semua permintaan peminjaman telah diproses dengan baik.</p>
                        </div>
                    </div>
                @endif
            @endif

            <!-- Pending Borrowings (User) or Approval Panel (Admin) -->
            @if(auth()->user()->isUser())
                @php
                    $pendingBorrowings = $borrowings->where('status', 'pending');
                @endphp
                @if($pendingBorrowings->isNotEmpty())
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500 rounded-lg p-4">
                        <p class="text-sm font-medium text-yellow-700 dark:text-yellow-300">
                            ⏳ Anda memiliki <strong>{{ $pendingBorrowings->count() }}</strong> permintaan peminjaman yang menunggu persetujuan admin.
                        </p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="px-6 py-4 bg-yellow-50 dark:bg-yellow-900/20 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider">📋 Permintaan Menunggu Persetujuan</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Buku</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($pendingBorrowings as $borrowing)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white font-medium">
                                                {{ $borrowing->book->title }}
                                            </td>
                                            <td class="px-6 py-4 text-sm">
                                                <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 text-xs font-semibold rounded-full">
                                                    ⏳ Menunggu Persetujuan
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm">
                                                <a href="{{ route('borrowings.show', $borrowing) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                                    Lihat Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @endif

            <!-- Filter Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span>🔍</span> Pencarian & Filter
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <form method="GET" action="{{ route('borrowings.index') }}" class="md:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-2">STATUS</label>
                                <select name="status" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>⏳ Menunggu Persetujuan</option>
                                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>📖 Sedang Dipinjam</option>
                                    <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>✓ Dikembalikan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-2">PENCARIAN</label>
                                <input type="text" name="search" placeholder="Cari buku atau peminjam..." value="{{ request('search') }}" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <button type="submit" class="w-full px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition flex items-center justify-center gap-2">
                                    <span>🔍</span> Cari
                                </button>
                            </div>
                        </form>
                        
                        @if(auth()->user()->isUser())
                            <a href="{{ route('borrowings.create') }}" class="w-full md:w-auto px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg transition flex items-center justify-center gap-2">
                                <span>➕</span> Pinjam Buku
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Main Borrowings Table -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-5 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <span class="text-lg">📚</span> Daftar Peminjaman
                    </h3>
                    <span class="text-xs font-bold text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-900/30 px-3 py-1 rounded-full">
                        {{ $borrowings->count() }} item
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-900 sticky top-0">
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Buku</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Peminjam</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Tanggal Pinjam</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Jatuh Tempo</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($borrowings->where('status', '!=', 'rejected')->where('status', '!=', 'pending') as $borrowing)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ $borrowing->book->title }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $borrowing->book->author ?? '-' }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                                {{ substr($borrowing->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ $borrowing->user->name }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $borrowing->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        @if($borrowing->borrowed_at)
                                            {{ $borrowing->borrowed_at->format('d M Y') }}
                                        @else
                                            <span class="text-yellow-600 dark:text-yellow-400 font-semibold">⏳ Belum dimulai</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if($borrowing->due_date)
                                            <span class="font-semibold {{ $borrowing->isOverdue() && $borrowing->status === 'approved' ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-300' }}">
                                                {{ $borrowing->due_date->format('d M Y') }}
                                                @if($borrowing->isOverdue() && $borrowing->status === 'approved')
                                                    <span class="text-red-500 font-bold"> (TERLAMBAT)</span>
                                                @endif
                                            </span>
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($borrowing->status === 'pending')
                                            <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 text-xs font-bold rounded-lg border border-yellow-300 dark:border-yellow-700">
                                                <span class="w-1.5 h-1.5 bg-yellow-600 rounded-full animate-pulse"></span>
                                                MENUNGGU
                                            </span>
                                        @elseif($borrowing->status === 'approved')
                                            <span class="inline-flex items-center gap-1 px-3 py-1.5 {{ $borrowing->isOverdue() ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' : 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' }} text-xs font-bold rounded-lg {{ $borrowing->isOverdue() ? 'border border-red-300 dark:border-red-700' : 'border border-blue-300 dark:border-blue-700' }}">
                                                <span class="w-1.5 h-1.5 {{ $borrowing->isOverdue() ? 'bg-red-600' : 'bg-blue-600' }} rounded-full {{ $borrowing->isOverdue() ? 'animate-pulse' : '' }}"></span>
                                                {{ $borrowing->isOverdue() ? 'TERLAMBAT' : 'DIPINJAM' }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-bold rounded-lg border border-green-300 dark:border-green-700">
                                                <span class="w-1.5 h-1.5 bg-green-600 rounded-full"></span>
                                                DIKEMBALIKAN
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('borrowings.show', $borrowing) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-full hover:bg-blue-100 dark:hover:bg-blue-900/30 text-blue-600 dark:text-blue-400 transition font-bold">
                                            →
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <span class="text-4xl">📭</span>
                                            <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">Tidak ada data peminjaman</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($borrowings->hasPages())
                    <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $borrowings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
