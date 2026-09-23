@extends('layouts.admin')

@section('title', 'Quản Lý Thợ Cắt Tóc')
@section('page-title', 'Danh Sách Stylist & Barber')
@section('page-description', 'Quản lý thông tin thợ, tay nghề, số năm kinh nghiệm và trạng thái hoạt động.')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Thợ Cắt Tóc</li>
@endsection

@section('content')
<section class="section">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Đội Ngũ Stylist Của Salon</h5>
            <a href="{{ route('admin.barbers.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-person-plus-fill"></i> Thêm Thợ Mới
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>BARBER</th>
                            <th>KINH NGHIỆM</th>
                            <th>ĐÁNH GIÁ</th>
                            <th>LƯỢT ĐÁNH GIÁ</th>
                            <th>TRẠNG THÁI</th>
                            <th>HÀNH ĐỘNG</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barbers as $barber)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-lg bg-light-primary text-primary me-3 font-bold d-flex align-items-center justify-content-center rounded-circle" style="width:45px;height:45px;">
                                        <i class="bi bi-scissors fs-5"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 font-bold">{{ $barber->user->name ?? 'Stylist' }}</h6>
                                        <small class="text-muted">{{ $barber->user->phone ?? $barber->user->email ?? '---' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <strong>{{ $barber->experience_years }} năm</strong> kinh nghiệm
                            </td>
                            <td>
                                <span class="text-warning font-bold">
                                    <i class="bi bi-star-fill"></i> {{ number_format($barber->rating_avg, 1) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-light-secondary text-secondary">{{ $barber->total_reviews }} nhận xét</span>
                            </td>
                            <td>
                                @if($barber->is_available)
                                    <span class="badge bg-success">Đang sẵn sàng</span>
                                @else
                                    <span class="badge bg-secondary">Tạm nghỉ</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.barbers.edit', $barber->id) }}" class="btn btn-sm btn-outline-primary" title="Sửa thông tin">
                                        <i class="bi bi-pencil"></i> Sửa
                                    </a>
                                    <form action="{{ route('admin.barbers.destroy', $barber->id) }}" method="POST" data-confirm="Bạn có chắc muốn xoá hồ sơ stylist {{ $barber->user->name ?? '' }}?" class="d-inline form-delete">
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
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-1 d-block mb-2"></i>
                                Chưa có thợ cắt tóc nào
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                {{ $barbers->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
