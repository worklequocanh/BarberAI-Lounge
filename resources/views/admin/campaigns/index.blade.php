@extends('layouts.admin')

@section('title', 'Email Marketing & Chăm Sóc Khách Hàng')
@section('page-title', 'Chiến Dịch Email Marketing')
@section('page-description', 'Gửi ưu đãi chăm sóc lại khách lâu chưa cắt, voucher tri ân và nhắc hẹn tự động.')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Marketing Campaigns</li>
@endsection

@section('content')
<section class="section">
    <!-- Stat Cards -->
    <div class="row mb-4">
        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="stats-icon purple me-3">
                        <i class="bi bi-envelope-paper-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted font-semibold mb-0">Tổng Chiến Dịch</h6>
                        <h4 class="font-extrabold mb-0 text-dark">{{ $campaigns->total() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="stats-icon green me-3">
                        <i class="bi bi-send-check-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted font-semibold mb-0">Email Đã Gửi Ra</h6>
                        <h4 class="font-extrabold mb-0 text-success">{{ number_format($totalSent, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="stats-icon blue me-3">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted font-semibold mb-0">Tệp Khách Khả Dụng</h6>
                        <h4 class="font-extrabold mb-0 text-primary">{{ $customerAudienceCount }} Khách</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Campaigns List -->
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Danh Sách Chiến Dịch Email</h5>
            <a href="{{ route('admin.campaigns.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-plus-circle"></i> Soạn Chiến Dịch Mới
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>TÊN CHIẾN DỊCH / TIÊU ĐỀ MAIL</th>
                            <th>NHÓM ĐỐI TƯỢNG (AUDIENCE)</th>
                            <th>COUPON ĐÍNH KÈM</th>
                            <th>SỐ LƯỢNG GỬI</th>
                            <th>TRẠNG THÁI</th>
                            <th>HÀNH ĐỘNG</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($campaigns as $camp)
                        <tr>
                            <td>
                                <div class="font-bold fs-6">{{ $camp->title }}</div>
                                <small class="text-muted"><i class="bi bi-envelope me-1"></i> {{ $camp->subject }}</small>
                            </td>
                            <td>
                                @if($camp->target_audience === 'inactive_30d')
                                    <span class="badge bg-light-warning text-warning font-bold">Khách > 30 ngày chưa cắt</span>
                                @elseif($camp->target_audience === 'vip_customers')
                                    <span class="badge bg-light-danger text-danger font-bold">Khách VIP thân thiết</span>
                                @else
                                    <span class="badge bg-light-info text-info font-bold">Toàn bộ khách hàng</span>
                                @endif
                            </td>
                            <td>
                                @if($camp->coupon_code)
                                    <span class="badge bg-warning text-dark font-monospace fs-6">{{ $camp->coupon_code }}</span>
                                @else
                                    <span class="text-muted small">Không kèm</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $camp->sent_count }}</strong> emails
                                @if($camp->sent_at)
                                    <small class="text-muted d-block">{{ $camp->sent_at->format('d/m/Y H:i') }}</small>
                                @endif
                            </td>
                            <td>
                                @if($camp->status === 'sent')
                                    <span class="badge bg-success"><i class="bi bi-check-all"></i> Đã gửi</span>
                                @else
                                    <span class="badge bg-secondary">Bản nháp</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    @if($camp->status !== 'sent')
                                    <form action="{{ route('admin.campaigns.send', $camp->id) }}" method="POST" class="d-inline" data-confirm="Bắn chiến dịch email '{{ $camp->title }}' ngay bây giờ?">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="bi bi-send-fill me-1"></i> Bắn Email
                                        </button>
                                    </form>
                                    @endif
                                    <form action="{{ route('admin.campaigns.destroy', $camp->id) }}" method="POST" data-confirm="Xoá chiến dịch '{{ $camp->title }}'?" class="d-inline form-delete ms-1">
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
                                <i class="bi bi-envelope-x fs-1 d-block mb-2"></i>
                                Chưa có chiến dịch email nào
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                {{ $campaigns->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
