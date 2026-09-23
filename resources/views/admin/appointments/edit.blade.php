@extends('layouts.admin')

@section('title', 'Cập Nhật Lịch Hẹn #' . $appointment->code)
@section('page-title', 'Chỉnh Sửa Lịch Hẹn #' . $appointment->code)
@section('page-description', 'Cập nhật lại thời gian, phân công thợ cắt tóc hoặc thay đổi trạng thái hoàn thành / huỷ đơn.')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.appointments.index') }}">Lịch Hẹn</a></li>
    <li class="breadcrumb-item active" aria-current="page">Chỉnh Sửa</li>
@endsection

@section('content')
<section class="section">
    <div class="row match-height">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h5 class="card-title mb-0">Cập Nhật Thông Tin Đặt Chỗ</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.appointments.update', $appointment->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Khách Hàng</label>
                                <input type="text" class="form-control bg-light" value="{{ $appointment->customer->name ?? 'Khách lẻ' }} - {{ $appointment->customer->phone ?? '' }}" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Trạng Thái Lịch Hẹn <span class="text-danger">*</span></label>
                                <select name="status" class="form-select font-bold">
                                    <option value="pending" {{ $appointment->status === 'pending' ? 'selected' : '' }}>⏳ Chờ xử lý (Pending)</option>
                                    <option value="confirmed" {{ $appointment->status === 'confirmed' ? 'selected' : '' }}>✅ Đã xác nhận (Confirmed)</option>
                                    <option value="completed" {{ $appointment->status === 'completed' ? 'selected' : '' }}>🎉 Đã hoàn thành (Completed)</option>
                                    <option value="cancelled" {{ $appointment->status === 'cancelled' ? 'selected' : '' }}>❌ Đã huỷ (Cancelled)</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-bold">Chọn Thợ Cắt Tóc (Barber)</label>
                                <select name="barber_id" class="form-select">
                                    <option value="">-- Chưa chỉ định / Bất kỳ thợ --</option>
                                    @foreach($barbers as $barber)
                                        <option value="{{ $barber->id }}" {{ $appointment->barber_id == $barber->id ? 'selected' : '' }}>
                                            {{ $barber->user->name ?? 'Stylist' }} ({{ $barber->title ?? 'Barber' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label font-bold">Ngày Hẹn</label>
                                <input type="date" name="appointment_date" class="form-control" value="{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') }}" required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label font-bold">Giờ Bắt Đầu</label>
                                <input type="text" name="start_time" class="form-control" value="{{ $appointment->start_time ?? '09:00' }}" placeholder="09:00" required>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label font-bold">Dịch Vụ Sử Dụng</label>
                                @php
                                    $currentServiceIds = $appointment->services->pluck('id')->toArray();
                                @endphp
                                <div class="row g-2">
                                    @foreach($services as $svc)
                                    <div class="col-md-6">
                                        <div class="form-check border rounded p-2 ps-4">
                                            <input class="form-check-input" type="checkbox" name="service_ids[]" value="{{ $svc->id }}" id="svc_{{ $svc->id }}" {{ in_array($svc->id, $currentServiceIds) ? 'checked' : '' }}>
                                            <label class="form-check-label d-flex justify-content-between" for="svc_{{ $svc->id }}">
                                                <span>{{ $svc->name }}</span>
                                                <strong class="text-primary">{{ number_format($svc->price, 0, ',', '.') }}đ</strong>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label font-bold">Ghi Chú Đặt Lịch</label>
                                <textarea name="note" class="form-control" rows="3">{{ old('note', $appointment->note) }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <button type="button" class="btn btn-outline-danger" onclick="if(confirm('Bạn có chắc chắn muốn xoá lịch hẹn này?')) document.getElementById('del-apt-form').submit();">
                                <i class="bi bi-trash"></i> Xoá Lịch Hẹn
                            </button>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.appointments.index') }}" class="btn btn-light-secondary">Huỷ Bỏ</a>
                                <button type="submit" class="btn btn-primary px-4">Lưu Thay Đổi</button>
                            </div>
                        </div>
                    </form>

                    <form id="del-apt-form" action="{{ route('admin.appointments.destroy', $appointment->id) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h5 class="card-title mb-0">Chi Tiết Đơn Hàng</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            Mã lịch: <strong class="text-primary">#{{ $appointment->code }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            Tổng tiền dự kiến: <strong class="fs-5 text-success">{{ number_format($appointment->total_price, 0, ',', '.') }}đ</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            Thanh toán: <span>{{ $appointment->payment_status === 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
