@extends('layouts.admin')

@section('title', 'Matrix Lịch Đặt Cắt Tóc')
@section('page-title', 'Bản Đồ Lịch Đặt Tóc (Matrix Timeline)')
@section('page-description', 'Theo dõi khung giờ phục vụ của từng Stylist trong ngày, chống trùng slot và tối ưu công suất ghế salon.')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.appointments.index') }}">Lịch Hẹn</a></li>
    <li class="breadcrumb-item active" aria-current="page">Matrix Timeline</li>
@endsection

@section('content')
<section class="section">
    <!-- Header Filter & Date Picker -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-3">
            <form action="{{ route('admin.appointments.timeline') }}" method="GET" class="row align-items-center g-3">
                <div class="col-12 col-md-4 d-flex align-items-center gap-2">
                    <label class="form-label font-bold mb-0 text-nowrap"><i class="bi bi-calendar-date text-primary"></i> Chọn ngày:</label>
                    <input type="date" name="date" class="form-control font-bold" value="{{ $date }}" onchange="this.form.submit()">
                </div>
                <div class="col-12 col-md-5 d-flex gap-2">
                    @php
                        $prevDate = \Carbon\Carbon::parse($date)->subDay()->format('Y-m-d');
                        $nextDate = \Carbon\Carbon::parse($date)->addDay()->format('Y-m-d');
                        $todayDate = \Carbon\Carbon::today()->format('Y-m-d');
                    @endphp
                    <a href="{{ route('admin.appointments.timeline', ['date' => $prevDate]) }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                        <i class="bi bi-chevron-left"></i> Hôm trước
                    </a>
                    <a href="{{ route('admin.appointments.timeline', ['date' => $todayDate]) }}" class="btn btn-sm {{ $date === $todayDate ? 'btn-primary' : 'btn-outline-primary' }}">
                        Hôm nay
                    </a>
                    <a href="{{ route('admin.appointments.timeline', ['date' => $nextDate]) }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                        Hôm sau <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
                <div class="col-12 col-md-3 text-md-end">
                    <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary btn-sm d-inline-flex align-items-center gap-2">
                        <i class="bi bi-plus-circle"></i> Đặt Lịch Mới
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Ghi chú phân loại màu sắc -->
    <div class="d-flex flex-wrap gap-3 mb-3 px-2">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-success px-2 py-1">&nbsp;</span>
            <small class="text-muted font-bold">Slot còn trống (Đặt được)</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary px-2 py-1">&nbsp;</span>
            <small class="text-muted font-bold">Đã xác nhận</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-warning px-2 py-1">&nbsp;</span>
            <small class="text-muted font-bold">Chờ duyệt</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-info text-dark px-2 py-1">&nbsp;</span>
            <small class="text-muted font-bold">Hoàn thành</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-secondary px-2 py-1">&nbsp;</span>
            <small class="text-muted font-bold">Thợ xin nghỉ / Nghỉ phép</small>
        </div>
    </div>

    <!-- Matrix Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0 align-middle text-center" style="min-width: 900px;">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 110px;" class="text-start ps-3 py-3">KHUNG GIỜ</th>
                            @foreach($barbers as $barber)
                                @php
                                    $isOff = $barber->leaves->isNotEmpty();
                                @endphp
                                <th class="py-3 {{ $isOff ? 'bg-light text-muted' : '' }}">
                                    <div class="font-bold fs-6 text-dark">{{ $barber->user->name ?? 'Stylist' }}</div>
                                    <small class="text-muted font-normal d-block">
                                        @if($isOff)
                                            <span class="badge bg-danger">Nghỉ phép</span>
                                        @else
                                            <span class="badge bg-light-success text-success">Đang trực</span>
                                        @endif
                                    </small>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($timeSlots as $slot)
                        <tr>
                            <td class="font-bold text-start ps-3 bg-light text-primary">
                                <i class="bi bi-clock me-1"></i> {{ $slot }}
                            </td>
                            @foreach($barbers as $barber)
                                @php
                                    $isOff = $barber->leaves->isNotEmpty();
                                    // Tìm cuộc hẹn tại slot này của barber
                                    $matchedAppointment = $appointments->first(function ($apt) use ($barber, $slot) {
                                        return $apt->barber_id == $barber->id && str_starts_with($apt->start_time, $slot);
                                    });
                                @endphp

                                @if($isOff)
                                    <td class="bg-light-secondary text-muted small py-2">
                                        <i class="bi bi-slash-circle"></i> Nghỉ
                                    </td>
                                @elseif($matchedAppointment)
                                    @php
                                        $statusClass = 'bg-primary text-white';
                                        if ($matchedAppointment->status === 'pending') $statusClass = 'bg-warning text-dark';
                                        elseif ($matchedAppointment->status === 'completed') $statusClass = 'bg-info text-dark';
                                    @endphp
                                    <td class="p-1">
                                        <div class="p-2 rounded {{ $statusClass }} shadow-sm text-start position-relative">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <strong class="text-truncate" style="max-width: 120px;">
                                                    {{ $matchedAppointment->customer->name ?? 'Khách' }}
                                                </strong>
                                                <a href="{{ route('admin.appointments.edit', $matchedAppointment->id) }}" class="text-white text-decoration-none" title="Chỉnh sửa">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            </div>
                                            <div class="small opacity-75">
                                                {{ $matchedAppointment->customer->phone ?? '' }}
                                            </div>
                                            <div class="small mt-1 text-truncate font-bold">
                                                @if($matchedAppointment->services->isNotEmpty())
                                                    {{ $matchedAppointment->services->first()->name }}
                                                @else
                                                    Cắt tạo kiểu
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                @else
                                    <td class="p-1">
                                        <a href="{{ route('admin.appointments.create', ['date' => $date, 'barber_id' => $barber->id, 'start_time' => $slot]) }}" 
                                           class="btn btn-sm btn-outline-success border-dashed w-100 py-2 d-flex align-items-center justify-content-center gap-1 opacity-75 hover-opacity-100" 
                                           title="Bấm để đặt lịch">
                                            <i class="bi bi-plus"></i> <small>Trống</small>
                                        </a>
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
