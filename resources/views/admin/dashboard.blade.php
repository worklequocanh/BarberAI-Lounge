@extends('layouts.admin')

@section('title', 'Bảng Điều Khiển Tổng Quan')
@section('page-title', 'Bảng Điều Khiển Tổng Quan')
@section('page-description', 'Theo dõi doanh thu, lịch hẹn cắt tóc và số liệu tư vấn kiểu tóc AI theo thời gian thực.')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('content')
<!-- Row 1: 4 Thẻ Thống Kê Chính -->
<div class="row">
    <div class="col-6 col-lg-3 col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body px-3 py-4-5">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="stats-icon green">
                            <i class="bi bi-cash-stack text-white fs-4"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-muted font-semibold mb-1">Doanh Thu Hôm Nay</h6>
                        <h4 class="font-extrabold mb-0 text-success">{{ number_format($revenueToday, 0, ',', '.') }}đ</h4>
                        <span class="text-xs text-muted">Tổng: {{ number_format($totalRevenue, 0, ',', '.') }}đ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3 col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body px-3 py-4-5">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="stats-icon blue">
                            <i class="bi bi-calendar-event-fill text-white fs-4"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-muted font-semibold mb-1">Lịch Hẹn Hôm Nay</h6>
                        <h4 class="font-extrabold mb-0 text-primary">{{ $todayAppointmentsCount }} Lịch</h4>
                        <span class="text-xs text-warning font-bold">{{ $pendingAppointmentsCount }} lịch chờ duyệt</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3 col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body px-3 py-4-5">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="stats-icon purple">
                            <i class="bi bi-person-badge-fill text-white fs-4"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-muted font-semibold mb-1">Thợ Hoạt Động</h6>
                        <h4 class="font-extrabold mb-0 text-purple">{{ $activeBarbersCount }} / {{ $totalBarbersCount }} Thợ</h4>
                        @if($barbersOnLeaveToday > 0)
                            <span class="text-xs text-danger font-bold"><i class="bi bi-person-x"></i> {{ $barbersOnLeaveToday }} thợ nghỉ phép hôm nay</span>
                        @else
                            <span class="text-xs text-success font-bold">100% đội ngũ sẵn sàng</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3 col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body px-3 py-4-5">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="stats-icon red">
                            <i class="bi bi-cpu-fill text-white fs-4"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-muted font-semibold mb-1">Lượt Tư Vấn AI</h6>
                        <h4 class="font-extrabold mb-0 text-danger">{{ $aiConversationsCount }} Lượt</h4>
                        <span class="text-xs text-info font-bold">Model Gemini Vision</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 2: Biểu Đồ & Dịch Vụ Nổi Bật -->
<div class="row mt-2">
    <div class="col-12 col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center pb-0">
                <div>
                    <h5 class="card-title mb-0">Biểu Đồ Lịch Hẹn & Hoạt Động Tuần Này</h5>
                    <p class="text-muted text-sm mb-0">Thống kê tự động từ hệ thống quản trị</p>
                </div>
                <span class="badge bg-light-primary text-primary px-3 py-2 rounded-pill font-bold">Tháng {{ date('m/Y') }}</span>
            </div>
            <div class="card-body">
                <div id="chart-revenue-booking" style="min-height: 315px;"></div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-header pb-0">
                <h5 class="card-title mb-0">Dịch Vụ Phổ Biến</h5>
                <p class="text-muted text-sm mb-0">Các gói dịch vụ được lựa chọn nhiều nhất</p>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush mt-2">
                    @forelse($popularServices as $svc)
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-md bg-light-primary text-primary me-3 d-flex align-items-center justify-content-center">
                                <i class="bi bi-scissors"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 font-bold">{{ $svc->name }}</h6>
                                <small class="text-muted">{{ $svc->duration_min }} phút • {{ $svc->category->name ?? 'Dịch vụ' }}</small>
                            </div>
                        </div>
                        <span class="font-extrabold text-primary">{{ number_format($svc->price, 0, ',', '.') }}đ</span>
                    </div>
                    @empty
                    <p class="text-muted text-center py-3">Chưa có dữ liệu dịch vụ</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 3: Bảng Lịch Hẹn Gần Nhất & Thợ Cắt Tóc -->
