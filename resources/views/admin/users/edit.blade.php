@extends('layouts.admin')

@section('title', 'Chỉnh Sửa Người Dùng: ' . $user->name)
@section('page-title', 'Chỉnh Sửa Tài Khoản: ' . $user->name)
@section('page-description', 'Cập nhật thông tin tài khoản, vai trò hoặc trạng thái hoạt động.')

@section('breadcrumb')
    <a href="{{ route('admin.users.index') }}" class="hover:text-amber-400">Người Dùng</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-600 mx-2"></i>
    <span class="text-amber-400 font-semibold">Chỉnh Sửa</span>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-2xl p-6 sm:p-8">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-2">Họ Và Tên <span class="text-rose-400">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Email <span class="text-rose-400">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Số Điện Thoại</label>
                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Đổi Mật Khẩu Mới</label>
                    <input type="password" name="password" placeholder="Bỏ trống nếu không đổi"
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Vai Trò <span class="text-rose-400">*</span></label>
                    <select name="role_id" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-800 flex justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-300 text-xs font-bold transition-colors">
                    Huỷ Bỏ
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-extrabold shadow-lg shadow-amber-500/20 transition-all">
                    Lưu Thay Đổi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
