# Sistem Peminjaman Buku Sekolah

Sistem web untuk manajemen peminjaman buku di sekolah dengan role berbasis admin dan user.

## Fitur Sistem

### 🔐 Autentikasi & Otorisasi
- Sistem login dengan email dan password
- Role-based access (Admin dan User)
- Middleware untuk pembatasan akses

### 👨‍💼 Fitur Admin

#### Manajemen Buku
- ✅ Tambah buku baru (dengan ISBN, pengarang, penerbit, dll)
- ✅ Ubah informasi buku
- ✅ Hapus buku
- ✅ Lihat daftar semua buku
- ✅ Cari dan filter buku
- ✅ Kelola stok buku

#### Manajemen Peminjaman
- ✅ Lihat semua catatan peminjaman
- ✅ Filter berdasarkan status (dipinjam/dikembalikan)
- ✅ Lihat detail peminjaman

#### Manajemen Denda
- ✅ Lihat daftar denda semua user
- ✅ Tandai denda sebagai sudah dibayar
- ✅ Laporan denda bulanan
- ✅ Filter denda berdasarkan status dan periode

#### Dashboard Admin
- 📊 Statistik total buku, peminjaman aktif, denda
- ⚠️ Alert peminjaman terlambat
- 📋 Daftar peminjaman terlambat
- 📈 Riwayat peminjaman terbaru

### 👤 Fitur User (Peminjam)

#### Peminjaman Buku
- ✅ Lihat daftar buku yang tersedia
- ✅ Pinjam buku dengan menentukan tanggal jatuh tempo
- ✅ Lihat status stok buku

#### Pengembalian Buku
- ✅ Kembalikan buku yang dipinjam
- ✅ Sistem otomatis menghitung denda jika terlambat

#### Riwayat Peminjaman
- ✅ Lihat riwayat peminjaman (dipinjam/dikembalikan)
- ✅ Lihat detail setiap peminjaman

#### Manajemen Denda Personal
- ✅ Lihat daftar denda pribadi
- ✅ Filter denda (belum/sudah dibayar)
- ✅ Lihat detail masing-masing denda

#### Dashboard User
- 📊 Buku yang sedang dipinjam
- 💰 Denda yang harus dibayar
- 📋 Riwayat peminjaman

## Teknologi yang Digunakan

- **Framework**: Laravel 13
- **Database**: MySQL
- **Auth**: Laravel Breeze
- **Styling**: Tailwind CSS
- **Frontend**: Blade Templates

## Setup dan Instalasi

### Prasyarat
- PHP 8.3+
- Composer
- MySQL Server
- Node.js (untuk Vite)

### Langkah Instalasi

1. **Clone repository** (jika diperlukan)
   ```bash
   cd c:\laragon\www\perpus
   ```

2. **Install dependencies PHP**
   ```bash
   composer install
   ```

3. **Install dependencies Node.js**
   ```bash
   npm install
   ```

4. **Setup file .env**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Konfigurasi database di .env**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=perpus
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Jalankan migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed database dengan sample data**
   ```bash
   php artisan db:seed
   ```

8. **Jalankan development server**
   ```bash
   php artisan serve
   ```

9. **Jalankan Vite (terminal lain)**
   ```bash
   npm run dev
   ```

Akses aplikasi di: http://localhost:8000

## Akun Default

Setelah menjalankan seeder, Anda dapat login dengan:

### Admin
- **Email**: admin@perpustakaan.test
- **Password**: password
- **Role**: Admin

### User
- **Email**: Lihat di database (dihasilkan otomatis)
- **Password**: password
- **Role**: User

## Struktur Database

### Users Table
- id, name, email, password, role (admin/user), email_verified_at, created_at, updated_at

### Books Table
- id, title, author, isbn, description, publisher, publication_year
- quantity, available_quantity, category, location, status (ready/not_ready)
- soft deletes, timestamps

### Borrowings Table
- id, user_id, book_id, borrowed_at, due_date, returned_at
- status (borrowed/returned), timestamps

### Fines Table
- id, borrowing_id, user_id, amount, days_late, issued_at
- status (unpaid/paid), paid_at, timestamps

## Alur Kerja

### Alur Peminjaman Buku

1. **User** memilih buku yang ingin dipinjam
2. **User** menentukan tanggal jatuh tempo peminjaman
3. Sistem mencatat peminjaman dengan status "borrowed"
4. Stok buku berkurang secara otomatis
5. **User** dapat melihat buku di daftar "Buku Yang Sedang Dipinjam"

### Alur Pengembalian Buku

1. **User** membuka halaman peminjaman buku
2. **User** mengklik tombol "Kembalikan Buku"
3. Sistem mencatat tanggal pengembalian
4. Status peminjaman berubah menjadi "returned"
5. Stok buku bertambah kembali
6. **Jika terlambat**: Sistem otomatis membuat denda

### Alur Denda Keterlambatan

1. Harga denda: **Rp 5.000 per hari**
2. **Admin** dapat melihat semua denda di dashboard dan laporan
3. **Admin** dapat menandai denda sebagai "Sudah Dibayar"
4. **User** dapat melihat denda pribadi mereka
5. Laporan bulanan menunjukkan total denda, terbayar, dan belum

## Route API

### Autentikasi
- POST /login - Login
- POST /logout - Logout
- POST /register - Register

### Dashboard
- GET /dashboard - Dashboard (show different view berdasarkan role)

### Buku (Admin)
- GET /books - Daftar buku
- POST /books - Tambah buku
- GET /books/{book} - Detail buku
- PUT /books/{book} - Edit buku
- DELETE /books/{book} - Hapus buku

### Peminjaman
- GET /borrowings - Daftar peminjaman
- POST /borrowings - Buat peminjaman baru
- GET /borrowings/{borrowing} - Detail peminjaman
- PUT /borrowings/{borrowing} - Update peminjaman (untuk return)

### Denda
- GET /fines - Daftar denda
- GET /fines/{fine} - Detail denda
- POST /fines/{fine}/mark-as-paid - Tandai denda sebagai dibayar
- GET /fines/reports/monthly - Laporan denda bulanan

## Kustomisasi

### Ubah Harga Denda Harian

Edit file `app/Services/FineService.php`:

```php
private float $dailyFineAmount = 5000; // Ubah nilai ini
```

### Ubah Periode Default Peminjaman

Edit validasi di `app/Http/Requests/StoreBorrowingRequest.php`:

```php
'due_date' => 'required|date|after_or_equal:today|before_or_equal:' . now()->addDays(30)->format('Y-m-d'),
```

## Troubleshooting

### Migrasi gagal
```bash
php artisan migrate:reset
php artisan migrate
php artisan db:seed
```

### Cache issue
```bash
php artisan cache:clear
php artisan config:clear
```

### Assets tidak termuat
```bash
npm run build
```

## Fitur Tambahan yang Dapat Dikembangkan

- [ ] Email notifikasi peminjaman dan pengembalian
- [ ] QR code untuk peminjaman cepat
- [ ] SMS reminder untuk keterlambatan
- [ ] Integrasi with payment gateway
- [ ] Laporan reservasi buku
- [ ] Rating dan review buku
- [ ] Kategorisasi buku lebih detail
- [ ] Export laporan ke PDF/Excel
- [ ] Dashboard analytics yang lebih detail
- [ ] Mobile app

## Support dan Kontribusi

Untuk pertanyaan atau kontribusi, silakan hubungi administrator perpustakaan.

---

**Dibuat dengan ❤️ untuk perpustakaan sekolah**
