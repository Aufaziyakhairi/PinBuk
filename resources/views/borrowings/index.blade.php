<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Peminjaman Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Admin Approval Panel -->
            @if(auth()->user()->isAdmin())
                @php
                    $pendingBorrowings = \App\Models\Borrowing::where('status', 'pending')->with(['user', 'book'])->latest()->get();
                @endphp
                
                @if($pendingBorrowings->isNotEmpty())
                    <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-lg p-4">
                        <p class="text-sm font-medium text-red-700 dark:text-red-300">
                            ⚠️ Ada <strong>{{ $pendingBorrowings->count() }}</strong> permintaan peminjaman yang menunggu persetujuan Anda.
                        </p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="px-6 py-4 bg-red-50 dark:bg-red-900/20 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider">🔴 Permintaan Menunggu Persetujuan</h3>
                        </div>
                        <div class="grid gap-4 p-6">
                            @foreach($pendingBorrowings as $borrowing)
                                <div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                        <div>
                                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Buku</p>
                                            <p class="font-semibold text-gray-900 dark:text-white">{{ $borrowing->book->title }}</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">oleh {{ $borrowing->book->author }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Peminjam</p>
                                            <p class="font-semibold text-gray-900 dark:text-white">{{ $borrowing->user->name }}</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">{{ $borrowing->user->email }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Tanggal Permintaan</p>
                                            <p class="font-semibold text-gray-900 dark:text-white">{{ $borrowing->created_at->format('d M Y') }}</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">{{ $borrowing->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="border-t border-gray-200 dark:border-gray-600 pt-4 flex gap-3">
                                        <form method="POST" action="{{ route('borrowings.update', $borrowing) }}" class="flex-1">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="approved">
                                            <input type="hidden" name="due_date" value="{{ now()->addDays(7)->format('Y-m-d') }}">
                                            <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold text-sm rounded-lg transition">
                                                ✓ Setujui
                                            </button>
                                        </form>
                                        
                                        <a href="{{ route('borrowings.edit', $borrowing) }}" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-lg transition text-center">
                                            ⚙️ Detail
                                        </a>
                                        
                                        <form method="POST" action="{{ route('borrowings.update', $borrowing) }}" class="flex-1" onsubmit="return confirm('Yakin ingin menolak?')">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold text-sm rounded-lg transition">
                                                ✗ Tolak
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 rounded-lg p-4">
                        <p class="text-sm font-medium text-green-700 dark:text-green-300">
                            ✓ Semua permintaan peminjaman telah diproses.
                        </p>
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

            <!-- Filter -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <form method="GET" action="{{ route('borrowings.index') }}" class="flex gap-4">
                            <select name="status"
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Semua Status</option>
                                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui (Menunggu Peminjaman)</option>
                                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Sedang Dipinjam</option>
                                <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Sudah Dikembalikan</option>
                            </select>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Filter
                            </button>
                        </form>
                        @if(auth()->user()->isUser())
                            <a href="{{ route('borrowings.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                + Pinjam Buku
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Borrowings List -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Buku</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Peminjam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal Pinjam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jatuh Tempo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($borrowings->whereIn('status', ['approved', 'returned']) as $borrowing)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        {{ $borrowing->book->title }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $borrowing->user->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        @if($borrowing->borrowed_at)
                                            {{ $borrowing->borrowed_at->format('d-m-Y') }}
                                        @else
                                            <span class="text-yellow-600 dark:text-yellow-400">Belum dimulai</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm @if($borrowing->isOverdue() && $borrowing->status === 'approved') text-red-600 dark:text-red-400 font-semibold @else text-gray-500 dark:text-gray-400 @endif">
                                        @if($borrowing->due_date)
                                            {{ $borrowing->due_date->format('d-m-Y') }}
                                            @if($borrowing->isOverdue() && $borrowing->status === 'approved')
                                                <span class="text-red-500">(TERLAMBAT)</span>
                                            @endif
                                        @else
                                            <span class="text-gray-400">--</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if($borrowing->status === 'approved')
                                            <span class="px-2 py-1 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 text-xs rounded font-semibold">
                                                ⏳ Siap Pinjam
                                            </span>
                                        @elseif($borrowing->status === 'approved')
                                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs rounded font-semibold">
                                                🔵 Sedang Dipinjam
                                            </span>
                                        @else
                                            <span class="px-2 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs rounded font-semibold">
                                                ✓ Dikembalikan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <a href="{{ route('borrowings.show', $borrowing) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        Tidak ada data peminjaman
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
