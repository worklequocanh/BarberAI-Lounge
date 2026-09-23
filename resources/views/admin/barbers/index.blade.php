@extends('layouts.admin')

@section('title', 'Đội Ngũ Stylist & Barber')
@section('page-title', 'Đội Ngũ Stylist & Barber')
@section('page-description', 'Quản lý thông tin thợ cắt tóc, tay nghề, số năm kinh nghiệm và trạng thái làm việc.')

@section('breadcrumb')
    <span class="text-amber-400 font-semibold">Thợ Cắt Tóc</span>
@endsection

@section('content')
<div class="rounded-3xl bg-slate-900/90 border border-slate-800 shadow-2xl overflow-hidden">
    <div class="p-5 sm:p-6 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-950/40">
        <div>
            <h3 class="text-base font-bold text-white">Đội Ngũ Stylist Của Salon</h3>
            <p class="text-xs text-slate-400">Danh sách các Master Barber và kỹ thuật viên tạo mẫu</p>
        </div>
        <a href="{{ route('admin.barbers.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-bold shadow-lg shadow-amber-500/20 transition-all">
            <i class="fa-solid fa-user-plus"></i> Thêm Thợ Mới
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="border-b border-slate-800 bg-slate-950/60 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                    <th class="py-3.5 px-5">STYLIST</th>
                    <th class="py-3.5 px-4">KINH NGHIỆM</th>
                    <th class="py-3.5 px-4">ĐÁNH GIÁ</th>
                    <th class="py-3.5 px-4">LƯỢT REVIEW</th>
                    <th class="py-3.5 px-4">TRẠNG THÁI</th>
                    <th class="py-3.5 px-5 text-right">THAO TÁC</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/60">
                @forelse($barbers as $barber)
                <tr class="hover:bg-slate-800/30 transition-colors">
                    <td class="py-4 px-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-500 to-amber-300 p-0.5 shrink-0">
                                <div class="w-full h-full rounded-[10px] bg-slate-950 flex items-center justify-center text-amber-400 font-bold text-sm">
                                    <i class="fa-solid fa-user-ninja"></i>
                                </div>
                            </div>
                            <div>
                                <div class="font-bold text-white text-sm">{{ $barber->user->name ?? 'Stylist' }}</div>
                                <div class="text-xs text-slate-400">{{ $barber->user->phone ?? $barber->user->email ?? '---' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-4 text-xs font-semibold text-slate-300">
                        <strong class="text-amber-400 font-bold text-sm">{{ $barber->experience_years }}</strong> năm kinh nghiệm
                    </td>
                    <td class="py-4 px-4">
                        <span class="inline-flex items-center gap-1 text-xs font-bold text-amber-400 bg-amber-500/10 px-2 py-1 rounded-lg border border-amber-500/20">
                            <i class="fa-solid fa-star text-[10px]"></i> {{ number_format($barber->rating_avg, 1) }}
                        </span>
                    </td>
                    <td class="py-4 px-4 text-xs text-slate-400">
                        <span class="px-2 py-0.5 rounded-md bg-slate-800 border border-slate-700 font-semibold">{{ $barber->total_reviews }} nhận xét</span>
                    </td>
                    <td class="py-4 px-4">
                        @if($barber->is_available)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Đang sẵn sàng
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-800 text-slate-400 border border-slate-700">
                                Tạm nghỉ
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-5 text-right">
                        <div class="inline-flex items-center gap-2">
                            <a href="{{ route('admin.barbers.edit', $barber->id) }}" class="p-2 rounded-xl bg-slate-800 hover:bg-amber-500 hover:text-slate-950 text-slate-300 transition-colors" title="Sửa & Lịch nghỉ">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </a>
                            <form action="{{ route('admin.barbers.destroy', $barber->id) }}" method="POST" data-confirm="Xoá hồ sơ stylist {{ $barber->user->name ?? '' }}?" class="inline form-delete">
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
                    <td colspan="6" class="text-center py-12 text-slate-500">Chưa có thợ cắt tóc nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-5 border-t border-slate-800 flex justify-end">
        {{ $barbers->links() }}
    </div>
</div>
@endsection
