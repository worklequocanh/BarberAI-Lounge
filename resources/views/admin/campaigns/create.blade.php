@extends('layouts.admin')

@section('title', 'Tạo Chiến Dịch Email Marketing')
@section('page-title', 'Soạn Thảo Chiến Dịch Email')
@section('page-description', 'Thiết lập nội dung chăm sóc khách hàng, tặng voucher và chọn tệp đối tượng.')

@section('breadcrumb')
    <a href="{{ route('admin.campaigns.index') }}" class="hover:text-amber-400">Campaigns</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-600 mx-2"></i>
    <span class="text-amber-400 font-semibold">Tạo Mới</span>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-2xl p-6 sm:p-8">
        <form action="{{ route('admin.campaigns.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-2">Tên Chiến Dịch (Nội bộ) <span class="text-rose-400">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="VD: Chiến Dịch Tri Ân Khách Tháng 10..." required
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-2">Tiêu Đề Email (Subject khách nhận được) <span class="text-rose-400">*</span></label>
                <input type="text" name="subject" value="{{ old('subject') }}" placeholder="VD: [BarberAI] Tặng bạn voucher giảm 20% cho lần cắt tiếp theo!" required
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Tệp Khách Hàng Mục Tiêu <span class="text-rose-400">*</span></label>
                    <select name="target_audience" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                        <option value="all_customers" {{ old('target_audience') == 'all_customers' ? 'selected' : '' }}>Toàn bộ khách hàng đã đăng ký</option>
                        <option value="inactive_30d" {{ old('target_audience') == 'inactive_30d' ? 'selected' : '' }}>Khách > 30 ngày chưa quay lại cắt tóc</option>
                        <option value="vip_customers" {{ old('target_audience') == 'vip_customers' ? 'selected' : '' }}>Khách hàng VIP (Tổng chi tiêu > 1.000.000đ)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Mã Giảm Giá Đính Kèm (Coupon)</label>
                    <input type="text" name="coupon_code" value="{{ old('coupon_code') }}" placeholder="VD: TRIAN20, COMEBACK"
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm uppercase focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-2">Nội Dung Thư (Email Content) <span class="text-rose-400">*</span></label>
                <textarea name="content" rows="8" placeholder="Xin chào quý khách, đã gần một tháng trôi qua kể từ lần gần nhất bạn ghé BarberAI Lounge..." required
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-xs leading-relaxed focus:ring-2 focus:ring-amber-500 focus:outline-none">{{ old('content') }}</textarea>
            </div>

            <div class="pt-6 border-t border-slate-800 flex justify-end gap-3">
                <a href="{{ route('admin.campaigns.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-300 text-xs font-bold transition-colors">
                    Huỷ Bỏ
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-extrabold shadow-lg shadow-amber-500/20 transition-all">
                    Lưu Chiến Dịch
                </button>
            </div>
        </form>
    </div>

    <!-- Side Tips -->
    <div class="space-y-6">
        <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl">
            <h4 class="text-sm font-bold text-white mb-2 flex items-center gap-2">
                <i class="fa-solid fa-bullhorn text-amber-400"></i> Chu Kỳ Tóc Nam
            </h4>
            <p class="text-xs text-slate-400 leading-relaxed">
                Tóc nam mất form sau 20-30 ngày. Thiết lập chiến dịch <strong>Khách > 30 ngày chưa quay lại</strong> gửi kèm mã giảm 15% là vũ khí hiệu quả nhất để giữ chân khách quen.
            </p>
        </div>
    </div>
</div>
@endsection
