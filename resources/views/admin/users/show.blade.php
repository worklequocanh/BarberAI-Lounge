@extends('layouts.admin')

@section('title', 'Hồ Sơ Khách Hàng 360° - ' . $user->name)
@section('page-title', 'Hồ Sơ Khách Hàng 360°')
@section('page-description', 'Toàn bộ lịch sử cắt tóc, thói quen kỹ thuật, Stylist quen thuộc và giá trị trọn đời (LTV).')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Khách Hàng</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
@endsection

@section('content')
<section class="section">
    <!-- Row 1: Profile Summary Card & Key Stats -->
    <div class="row">
        <!-- Customer Info Card -->
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body text-center p-4">
                    <div class="avatar avatar-2xl bg-light-primary text-primary mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px; font-size: 2.5rem;">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <h4 class="mb-1 font-bold">{{ $user->name }}</h4>
                    <p class="text-muted mb-2">
                        @if($user->role && ($user->role->slug === 'admin' || str_contains(strtolower($user->role->name), 'admin')))
                            <span class="badge bg-danger">Quản Trị Viên</span>
                        @elseif($user->role && ($user->role->slug === 'barber' || str_contains(strtolower($user->role->name), 'barber')))
                            <span class="badge bg-primary">Stylist / Barber</span>
                        @else
                            <span class="badge bg-light-primary text-primary">Khách Hàng Thành Viên</span>
                        @endif
                    </p>

                    <div class="d-flex justify-content-center gap-2 mb-4">
                        <a href="tel:{{ $user->phone }}" class="btn btn-sm btn-outline-primary {{ empty($user->phone) ? 'disabled' : '' }}">
                            <i class="bi bi-telephone-fill me-1"></i> Gọi Điện
                        </a>
                        <a href="mailto:{{ $user->email }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-envelope-fill me-1"></i> Gửi Mail
                        </a>
                    </div>

                    <ul class="list-group list-group-flush text-start border-top">
                        <li class="list-group-item d-flex justify-content-between px-0 py-2">
                            <span class="text-muted"><i class="bi bi-phone me-1"></i> Điện thoại:</span>
                            <strong>{{ $user->phone ?? 'Chưa cập nhật' }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2">
                            <span class="text-muted"><i class="bi bi-envelope me-1"></i> Email:</span>
                            <span class="text-truncate" style="max-width: 180px;">{{ $user->email }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2">
                            <span class="text-muted"><i class="bi bi-gender-ambiguous me-1"></i> Giới tính:</span>
                            <strong>{{ $user->gender === 'female' ? 'Nữ' : ($user->gender === 'male' ? 'Nam' : 'Khác') }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2">
                            <span class="text-muted"><i class="bi bi-calendar3 me-1"></i> Ngày gia nhập:</span>
                            <span>{{ $user->created_at ? $user->created_at->format('d/m/Y') : '---' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Stylist "Ruột" -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-transparent pb-0">
                    <h6 class="font-bold mb-0"><i class="bi bi-heart-fill text-danger me-2"></i>Stylist Thân Thiết ("Ruột")</h6>
                </div>
                <div class="card-body">
                    @if($favoriteBarber)
                        <div class="d-flex align-items-center mt-2">
                            <div class="avatar avatar-lg bg-light-primary text-primary me-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px;">
                                <i class="bi bi-scissors fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 font-bold">{{ $favoriteBarber->user->name ?? 'Stylist' }}</h6>
                                <small class="text-muted">{{ $favoriteBarber->title ?? 'Master Barber' }} ({{ $favoriteBarber->experience_years }} năm KN)</small>
                            </div>
                        </div>
                    @else
                        <p class="text-muted small mb-0 mt-2">Chưa xác định thợ ruột (chưa có đủ lượt đặt)</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Lifetime Value & KPI + Hair Notes + History -->
        <div class="col-12 col-lg-8">
            <!-- 3 Mini Metric Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body p-3">
                            <div class="text-muted small font-bold mb-1">TỔNG CHI TIÊU (LTV)</div>
                            <h3 class="font-extrabold text-success mb-0">{{ number_format($totalSpent, 0, ',', '.') }}đ</h3>
                            <small class="text-muted">Doanh thu từ các lần cắt</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body p-3">
                            <div class="text-muted small font-bold mb-1">LẦN CẮT HOÀN THÀNH</div>
                            <h3 class="font-extrabold text-primary mb-0">{{ $completedCount }} lần</h3>
                            <small class="text-muted">Tổng {{ $appointments->count() }} lịch hẹn</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body p-3">
                            <div class="text-muted small font-bold mb-1">CHI TIÊU TB / LẦN</div>
                            @php
                                $avgTicket = $completedCount > 0 ? round($totalSpent / $completedCount) : 0;
                            @endphp
                            <h3 class="font-extrabold text-info mb-0">{{ number_format($avgTicket, 0, ',', '.') }}đ</h3>
                            <small class="text-muted">Ticket size trung bình</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ghi Chú Kỹ Thuật Tóc (Hair Technical Profile) -->
            <div class="card shadow-sm border-0 mb-4 border-start border-primary border-4">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 text-primary">
                        <i class="bi bi-journal-medical me-2"></i>Sổ Tay Kỹ Thuật Tóc (Hair Technical Profile)
                    </h5>
                    <span class="badge bg-light-primary text-primary">{{ $hairNotes->count() }} ghi chú</span>
                </div>
                <div class="card-body">
                    @if($hairNotes->isNotEmpty())
                        <div class="timeline">
                            @foreach($hairNotes as $note)
                                <div class="p-3 mb-2 rounded bg-light border">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="font-bold text-dark">
                                            <i class="bi bi-clock-history me-1"></i> {{ \Carbon\Carbon::parse($note->appointment_date)->format('d/m/Y') }}
                                            (Stylist: {{ $note->barber->user->name ?? 'Salon' }})
                                        </span>
                                        <span class="badge bg-secondary">#{{ $note->code }}</span>
                                    </div>
                                    <p class="mb-0 text-dark font-normal fst-italic">"{{ $note->hair_notes }}"</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">Chưa có ghi chú kỹ thuật nào về chất tóc, dáng đầu hoặc thói quen vuốt sáp của khách hàng này.</p>
                    @endif
                </div>
            </div>

            <!-- Lịch Sử Cuộc Hẹn -->
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Lịch Sử Sử Dụng Dịch Vụ</h5>
                    <a href="{{ route('admin.appointments.create', ['customer_name' => $user->name, 'customer_phone' => $user->phone]) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus"></i> Đặt Lịch Cho Khách Này
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">MÃ ĐƠN</th>
                                    <th>NGÀY HẸN</th>
                                    <th>STYLIST</th>
                                    <th>DỊCH VỤ ĐÃ LÀM</th>
                                    <th>TỔNG TIỀN</th>
                                    <th>TRẠNG THÁI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($appointments as $apt)
                                <tr>
                                    <td class="ps-3 font-bold text-primary">
                                        <a href="{{ route('admin.appointments.edit', $apt->id) }}" class="text-decoration-none">
                                            #{{ $apt->code }}
                                        </a>
                                    </td>
                                    <td>
                                        <div>{{ \Carbon\Carbon::parse($apt->appointment_date)->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $apt->start_time }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light-info text-info font-bold">
                                            {{ $apt->barber->user->name ?? 'Chưa chỉ định' }}
                                        </span>
                                    </td>
                                    <td>
                                        @foreach($apt->services as $s)
                                            <span class="badge bg-secondary me-1">{{ $s->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="font-bold text-success">{{ number_format($apt->total_price, 0, ',', '.') }}đ</td>
                                    <td>
                                        @if($apt->status === 'completed')
                                            <span class="badge bg-success">Hoàn thành</span>
                                        @elseif($apt->status === 'confirmed')
                                            <span class="badge bg-primary">Đã xác nhận</span>
                                        @elseif($apt->status === 'cancelled')
                                            <span class="badge bg-danger">Đã huỷ</span>
                                        @else
                                            <span class="badge bg-warning">Chờ duyệt</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Khách hàng chưa có cuộc hẹn nào</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
