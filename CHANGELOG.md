# Perubahan Sistem Peminjaman Buku - Dokumentasi

## 📋 Ringkasan Perubahan

### 1. **Sistem Peminjaman (Borrowing Workflow)**

#### Status Peminjaman (Sebelumnya)
- `borrowed` - Buku sedang dipinjam
- `returned` - Buku telah dikembalikan

#### Status Peminjaman (Sekarang)
- `pending` - Menunggu persetujuan admin
- `approved` - Disetujui oleh admin (buku sedang dipinjam)
- `rejected` - Ditolak oleh admin
- `returned` - Buku telah dikembalikan

#### Workflow Baru

**Sebelumnya:**
```
User memilih buku + tenggat waktu → Buku langsung dipinjam
```

**Sekarang:**
```
User memilih buku → Permintaan pending
                 ↓
              Admin menerima/menolak + tetapkan tenggat waktu
                 ↓
              Jika disetujui → Buku dipinjam (status: approved)
              Jika ditolak → Status: rejected
```

#### Tanggal Kunci (due_date)

**Sebelumnya:**
- User memilih tenggat waktu saat meminjam

**Sekarang:**
- Admin menetapkan tenggat waktu saat menyetujui permintaan
- Field `borrowed_at` dan `due_date` kosong sampai disetujui

---

### 2. **Sistem Denda (Fine System)**

#### Field Denda (Sebelumnya)
```
- amount (Rp 5.000/hari)  
- days_late (jumlah hari keterlambatan)
- issued_at (tanggal denda dibuat)
- paid_at (tanggal pembayaran)
- status (paid/unpaid)
```

#### Field Denda (Sekarang)
```
- description (deskripsi alasan denda)
- status (paid/unpaid)
- created_at (otomatis)
- updated_at (otomatis)
```

#### Proses Denda

**Sebelumnya:**
```
User return overdue → Otomatis hitung amount & buat denda
```

**Sekarang:**
```
User return overdue → Sistem beri notifikasi
                  ↓
              Admin review & buat denda dengan deskripsi
                  ↓
              Admin mark as paid kapan user bayar
```

---

### 3. **Manajemen User (User Management)**

#### Fitur Baru
- Admin bisa membuat user baru
- Admin bisa lihat daftar semua user
- Admin bisa mengedit role user
- Admin bisa menghapus user

#### Routes Baru
```
GET    /users               (User management list)
GET    /users/create        (Form create user)
POST   /users               (Store new user)
GET    /users/{user}        (View user details)
GET    /users/{user}/edit   (Edit user)
PATCH  /users/{user}        (Update user)
DELETE /users/{user}        (Delete user)
```

---

### 4. **Panel Persetujuan Peminjaman (Admin)**

#### Fitur Baru
- Admin bisa lihat semua permintaan pending
- Admin bisa setujui dengan memilih tenggat waktu
- Admin bisa menolak permintaan

#### Route Baru
```
GET /borrowings-approval/panel   (Approval panel)
```

---

## 🔄 Model Updates

### Borrowing Model
```php
// Accessor methods ditambah:
isPending()    - Status pending
isApproved()   - Status approved  
isRejected()   - Status rejected
isReturned()   - Status returned
isOverdue()    - Check if approved & returned_at > due_date
getDaysLate()  - Hitung hari keterlambatan
```

### Fine Model
```php
// Field berubah:
- Removed: amount, days_late, issued_at, paid_at
+ Added: description

// Casts di-remove (tidak ada date fields lagi)
```

---

## 🗄️ Database Changes

### Borrowing Table
```sql
ALTER TABLE borrowings
DROP COLUMN status;
ALTER TABLE borrowings  
ADD COLUMN status ENUM('pending','approved','rejected','returned') DEFAULT 'pending';
ALTER TABLE borrowings
MODIFY borrowed_at DATETIME NULL;
MODIFY due_date DATETIME NULL;
```

### Fine Table
```sql
ALTER TABLE fines
DROP COLUMN amount, days_late, issued_at, paid_at;
ALTER TABLE fines  
ADD COLUMN description TEXT NULL;
```

---

## 📁 File yang Berubah

### Controllers
- `BookController` - No major changes
- `BorrowingController` - **Completely refactored**
- `FineController` - Updated for description-only fines
- `DashboardController` - Updated status filters
- `UserController` - **NEW** (Admin user management)

### Models
- `Borrowing` - Added status methods
- `Fine` - Removed amount-related properties
- `User` - No changes

### Requests
- `StoreBorrowingRequest` - Removed due_date requirement
- `UpdateBorrowingRequest` - Updated for approval workflow
- `StoreUserRequest` - **NEW**

### Services
- `FineService` - Changed from calculateFine() to createFine()

### Routes (routes/web.php)
- Added user management routes
- Added borrowing approval panel route
- Updated borrowing routes for new workflow

### Factories
- `BorrowingFactory` - Updated for new status values
- `FineFactory` - Removed amount/days_late fields
- `FineFactory` - Added description field

---

## 🎯 Fitur yang Harus Diimplementasikan di Views

### Views yang Perlu Diupdate/Dibuat:
1. `borrowings/create.blade.php` - Sekarang hanya pilih buku (tidak ada due_date)
2. `borrowings/edit.blade.php` - Admin approval form (approve/reject + set due date)
3. `borrowings/return.blade.php` - Return form untuk user
4. `borrowings/approval-panel.blade.php` - **NEW** Approval panel admin
5. `borrowings/index.blade.php` - Filter by new status values
6. `borrowings/show.blade.php` - Show details + action based on status
7. `users/index.blade.php` - **NEW** User management list
8. `users/create.blade.php` - **NEW** Create user form
9. `users/edit.blade.php` - **NEW** Edit user form
10. `users/show.blade.php` - **NEW** User details
11. `fines/index.blade.php` - Update to show description instead of amount
12. `fines/show.blade.php` - Update to show description instead of amount
13. `fines/monthly-report.blade.php` - Update statistics (count instead of amount)
14. `dashboard/admin.blade.php` - Add pending requests section
15. `dashboard/user.blade.php` - Add pending requests section

---

## ✅ Status Implementasi

- [x] Migrasi database
- [x] Update models
- [x] Update controllers
- [x] Update form requests
- [x] Update services
- [x] Update routes
- [x] Update factories
- [x] All tests passing (25/25)
- [ ] Create/update views
- [ ] Test user flows

---

## 🧪 Testing Checklist

Setelah views dibuat, test flows berikut:

### Admin Flow
- [ ] Login sebagai admin
- [ ] Buat user baru
- [ ] Edit user (ubah role)
- [ ] Lihat daftar user
- [ ] Lihat panel approval permintaan peminjaman
- [ ] Approve permintaan dengan set due date
- [ ] Reject permintaan
- [ ] Lihat daftar peminjaman overdue
- [ ] Buat denda dengan deskripsi
- [ ] Mark denda as paid
- [ ] Lihat laporan denda bulanan

### User Flow
- [ ] Login sebagai user
- [ ] Request peminjaman buku
- [ ] Lihat status pending di dashboard
- [ ] Admin approve → lihat di dashboard (approved)
- [ ] Return buku sesuai due date (no fine)
- [ ] Request peminjaman lagi
- [ ] Admin approve
- [ ] Return buku lewat due date
- [ ] Lihat denda di fine list dengan deskripsi
- [ ] Admin buat denda dengan deskripsi
- [ ] Mark as paid

---

**Siap untuk implementasi views dan testing!** 🚀
