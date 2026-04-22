# SweetAlert2 Integration Guide

## Setup
SweetAlert2 sudah terintegrasi ke aplikasi. File-file yang dimodifikasi:
- `resources/js/app.js` - Import SweetAlert2 dan helper functions
- `resources/css/app.css` - Import SweetAlert2 CSS
- `resources/js/sweetalert-helper.js` - Event listeners untuk forms dan links

## Cara Menggunakan

### 1. Form Confirmation (Automatic)
Tambahkan atribut `data-confirm` pada form untuk menampilkan konfirmasi sebelum submit:

```blade
<form method="POST" action="{{ route('items.destroy', $item) }}" data-confirm="Yakin ingin menghapus?">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Hapus</button>
</form>
```

### 2. Alert Notifications (JavaScript)
Gunakan helper functions global yang sudah tersedia:

#### Success Alert
```javascript
showSuccess('Berhasil!', 'Data berhasil disimpan');
```

#### Error Alert
```javascript
showError('Gagal!', 'Terjadi kesalahan saat menyimpan data');
```

#### Info Alert
```javascript
showAlert('Informasi', 'Ini adalah notifikasi informasi', 'info');
```

#### Warning Alert
```javascript
showAlert('Perhatian', 'Ini adalah notifikasi peringatan', 'warning');
```

#### Confirmation Dialog
```javascript
showConfirm(
    'Konfirmasi Aksi',
    'Apakah Anda yakin?',
    () => {
        // Callback jika user klik "Ya"
        console.log('User memilih Ya');
    },
    () => {
        // Callback jika user klik "Batal"
        console.log('User memilih Batal');
    }
);
```

#### Toast Notification
```javascript
showToast('Operasi berhasil!', 'success');
showToast('Terjadi kesalahan', 'error');
showToast('Informasi penting', 'info');
showToast('Peringatan', 'warning');
```

#### Loading Dialog
```javascript
showLoading('Sedang memproses...');
// Untuk menutup:
Swal.close();
```

### 3. Custom SweetAlert (Advanced)
Gunakan `window.Swal` untuk custom configuration:

```javascript
Swal.fire({
    title: 'Custom Title',
    text: 'Custom message',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'OK',
    cancelButtonText: 'Cancel',
    confirmButtonColor: '#3b82f6',
    cancelButtonColor: '#6b7280'
}).then((result) => {
    if (result.isConfirmed) {
        // User klik OK
    } else {
        // User klik Cancel
    }
});
```

### 4. Dalam Blade Template
Gunakan helper functions langsung di inline JavaScript:

```blade
<button onclick="showAlert('Halo', 'Ini adalah alert dari blade')">
    Click Me
</button>
```

## Examples di Aplikasi

### Approval Borrowing
```blade
<form method="POST" action="{{ route('borrowings.update', $borrowing) }}" data-confirm="Yakin ingin menolak permintaan ini?">
    @csrf
    @method('PUT')
    <input type="hidden" name="status" value="rejected">
    <button type="submit" class="btn btn-danger">Tolak</button>
</form>
```

### Delete User
```blade
<form method="POST" action="{{ route('users.destroy', $user) }}" data-confirm="Yakin ingin menghapus user ini?">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Hapus</button>
</form>
```

### Return Book
```blade
<form method="POST" action="{{ route('borrowings.update', $borrowing) }}" data-confirm="Apakah Anda yakin ingin mengembalikan buku ini?">
    @csrf
    @method('PUT')
    <input type="hidden" name="status" value="returned">
    <button type="submit" class="btn btn-success">Kembalikan Buku</button>
</form>
```

## Icon Options
- `success` - ✓ Icon berhasil (hijau)
- `error` - ✗ Icon error (merah)
- `warning` - ⚠ Icon peringatan (kuning)
- `info` - ℹ Icon info (biru)
- `question` - ? Icon pertanyaan

## Warna Default
- Success: #10b981 (Green)
- Error: #ef4444 (Red)
- Warning: #f59e0b (Yellow)
- Info: #3b82f6 (Blue)

## Tips & Best Practices

1. **Consistency**: Gunakan helper functions yang sudah ada untuk konsistensi
2. **Form Validation**: Tetap gunakan server-side validation di backend
3. **Loading State**: Gunakan `showLoading()` untuk long-running operations
4. **User Feedback**: Selalu berikan feedback yang jelas untuk setiap aksi

## Troubleshooting

### SweetAlert tidak muncul?
1. Pastikan CSS sudah di-import: `npm run dev`
2. Cek browser console untuk errors
3. Pastikan form memiliki atribut `data-confirm`

### Button tidak merespons?
1. Pastikan form memiliki proper structure
2. Cek bahwa event listener sudah ter-load (buka DevTools > Console)
3. Coba refresh halaman

## Resources
- [SweetAlert2 Documentation](https://sweetalert2.github.io/)
- [SweetAlert2 GitHub](https://github.com/sweetalert2/sweetalert2)
