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
                    <div class="bg-gradient-to-r from-amber-50 via-red-50 to-orange-50 dark:from-amber-900/20 dark:via-red-900/20 dark:to-orange-900/20 border-l-4 border-red-500 rounded-xl p-6 flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="text-4xl animate-bounce">⏳</div>
                            <div>
                                <p class="text-sm font-bold text-red-700 dark:text-red-300 uppercase tracking-wider">Persetujuan Menunggu</p>
                                <p class="text-red-600 dark:text-red-400 text-base mt-1">
                                    Anda memiliki <strong class="text-lg font-extrabold text-red-700 dark:text-red-300">{{ $pendingBorrowings->count() }}</strong> permintaan yang perlu ditinjau
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="inline-flex items-center gap-1 px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white text-sm font-bold rounded-full shadow-md">
                                <span class="w-2.5 h-2.5 bg-white rounded-full animate-pulse"></span>
                                Butuh Aksi
                            </span>
                        </div>
                    </div>

                    <!-- Approval Cards -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-8 py-6 bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                            <h3 class="text-base font-bold text-gray-900 dark:text-white uppercase tracking-widest flex items-center gap-3">
                                <span class="text-2xl">📋</span> 
                                <span>Permintaan Peminjaman Baru</span>
                                <span class="ml-2 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">{{ $pendingBorrowings->count() }}</span>
                            </h3>
                        </div>
                        
                        <div class="grid gap-4 p-6 lg:p-8 bg-gradient-to-b from-white to-gray-50 dark:from-gray-800 dark:to-gray-800/50">
                            @foreach($pendingBorrowings as $borrowing)
                                <div class="group bg-white dark:bg-gray-700/50 border-2 border-gray-200 dark:border-gray-600 rounded-xl p-6 hover:border-orange-400 dark:hover:border-orange-500 hover:shadow-lg transition-all duration-300" x-data="{ editModal{{ $borrowing->id }}: false }">
                                    <!-- Header with Book Info -->
                                    <div class="flex items-start justify-between mb-5 pb-5 border-b border-gray-200 dark:border-gray-600">
                                        <div class="flex-1">
                                            <p class="text-xs font-bold text-orange-600 dark:text-orange-400 uppercase tracking-wider mb-1">📚 Judul Buku</p>
                                            <h4 class="text-lg font-bold text-gray-900 dark:text-white">{{ $borrowing->book->title }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Oleh <span class="font-semibold">{{ $borrowing->book->author ?? 'Penulis tidak diketahui' }}</span></p>
                                        </div>
                                        <div class="text-right ml-4">
                                            <span class="inline-block px-3 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-bold rounded-lg">
                                                ID: #{{ $borrowing->id }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Peminjam & Permintaan Info -->
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">
                                        <!-- Peminjam -->
                                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-900/10 rounded-lg p-4 border border-blue-200 dark:border-blue-700">
                                            <p class="text-xs font-bold text-blue-700 dark:text-blue-400 uppercase tracking-wider mb-2">👤 Peminjam</p>
                                            <p class="text-base font-bold text-gray-900 dark:text-white">{{ $borrowing->user->name }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">{{ $borrowing->user->email }}</p>
                                        </div>

                                        <!-- Waktu Permintaan -->
                                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-900/10 rounded-lg p-4 border border-purple-200 dark:border-purple-700">
                                            <p class="text-xs font-bold text-purple-700 dark:text-purple-400 uppercase tracking-wider mb-2">📅 Waktu Permintaan</p>
                                            <p class="text-base font-bold text-gray-900 dark:text-white">{{ $borrowing->created_at->format('d M Y') }}</p>
                                            <p class="text-sm text-purple-600 dark:text-purple-300 font-semibold mt-1">{{ $borrowing->created_at->diffForHumans() }}</p>
                                        </div>

                                        <!-- Ketersediaan Buku -->
                                        <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-900/10 rounded-lg p-4 border border-green-200 dark:border-green-700">
                                            <p class="text-xs font-bold text-green-700 dark:text-green-400 uppercase tracking-wider mb-2">📊 Ketersediaan</p>
                                            <p class="text-base font-bold text-gray-900 dark:text-white">
                                                <span class="text-2xl text-green-600 dark:text-green-400">{{ $borrowing->book->available_quantity }}</span>
                                                <span class="text-gray-600 dark:text-gray-300">/{{ $borrowing->book->quantity }}</span>
                                            </p>
                                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                                @if($borrowing->book->available_quantity > 0)
                                                    <span class="text-green-600 dark:text-green-400 font-semibold">✓ Tersedia</span>
                                                @else
                                                    <span class="text-red-600 dark:text-red-400 font-semibold">✗ Habis</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex gap-3 pt-4 border-t border-gray-200 dark:border-gray-600">
                                        <!-- Approve Button -->
                                        <form method="POST" action="{{ route('borrowings.update', $borrowing) }}" class="flex-1">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="approved">
                                            <input type="hidden" name="due_date" value="{{ now()->addDays(7)->format('Y-m-d') }}">
                                            <button type="submit" class="w-full px-4 py-3 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-bold text-sm rounded-lg transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg transform hover:scale-105">
                                                <span class="text-lg">✓</span> Setujui (7 hari)
                                            </button>
                                        </form>
                                        
                                        <!-- Edit Button (Trigger Modal) -->
                                        <button type="button" @click="editModal{{ $borrowing->id }} = true" class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white font-bold text-sm rounded-lg transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg transform hover:scale-105">
                                            <span class="text-lg">⚙️</span> Edit Durasi
                                        </button>
                                        
                                        <!-- Reject Button -->
                                        <form method="POST" action="{{ route('borrowings.update', $borrowing) }}" class="flex-1" data-confirm="Permintaan akan ditolak. Yakin lanjutkan?">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="w-full px-4 py-3 bg-gradient-to-r from-red-500 to-rose-500 hover:from-red-600 hover:to-rose-600 text-white font-bold text-sm rounded-lg transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg transform hover:scale-105">
                                                <span class="text-lg">✕</span> Tolak
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Edit Duration Modal -->
                                    <div x-show="editModal{{ $borrowing->id }}" class="fixed inset-0 bg-black/50 dark:bg-black/70 z-50 flex items-center justify-center p-4" style="display: none;">
                                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full border border-gray-200 dark:border-gray-700" @click.stop>
                                            <!-- Modal Header -->
                                            <div class="px-8 py-6 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                                                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                                    <span class="text-2xl">⏰</span> Edit Durasi
                                                </h3>
                                                <button type="button" @click="editModal{{ $borrowing->id }} = false" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 text-2xl">
                                                    ✕
                                                </button>
                                            </div>

                                            <!-- Modal Body -->
                                            <form method="POST" action="{{ route('borrowings.update', $borrowing) }}" class="p-8">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="approved">

                                                <!-- Book Info -->
                                                <div class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-4 mb-6 border border-gray-200 dark:border-gray-600">
                                                    <p class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-1">📚 Buku</p>
                                                    <p class="text-base font-bold text-gray-900 dark:text-white">{{ $borrowing->book->title }}</p>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Peminjam: <strong>{{ $borrowing->user->name }}</strong></p>
                                                </div>

                                                <!-- Current Due Date -->
                                                <div class="mb-6">
                                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">📅 Jatuh Tempo Saat Ini</p>
                                                    <div class="bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-700 rounded-lg p-3">
                                                        <p class="text-lg font-bold text-orange-700 dark:text-orange-300">
                                                            @if($borrowing->due_date)
                                                                {{ $borrowing->due_date->format('d M Y') }}
                                                            @else
                                                                Belum ditentukan
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Duration Selection -->
                                                <div class="mb-6">
                                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">⏱️ Pilih Durasi Peminjaman</p>
                                                    <div class="space-y-2">
                                                        <!-- 3 Days -->
                                                        <label class="flex items-center p-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-blue-400 dark:hover:border-blue-400 transition">
                                                            <input type="radio" name="due_date" value="{{ now()->addDays(3)->format('Y-m-d') }}" class="w-4 h-4 text-blue-600">
                                                            <span class="ml-3 text-sm font-semibold text-gray-700 dark:text-gray-300">3 hari - {{ now()->addDays(3)->format('d M Y') }}</span>
                                                        </label>

                                                        <!-- 7 Days (Standard) -->
                                                        <label class="flex items-center p-3 border-2 border-blue-500 bg-blue-50 dark:bg-blue-900/20 rounded-lg cursor-pointer transition">
                                                            <input type="radio" name="due_date" value="{{ now()->addDays(7)->format('Y-m-d') }}" checked class="w-4 h-4 text-blue-600">
                                                            <span class="ml-3 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                                7 hari - {{ now()->addDays(7)->format('d M Y') }}
                                                                <span class="text-xs text-blue-600 ml-1 font-bold">(Standar)</span>
                                                            </span>
                                                        </label>

                                                        <!-- 14 Days (Max) -->
                                                        <label class="flex items-center p-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-orange-400 dark:hover:border-orange-400 transition">
                                                            <input type="radio" name="due_date" value="{{ now()->addDays(14)->format('Y-m-d') }}" class="w-4 h-4 text-blue-600">
                                                            <span class="ml-3 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                                14 hari - {{ now()->addDays(14)->format('d M Y') }}
                                                                <span class="text-xs text-amber-600 ml-1 font-bold">(Max)</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Info -->
                                                <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 rounded-lg p-4 mb-6">
                                                    <p class="text-sm text-amber-900 dark:text-amber-300">
                                                        <span class="font-bold">💡 Catatan:</span> Durasi maksimal 14 hari. Denda keterlambatan Rp 5.000/hari.
                                                    </p>
                                                </div>

                                                <!-- Buttons -->
                                                <div class="flex gap-3">
                                                    <button type="button" @click="editModal{{ $borrowing->id }} = false" class="flex-1 px-4 py-2.5 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-800 dark:text-white font-semibold rounded-lg transition">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="flex-1 px-4 py-2.5 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-bold rounded-lg transition shadow-md hover:shadow-lg">
                                                        ✓ Simpan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="bg-gradient-to-r from-green-50 via-emerald-50 to-teal-50 dark:from-green-900/20 dark:via-emerald-900/20 dark:to-teal-900/20 border-2 border-green-200 dark:border-green-700 rounded-xl p-6 flex items-center gap-4 shadow-sm">
                        <div class="text-4xl animate-bounce">✅</div>
                        <div>
                            <p class="text-base font-bold text-green-700 dark:text-green-300 uppercase tracking-wider">Semua Permintaan Terproses</p>
                            <p class="text-green-600 dark:text-green-400 text-sm mt-1">Tidak ada permintaan peminjaman yang menunggu persetujuan. Bagus sekali! 🎉</p>
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
                    <form method="GET" action="{{ route('borrowings.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
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
                        <div class="flex flex-col justify-end">
                            <button type="submit" class="w-full px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition flex items-center justify-center gap-2">
                                <span>🔍</span> Cari
                            </button>
                        </div>
                        @if(auth()->user()->isUser())
                            <div class="flex flex-col justify-end">
                                <a href="{{ route('borrowings.create') }}" class="w-full px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg transition flex items-center justify-center gap-2">
                                    <span>➕</span> Pinjam Buku
                                </a>
                            </div>
                        @endif
                    </form>
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
