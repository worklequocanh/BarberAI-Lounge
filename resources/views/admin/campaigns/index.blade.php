@extends('layouts.admin')

@section('title', 'Email Marketing & Chăm Sóc Khách Hàng')
@section('page-title', 'Chiến Dịch Email Marketing')
@section('page-description', 'Gửi ưu đãi chăm sóc lại khách lâu chưa cắt, voucher tri ân và tự động hoá marketing.')

@section('breadcrumb')
    <span class="text-amber-400 font-semibold">Marketing Campaigns</span>
@endsection

@section('content')
<!-- Stats Metric Cards -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
    <div class="p-5 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-400 border border-amber-500/20 flex items-center justify-center text-xl shrink-0">
            <i class="fa-solid fa-envelopes-bulk"></i>
        </div>
        <div>
            <div class="text-[11px] font-bold uppercase text-slate-400">Tổng Chiến Dịch</div>
            <div class="text-2xl font-black text-white">{{ $campaigns->total() }}</div>
        </div>
    </div>

    <div class="p-5 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center text-xl shrink-0">
            <i class="fa-solid fa-paper-plane"></i>
        </div>
        <div>
            <div class="text-[11px] font-bold uppercase text-slate-400">Email Đã Gửi Ra</div>
            <div class="text-2xl font-black text-emerald-400">{{ number_format($totalSent, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="p-5 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-sky-500/10 text-sky-400 border border-sky-500/20 flex items-center justify-center text-xl shrink-0">
            <i class="fa-solid fa-users"></i>
        </div>
        <div>
            <div class="text-[11px] font-bold uppercase text-slate-400">Tệp Khách Khả Dụng</div>
            <div class="text-2xl font-black text-sky-400">{{ $customerAudienceCount }} <span class="text-sm font-medium text-slate-400">khách</span></div>
        </div>
    </div>
</div>

<!-- Campaigns Master Table -->
<div class="rounded-3xl bg-slate-900/90 border border-slate-800 shadow-2xl overflow-hidden">
    <div class="p-5 sm:p-6 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-950/40">
        <div>
            <h3 class="text-base font-bold text-white">Danh Sách Chiến Dịch Email</h3>
            <p class="text-xs text-slate-400">Thiết lập nội dung và kích hoạt gửi hàng loạt</p>
        </div>
        <a href="{{ route('admin.campaigns.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-bold shadow-lg shadow-amber-500/20 transition-all">
            <i class="fa-solid fa-plus"></i> Soạn Chiến Dịch Mới
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="border-b border-slate-800 bg-slate-950/60 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                    <th class="py-3.5 px-5">TÊN CHIẾN DỊCH / TIÊU ĐỀ</th>
                    <th class="py-3.5 px-4">TỆP KHÁCH HÀNG</th>
                    <th class="py-3.5 px-4">MÃ COUPON</th>
                    <th class="py-3.5 px-4">LƯỢT GỬI</th>
                    <th class="py-3.5 px-4">TRẠNG THÁI</th>
                    <th class="py-3.5 px-5 text-right">THAO TÁC</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/60">
                @forelse($campaigns as $camp)
                <tr class="hover:bg-slate-800/30 transition-colors">
                    <td class="py-4 px-5">
                        <div class="font-bold text-white">{{ $camp->title }}</div>
                        <div class="text-xs text-slate-400 mt-0.5 flex items-center gap-1.5">
                            <i class="fa-regular fa-envelope text-amber-400"></i> {{ $camp->subject }}
                        </div>
                    </td>
                    <td class="py-4 px-4">
                        @if($camp->target_audience === 'inactive_30d')
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-500/15 text-amber-400 border border-amber-500/30">
                                Khách > 30 ngày chưa cắt
                            </span>
                        @elseif($camp->target_audience === 'vip_customers')
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-500/15 text-purple-300 border border-purple-500/30">
                                Khách VIP thân thiết
                            </span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-800 text-slate-300 border border-slate-700">
                                Toàn bộ khách hàng
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-4">
                        @if($camp->coupon_code)
                            <span class="font-mono font-bold text-xs px-2.5 py-1 rounded-lg bg-amber-500/10 text-amber-300 border border-amber-500/20">
                                {{ $camp->coupon_code }}
                            </span>
                        @else
                            <span class="text-xs text-slate-500">Không đính kèm</span>
                        @endif
                    </td>
                    <td class="py-4 px-4 text-xs">
                        <strong class="text-white">{{ $camp->sent_count }}</strong> emails
                        @if($camp->sent_at)
                            <div class="text-[11px] text-slate-500">{{ $camp->sent_at->format('d/m/Y H:i') }}</div>
                        @endif
                    </td>
                    <td class="py-4 px-4">
                        @if($camp->status === 'sent')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-500/15 text-emerald-400 border border-emerald-500/30">
                                <i class="fa-solid fa-circle-check text-[10px]"></i> Đã gửi
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-800 text-slate-400 border border-slate-700">
                                Bản nháp
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-5 text-right">
                        <div class="inline-flex items-center gap-2">
                            @if($camp->status !== 'sent')
                            <form action="{{ route('admin.campaigns.send', $camp->id) }}" method="POST" class="inline" data-confirm="Bắn chiến dịch email '{{ $camp->title }}' ngay bây giờ?">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-bold shadow-md shadow-amber-500/20 transition-all">
                                    <i class="fa-solid fa-paper-plane mr-1"></i> Bắn Email
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('admin.campaigns.destroy', $camp->id) }}" method="POST" data-confirm="Xoá chiến dịch '{{ $camp->title }}'?" class="inline form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-xl bg-slate-800 hover:bg-rose-500 hover:text-white text-slate-400 transition-colors" title="Xoá">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-12 text-slate-500">Chưa có chiến dịch email nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-5 border-t border-slate-800 flex justify-end">
        {{ $campaigns->links() }}
    </div>
</div>
@endsection
