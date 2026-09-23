<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Flash Notifications from Laravel Session
        @if (session('success'))
            if (window.Toast) {
                Toast.fire({
                    icon: 'success',
                    title: '{{ session('success') }}'
                });
            }
        @endif

        @if (session('error'))
            if (window.Swal) {
                 Swal.fire({
                     icon: 'error',
                     title: 'Thông Báo Lỗi',
                     text: "{{ session('error') }}",
                     background: '#1E293B',
                     color: '#F8FAFC',
                     confirmButtonColor: '#6366F1',
                     confirmButtonText: 'Đã hiểu',
                     customClass: {
                         popup: 'rounded-2xl border border-[#334155] shadow-2xl'
                     }
                 });
             }
         @endif

         @if ($errors->any())
             let errorList = '<ul class="text-left text-sm space-y-1 list-disc pl-5 mt-2">';
             @foreach ($errors->all() as $error)
                 errorList += '<li>{{ addslashes($error) }}</li>';
             @endforeach
             errorList += '</ul>';

             if (window.Swal) {
                 Swal.fire({
                     icon: 'error',
                     title: 'Vui lòng kiểm tra lại thông tin',
                     html: errorList,
                     background: '#1E293B',
                     color: '#F8FAFC',
                     confirmButtonColor: '#6366F1',
                     confirmButtonText: 'Xác nhận',
                     customClass: {
                         popup: 'rounded-2xl border border-[#334155] shadow-2xl'
                     }
                 });
             }
         @endif

         // Global Interceptor for Delete / Confirmation Forms
         document.addEventListener('submit', function (e) {
             const form = e.target;
             const isDeleteMethod = form.querySelector('input[name="_method"][value="DELETE"]');
             const hasDataConfirm = form.hasAttribute('data-confirm');
             const isDeleteClass = form.classList.contains('form-delete');

             if (isDeleteMethod || hasDataConfirm || isDeleteClass) {
                 if (form.dataset.swalConfirmed === 'true') {
                     return;
                 }

                 e.preventDefault();
                 const confirmMsg = form.getAttribute('data-confirm') || 'Dữ liệu bị xoá sẽ không thể khôi phục lại!';

                 if (window.Swal) {
                     Swal.fire({
                         title: 'Xác nhận thao tác?',
                         text: confirmMsg,
                         icon: 'warning',
                         showCancelButton: true,
                         background: '#1E293B',
                         color: '#F8FAFC',
                         confirmButtonColor: '#F43F5E',
                         cancelButtonColor: '#334155',
                         confirmButtonText: '<i class="fa-solid fa-trash-can mr-1"></i> Đồng ý xoá',
                         cancelButtonText: 'Huỷ bỏ',
                         reverseButtons: true,
                         focusCancel: true,
                         customClass: {
                             popup: 'rounded-2xl border border-[#334155] shadow-2xl'
                         }
                     }).then((result) => {
                        if (result.isConfirmed) {
                            form.dataset.swalConfirmed = 'true';
                            form.submit();
                        }
                    });
                } else if (confirm(confirmMsg)) {
                    form.submit();
                }
            }
        });
    });
</script>
