@extends('layouts.admin')

@section('title', 'Thêm Dịch Vụ Mới')
@section('page-title', 'Thêm Dịch Vụ Salon')
@section('page-description', 'Tạo gói dịch vụ cắt, uốn, nhuộm hoặc đóng gói Combo tiết kiệm cho tiệm.')

@section('breadcrumb')
    <a href="{{ route('admin.services.index') }}" class="hover:text-[#22D3EE]">Dịch Vụ</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-[#334155] mx-2"></i>
    <span class="text-[#22D3EE] font-semibold">Thêm Mới</span>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 rounded-3xl bg-[#1E293B] border border-[#334155] shadow-2xl p-6 sm:p-8">
        <form action="{{ route('admin.services.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-[#CBD5E1] mb-2">Tên Dịch Vụ <span class="text-[#F43F5E]">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="VD: Uốn Con Sâu 2026, Combo VIP Đế Vương..." required
                    class="w-full px-4 py-2.5 rounded-xl bg-[#0B1120] border border-[#334155] text-[#F8FAFC] text-sm focus:ring-2 focus:ring-[#6366F1] focus:outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-[#CBD5E1] mb-2">Danh Mục Dịch Vụ</label>
                    <select name="category_id" class="w-full px-4 py-2.5 rounded-xl bg-[#0B1120] border border-[#334155] text-[#F8FAFC] text-sm focus:ring-2 focus:ring-[#6366F1] focus:outline-none">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#CBD5E1] mb-2">Thời Gian Thực Hiện (Phút) <span class="text-[#F43F5E]">*</span></label>
                    <input type="number" name="duration_min" value="{{ old('duration_min', 30) }}" min="5" max="300" required
                        class="w-full px-4 py-2.5 rounded-xl bg-[#0B1120] border border-[#334155] text-[#F8FAFC] text-sm focus:ring-2 focus:ring-[#6366F1] focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-[#CBD5E1] mb-2">Giá Bán / Khuyến Mãi (VNĐ) <span class="text-[#F43F5E]">*</span></label>
                    <input type="number" name="price" value="{{ old('price', 150000) }}" min="0" step="5000" required
                        class="w-full px-4 py-2.5 rounded-xl bg-[#0B1120] border border-[#334155] text-[#F8FAFC] text-sm focus:ring-2 focus:ring-[#6366F1] focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#CBD5E1] mb-2">Giá Gốc Trước Giảm (Dành cho Combo)</label>
                    <input type="number" name="original_price" value="{{ old('original_price') }}" min="0" step="5000" placeholder="VD: 350000"
                        class="w-full px-4 py-2.5 rounded-xl bg-[#0B1120] border border-[#334155] text-[#F8FAFC] text-sm focus:ring-2 focus:ring-[#6366F1] focus:outline-none">
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-[#6366F1]/10 border border-[#6366F1]/20">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_combo" value="1" {{ old('is_combo') ? 'checked' : '' }}
                        class="w-4 h-4 rounded text-[#6366F1] focus:ring-[#6366F1] bg-[#0B1120] border-[#334155]">
                    <span class="text-xs font-bold text-[#22D3EE]">
                        <i class="fa-solid fa-crown mr-1"></i> Đóng gói thành Combo Dịch Vụ Siêu Tiết Kiệm (Cắt + Gội + Uốn...)
                    </span>
                </label>
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#CBD5E1] mb-2">Mô Tả Quy Trình Thực Hiện</label>
                <textarea name="description" rows="4" placeholder="Mô tả các bước thực hiện, dòng mỹ phẩm cao cấp sử dụng..."
                    class="w-full px-4 py-2.5 rounded-xl bg-[#0B1120] border border-[#334155] text-[#F8FAFC] text-xs focus:ring-2 focus:ring-[#6366F1] focus:outline-none">{{ old('description') }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" id="isActive" value="1" checked
                    class="w-4 h-4 rounded text-[#6366F1] focus:ring-[#6366F1] bg-[#0B1120] border-[#334155]">
                <label for="isActive" class="text-xs font-semibold text-[#CBD5E1] cursor-pointer">Kích hoạt phục vụ ngay trên hệ thống đặt lịch</label>
            </div>

            <div class="pt-6 border-t border-[#334155] flex justify-end gap-3">
                <a href="{{ route('admin.services.index') }}" class="px-5 py-2.5 rounded-xl bg-[#0B1120] hover:bg-[#273449] border border-[#334155] text-[#CBD5E1] text-xs font-bold transition-colors">
                    Huỷ Bỏ
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#6366F1] hover:bg-[#818CF8] text-white text-xs font-extrabold shadow-lg shadow-indigo-500/20 transition-all">
                    Lưu Dịch Vụ
                </button>
            </div>
        </form>
    </div>

    <!-- Side Tips -->
    <div class="space-y-6">
        <div class="p-6 rounded-3xl bg-[#1E293B] border border-[#334155] shadow-xl">
            <h4 class="text-sm font-bold text-[#F8FAFC] mb-2 flex items-center gap-2">
                <i class="fa-solid fa-lightbulb text-[#22D3EE]"></i> Chiến Lược Combo
            </h4>
            <p class="text-xs text-[#94A3B8] leading-relaxed">
                Đóng gói combo cắt + uốn phồng + gội massage giúp nâng cao ticket size trung bình trên mỗi khách hàng lên từ 250k - 400k.
            </p>
        </div>
    </div>
</div>
@endsection
