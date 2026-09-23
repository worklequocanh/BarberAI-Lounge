@extends('layouts.admin')

@section('title', 'Tạo Lịch Hẹn Mới')
@section('page-title', 'Tạo Lịch Đặt Chỗ')
@section('page-description', 'Thêm mới lịch hẹn cho khách trực tiếp hoặc qua điện thoại.')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.appointments.index') }}">Lịch Hẹn</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tạo Mới</li>
@endsection

@section('content')
<section class="section">
    <div class="row match-height">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thông Tin Đặt Chỗ</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.appointments.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Họ & Tên Khách Hàng <span class="text-danger">*</span></label>
                                <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" value="{{ old('customer_name') }}" placeholder="Nhập tên khách hàng" required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Số Điện Thoại <span class="text-danger">*</span></label>
                                <input type="tel" name="customer_phone" class="form-control @error('customer_phone') is-invalid @enderror" value="{{ old('customer_phone') }}" placeholder="09xxxxxxxx" required>
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Chọn Thợ Cắt Tóc (Barber)</label>
                                <select name="barber_id" class="form-select">
                                    <option value="">-- Bất kỳ thợ nào còn trống --</option>
                                    @foreach($barbers as $barber)
                                        <option value="{{ $barber->id }}" {{ (old('barber_id', request('barber_id')) == $barber->id) ? 'selected' : '' }}>
                                            {{ $barber->user->name ?? 'Stylist' }} ({{ $barber->experience_years ?? 0 }} năm KN)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Ngày Hẹn <span class="text-danger">*</span></label>
                                <input type="date" name="appointment_date" class="form-control" value="{{ old('appointment_date', request('date', date('Y-m-d'))) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Khung Giờ <span class="text-danger">*</span></label>
                                <select name="start_time" class="form-select" required>
                                    @foreach(['08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30'] as $time)
                                        <option value="{{ $time }}" {{ old('start_time', request('start_time', '14:00')) == $time ? 'selected' : '' }}>{{ $time }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label font-bold">Chọn Dịch Vụ Sử Dụng <span class="text-danger">*</span></label>
                                <div class="row g-2">
                                    @foreach($services as $svc)
                                    <div class="col-md-6">
                                        <div class="form-check border rounded p-2 ps-4">
                                            <input class="form-check-input" type="checkbox" name="service_ids[]" value="{{ $svc->id }}" id="svc_{{ $svc->id }}" {{ $loop->first ? 'checked' : '' }}>
                                            <label class="form-check-label d-flex justify-content-between" for="svc_{{ $svc->id }}">
                                                <span>{{ $svc->name }}</span>
                                                <strong class="text-primary">{{ number_format($svc->price, 0, ',', '.') }}đ</strong>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @error('service_ids')
                                    <div class="text-danger small mt-1">Vui lòng chọn ít nhất 1 dịch vụ!</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label font-bold">Ghi Chú Đặt Lịch</label>
                                <textarea name="note" class="form-control" rows="3" placeholder="Yêu cầu riêng của khách...">{{ old('note') }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('admin.appointments.index') }}" class="btn btn-light-secondary">Huỷ Bỏ</a>
                            <button type="submit" class="btn btn-primary px-4">Xác Nhận Tạo Lịch</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h5 class="card-title mb-0">Lưu Ý Vận Hành</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-light-primary mb-0">
                        <i class="bi bi-info-circle me-1"></i> Khi tạo lịch tại quầy, trạng thái sẽ mặc định là <strong>Đã xác nhận</strong> và hệ thống tự động lưu khách hàng vào database.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
