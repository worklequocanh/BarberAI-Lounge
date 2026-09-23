@extends('layouts.admin')

@section('title', 'Tạo Mã Giảm Giá Mới')
@section('page-title', 'Tạo Voucher Khuyến Mãi')
@section('page-description', 'Phát hành mã ưu đãi giảm giá theo phần trăm hoặc số tiền cố định cho khách hàng.')

@section('breadcrumb')
    <a href="{{ route('admin.coupons.index') }}" class="hover:text-amber-400">Khuyến Mãi</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-600 mx-2"></i>
    <span class="text-amber-400 font-semibold">Tạo Mới</span>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-2xl p-6 sm:p-8">
        <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-2">Mã Voucher (Code) <span class="text-rose-400">*</span></label>
                <input type="text" name="code" value="{{ old('code') }}" placeholder="VD: BARBERAI20, HELLO2026..." required
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-amber-400 font-mono font-bold text-sm tracking-wider uppercase focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Hình Thức Giảm <span class="text-rose-400">*</span></label>
                    <select name="discount_type" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm font-semibold focus:ring-2 focus:ring-amber-500 focus:outline-none">
                        <option value="percent">Giảm theo phần trăm (%)</option>
                        <option value="fixed">Giảm số tiền cố định (VNĐ)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Mức Giảm Giá <span class="text-rose-400">*</span></label>
                    <input type="number" name="discount_value" value="{{ old('discount_value', 20) }}" min="1" required
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Đơn Hàng Tối Thiểu (VNĐ)</label>
                    <input type="number" name="min_order_amount" value="{{ old('min_order_amount', 100000) }}" min="0"
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Giới Hạn Lượt Dùng</label>
                    <input type="number" name="usage_limit" value="{{ old('usage_limit', 100) }}" min="1"
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Ngày Bắt Đầu</label>
                    <input type="date" name="starts_at" value="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Ngày Hết Hạn</label>
                    <input type="date" name="expires_at"
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" id="isActive" value="1" checked
                    class="w-4 h-4 rounded text-amber-500 focus:ring-amber-400 bg-slate-900 border-slate-700">
                <label for="isActive" class="text-xs font-semibold text-slate-300 cursor-pointer">Kích hoạt mã sử dụng ngay</label>
            </div>

            <div class="pt-6 border-t border-slate-800 flex justify-end gap-3">
                <a href="{{ route('admin.coupons.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-300 text-xs font-bold transition-colors">
                    Huỷ Bỏ
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-extrabold shadow-lg shadow-amber-500/20 transition-all">
                    Lưu Voucher
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
