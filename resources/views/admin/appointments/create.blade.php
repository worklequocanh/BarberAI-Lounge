@extends('layouts.admin')

@section('title', 'Tạo Lịch Hẹn Đặt Chỗ')
@section('page-title', 'Tạo Lịch Đặt Chỗ')
@section('page-description', 'Thêm mới lịch hẹn cho khách trực tiếp tại salon hoặc qua điện thoại.')

@section('breadcrumb')
    <a href="{{ route('admin.appointments.index') }}" class="hover:text-amber-400">Lịch Hẹn</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-600 mx-2"></i>
    <span class="text-amber-400 font-semibold">Tạo Mới</span>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Form (2 Cols) -->
    <div class="lg:col-span-2 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-2xl p-6 sm:p-8">
        <form action="{{ route('admin.appointments.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Section 1: Khách hàng -->
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-amber-400 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-user-tag"></i> 1. Thông Tin Khách Hàng
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-2">Họ & Tên Khách Hàng <span class="text-rose-400">*</span></label>
                        <input type="text" name="customer_name" value="{{ old('customer_name') }}" placeholder="VD: Nguyễn Tuấn Minh" required
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-2">Số Điện Thoại <span class="text-rose-400">*</span></label>
                        <input type="tel" name="customer_phone" value="{{ old('customer_phone') }}" placeholder="09xxxxxxxx" required
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                    </div>
                </div>
            </div>

            <!-- Section 2: Thời gian & Thợ -->
            <div class="pt-4 border-t border-slate-800/80">
                <h3 class="text-sm font-bold uppercase tracking-wider text-amber-400 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-calendar-check"></i> 2. Stylist & Khung Giờ
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-2">Chọn Thợ Cắt Tóc</label>
                        <select name="barber_id" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                            <option value="">-- Bất kỳ thợ trống --</option>
                            @foreach($barbers as $barber)
                                <option value="{{ $barber->id }}" {{ (old('barber_id', request('barber_id')) == $barber->id) ? 'selected' : '' }}>
                                    {{ $barber->user->name ?? 'Stylist' }} ({{ $barber->experience_years ?? 0 }} năm KN)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-2">Ngày Hẹn <span class="text-rose-400">*</span></label>
                        <input type="date" name="appointment_date" value="{{ old('appointment_date', request('date', date('Y-m-d'))) }}" required
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-2">Khung Giờ <span class="text-rose-400">*</span></label>
                        <select name="start_time" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                            @foreach(['08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30'] as $time)
                                <option value="{{ $time }}" {{ old('start_time', request('start_time', '14:00')) == $time ? 'selected' : '' }}>{{ $time }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Section 3: Dịch vụ & Combo -->
            <div class="pt-4 border-t border-slate-800/80">
                <h3 class="text-sm font-bold uppercase tracking-wider text-amber-400 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-scissors"></i> 3. Chọn Dịch Vụ / Combo <span class="text-rose-400">*</span>
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-60 overflow-y-auto p-1">
                    @foreach($services as $svc)
                    <label class="flex items-center justify-between p-3 rounded-2xl bg-slate-950/60 border border-slate-800 hover:border-amber-500/40 cursor-pointer transition-colors">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="service_ids[]" value="{{ $svc->id }}" {{ $loop->first ? 'checked' : '' }}
                                class="w-4 h-4 rounded text-amber-500 focus:ring-amber-400 bg-slate-900 border-slate-700">
                            <div>
                                <span class="text-xs font-bold text-white block">{{ $svc->name }}</span>
                                <span class="text-[11px] text-slate-400">{{ $svc->duration_min }} phút</span>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-amber-400">{{ number_format($svc->price, 0, ',', '.') }}đ</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Section 4: Ghi chú kỹ thuật -->
            <div class="pt-4 border-t border-slate-800/80 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Ghi Chú Đặt Lịch</label>
                    <textarea name="note" rows="3" placeholder="Yêu cầu đồ uống, thợ cắt nhanh..." class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none">{{ old('note') }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-amber-400 mb-2">Sổ Tay Kỹ Thuật Tóc (Hair Notes)</label>
                    <textarea name="hair_notes" rows="3" placeholder="Ví dụ: Tóc mỏng, xoáy đôi, uốn size 16, vuốt pomade mờ..." class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none">{{ old('hair_notes') }}</textarea>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-800 flex justify-end gap-3">
                <a href="{{ route('admin.appointments.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-300 text-xs font-bold transition-colors">
                    Huỷ Bỏ
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-extrabold shadow-lg shadow-amber-500/20 transition-all">
                    <i class="fa-solid fa-check mr-1.5"></i> Xác Nhận Tạo Lịch
                </button>
            </div>
        </form>
    </div>

    <!-- Side Tips -->
    <div class="space-y-6">
        <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl">
            <h4 class="text-sm font-bold text-white mb-2 flex items-center gap-2">
                <i class="fa-solid fa-lightbulb text-amber-400"></i> Quy Trình Đặt Chỗ
            </h4>
            <p class="text-xs text-slate-400 leading-relaxed">
                Khi tạo lịch tại quầy, lịch sẽ được tự động kích hoạt trạng thái <strong>Đã xác nhận</strong>. Khách hàng mới sẽ được tạo hồ sơ hội viên tự động để tích điểm LTV.
            </p>
        </div>
    </div>
</div>
@endsection
