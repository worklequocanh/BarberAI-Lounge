@extends('layouts.admin')

@section('title', 'Chỉnh Sửa Dịch Vụ: ' . $service->name)
@section('page-title', 'Chỉnh Sửa Dịch Vụ / Combo')
@section('page-description', 'Cập nhật lại giá tiền, thời gian hoặc mô tả dịch vụ salon.')

@section('breadcrumb')
    <a href="{{ route('admin.services.index') }}" class="hover:text-amber-400">Dịch Vụ</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-600 mx-2"></i>
    <span class="text-amber-400 font-semibold">Chỉnh Sửa</span>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-2xl p-6 sm:p-8">
        <form action="{{ route('admin.services.update', $service->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-2">Tên Dịch Vụ <span class="text-rose-400">*</span></label>
                <input type="text" name="name" value="{{ old('name', $service->name) }}" required
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Danh Mục Dịch Vụ</label>
                    <select name="category_id" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $service->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Thời Gian Thực Hiện (Phút) <span class="text-rose-400">*</span></label>
                    <input type="number" name="duration_min" value="{{ old('duration_min', $service->duration_min) }}" min="5" max="300" required
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Giá Bán / Khuyến Mãi (VNĐ) <span class="text-rose-400">*</span></label>
                    <input type="number" name="price" value="{{ old('price', (int)$service->price) }}" min="0" step="5000" required
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Giá Gốc Trước Giảm (Dành cho Combo)</label>
                    <input type="number" name="original_price" value="{{ old('original_price', (int)$service->original_price) }}" min="0" step="5000"
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-amber-500/10 border border-amber-500/20">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_combo" value="1" {{ old('is_combo', $service->is_combo) ? 'checked' : '' }}
                        class="w-4 h-4 rounded text-amber-500 focus:ring-amber-400 bg-slate-900 border-slate-700">
                    <span class="text-xs font-bold text-amber-300">
                        <i class="fa-solid fa-crown mr-1"></i> Đóng gói thành Combo Dịch Vụ Siêu Tiết Kiệm
                    </span>
                </label>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-2">Mô Tả Quy Trình Thực Hiện</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none">{{ old('description', $service->description) }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" id="isActive" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}
                    class="w-4 h-4 rounded text-amber-500 focus:ring-amber-400 bg-slate-900 border-slate-700">
                <label for="isActive" class="text-xs font-semibold text-slate-300 cursor-pointer">Kích hoạt phục vụ ngay trên hệ thống đặt lịch</label>
            </div>

            <div class="pt-6 border-t border-slate-800 flex items-center justify-between">
                <button type="button" onclick="if(confirm('Bạn có chắc muốn xoá dịch vụ này?')) document.getElementById('delete-svc-form').submit();"
                    class="px-4 py-2.5 rounded-xl bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white text-xs font-bold border border-rose-500/20 transition-colors">
                    <i class="fa-solid fa-trash mr-1.5"></i> Xoá Dịch Vụ
                </button>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.services.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-300 text-xs font-bold transition-colors">
                        Huỷ Bỏ
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-extrabold shadow-lg shadow-amber-500/20 transition-all">
                        Cập Nhật
                    </button>
                </div>
            </div>
        </form>

        <form id="delete-svc-form" action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection
