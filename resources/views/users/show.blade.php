<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Header with User Avatar -->
                <div class="px-6 py-8 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-6">
                        <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                            <span class="text-white font-bold text-3xl">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                            @if(auth()->id() === $user->id)
                                <span class="inline-block mt-2 px-3 py-1 text-xs font-semibold bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full">
                                    Anda
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6 space-y-6">
                    <!-- User Information -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi User</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Name -->
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Nama Lengkap</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user->name }}</p>
                            </div>

                            <!-- Email -->
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Email</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white break-all">{{ $user->email }}</p>
                            </div>

                            <!-- Role -->
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Role</p>
                                @if($user->isAdmin())
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 bg-purple-600 rounded-full"></span>
                                        <span class="font-semibold text-purple-700 dark:text-purple-300">Admin</span>
                                    </div>
                                @else
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 bg-gray-600 rounded-full"></span>
                                        <span class="font-semibold text-gray-700 dark:text-gray-300">User</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Created At -->
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Terdaftar Sejak</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user->created_at->format('d M Y') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Stats (if admin) -->
                    @if(auth()->user()->isAdmin())
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Statistik Aktivitas</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Total Borrowings -->
                                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                                    <p class="text-xs font-semibold text-blue-700 dark:text-blue-300 uppercase tracking-wider">Total Peminjaman</p>
                                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-2">{{ $user->borrowings()->count() }}</p>
                                </div>

                                <!-- Active Borrowings -->
                                <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-4 border border-yellow-200 dark:border-yellow-800">
                                    <p class="text-xs font-semibold text-yellow-700 dark:text-yellow-300 uppercase tracking-wider">Peminjaman Aktif</p>
                                    <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 mt-2">{{ $user->borrowings()->where('status', 'approved')->count() }}</p>
                                </div>

                                <!-- Fines -->
                                <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-4 border border-red-200 dark:border-red-800">
                                    <p class="text-xs font-semibold text-red-700 dark:text-red-300 uppercase tracking-wider">Pelanggaran</p>
                                    <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-2">{{ $user->fines()->count() }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 flex gap-3">
                <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 px-6 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition font-medium">
                    ← Kembali
                </a>
                <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center gap-2 px-6 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition font-medium">
                    ✏️ Edit
                </a>
                @if(auth()->user()->isAdmin() && auth()->id() !== $user->id)
                    @if($user->isAdmin())
                        <button disabled class="inline-flex items-center gap-2 px-6 py-2 bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 rounded-lg cursor-not-allowed font-medium" title="Admin tidak bisa dihapus">
                            🗑️ Hapus (Admin)
                        </button>
                    @else
                        <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline" data-confirm="Yakin ingin menghapus user ini? Semua data akan hilang.">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition font-medium">
                                🗑️ Hapus
                            </button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
