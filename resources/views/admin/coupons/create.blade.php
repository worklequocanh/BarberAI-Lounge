@extends('layouts.admin')

@section('title', 'Tạo Mã Giảm Giá Mới')
@section('page-title', 'Tạo Voucher Khuyến Mãi')
@section('page-description', 'Phát hành mã ưu đãi giảm giá theo phần trăm hoặc số tiền cố định cho khách hàng.')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.coupons.index') }}">Khuyến Mãi</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tạo Mới</li>
@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thông Tin Mã Ưu Đãi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.coupons.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label font-bold">Mã Voucher (Code) <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control text-uppercase font-bold @error('code') is-invalid @enderror" value="{{ old('code') }}" placeholder="VD: BARBERAI20, HELLO2026..." required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Hình Thức Giảm <span class="text-danger">*</span></label>
                                <select name="discount_type" class="form-select font-bold">
                                    <option value="percent" {{ old('discount_type') == 'percent' ? 'selected' : '' }}>Giảm theo phần trăm (%)</option>
                                    <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Giảm số tiền cố định (VNĐ)</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Mức Giảm Giá <span class="text-danger">*</span></label>
                                <input type="number" name="discount_value" class="form-control @error('discount_value') is-invalid @enderror" value="{{ old('discount_value', 20) }}" min="1" required>
                                @error('discount_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Đơn Tối Thiểu (VNĐ)</label>
                                <input type="number" name="min_order_amount" class="form-control" value="{{ old('min_order_amount', 100000) }}" min="0">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Giới Hạn Lượt Dùng</label>
                                <input type="number" name="usage_limit" class="form-control" value="{{ old('usage_limit', 100) }}" min="1">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Ngày Bắt Đầu</label>
                                <input type="date" name="starts_at" class="form-control" value="{{ date('Y-m-d') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Ngày Hết Hạn</label>
                                <input type="date" name="expires_at" class="form-control" value="{{ date('Y-m-d', strtotime('+30 days')) }}">
                            </div>
                        </div>

                        <div class="mb-4 form-check form-switch ps-5">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitch" value="1" checked>
                            <label class="form-check-label font-bold" for="isActiveSwitch">Kích hoạt mã này ngay sau khi tạo</label>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.coupons.index') }}" class="btn btn-light-secondary">Huỷ Bỏ</a>
                            <button type="submit" class="btn btn-primary px-4">Tạo Mã Giảm Giá</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
