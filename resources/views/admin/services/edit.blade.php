@extends('layouts.admin')

@section('title', 'Chỉnh Sửa Dịch Vụ: ' . $service->name)
@section('page-title', 'Chỉnh Sửa Dịch Vụ / Combo')
@section('page-description', 'Cập nhật lại giá tiền, thời gian hoặc mô tả dịch vụ salon.')

@section('breadcrumb')
    <a href="{{ route('admin.services.index') }}" class="hover:text-[#22D3EE]">Dịch Vụ</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-[#334155] mx-2"></i>
    <span class="text-[#22D3EE] font-semibold">Chỉnh Sửa</span>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 rounded-3xl bg-[#1E293B] border border-[#334155] shadow-2xl p-6 sm:p-8">
        <form action="{{ route('admin.services.update', $service->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-semibold text-[#CBD5E1] mb-2">Tên Dịch Vụ <span class="text-[#F43F5E]">*</span></label>
                <input type="text" name="name" value="{{ old('name', $service->name) }}" required
                    class="w-full px-4 py-2.5 rounded-xl bg-[#0B1120] border border-[#334155] text-[#F8FAFC] text-sm focus:ring-2 focus:ring-[#6366F1] focus:outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-[#CBD5E1] mb-2">Danh Mục Dịch Vụ</label>
                    <select name="category_id" class="w-full px-4 py-2.5 rounded-xl bg-[#0B1120] border border-[#334155] text-[#F8FAFC] text-sm focus:ring-2 focus:ring-[#6366F1] focus:outline-none">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $service->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#CBD5E1] mb-2">Thời Gian Thực Hiện (Phút) <span class="text-[#F43F5E]">*</span></label>
                    <input type="number" name="duration_min" value="{{ old('duration_min', $service->duration_min) }}" min="5" max="300" required
                        class="w-full px-4 py-2.5 rounded-xl bg-[#0B1120] border border-[#334155] text-[#F8FAFC] text-sm focus:ring-2 focus:ring-[#6366F1] focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-[#CBD5E1] mb-2">Giá Bán / Khuyến Mãi (VNĐ) <span class="text-[#F43F5E]">*</span></label>
                    <input type="number" name="price" value="{{ old('price', (int)$service->price) }}" min="0" step="5000" required
                        class="w-full px-4 py-2.5 rounded-xl bg-[#0B1120] border border-[#334155] text-[#F8FAFC] text-sm focus:ring-2 focus:ring-[#6366F1] focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#CBD5E1] mb-2">Giá Gốc Trước Giảm (Dành cho Combo)</label>
                    <input type="number" name="original_price" value="{{ old('original_price', (int)$service->original_price) }}" min="0" step="5000"
                        class="w-full px-4 py-2.5 rounded-xl bg-[#0B1120] border border-[#334155] text-[#F8FAFC] text-sm focus:ring-2 focus:ring-[#6366F1] focus:outline-none">
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-[#6366F1]/10 border border-[#6366F1]/20">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_combo" value="1" {{ old('is_combo', $service->is_combo) ? 'checked' : '' }}
                        class="w-4 h-4 rounded text-[#6366F1] focus:ring-[#6366F1] bg-[#0B1120] border-[#334155]">
                    <span class="text-xs font-bold text-[#22D3EE]">
                        <i class="fa-solid fa-crown mr-1"></i> Đóng gói thành Combo Dịch Vụ Siêu Tiết Kiệm (Cắt + Gội + Uốn...)
                    </span>
                </label>
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#CBD5E1] mb-2">Mô Tả Quy Trình Thực Hiện</label>
                <textarea name="description" rows="4"
                    class="w-full px-4 py-2.5 rounded-xl bg-[#0B1120] border border-[#334155] text-[#F8FAFC] text-xs focus:ring-2 focus:ring-[#6366F1] focus:outline-none">{{ old('description', $service->description) }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" id="isActive" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}
                    class="w-4 h-4 rounded text-[#6366F1] focus:ring-[#6366F1] bg-[#0B1120] border-[#334155]">
                <label for="isActive" class="text-xs font-semibold text-[#CBD5E1] cursor-pointer">Kích hoạt phục vụ ngay trên hệ thống đặt lịch</label>
            </div>

            <div class="pt-6 border-t border-[#334155] flex justify-end gap-3">
                <a href="{{ route('admin.services.index') }}" class="px-5 py-2.5 rounded-xl bg-[#0B1120] hover:bg-[#273449] border border-[#334155] text-[#CBD5E1] text-xs font-bold transition-colors">
                    Huỷ Bỏ
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#6366F1] hover:bg-[#818CF8] text-white text-xs font-extrabold shadow-lg shadow-indigo-500/20 transition-all">
                    Cập Nhật Dịch Vụ
                </button>
            </div>
        </form>
    </div>

    <!-- Side Tips -->
    <div class="space-y-6">
        <div class="p-6 rounded-3xl bg-[#1E293B] border border-[#334155] shadow-xl">
            <h4 class="text-sm font-bold text-[#F8FAFC] mb-2 flex items-center gap-2">
                <i class="fa-solid fa-scissors text-[#22D3EE]"></i> Thông Tin Dịch Vụ
            </h4>
            <p class="text-xs text-[#94A3B8] leading-relaxed">
                Khi kích hoạt tính năng Combo, hệ thống đặt lịch hẹn của khách sẽ tự động tính toán tổng thời gian làm tóc và áp dụng mức giảm giá trực quan.
            </p>
        </div>
    </div>
</div>
@endsection
