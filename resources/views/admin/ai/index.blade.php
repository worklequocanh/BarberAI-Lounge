@extends('layouts.admin')

@section('title', 'AI Styling Assistant')
@section('page-title', 'AI Styling Assistant')
@section('page-description', 'Theo dõi lịch sử tư vấn, phân tích hình thái khuôn mặt và thống kê hiệu suất AI.')

@section('breadcrumb')
    <span class="text-amber-400 font-semibold">Trợ Lý AI</span>
@endsection

@section('content')
<!-- Row 1: AI Stats -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
    <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl flex items-center gap-4">
        <div class="w-14 h-14 rounded-2xl bg-purple-500/10 text-purple-400 border border-purple-500/20 flex items-center justify-center text-2xl shrink-0">
            <i class="fa-solid fa-microchip"></i>
        </div>
        <div>
            <div class="text-[11px] font-bold uppercase text-slate-400">Mô Hình AI</div>
            <div class="text-lg font-black text-white">Gemini 1.5 Vision</div>
            <span class="inline-flex items-center gap-1 text-[11px] text-emerald-400 font-semibold mt-0.5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Hoạt động ổn định
            </span>
        </div>
    </div>

    <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl flex items-center gap-4">
        <div class="w-14 h-14 rounded-2xl bg-amber-500/10 text-amber-400 border border-amber-500/20 flex items-center justify-center text-2xl shrink-0">
            <i class="fa-solid fa-comments"></i>
        </div>
        <div>
            <div class="text-[11px] font-bold uppercase text-slate-400">Lượt Tư Vấn Tháng Này</div>
            <div class="text-2xl font-black text-amber-400">1,482 <span class="text-sm font-medium text-slate-400">lượt</span></div>
            <span class="text-[11px] text-emerald-400 font-medium">+18.5% so với tháng trước</span>
        </div>
    </div>

    <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl flex items-center gap-4">
        <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center text-2xl shrink-0">
            <i class="fa-solid fa-heart-circle-check"></i>
        </div>
        <div>
            <div class="text-[11px] font-bold uppercase text-slate-400">Độ Hài Lòng Kiểu Tóc</div>
            <div class="text-2xl font-black text-emerald-400">96.8%</div>
            <span class="text-[11px] text-slate-400 font-medium">Từ 850 lượt đánh giá khách</span>
        </div>
    </div>
</div>

<!-- AI Matching Overview -->
<div class="rounded-3xl bg-slate-900/90 border border-slate-800 shadow-2xl p-6 sm:p-8">
    <div class="flex items-center justify-between pb-4 border-b border-slate-800 mb-6">
        <div>
            <h3 class="text-base font-bold text-white flex items-center gap-2">
                <i class="fa-solid fa-wand-magic-sparkles text-amber-400"></i> AI Matching Engine Status
            </h3>
            <p class="text-xs text-slate-400">Hệ thống phân tích hình thái xương quai hàm, vầng trán và chất tóc</p>
        </div>
        <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/15 text-emerald-400 border border-emerald-500/30">
            <i class="fa-solid fa-circle-check text-[10px] mr-1"></i> Sẵn Sàng 100%
        </span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="p-4 rounded-2xl bg-slate-950/60 border border-slate-800 text-center">
            <div class="text-xs font-bold text-slate-400 mb-1">MẶT TRÒN (ROUND)</div>
            <div class="text-sm font-black text-amber-400">Side Part 7/3, Pompadour</div>
            <span class="text-[10px] text-slate-500">Tạo cảm giác mặt dài hơn</span>
        </div>
        <div class="p-4 rounded-2xl bg-slate-950/60 border border-slate-800 text-center">
            <div class="text-xs font-bold text-slate-400 mb-1">MẶT VUÔNG (SQUARE)</div>
            <div class="text-sm font-black text-sky-400">Textured Crop, Ivy League</div>
            <span class="text-[10px] text-slate-500">Tôn xương quai hàm nam tính</span>
        </div>
        <div class="p-4 rounded-2xl bg-slate-950/60 border border-slate-800 text-center">
            <div class="text-xs font-bold text-slate-400 mb-1">MẶT DÀI (OBLONG)</div>
            <div class="text-sm font-black text-purple-400">Two Block, Layer Mái Rủ</div>
            <span class="text-[10px] text-slate-500">Thu gọn chiều dài khuôn mặt</span>
        </div>
        <div class="p-4 rounded-2xl bg-slate-950/60 border border-slate-800 text-center">
            <div class="text-xs font-bold text-slate-400 mb-1">MẶT TRÁI XOAN (OVAL)</div>
            <div class="text-sm font-black text-emerald-400">Phù Hợp Mọi Kiểu Tóc</div>
            <span class="text-[10px] text-slate-500">Tỷ lệ vàng hoàn hảo</span>
        </div>
    </div>
</div>
@endsection
