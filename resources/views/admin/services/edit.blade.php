@extends('layouts.admin')

@section('title', 'Chỉnh Sửa Dịch Vụ')
@section('page-title', 'Chỉnh Sửa Dịch Vụ: ' . $service->name)
@section('page-description', 'Cập nhật lại giá tiền, thời gian hoặc mô tả dịch vụ salon.')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}">Dịch Vụ</a></li>
    <li class="breadcrumb-item active" aria-current="page">Chỉnh Sửa</li>
@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h5 class="card-title mb-0">Cập Nhật Thông Tin</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.services.update', $service->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label font-bold">Tên Dịch Vụ <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $service->name) }}" required>
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
                                        <option value="{{ $cat->id }}" {{ old('category_id', $service->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Thời Gian Thực Hiện (Phút) <span class="text-danger">*</span></label>
                                <input type="number" name="duration_min" class="form-control @error('duration_min') is-invalid @enderror" value="{{ old('duration_min', $service->duration_min) }}" min="5" max="300" required>
                                @error('duration_min')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Giá Bán / Khuyến Mãi (VNĐ) <span class="text-danger">*</span></label>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', (int)$service->price) }}" min="0" step="5000" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Giá Gốc Trước Giảm (VNĐ)</label>
                                <input type="number" name="original_price" class="form-control @error('original_price') is-invalid @enderror" value="{{ old('original_price', (int)$service->original_price) }}" min="0" step="5000">
                                <small class="text-muted">Dùng để hiển thị giảm giá cho gói Combo</small>
                            </div>
                        </div>

                        <div class="mb-3 form-check form-switch ps-5">
                            <input class="form-check-input" type="checkbox" name="is_combo" id="isComboSwitch" value="1" {{ old('is_combo', $service->is_combo) ? 'checked' : '' }}>
                            <label class="form-check-label font-bold text-warning" for="isComboSwitch">
                                <i class="bi bi-stars"></i> Đóng gói thành gói Combo Dịch Vụ (Cắt + Uốn + Gội...)
                            </label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-bold">Mô Tả Chi Tiết Quy Trình</label>
                            <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $service->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4 form-check form-switch ps-5">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitch" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label font-bold" for="isActiveSwitch">Kích hoạt dịch vụ này trên hệ thống đặt lịch</label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-outline-danger" onclick="if(confirm('Bạn có chắc chắn muốn xoá dịch vụ này không?')) document.getElementById('delete-form').submit();">
                                <i class="bi bi-trash"></i> Xoá Dịch Vụ
                            </button>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.services.index') }}" class="btn btn-light-secondary">Huỷ Bỏ</a>
                                <button type="submit" class="btn btn-primary px-4">Cập Nhật</button>
                            </div>
                        </div>
                    </form>

                    <form id="delete-form" action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
