@extends('layouts.admin')

@section('title', 'Thêm Thợ Mới')
@section('page-title', 'Thêm Stylist & Barber Mới')
@section('page-description', 'Tạo tài khoản và hồ sơ nhân viên tạo mẫu tóc mới cho salon.')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.barbers.index') }}">Thợ Cắt Tóc</a></li>
    <li class="breadcrumb-item active" aria-current="page">Thêm Mới</li>
@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h5 class="card-title mb-0">Hồ Sơ Nhân Sự</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.barbers.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label font-bold">Họ Và Tên Stylist <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="VD: Hoàng Tuấn Anh" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Số Điện Thoại <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="09xxxxxxxx" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="stylist@barber.local" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-bold">Số Năm Kinh Nghiệm (Năm)</label>
                            <input type="number" name="experience_years" class="form-control" value="{{ old('experience_years', 3) }}" min="0" max="40">
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-bold">Tiểu Sử / Phong Cách Sở Trường</label>
                            <textarea name="bio" rows="4" class="form-control" placeholder="Chuyên gia tạo mẫu các kiểu tóc uốn Hàn Quốc, tỉa Texture và Skin Fade cổ điển...">{{ old('bio') }}</textarea>
                        </div>

                        <div class="mb-4 form-check form-switch ps-5">
                            <input class="form-check-input" type="checkbox" name="is_available" id="isAvailableSwitch" value="1" checked>
                            <label class="form-check-label font-bold" for="isAvailableSwitch">Trạng thái sẵn sàng tiếp nhận lịch hẹn từ khách hàng</label>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.barbers.index') }}" class="btn btn-light-secondary">Huỷ Bỏ</a>
                            <button type="submit" class="btn btn-primary px-4">Lưu Thợ Mới</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
