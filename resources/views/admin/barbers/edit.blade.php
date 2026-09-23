@extends('layouts.admin')

@section('title', 'Chỉnh Sửa Stylist')
@section('page-title', 'Chỉnh Sửa Stylist: ' . ($barber->user->name ?? 'Barber'))
@section('page-description', 'Cập nhật thông tin nhân sự, số năm kinh nghiệm và trạng thái trực salon.')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.barbers.index') }}">Thợ Cắt Tóc</a></li>
    <li class="breadcrumb-item active" aria-current="page">Chỉnh Sửa</li>
@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thông Tin Cá Nhân & Chuyên Môn</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.barbers.update', $barber->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label font-bold">Họ Và Tên Stylist <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $barber->user->name ?? '') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Số Điện Thoại <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $barber->user->phone ?? '') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Email</label>
                                <input type="email" class="form-control bg-light" value="{{ $barber->user->email ?? '' }}" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-bold">Số Năm Kinh Nghiệm (Năm)</label>
                            <input type="number" name="experience_years" class="form-control" value="{{ old('experience_years', $barber->experience_years) }}" min="0" max="40">
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-bold">Tiểu Sử / Phong Cách Sở Trường</label>
                            <textarea name="bio" rows="4" class="form-control">{{ old('bio', $barber->bio) }}</textarea>
                        </div>

                        <div class="mb-4 form-check form-switch ps-5">
                            <input class="form-check-input" type="checkbox" name="is_available" id="isAvailableSwitch" value="1" {{ old('is_available', $barber->is_available) ? 'checked' : '' }}>
                            <label class="form-check-label font-bold" for="isAvailableSwitch">Trạng thái sẵn sàng tiếp nhận lịch hẹn từ khách hàng</label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-outline-danger" onclick="if(confirm('Bạn có chắc chắn muốn xoá hồ sơ thợ này?')) document.getElementById('del-barber-form').submit();">
                                <i class="bi bi-trash"></i> Xoá Stylist
                            </button>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.barbers.index') }}" class="btn btn-light-secondary">Huỷ Bỏ</a>
                                <button type="submit" class="btn btn-primary px-4">Lưu Thay Đổi</button>
                            </div>
                        </div>
                    </form>

                    <form id="del-barber-form" action="{{ route('admin.barbers.destroy', $barber->id) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
