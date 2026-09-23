@extends('layouts.admin')

@section('title', 'Chỉnh Sửa Voucher: ' . $coupon->code)
@section('page-title', 'Chỉnh Sửa Voucher')
@section('page-description', 'Cập nhật lại tỷ lệ giảm giá, hạn sử dụng hoặc kích hoạt/vô hiệu hoá voucher.')

@section('breadcrumb')
    <a href="{{ route('admin.coupons.index') }}" class="hover:text-amber-400">Khuyến Mãi</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-600 mx-2"></i>
    <span class="text-amber-400 font-semibold">Chỉnh Sửa</span>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-2xl p-6 sm:p-8">
        <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-2">Mã Voucher (Code) <span class="text-rose-400">*</span></label>
                <input type="text" name="code" value="{{ old('code', $coupon->code) }}" required
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-amber-400 font-mono font-bold text-sm tracking-wider uppercase focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Hình Thức Giảm <span class="text-rose-400">*</span></label>
                    <select name="discount_type" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm font-semibold focus:ring-2 focus:ring-amber-500 focus:outline-none">
                        <option value="percent" {{ old('discount_type', $coupon->discount_type) == 'percent' ? 'selected' : '' }}>Giảm theo phần trăm (%)</option>
                        <option value="fixed" {{ old('discount_type', $coupon->discount_type) == 'fixed' ? 'selected' : '' }}>Giảm số tiền cố định (VNĐ)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Mức Giảm Giá <span class="text-rose-400">*</span></label>
                    <input type="number" name="discount_value" value="{{ old('discount_value', (int)$coupon->discount_value) }}" min="1" required
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Đơn Hàng Tối Thiểu (VNĐ)</label>
                    <input type="number" name="min_order_amount" value="{{ old('min_order_amount', (int)$coupon->min_order_amount) }}" min="0"
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Giới Hạn Lượt Dùng</label>
                    <input type="number" name="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit) }}" min="1"
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" id="isActive" value="1" {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}
                    class="w-4 h-4 rounded text-amber-500 focus:ring-amber-400 bg-slate-900 border-slate-700">
                <label for="isActive" class="text-xs font-semibold text-slate-300 cursor-pointer">Kích hoạt mã ưu đãi</label>
            </div>

            <div class="pt-6 border-t border-slate-800 flex justify-end gap-3">
                <a href="{{ route('admin.coupons.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-300 text-xs font-bold transition-colors">
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
