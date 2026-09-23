@extends('layouts.admin')

@section('title', 'Quản Lý Lịch Hẹn')
@section('page-title', 'Danh Sách Lịch Hẹn Cắt Tóc')
@section('page-description', 'Theo dõi và quản lý lịch đặt cắt tóc của khách hàng theo thời gian thực.')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Lịch Hẹn</li>
@endsection

@section('content')
<section class="section">
    <!-- Thẻ đếm số lượng theo trạng thái -->
    <div class="row mb-4">
        <div class="col-12 col-md-3">
            <a href="{{ route('admin.appointments.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 {{ !$status ? 'border-primary border-2' : '' }}">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="stats-icon purple me-3">
                            <i class="bi bi-calendar-check-fill"></i>
                        </div>
                        <div>
                            <h6 class="text-muted font-semibold mb-0">Tất Cả Lịch</h6>
                            <h4 class="font-extrabold mb-0 text-dark">{{ $counts['total'] }}</h4>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-3">
            <a href="{{ route('admin.appointments.index', ['status' => 'pending']) }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 {{ $status === 'pending' ? 'border-warning border-2' : '' }}">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="stats-icon orange me-3">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div>
                            <h6 class="text-muted font-semibold mb-0">Chờ Xử Lý</h6>
                            <h4 class="font-extrabold mb-0 text-warning">{{ $counts['pending'] }}</h4>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-3">
            <a href="{{ route('admin.appointments.index', ['status' => 'confirmed']) }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 {{ $status === 'confirmed' ? 'border-info border-2' : '' }}">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="stats-icon blue me-3">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div>
                            <h6 class="text-muted font-semibold mb-0">Đã Xác Nhận</h6>
                            <h4 class="font-extrabold mb-0 text-info">{{ $counts['confirmed'] }}</h4>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-3">
            <a href="{{ route('admin.appointments.index', ['status' => 'completed']) }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 {{ $status === 'completed' ? 'border-success border-2' : '' }}">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="stats-icon green me-3">
                            <i class="bi bi-stars"></i>
                        </div>
                        <div>
                            <h6 class="text-muted font-semibold mb-0">Đã Hoàn Thành</h6>
                            <h4 class="font-extrabold mb-0 text-success">{{ $counts['completed'] }}</h4>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                Danh Sách Lịch Đặt Chỗ
                @if($status)
                    <span class="badge bg-secondary ms-2">Lọc: {{ ucfirst($status) }}</span>
                @endif
            </h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.appointments.timeline') }}" class="btn btn-outline-primary d-flex align-items-center gap-2">
                    <i class="bi bi-grid-3x3-gap-fill"></i> Matrix Timeline (Bản Đồ Giờ)
                </a>
                <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                    <i class="bi bi-plus-circle"></i> Tạo Lịch Hẹn Mới
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>MÃ LỊCH</th>
                            <th>KHÁCH HÀNG</th>
                            <th>BARBER</th>
                            <th>NGÀY & GIỜ</th>
                            <th>DỊCH VỤ</th>
                            <th>TỔNG TIỀN</th>
                            <th>TRẠNG THÁI</th>
                            <th>HÀNH ĐỘNG</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                        <tr>
                            <td class="font-bold text-primary">#{{ $appointment->code ?? ('APT-' . str_pad($appointment->id, 5, '0', STR_PAD_LEFT)) }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-md bg-light-primary text-primary me-2 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $appointment->customer->name ?? 'Khách vãng lai' }}</h6>
                                        <small class="text-muted">{{ $appointment->customer->phone ?? '---' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light-info text-info font-bold">
                                    <i class="bi bi-scissors me-1"></i> {{ $appointment->barber->user->name ?? 'Chưa chỉ định' }}
                                </span>
                            </td>
                            <td>
                                <div>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}</div>
                                <small class="text-primary font-bold">{{ $appointment->start_time ?? '09:00' }}</small>
                            </td>
                            <td>
                                @if($appointment->services && $appointment->services->count() > 0)
                                    @foreach($appointment->services->take(2) as $s)
                                        <span class="badge bg-secondary mb-1">{{ $s->name }}</span>
                                    @endforeach
                                    @if($appointment->services->count() > 2)
                                        <span class="badge bg-light-secondary text-secondary">+{{ $appointment->services->count() - 2 }}</span>
                                    @endif
                                @else
                                    <span class="badge bg-light-secondary text-secondary">Cắt tóc tiêu chuẩn</span>
                                @endif
                            </td>
                            <td class="font-extrabold text-success">
                                {{ number_format($appointment->total_price, 0, ',', '.') }} đ
                            </td>
                            <td>
                                @if($appointment->status === 'completed')
                                    <span class="badge bg-success">Hoàn thành</span>
                                @elseif($appointment->status === 'confirmed')
                                    <span class="badge bg-primary">Đã xác nhận</span>
                                @elseif($appointment->status === 'cancelled')
                                    <span class="badge bg-danger">Đã huỷ</span>
                                @else
                                    <span class="badge bg-warning">Chờ xử lý</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.appointments.edit', $appointment->id) }}" class="btn btn-sm btn-outline-primary" title="Sửa & Cập nhật">
                                        <i class="bi bi-pencil"></i> Sửa
                                    </a>
                                    <form action="{{ route('admin.appointments.destroy', $appointment->id) }}" method="POST" data-confirm="Bạn có chắc muốn xoá lịch hẹn #{{ $appointment->code }}?" class="d-inline form-delete">
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
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
                                Không tìm thấy lịch hẹn nào
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                {{ $appointments->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
