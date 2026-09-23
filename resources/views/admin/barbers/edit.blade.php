@extends('layouts.admin')

@section('title', 'Chỉnh Sửa Stylist: ' . ($barber->user->name ?? 'Barber'))
@section('page-title', 'Chỉnh Sửa Stylist: ' . ($barber->user->name ?? 'Barber'))
@section('page-description', 'Cập nhật thông tin nhân sự, số năm kinh nghiệm và trạng thái trực salon.')

@section('breadcrumb')
    <a href="{{ route('admin.barbers.index') }}" class="hover:text-amber-400">Thợ Cắt Tóc</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-600 mx-2"></i>
    <span class="text-amber-400 font-semibold">Chỉnh Sửa</span>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Info Form (2 Cols) -->
    <div class="lg:col-span-2 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-2xl p-6 sm:p-8">
        <form action="{{ route('admin.barbers.update', $barber->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-2">Họ Và Tên Stylist <span class="text-rose-400">*</span></label>
                <input type="text" name="name" value="{{ old('name', $barber->user->name ?? '') }}" required
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Số Điện Thoại <span class="text-rose-400">*</span></label>
                    <input type="tel" name="phone" value="{{ old('phone', $barber->user->phone ?? '') }}" required
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Email</label>
                    <input type="email" value="{{ $barber->user->email ?? '' }}" readonly
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-950/60 border border-slate-800 text-slate-500 text-sm cursor-not-allowed">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-2">Số Năm Kinh Nghiệm (Năm)</label>
                <input type="number" name="experience_years" value="{{ old('experience_years', $barber->experience_years) }}" min="0" max="40"
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-2">Tiểu Sử / Phong Cách Sở Trường</label>
                <textarea name="bio" rows="4" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none">{{ old('bio', $barber->bio) }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_available" id="isAvailable" value="1" {{ old('is_available', $barber->is_available) ? 'checked' : '' }}
                    class="w-4 h-4 rounded text-amber-500 focus:ring-amber-400 bg-slate-900 border-slate-700">
                <label for="isAvailable" class="text-xs font-semibold text-slate-300 cursor-pointer">Sẵn sàng tiếp nhận lịch hẹn từ khách hàng</label>
            </div>

            <div class="pt-6 border-t border-slate-800 flex items-center justify-between">
                <button type="button" onclick="if(confirm('Xoá hồ sơ stylist này?')) document.getElementById('del-barber-form').submit();"
                    class="px-4 py-2.5 rounded-xl bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white text-xs font-bold border border-rose-500/20 transition-colors">
                    <i class="fa-solid fa-trash mr-1.5"></i> Xoá Stylist
                </button>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.barbers.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-300 text-xs font-bold transition-colors">
                        Huỷ Bỏ
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-extrabold shadow-lg shadow-amber-500/20 transition-all">
                        Lưu Thay Đổi
                    </button>
                </div>
            </div>
        </form>

        <form id="del-barber-form" action="{{ route('admin.barbers.destroy', $barber->id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <!-- Side Panel: Day-off / Leaves Management (1 Col) -->
    <div class="space-y-6">
        <!-- Register Day-off -->
        <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl">
            <h4 class="text-sm font-bold text-white mb-4 pb-3 border-b border-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-calendar-xmark text-rose-400"></i> Đăng Ký Nghỉ Phép (Day Off)
            </h4>
            <form action="{{ route('admin.barbers.leaves.store', $barber->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Ngày Nghỉ <span class="text-rose-400">*</span></label>
                    <input type="date" name="leave_date" value="{{ date('Y-m-d') }}" required
                        class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-700 text-white text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Lý Do</label>
                    <input type="text" name="reason" placeholder="Việc cá nhân, đào tạo..."
                        class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-700 text-white text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>
                <button type="submit" class="w-full py-2.5 rounded-xl bg-slate-800 hover:bg-amber-500 hover:text-slate-950 text-slate-200 text-xs font-bold border border-slate-700 transition-all">
                    <i class="fa-solid fa-plus mr-1"></i> Lưu Ngày Nghỉ
                </button>
            </form>
        </div>

        <!-- History Leaves List -->
        <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800 mb-3">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Lịch Nghỉ Đã Đăng Ký</h4>
                <span class="text-xs font-bold text-amber-400">{{ $barber->leaves->count() }}</span>
            </div>
            <div class="divide-y divide-slate-800/80 max-h-56 overflow-y-auto">
                @forelse($barber->leaves as $leave)
                <div class="py-2.5 flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-white flex items-center gap-1.5">
                            <i class="fa-regular fa-calendar text-slate-500"></i>
                            {{ \Carbon\Carbon::parse($leave->leave_date)->format('d/m/Y') }}
                        </div>
                        <div class="text-[11px] text-slate-400 mt-0.5">{{ $leave->reason ?? 'Nghỉ phép' }}</div>
                    </div>
                    <form action="{{ route('admin.barbers.leaves.destroy', [$barber->id, $leave->id]) }}" method="POST" data-confirm="Huỷ ngày nghỉ phép {{ \Carbon\Carbon::parse($leave->leave_date)->format('d/m/Y') }}?" class="inline form-delete">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 text-slate-500 hover:text-rose-400 transition-colors" title="Huỷ">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </button>
                    </form>
                </div>
                @empty
                <p class="text-xs text-slate-500 text-center py-4">Chưa có ngày nghỉ nào</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
