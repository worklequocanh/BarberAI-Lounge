@extends('layouts.admin')

@section('title', 'Thêm Thợ Mới')
@section('page-title', 'Thêm Stylist & Barber Mới')
@section('page-description', 'Tạo tài khoản và hồ sơ nhân viên tạo mẫu tóc mới cho salon.')

@section('breadcrumb')
    <a href="{{ route('admin.barbers.index') }}" class="hover:text-amber-400">Thợ Cắt Tóc</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-600 mx-2"></i>
    <span class="text-amber-400 font-semibold">Thêm Mới</span>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-2xl p-6 sm:p-8">
        <form action="{{ route('admin.barbers.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-2">Họ Và Tên Stylist <span class="text-rose-400">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="VD: Hoàng Tuấn Anh" required
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Số Điện Thoại <span class="text-rose-400">*</span></label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="09xxxxxxxx" required
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Email <span class="text-rose-400">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="stylist@barber.local" required
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-2">Số Năm Kinh Nghiệm (Năm)</label>
                <input type="number" name="experience_years" value="{{ old('experience_years', 3) }}" min="0" max="40"
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-2">Tiểu Sử / Phong Cách Sở Trường</label>
                <textarea name="bio" rows="4" placeholder="Chuyên gia uốn con sâu, Side Part, Skin Fade nghệ thuật..."
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none">{{ old('bio') }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_available" id="isAvailable" value="1" checked
                    class="w-4 h-4 rounded text-amber-500 focus:ring-amber-400 bg-slate-900 border-slate-700">
                <label for="isAvailable" class="text-xs font-semibold text-slate-300 cursor-pointer">Sẵn sàng nhận khách ngay</label>
            </div>

            <div class="pt-6 border-t border-slate-800 flex justify-end gap-3">
                <a href="{{ route('admin.barbers.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-300 text-xs font-bold transition-colors">
                    Huỷ Bỏ
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-extrabold shadow-lg shadow-amber-500/20 transition-all">
                    Lưu Hồ Sơ Stylist
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
