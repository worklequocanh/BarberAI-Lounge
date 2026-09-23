@extends('layouts.admin')

@section('title', 'Thêm Dịch Vụ Mới')
@section('page-title', 'Thêm Dịch Vụ Salon')
@section('page-description', 'Tạo gói dịch vụ cắt, uốn, nhuộm hoặc chăm sóc tóc mới cho tiệm.')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}">Dịch Vụ</a></li>
    <li class="breadcrumb-item active" aria-current="page">Thêm Mới</li>
@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thông Tin Dịch Vụ</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.services.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label font-bold">Tên Dịch Vụ <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="VD: Uốn Con Sâu 2026, Cắt Fade Nghệ Thuật..." required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Danh Mục Dịch Vụ</label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                    <option value="">-- Chọn danh mục --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Thời Gian Thực Hiện (Phút) <span class="text-danger">*</span></label>
                                <input type="number" name="duration_min" class="form-control @error('duration_min') is-invalid @enderror" value="{{ old('duration_min', 30) }}" min="5" max="300" required>
                                @error('duration_min')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Giá Bán / Khuyến Mãi (VNĐ) <span class="text-danger">*</span></label>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', 150000) }}" min="0" step="5000" placeholder="150000" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Giá Gốc Trước Giảm (VNĐ)</label>
                                <input type="number" name="original_price" class="form-control @error('original_price') is-invalid @enderror" value="{{ old('original_price') }}" min="0" step="5000" placeholder="VD: 350000 (Dành cho gói Combo)">
                                <small class="text-muted">Để trống nếu không có giá so sánh</small>
                            </div>
                        </div>

                        <div class="mb-3 form-check form-switch ps-5">
                            <input class="form-check-input" type="checkbox" name="is_combo" id="isComboSwitch" value="1" {{ old('is_combo') ? 'checked' : '' }}>
                            <label class="form-check-label font-bold text-warning" for="isComboSwitch">
                                <i class="bi bi-stars"></i> Đóng gói thành gói Combo Dịch Vụ (Cắt + Uốn + Gội...)
                            </label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-bold">Mô Tả Chi Tiết Quy Trình</label>
                            <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" placeholder="Mô tả các bước thực hiện, công nghệ uốn, dưỡng chất sử dụng...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4 form-check form-switch ps-5">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitch" value="1" checked>
                            <label class="form-check-label font-bold" for="isActiveSwitch">Kích hoạt dịch vụ này trên hệ thống đặt lịch</label>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.services.index') }}" class="btn btn-light-secondary">Huỷ Bỏ</a>
                            <button type="submit" class="btn btn-primary px-4">Lưu Dịch Vụ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h5 class="card-title mb-0">Mẹo Thiết Lập</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small">Thời gian thực hiện chính xác giúp thuật toán đặt lịch tự động tránh bị trùng lịch hoặc quá tải cho các Stylist.</p>
                    <div class="alert alert-light-primary mb-0">
                        <i class="bi bi-lightbulb me-1"></i> Giá dịch vụ sẽ được dùng để tự động tính tổng tiền khi khách chọn nhiều dịch vụ cùng lúc.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
