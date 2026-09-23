@extends('layouts.admin')

@section('title', 'Chỉnh Sửa Mã Giảm Giá')
@section('page-title', 'Chỉnh Sửa Voucher: ' . $coupon->code)
@section('page-description', 'Cập nhật lại tỷ lệ giảm giá, hạn sử dụng hoặc kích hoạt/vô hiệu hoá voucher.')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.coupons.index') }}">Khuyến Mãi</a></li>
    <li class="breadcrumb-item active" aria-current="page">Chỉnh Sửa</li>
@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h5 class="card-title mb-0">Cập Nhật Mã Ưu Đãi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label font-bold">Mã Voucher (Code) <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control text-uppercase font-bold @error('code') is-invalid @enderror" value="{{ old('code', $coupon->code) }}" required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Hình Thức Giảm <span class="text-danger">*</span></label>
                                <select name="discount_type" class="form-select font-bold">
                                    <option value="percent" {{ old('discount_type', $coupon->discount_type) == 'percent' ? 'selected' : '' }}>Giảm theo phần trăm (%)</option>
                                    <option value="fixed" {{ old('discount_type', $coupon->discount_type) == 'fixed' ? 'selected' : '' }}>Giảm số tiền cố định (VNĐ)</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Mức Giảm Giá <span class="text-danger">*</span></label>
                                <input type="number" name="discount_value" class="form-control @error('discount_value') is-invalid @enderror" value="{{ old('discount_value', (int)$coupon->discount_value) }}" min="1" required>
                                @error('discount_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Đơn Tối Thiểu (VNĐ)</label>
                                <input type="number" name="min_order_amount" class="form-control" value="{{ old('min_order_amount', (int)$coupon->min_order_amount) }}" min="0">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Giới Hạn Lượt Dùng</label>
                                <input type="number" name="usage_limit" class="form-control" value="{{ old('usage_limit', $coupon->usage_limit) }}" min="1">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Ngày Hết Hạn</label>
                                <input type="date" name="expires_at" class="form-control" value="{{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('Y-m-d') : '' }}">
                            </div>
                        </div>

                        <div class="mb-4 form-check form-switch ps-5">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitch" value="1" {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label font-bold" for="isActiveSwitch">Kích hoạt mã khuyến mãi này</label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-outline-danger" onclick="confirmAction({text: 'Bạn có chắc muốn xoá mã voucher {{ $coupon->code }}?'}).then(r => { if(r.isConfirmed) document.getElementById('del-coupon-form').submit(); });">
                                <i class="bi bi-trash"></i> Xoá Mã
                            </button>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.coupons.index') }}" class="btn btn-light-secondary">Huỷ Bỏ</a>
                                <button type="submit" class="btn btn-primary px-4">Lưu Cập Nhật</button>
                            </div>
                        </div>
                    </form>

                    <form id="del-coupon-form" action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
