import Swal from 'sweetalert2';

window.Swal = Swal;

// Global Toast notification configured for luxury dark/amber theme
window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3500,
    timerProgressBar: true,
    background: '#18191c',
    color: '#f8fafc',
    iconColor: '#f59e0b',
    customClass: {
        popup: 'rounded-xl border border-slate-700/60 shadow-2xl shadow-black/80 backdrop-blur-md'
    },
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});

// Modern global confirmation with SweetAlert2
window.confirmAction = function(options = {}) {
    return Swal.fire({
        title: options.title || 'Bạn có chắc chắn?',
        text: options.text || 'Thao tác này sẽ không thể khôi phục lại!',
        icon: options.icon || 'warning',
        showCancelButton: true,
        background: '#18191c',
        color: '#f8fafc',
        confirmButtonColor: options.confirmButtonColor || '#ef4444',
        cancelButtonColor: options.cancelButtonColor || '#334155',
        confirmButtonText: options.confirmButtonText || '<i class="fa-solid fa-trash-can mr-1.5"></i> Đồng ý xoá',
        cancelButtonText: options.cancelButtonText || 'Huỷ bỏ',
        reverseButtons: true,
        focusCancel: true,
        customClass: {
            popup: 'rounded-2xl border border-slate-700/60 shadow-2xl shadow-black/80'
        }
    });
};
