@extends('layouts.admin')

@section('title', 'Thêm Người Dùng Mới')
@section('page-title', 'Thêm Người Dùng Mới')
@section('page-description', 'Tạo tài khoản thành viên, nhân viên salon hoặc quản trị viên hệ thống.')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Người Dùng</a></li>
    <li class="breadcrumb-item active" aria-current="page">Thêm Mới</li>
@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thông Tin Tài Khoản</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label font-bold">Họ Và Tên <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="VD: Nguyễn Văn A" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="user@example.com" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Số Điện Thoại</label>
                                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="09xxxxxxxx">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Mật Khẩu <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Tối thiểu 6 ký tự" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Vai Trò <span class="text-danger">*</span></label>
                                <select name="role_id" class="form-select @error('role_id') is-invalid @enderror" required>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('role_id', 2) == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Giới Tính</label>
                                <select name="gender" class="form-select">
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Khác</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4 form-check form-switch ps-5">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitch" value="1" checked>
                            <label class="form-check-label font-bold" for="isActiveSwitch">Kích hoạt tài khoản</label>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-light-secondary">Huỷ Bỏ</a>
                            <button type="submit" class="btn btn-primary px-4">Tạo Tài Khoản</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
