@if (session('success'))
    <div class="alert alert-success alert-dismissible show fade mb-4 shadow-sm border-0 d-flex align-items-center">
        <i class="bi bi-check-circle-fill fs-4 me-2"></i>
        <div class="flex-grow-1">
            <strong>Thành công!</strong> {{ session('success') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible show fade mb-4 shadow-sm border-0 d-flex align-items-center">
        <i class="bi bi-exclamation-triangle-fill fs-4 me-2"></i>
        <div class="flex-grow-1">
            <strong>Lỗi!</strong> {{ session('error') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible show fade mb-4 shadow-sm border-0">
        <div class="d-flex align-items-center mb-2">
            <i class="bi bi-x-circle-fill fs-4 me-2"></i>
            <strong>Vui lòng kiểm tra lại thông tin:</strong>
        </div>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
