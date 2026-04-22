import Swal from 'sweetalert2';

/**
 * Handle form submissions with SweetAlert confirmation
 * Add data-confirm attribute to forms to trigger confirmation
 * Example: <form data-confirm="Are you sure?">
 */
document.addEventListener('submit', function(e) {
    const form = e.target;
    const confirmMessage = form.getAttribute('data-confirm');
    
    if (confirmMessage) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Konfirmasi',
            text: confirmMessage,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
}, true);

/**
 * Handle delete links with SweetAlert confirmation
 * Add data-delete-confirm attribute to links for delete confirmation
 * Example: <a href="..." data-delete-confirm>Delete</a>
 */
document.addEventListener('click', function(e) {
    if (e.target.hasAttribute('data-delete-confirm')) {
        e.preventDefault();
        
        const href = e.target.getAttribute('href');
        const itemName = e.target.getAttribute('data-item-name') || 'item';
        
        Swal.fire({
            title: 'Hapus ' + itemName + '?',
            text: 'Tindakan ini tidak dapat dibatalkan',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = href;
            }
        });
    }
}, true);

/**
 * Show toast notification
 * Example: showToast('Success!', 'success')
 */
window.showToast = (message, type = 'info') => {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    
    Toast.fire({
        icon: type,
        title: message
    });
};
