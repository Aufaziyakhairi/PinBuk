<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'PinBuk') }} - Sistem Manajemen Perpustakaan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                    📚
                </div>
                <span class="font-bold text-xl text-gray-900 dark:text-white">PinBuk</span>
            </div>
            
            <div class="flex gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
                        Masuk
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                            Daftar
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-16">
            <h1 class="text-5xl md:text-6xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                Kelola Perpustakaan Anda dengan <span class="bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">Mudah</span>
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto">
                PinBuk adalah sistem manajemen perpustakaan modern yang memudahkan Anda mengelola koleksi buku, peminjaman, pengembalian, dan denda dengan interface yang sederhana dan intuitif.
            </p>
            <div class="flex gap-4 justify-center flex-wrap">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-lg hover:shadow-xl">
                        ➜ Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-lg hover:shadow-xl">
                        ➜ Mulai Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-3 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white hover:border-gray-400 dark:hover:border-gray-500 font-semibold rounded-lg transition">
                        ↳ Masuk
                    </a>
                @endauth
            </div>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-20">
            <!-- Feature 1: Manajemen Buku -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 hover:shadow-lg transition">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center text-2xl mb-4">
                    📖
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Manajemen Buku</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Kelola katalog buku dengan mudah. Tambah, edit, hapus buku, pantau stok, dan kategorisasi koleksi Anda secara efisien.
                </p>
                <div class="mt-4 text-sm text-gray-500 dark:text-gray-500">
                    ✓ Katalog buku lengkap<br>
                    ✓ Tracking stok real-time<br>
                    ✓ Kategori & lokasi
                </div>
            </div>

            <!-- Feature 2: Peminjaman & Pengembalian -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 hover:shadow-lg transition">
                <div class="w-12 h-12 bg-cyan-100 dark:bg-cyan-900/30 rounded-lg flex items-center justify-center text-2xl mb-4">
                    📋
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Peminjaman & Pengembalian</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Proses peminjaman dan pengembalian buku yang terstruktur dengan approval system dan tracking tanggal jatuh tempo.
                </p>
                <div class="mt-4 text-sm text-gray-500 dark:text-gray-500">
                    ✓ Request peminjaman<br>
                    ✓ Approval system<br>
                    ✓ Tracking jatuh tempo
                </div>
            </div>

            <!-- Feature 3: Manajemen Denda -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 hover:shadow-lg transition">
                <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center text-2xl mb-4">
                    ⚖️
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Manajemen Denda</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Otomatis track dan kelola denda keterlambatan, pantau status pembayaran, dan buat laporan bulanan yang detail.
                </p>
                <div class="mt-4 text-sm text-gray-500 dark:text-gray-500">
                    ✓ Tracking denda otomatis<br>
                    ✓ Status pembayaran<br>
                    ✓ Laporan bulanan
                </div>
            </div>

            <!-- Feature 4: Manajemen User -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 hover:shadow-lg transition">
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center text-2xl mb-4">
                    👥
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Manajemen User</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Kelola pengguna sistem dengan role-based access control. Pisahkan akses admin dan user biasa untuk keamanan maksimal.
                </p>
                <div class="mt-4 text-sm text-gray-500 dark:text-gray-500">
                    ✓ Role-based access<br>
                    ✓ User management<br>
                    ✓ Activity tracking
                </div>
            </div>

            <!-- Feature 5: Dashboard Analytics -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 hover:shadow-lg transition">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center text-2xl mb-4">
                    📊
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Dashboard Analytics</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Visualisasi data perpustakaan dalam satu dashboard. Lihat statistik peminjaman, denda, dan aktivitas user secara real-time.
                </p>
                <div class="mt-4 text-sm text-gray-500 dark:text-gray-500">
                    ✓ Statistik real-time<br>
                    ✓ Visualisasi data<br>
                    ✓ Export laporan
                </div>
            </div>

            <!-- Feature 6: Dark Mode -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 hover:shadow-lg transition">
                <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center text-2xl mb-4">
                    🎨
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Dark Mode & Responsive</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Interface yang nyaman untuk mata dengan dark mode built-in. Akses dari desktop, tablet, atau smartphone dengan smooth.
                </p>
                <div class="mt-4 text-sm text-gray-500 dark:text-gray-500">
                    ✓ Dark mode lengkap<br>
                    ✓ Responsive design<br>
                    ✓ Modern UI/UX
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-white dark:bg-gray-800 border-t border-b border-gray-200 dark:border-gray-700 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">100%</div>
                    <p class="text-gray-600 dark:text-gray-400">Gratis & Open Source</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">5+</div>
                    <p class="text-gray-600 dark:text-gray-400">Fitur Utama</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">Easy</div>
                    <p class="text-gray-600 dark:text-gray-400">Setup Mudah</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">24/7</div>
                    <p class="text-gray-600 dark:text-gray-400">Selalu Tersedia</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl p-12 text-center text-white shadow-xl">
            <h2 class="text-4xl font-bold mb-4">Siap Mengelola Perpustakaan Anda?</h2>
            <p class="text-lg text-blue-100 mb-8 max-w-2xl mx-auto">
                Bergabunglah dengan ribuan perpustakaan yang telah menggunakan PinBuk untuk manajemen yang lebih efisien.
            </p>
            <div class="flex gap-4 justify-center flex-wrap">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-8 py-3 bg-white text-blue-600 hover:bg-gray-100 font-semibold rounded-lg transition">
                        Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-3 bg-white text-blue-600 hover:bg-gray-100 font-semibold rounded-lg transition">
                        Daftar Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-3 border-2 border-white text-white hover:bg-blue-700 font-semibold rounded-lg transition">
                        Sudah Punya Akun?
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 dark:bg-gray-950 text-gray-400 py-8 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                            📚
                        </div>
                        <span class="font-bold text-white">PinBuk</span>
                    </div>
                    <p class="text-sm">Sistem manajemen perpustakaan modern dan mudah digunakan.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-4">Fitur</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Manajemen Buku</a></li>
                        <li><a href="#" class="hover:text-white transition">Peminjaman</a></li>
                        <li><a href="#" class="hover:text-white transition">Denda</a></li>
                        <li><a href="#" class="hover:text-white transition">Laporan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-4">Aplikasi</h4>
                    <ul class="space-y-2 text-sm">
                        @auth
                            <li><a href="{{ route('dashboard') }}" class="hover:text-white transition">Dashboard</a></li>
                            <li><a href="{{ route('borrowings.index') }}" class="hover:text-white transition">Peminjaman</a></li>
                            <li><a href="{{ route('fines.index') }}" class="hover:text-white transition">Denda</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="hover:text-white transition">Login</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-white transition">Register</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-4">Kontak</h4>
                    <ul class="space-y-2 text-sm">
                        <li>Email: <a href="mailto:info@pinbuk.com" class="hover:text-white transition">info@pinbuk.com</a></li>
                        <li>WhatsApp: <a href="https://wa.me/628123456789" class="hover:text-white transition">+62 812 3456 789</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <p class="text-sm">&copy; 2026 PinBuk. All rights reserved.</p>
                    <div class="flex gap-4">
                        <a href="#" class="hover:text-white transition text-sm">Privacy Policy</a>
                        <a href="#" class="hover:text-white transition text-sm">Terms of Service</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
