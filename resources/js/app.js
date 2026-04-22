import './bootstrap';
import './sweetalert-helper';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

window.Alpine = Alpine;
window.Swal = Swal;

// Global helper functions for SweetAlert
window.showAlert = (title, text, icon = 'info') => {
    return Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonColor: '#3b82f6',
        confirmButtonText: 'OK'
    });
};

window.showConfirm = (title, text, onConfirm, onCancel = null) => {
    return Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Lanjutkan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed && onConfirm) {
            onConfirm();
        } else if (!result.isConfirmed && onCancel) {
            onCancel();
        }
    });
};

window.showSuccess = (title, text = 'Operasi berhasil dilakukan') => {
    return Swal.fire({
        title: title,
        text: text,
        icon: 'success',
        confirmButtonColor: '#10b981',
        confirmButtonText: 'OK'
    });
};

window.showError = (title, text = 'Terjadi kesalahan') => {
    return Swal.fire({
        title: title,
        text: text,
        icon: 'error',
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'OK'
    });
};

window.showLoading = (title = 'Loading...') => {
    return Swal.fire({
        title: title,
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: (modal) => {
            Swal.showLoading();
        }
    });
};

Alpine.start();
