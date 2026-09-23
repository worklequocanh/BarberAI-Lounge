@extends('layouts.admin')

@section('title', 'Cập Nhật Lịch Hẹn #' . $appointment->code)
@section('page-title', 'Chỉnh Sửa Lịch Hẹn #' . $appointment->code)
@section('page-description', 'Cập nhật lại thời gian, phân công thợ cắt tóc hoặc thay đổi trạng thái hoàn thành / huỷ đơn.')

@section('breadcrumb')
    <a href="{{ route('admin.appointments.index') }}" class="hover:text-amber-400">Lịch Hẹn</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-600 mx-2"></i>
    <span class="text-amber-400 font-semibold">Chỉnh Sửa</span>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Form Area -->
    <div class="lg:col-span-2 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-2xl p-6 sm:p-8">
        <form action="{{ route('admin.appointments.update', $appointment->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Row 1: Khách & Trạng thái -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Khách Hàng</label>
                    <input type="text" value="{{ $appointment->customer->name ?? 'Khách lẻ' }} - {{ $appointment->customer->phone ?? '' }}" readonly
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-950/60 border border-slate-800 text-slate-400 text-sm font-semibold cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Trạng Thái Lịch Hẹn <span class="text-rose-400">*</span></label>
                    <select name="status" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm font-bold focus:ring-2 focus:ring-amber-500 focus:outline-none">
                        <option value="pending" {{ $appointment->status === 'pending' ? 'selected' : '' }}>⏳ Chờ xử lý (Pending)</option>
                        <option value="confirmed" {{ $appointment->status === 'confirmed' ? 'selected' : '' }}>✅ Đã xác nhận (Confirmed)</option>
                        <option value="completed" {{ $appointment->status === 'completed' ? 'selected' : '' }}>🎉 Đã hoàn thành (Completed)</option>
                        <option value="cancelled" {{ $appointment->status === 'cancelled' ? 'selected' : '' }}>❌ Đã huỷ (Cancelled)</option>
                    </select>
                </div>
            </div>

            <!-- Row 2: Thợ & Thời gian -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 border-t border-slate-800/80">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Thợ Cắt Tóc (Stylist)</label>
                    <select name="barber_id" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                        <option value="">-- Chưa chỉ định thợ --</option>
                        @foreach($barbers as $barber)
                            <option value="{{ $barber->id }}" {{ $appointment->barber_id == $barber->id ? 'selected' : '' }}>
                                {{ $barber->user->name ?? 'Stylist' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Ngày Hẹn <span class="text-rose-400">*</span></label>
                    <input type="date" name="appointment_date" value="{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') }}" required
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Giờ Bắt Đầu <span class="text-rose-400">*</span></label>
                    <input type="text" name="start_time" value="{{ $appointment->start_time ?? '09:00' }}" placeholder="09:00" required
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>
            </div>

            <!-- Row 3: Dịch vụ -->
            <div class="pt-4 border-t border-slate-800/80">
                <label class="block text-xs font-bold uppercase tracking-wider text-amber-400 mb-3">Dịch Vụ Sử Dụng</label>
                @php
                    $currentServiceIds = $appointment->services->pluck('id')->toArray();
                @endphp
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-56 overflow-y-auto p-1">
                    @foreach($services as $svc)
                    <label class="flex items-center justify-between p-3 rounded-2xl bg-slate-950/60 border border-slate-800 hover:border-amber-500/40 cursor-pointer transition-colors">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="service_ids[]" value="{{ $svc->id }}" {{ in_array($svc->id, $currentServiceIds) ? 'checked' : '' }}
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

            <!-- Row 4: Ghi chú & Hair notes -->
            <div class="pt-4 border-t border-slate-800/80 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Ghi Chú Đặt Lịch</label>
                    <textarea name="note" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none">{{ old('note', $appointment->note) }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-amber-400 mb-2">Sổ Tay Kỹ Thuật Tóc (Hair Notes)</label>
                    <textarea name="hair_notes" rows="3" placeholder="Ghi chú kỹ thuật tóc cho lần cắt này..." class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none">{{ old('hair_notes', $appointment->hair_notes) }}</textarea>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="pt-6 border-t border-slate-800 flex items-center justify-between">
                <button type="button" onclick="if(confirm('Xoá lịch hẹn này?')) document.getElementById('del-apt-form').submit();"
                    class="px-4 py-2.5 rounded-xl bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white text-xs font-bold border border-rose-500/20 transition-colors">
                    <i class="fa-solid fa-trash mr-1.5"></i> Xoá Lịch Hẹn
                </button>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.appointments.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-300 text-xs font-bold transition-colors">
                        Huỷ Bỏ
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-extrabold shadow-lg shadow-amber-500/20 transition-all">
                        <i class="fa-solid fa-floppy-disk mr-1.5"></i> Lưu Thay Đổi
                    </button>
                </div>
            </div>
        </form>

        <form id="del-apt-form" action="{{ route('admin.appointments.destroy', $appointment->id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <!-- Side Order Summary -->
    <div class="space-y-6">
        <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl">
            <h4 class="text-sm font-bold text-white mb-4 pb-3 border-b border-slate-800 flex items-center justify-between">
                <span>Chi Tiết Đơn Hàng</span>
                <span class="text-amber-400 font-mono font-bold">#{{ $appointment->code }}</span>
            </h4>
            <div class="space-y-3 text-xs">
                <div class="flex justify-between py-1">
                    <span class="text-slate-400">Tổng tiền dự kiến:</span>
                    <span class="font-extrabold text-emerald-400 text-sm">{{ number_format($appointment->total_price, 0, ',', '.') }}đ</span>
                </div>
                <div class="flex justify-between py-1">
                    <span class="text-slate-400">Trạng thái thanh toán:</span>
                    <span class="font-bold text-slate-200">{{ $appointment->payment_status === 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}</span>
                </div>
                <div class="flex justify-between py-1">
                    <span class="text-slate-400">Hình thức thanh toán:</span>
                    <span class="text-slate-300 uppercase font-semibold">{{ $appointment->payment_method ?? 'Tiền mặt' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
