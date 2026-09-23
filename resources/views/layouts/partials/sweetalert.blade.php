<script>
    // =========================================================================
    // SWEETALERT2 GLOBAL CONFIGURATION & INTEGRATION
    // =========================================================================

    // 1. Toast Notification Helper
    window.Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    // 2. Global Confirm Helper
    window.confirmAction = function(options = {}) {
        return Swal.fire({
            title: options.title || 'Bạn có chắc chắn?',
            text: options.text || 'Hành động này sẽ không thể hoàn tác!',
            icon: options.icon || 'warning',
            showCancelButton: true,
            confirmButtonColor: options.confirmButtonColor || '#dc3545',
            cancelButtonColor: options.cancelButtonColor || '#6c757d',
            confirmButtonText: options.confirmButtonText || '<i class="bi bi-trash"></i> Đồng ý xoá',
            cancelButtonText: options.cancelButtonText || 'Huỷ bỏ',
            reverseButtons: true,
            focusCancel: true
        });
    };

    document.addEventListener('DOMContentLoaded', function () {
        // 3. Flash Notifications from Laravel Session
        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: 'Thành công!',
                text: "{{ session('success') }}"
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Thất bại!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#435ebe',
                confirmButtonText: 'Đã hiểu'
            });
        @endif

        @if ($errors->any())
            let errorList = '<ul style="text-align: left; padding-left: 20px; margin-bottom: 0;">';
            @foreach ($errors->all() as $error)
                errorList += '<li>{{ addslashes($error) }}</li>';
            @endforeach
            errorList += '</ul>';

            Swal.fire({
                icon: 'error',
                title: 'Vui lòng kiểm tra lại thông tin!',
                html: errorList,
                confirmButtonColor: '#435ebe',
                confirmButtonText: 'Đồng ý'
            });
        @endif

        // 4. Global Interceptor for Delete / Confirmation Forms
        document.addEventListener('submit', function (e) {
            const form = e.target;
            const isDeleteMethod = form.querySelector('input[name="_method"][value="DELETE"]');
            const hasDataConfirm = form.hasAttribute('data-confirm');
            const isDeleteClass = form.classList.contains('form-delete');

            if (isDeleteMethod || hasDataConfirm || isDeleteClass) {
                if (form.dataset.swalConfirmed === 'true') {
                    return; // Đã xác nhận qua SweetAlert, cho phép gửi form
                }

                e.preventDefault();
                const confirmMsg = form.getAttribute('data-confirm') || 'Dữ liệu bị xoá sẽ không thể khôi phục lại!';

                Swal.fire({
                    title: 'Xác nhận xoá?',
                    text: confirmMsg,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="bi bi-trash"></i> Đồng ý xoá',
                    cancelButtonText: 'Huỷ bỏ',
                    reverseButtons: true,
                    focusCancel: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.dataset.swalConfirmed = 'true';
                        form.submit();
                    }
                });
            }
        });
    });
</script>