<div class="row mt-2">
    <!-- Cột trái: Lịch Hẹn Gần Đây -->
    <div class="col-12 col-xl-8">
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Lịch Hẹn Cắt Tóc Gần Nhất</h5>
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">Xem tất cả lịch hẹn</a>
            </div>
            <div class="card-body px-0 pt-0">
                <div class="table-responsive">
                    <table class="table table-hover table-lg mb-0 align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">MÃ ĐẶT</th>
                                <th>KHÁCH HÀNG</th>
                                <th>THỢ ĐẢM NHẬN</th>
                                <th>GIỜ HẸN</th>
                                <th>TỔNG TIỀN</th>
                                <th class="pe-4">TRẠNG THÁI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAppointments as $apt)
                            <tr>
                                <td class="ps-4 font-bold text-primary">#{{ $apt->code ?? ('APT-' . str_pad($apt->id, 5, '0', STR_PAD_LEFT)) }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2 bg-light-primary text-primary rounded-circle d-flex align-items-center justify-content-center" style="width:32px;height:32px;">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold mb-0">{{ $apt->customer->name ?? 'Khách lẻ' }}</p>
                                            <p class="text-muted text-xs mb-0">{{ $apt->customer->phone ?? '---' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $apt->barber->user->name ?? 'Stylist chỉ định' }}</td>
                                <td>
                                    <div>{{ \Carbon\Carbon::parse($apt->appointment_date)->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ $apt->start_time ?? '09:00' }}</small>
                                </td>
                                <td class="font-bold text-success">{{ number_format($apt->total_price, 0, ',', '.') }}đ</td>
                                <td class="pe-4">
                                    @if($apt->status === 'completed')
                                        <span class="badge bg-light-success text-success">Đã hoàn thành</span>
                                    @elseif($apt->status === 'confirmed')
                                        <span class="badge bg-light-primary text-primary">Đã xác nhận</span>
                                    @elseif($apt->status === 'cancelled')
                                        <span class="badge bg-light-danger text-danger">Đã huỷ</span>
                                    @else
                                        <span class="badge bg-light-warning text-warning">Chờ duyệt</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted ps-4">Chưa có lịch hẹn nào</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Cột phải: Top Barber -->
    <div class="col-12 col-xl-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header d-flex justify-content-between align-items-center pb-2">
                <h5 class="card-title mb-0">Thợ Cắt Tóc Tiêu Biểu</h5>
                <span class="badge bg-light-primary text-primary">Top Stylists</span>
            </div>
            <div class="card-body">
                @forelse($topBarbers as $barber)
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar avatar-lg me-3 bg-light-primary text-primary d-flex align-items-center justify-content-center rounded-circle" style="width:48px;height:48px;">
                        <i class="bi bi-scissors fs-4"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0 font-bold">{{ $barber->user->name ?? 'Stylist Salon' }}</h6>
                        <small class="text-muted">{{ $barber->title ?? 'Master Barber' }} ({{ $barber->experience_years }} năm KN)</small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-warning text-dark font-bold"><i class="bi bi-star-fill"></i> {{ number_format($barber->rating, 1) }}</span>
                    </div>
                </div>
                @empty
                <p class="text-muted text-center py-3">Chưa có dữ liệu thợ</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/vendors/apexcharts/apexcharts.js') }}"></script>
<script>
    var options = {
        series: [{
            name: 'Lịch Đặt Chỗ',
            data: [12, 18, 15, 25, 22, 30, 28]
        }, {
            name: 'Đã Cắt Xong',
            data: [10, 16, 14, 23, 20, 28, 27]
        }],
        chart: {
            height: 315,
            type: 'area',
            toolbar: { show: false }
        },
        colors: ['#435ebe', '#55c6e8'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        xaxis: {
            categories: ["T2", "T3", "T4", "T5", "T6", "T7", "CN"]
        },
        tooltip: { x: { format: 'dd/MM' } }
    };
    var chart = new ApexCharts(document.querySelector("#chart-revenue-booking"), options);
    chart.render();
</script>
@endpush
