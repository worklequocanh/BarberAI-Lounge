@extends('layouts.admin')

@section('title', 'Quản Lý Dịch Vụ Salon')
@section('page-title', 'Bảng Giá & Dịch Vụ')
@section('page-description', 'Danh mục các dịch vụ cắt, uốn, nhuộm, chăm sóc tóc và giá niêm yết.')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Dịch Vụ</li>
@endsection

@section('content')
<section class="section">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Tất Cả Dịch Vụ Tại Tiệm</h5>
            <a href="{{ route('admin.services.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i> Thêm Dịch Vụ Mới
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>TÊN DỊCH VỤ</th>
                            <th>DANH MỤC</th>
                            <th>THỜI GIAN THỰC HIỆN</th>
                            <th>GIÁ NIÊM YẾT</th>
                            <th>TRẠNG THÁI</th>
                            <th>HÀNH ĐỘNG</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $service)
                        <tr>
                            <td>
                                <div class="font-bold fs-6">{{ $service->name }}</div>
                                <small class="text-muted">{{ Str::limit($service->description, 60) }}</small>
                            </td>
                            <td>
                                <span class="badge bg-light-primary text-primary font-bold">
                                    {{ $service->category->name ?? 'Dịch Vụ Chung' }}
                                </span>
                            </td>
                            <td>
                                <i class="bi bi-stopwatch text-muted me-1"></i> {{ $service->duration_min ?? 30 }} phút
                            </td>
                            <td class="font-extrabold text-primary">
                                {{ number_format($service->price, 0, ',', '.') }} đ
                            </td>
                            <td>
                                @if($service->is_active ?? true)
                                    <span class="badge bg-success">Đang phục vụ</span>
                                @else
                                    <span class="badge bg-secondary">Tạm ngừng</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-outline-primary" title="Chỉnh sửa">
                                        <i class="bi bi-pencil"></i> Sửa
                                    </a>
                                    <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xoá dịch vụ {{ $service->name }}?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Xoá">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                Chưa có dịch vụ nào
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                {{ $services->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
