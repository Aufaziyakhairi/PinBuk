# 🚀 PANDUAN CEPAT SISTEM PEMINJAMAN BUKU

## Persiapan Awal

Pastikan aplikasi sudah ter-setup dengan baik:

```bash
# 1. Masuk ke direktori project
cd c:\laragon\www\perpus

# 2. Jalankan development server
php artisan serve

# 3. Di terminal lain, jalankan Vite untuk assets
npm run dev
```

Aplikasi akan berjalan di: **http://localhost:8000**

---

## 📝 Login Default

### Akun Admin
- **Email**: `admin@perpustakaan.test`
- **Password**: `password`

Admin dapat:
- Mengelola buku (CRUD)
- Melihat semua peminjaman
- Mengelola denda dan laporan bulanan

### Akun User (Peminjam)
User dibuat otomatis saat seeding. Anda bisa:
1. Login dengan email yang ada
2. Atau register akun baru di halaman register

---

## 🎯 Fitur Utama

### Untuk Admin

#### 1. **Kelola Buku**
```
Navigasi: Menu Atas → Manajemen Buku
- Lihat semua buku
- Tambah buku baru
- Edit informasi buku
- Hapus buku
- Cari/filter buku
```

#### 2. **Pantau Peminjaman**
```
Navigasi: Menu Atas → Peminjaman
- Lihat semua peminjaman
- Filter berdasarkan status
- Lihat detail peminjaman
- Identifikasi yang terlambat
```

#### 3. **Kelola Denda**
```
Navigasi: Menu Atas → Laporan Denda
- Laporan bulanan per bulan/tahun
- Lihat semua denda
- Tandai denda sebagai dibayar
- Statistik pembayaran
```

#### 4. **Dashboard Admin**
```
Navigasi: Menu Atas → Dashboard
Menampilkan:
- Total buku, peminjaman aktif, total denda
- Alert peminjaman terlambat
- Riwayat peminjaman terbaru
```

---

### Untuk User (Peminjam)

#### 1. **Pinjam Buku**
```
Navigasi: Menu Atas → Pinjam Buku
1. Pilih buku dari daftar (hanya yang tersedia)
2. Tentukan tanggal jatuh tempo
3. Klik "Pinjam Buku"
✓ Buku akan muncul di "Buku Yang Sedang Dipinjam"
```

#### 2. **Kembalikan Buku**
```
Navigasi: Menu Atas → Peminjaman → Lihat Detail
1. Lihat buku yang sedang dipinjam
2. Klik "Kembalikan Buku"
3. Konfirmasi pengembalian
✓ Jika terlambat: denda otomatis dihitung
```

#### 3. **Lihat Denda**
```
Navigasi: Menu Atas → Denda Saya
- Lihat daftar denda pribadi
- Lihat detail denda
- Status pembayaran
```

#### 4. **Dashboard User**
```
Navigasi: Menu Atas → Dashboard
Menampilkan:
- Buku yang sedang dipinjam
- Denda yang harus dibayar
- Riwayat peminjaman
```

---

## 📋 Skenario Testing

### Skenario 1: Peminjaman Normal
1. Login sebagai user
2. Ke "Pinjam Buku"
3. Pilih salah satu buku (misal: Laskar Pelangi)
4. Tentukan due date (misal: 7 hari dari sekarang)
5. Klik "Pinjam Buku"
6. Cek di dashboard - buku akan muncul di "Buku Yang Sedang Dipinjam"

### Skenario 2: Pengembalian Tepat Waktu
1. Login sebagai user yang punya peminjaman aktif
2. Ke "Peminjaman"
3. Klik "Lihat Detail" pada peminjaman
4. Klik "Kembalikan Buku"
5. Cek - tidak ada denda karena tepat waktu

### Skenario 3: Peminjaman Terlambat (Testing Denda)
1. Sebagai admin, buka database atau gunakan tinker
2. Update `due_date` peminjaman ke tanggal lampau
3. User mengembalikan buku
4. Denda otomatis terbuat dengan satuan Rp 5.000/hari
5. User bisa lihat denda di "Denda Saya"
6. Admin bisa lihat di laporan bulanan

### Skenario 4: Laporan Bulanan
1. Login sebagai admin
2. Ke "Laporan Denda"
3. Pilih bulan dan tahun
4. Lihat statistik: total denda, terbayar, belum terbayar
5. Lihat detail semua denda untuk periode itu

---

## 🔧 Database Commands

### Melihat Data di Database

```bash
# Masuk ke Tinker shell
php artisan tinker

# Lihat semua buku
>> App\Models\Book::all();

# Lihat semua peminjaman
>> App\Models\Borrowing::with('user', 'book')->get();

# Lihat semua denda
>> App\Models\Fine::with('user')->get();

# Lihat user tertentu
>> App\Models\User::find(1);

# Exit
>> exit
```

### Reset Database

```bash
# Jika ingin mulai dari awal
php artisan migrate:reset
php artisan migrate
php artisan db:seed
```

---

## 🐛 Troubleshooting

### Port 8000 sudah terpakai
```bash
# Gunakan port lain
php artisan serve --port=8001
```

### Assets tidak muncul
```bash
# Rebuild assets
npm run dev
# atau
npm run build
```

### Database error
```bash
# Check koneksi di .env
# Pastikan MySQL running
# Jalankan migrate lagi
php artisan migrate:fresh --seed
```

### Lupa password?
Ganti password di database atau daftar akun baru untuk testing.

---

## 📊 Breakdown Fitur

| Fitur | Admin | User |
|-------|-------|------|
| CRUD Buku | ✅ | ❌ |
| Lihat Buku | ✅ | ✅ |
| Pinjam Buku | ❌ | ✅ |
| Kembalikan Buku | ✅ | ✅ |
| Lihat Peminjaman | ✅ | ✅ (Miliknya) |
| Kelola Denda | ✅ | ❌ |
| Lihat Denda | ✅ | ✅ (Miliknya) |
| Laporan Bulanan | ✅ | ❌ |

---

## 💡 Tips Penggunaan

1. **Harga Denda**: Rp 5.000 per hari keterlambatan
2. **Stok Buku**: Otomatis berkurang saat pinjam, bertambah saat kembali
3. **Alert Admin**: Dashboard menampilkan peminjaman terlambat
4. **Export**: Laporan bulanan bisa diprint (Ctrl+P)

---

## 📞 Support

Jika ada error atau pertanyaan, check:
1. Terminal untuk error messages
2. Laravel logs: `storage/logs/laravel.log`
3. Database connections di `.env`

**Selamat menggunakan Sistem Peminjaman Buku! 📚**
