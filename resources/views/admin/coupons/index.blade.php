@extends('layouts.admin')

@section('title', 'Mã Giảm Giá & Voucher')
@section('page-title', 'Mã Giảm Giá & Voucher')
@section('page-description', 'Danh sách mã ưu đãi, giảm giá phần trăm hoặc số tiền cố định cho khách hàng.')

@section('breadcrumb')
    <span class="text-amber-400 font-semibold">Khuyến Mãi</span>
@endsection

@section('content')
<div class="rounded-3xl bg-slate-900/90 border border-slate-800 shadow-2xl overflow-hidden">
    <div class="p-5 sm:p-6 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-950/40">
        <div>
            <h3 class="text-base font-bold text-white">Danh Sách Mã Giảm Giá</h3>
            <p class="text-xs text-slate-400">Tạo voucher kích cầu và gắn vào các chiến dịch Email Marketing</p>
        </div>
        <a href="{{ route('admin.coupons.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-bold shadow-lg shadow-amber-500/20 transition-all">
            <i class="fa-solid fa-plus"></i> Tạo Mã Mới
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="border-b border-slate-800 bg-slate-950/60 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                    <th class="py-3.5 px-5">MÃ VOUCHER</th>
                    <th class="py-3.5 px-4">MỨC GIẢM</th>
                    <th class="py-3.5 px-4">ĐƠN TỐI THIỂU</th>
                    <th class="py-3.5 px-4">LƯỢT DÙNG</th>
                    <th class="py-3.5 px-4">HẠN DÙNG</th>
                    <th class="py-3.5 px-4">TRẠNG THÁI</th>
                    <th class="py-3.5 px-5 text-right">THAO TÁC</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/60">
                @forelse($coupons as $coupon)
                <tr class="hover:bg-slate-800/30 transition-colors">
                    <td class="py-4 px-5">
                        <span class="font-mono font-bold text-xs px-3 py-1.5 rounded-xl bg-amber-500/10 text-amber-300 border border-dashed border-amber-500/40 tracking-wider">
                            {{ $coupon->code }}
                        </span>
                    </td>
                    <td class="py-4 px-4 font-extrabold text-emerald-400 text-sm">
                        @if($coupon->discount_type === 'percent')
                            Giảm {{ (int)$coupon->discount_value }}%
                        @else
                            Giảm {{ number_format($coupon->discount_value, 0, ',', '.') }}đ
                        @endif
                    </td>
                    <td class="py-4 px-4 text-xs text-slate-300">
                        {{ number_format($coupon->min_order_amount ?? 0, 0, ',', '.') }}đ
                    </td>
                    <td class="py-4 px-4 text-xs text-slate-300">
                        <strong class="text-white">{{ $coupon->used_count ?? 0 }}</strong> / {{ $coupon->usage_limit ?? '∞' }}
                    </td>
                    <td class="py-4 px-4 text-xs text-slate-400">
                        {{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('d/m/Y') : 'Vô thời hạn' }}
                    </td>
                    <td class="py-4 px-4">
                        @if($coupon->is_active ?? true)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                Đang hiệu lực
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-800 text-slate-400 border border-slate-700">
                                Tạm khoá
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-5 text-right">
                        <div class="inline-flex items-center gap-2">
                            <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="p-2 rounded-xl bg-slate-800 hover:bg-amber-500 hover:text-slate-950 text-slate-300 transition-colors" title="Sửa">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </a>
                            <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" data-confirm="Xoá mã voucher {{ $coupon->code }}?" class="inline form-delete">
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
                    <td colspan="7" class="text-center py-12 text-slate-500">Chưa có mã giảm giá nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-5 border-t border-slate-800 flex justify-end">
        {{ $coupons->links() }}
    </div>
</div>
@endsection
