@extends('layouts.admin')

@section('title', 'AI Tư Vấn Kiểu Tóc')
@section('page-title', 'AI Styling Assistant')
@section('page-description', 'Theo dõi lịch sử tư vấn, phân tích hình thái khuôn mặt và thống kê token AI.')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Trợ Lý AI</li>
@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 text-center">
                    <div class="avatar avatar-xl bg-light-primary text-primary mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                        <i class="bi bi-cpu fs-1"></i>
                    </div>
                    <h5 class="font-bold">Mô Hình AI Đang Chạy</h5>
                    <p class="text-muted small">Gemini 1.5 Pro / Vision Face Detection</p>
                    <span class="badge bg-success px-3 py-2 rounded-pill">Hoạt động ổn định</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 text-center">
                    <div class="avatar avatar-xl bg-light-warning text-warning mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                        <i class="bi bi-chat-heart fs-1"></i>
                    </div>
                    <h5 class="font-bold">Lượt Tư Vấn Tháng Này</h5>
                    <h3 class="font-extrabold text-primary mb-0">1,482</h3>
                    <p class="text-muted small mt-1">+18.5% so với tháng trước</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 text-center">
                    <div class="avatar avatar-xl bg-light-info text-info mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                        <i class="bi bi-shield-check fs-1"></i>
                    </div>
                    <h5 class="font-bold">Độ Hài Lòng Của Khách</h5>
                    <h3 class="font-extrabold text-success mb-0">96.8%</h3>
                    <p class="text-muted small mt-1">Dựa trên 850 lượt feedback</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header">
            <h5 class="card-title mb-0">Nhật Ký Phiên Tư Vấn Gần Nhất</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>PHIÊN TƯ VẤN</th>
                            <th>NGƯỜI DÙNG</th>
                            <th>DÁNG MẶT NHẬN DIỆN</th>
                            <th>MẪU TÓC GỢI Ý</th>
                            <th>THỜI GIAN</th>
                            <th>HÀNH ĐỘNG</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($conversations as $conv)
                        <tr>
                            <td class="font-bold">#{{ $conv->id }}</td>
                            <td>{{ $conv->user->name ?? 'Khách truy cập' }}</td>
                            <td>
                                <span class="badge bg-light-primary text-primary">Khuôn mặt tròn</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary me-1">Side Part 7/3</span>
                                <span class="badge bg-secondary">Pompadour</span>
                            </td>
                            <td>{{ $conv->created_at->diffForHumans() }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Xem kết quả</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                Chưa có phiên tư vấn nào gần đây
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
