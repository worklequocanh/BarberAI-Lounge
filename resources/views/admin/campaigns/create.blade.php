@extends('layouts.admin')

@section('title', 'Tạo Chiến Dịch Email Marketing')
@section('page-title', 'Soạn Thảo Chiến Dịch Email')
@section('page-description', 'Thiết lập nội dung chăm sóc khách hàng, tặng mã giảm giá và chọn tệp đối tượng.')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.campaigns.index') }}">Campaigns</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tạo Mới</li>
@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h5 class="card-title mb-0">Nội Dung Chiến Dịch</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.campaigns.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label font-bold">Tên Chiến Dịch (Nội bộ) <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="VD: Chiến Dịch Tri Ân Khách Tháng 10, Nhắc Hẹn 30 Ngày..." required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-bold">Tiêu Đề Email (Subject khách hàng nhìn thấy) <span class="text-danger">*</span></label>
                            <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}" placeholder="VD: [BarberAI] Tặng bạn voucher giảm 20% cho lần cắt tiếp theo!" required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Tệp Khách Hàng Mục Tiêu <span class="text-danger">*</span></label>
                                <select name="target_audience" class="form-select @error('target_audience') is-invalid @enderror" required>
                                    <option value="all_customers" {{ old('target_audience') == 'all_customers' ? 'selected' : '' }}>Toàn bộ khách hàng đã đăng ký</option>
                                    <option value="inactive_30d" {{ old('target_audience') == 'inactive_30d' ? 'selected' : '' }}>Khách > 30 ngày chưa quay lại cắt tóc</option>
                                    <option value="vip_customers" {{ old('target_audience') == 'vip_customers' ? 'selected' : '' }}>Khách hàng VIP (Tổng chi tiêu > 1.000.000đ)</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Mã Giảm Giá Đính Kèm (Coupon)</label>
                                <input type="text" name="coupon_code" class="form-control text-uppercase @error('coupon_code') is-invalid @enderror" value="{{ old('coupon_code') }}" placeholder="VD: TRIAN20, COMEBACK">
                                <small class="text-muted">Nhập mã voucher đã tạo trong mục Coupons</small>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label font-bold">Nội Dung Thư (Email Body) <span class="text-danger">*</span></label>
                            <textarea name="content" rows="8" class="form-control @error('content') is-invalid @enderror" placeholder="Xin chào quý khách, đã gần một tháng trôi qua kể từ lần gần nhất bạn ghé BarberAI Lounge..." required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.campaigns.index') }}" class="btn btn-light-secondary">Huỷ Bỏ</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-1"></i> Lưu Chiến Dịch
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h5 class="card-title mb-0">Mẹo Marketing Salon</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-light-warning mb-3">
                        <i class="bi bi-lightbulb-fill text-warning me-1"></i>
                        <strong>Chu kỳ cắt tóc nam:</strong> Thông thường từ 21 - 30 ngày tóc nam sẽ mất form. Nhắm tệp <em>"inactive_30d"</em> kèm voucher 15-20% sẽ mang lại tỷ lệ quay lại cao nhất!
                    </div>
                    <p class="text-muted small mb-0">
                        Chiến dịch sau khi tạo sẽ ở trạng thái <strong>Bản nháp</strong>. Bạn có thể kiểm tra lại thông tin trước khi nhấn nút "Bắn Email" để gửi tới toàn bộ hòm thư của khách hàng.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
