@extends('layouts.admin')

@section('title', 'Đội Ngũ Stylist & Barber')
@section('page-title', 'Đội Ngũ Stylist & Barber')
@section('page-description', 'Quản lý thông tin thợ cắt tóc, tay nghề, số năm kinh nghiệm và trạng thái làm việc.')

@section('breadcrumb')
    <span class="text-[#22D3EE] font-semibold">Thợ Cắt Tóc</span>
@endsection

@section('content')
<div class="rounded-3xl bg-[#1E293B] border border-[#334155] shadow-2xl overflow-hidden">
    <div class="p-5 sm:p-6 border-b border-[#334155] flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-[#111827]/60">
        <div>
            <h3 class="text-base font-bold text-[#F8FAFC]">Đội Ngũ Stylist Của Salon</h3>
            <p class="text-xs text-[#94A3B8]">Danh sách các Master Barber và kỹ thuật viên tạo mẫu</p>
        </div>
        <a href="{{ route('admin.barbers.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#6366F1] hover:bg-[#818CF8] text-white text-xs font-bold shadow-lg shadow-indigo-500/20 transition-all">
            <i class="fa-solid fa-user-plus"></i> Thêm Thợ Mới
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="border-b border-[#334155] bg-[#0B1120]/40 text-[11px] font-bold uppercase tracking-wider text-[#94A3B8]">
                    <th class="py-3.5 px-5">STYLIST</th>
                    <th class="py-3.5 px-4">KINH NGHIỆM</th>
                    <th class="py-3.5 px-4">ĐÁNH GIÁ</th>
                    <th class="py-3.5 px-4">LƯỢT REVIEW</th>
                    <th class="py-3.5 px-4">TRẠNG THÁI</th>
                    <th class="py-3.5 px-5 text-right">THAO TÁC</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#334155]">
                @forelse($barbers as $barber)
                <tr class="hover:bg-[#273449]/40 transition-colors">
                    <td class="py-4 px-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-[#6366F1] to-[#22D3EE] p-0.5 shrink-0">
                                <div class="w-full h-full rounded-[10px] bg-[#0B1120] flex items-center justify-center text-[#22D3EE] font-bold text-sm">
                                    <i class="fa-solid fa-user-ninja"></i>
                                </div>
                            </div>
                            <div>
                                <div class="font-bold text-[#F8FAFC] text-sm">{{ $barber->user->name ?? 'Stylist' }}</div>
                                <div class="text-xs text-[#94A3B8]">{{ $barber->user->phone ?? $barber->user->email ?? '---' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-4 text-xs font-semibold text-[#CBD5E1]">
                        <strong class="text-[#22D3EE] font-bold text-sm">{{ $barber->experience_years }}</strong> năm kinh nghiệm
                    </td>
                    <td class="py-4 px-4">
                        <span class="inline-flex items-center gap-1 text-xs font-bold text-[#F59E0B] bg-[#F59E0B]/10 px-2 py-1 rounded-lg border border-[#F59E0B]/20">
                            <i class="fa-solid fa-star text-[10px]"></i> {{ number_format($barber->rating_avg, 1) }}
                        </span>
                    </td>
                    <td class="py-4 px-4 text-xs text-[#94A3B8]">
                        <span class="px-2 py-0.5 rounded-md bg-[#0B1120] border border-[#334155] font-semibold">{{ $barber->total_reviews }} nhận xét</span>
                    </td>
                    <td class="py-4 px-4">
                        @if($barber->is_available)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#10B981]/15 text-[#10B981] border border-[#10B981]/30">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#10B981]"></span> Đang sẵn sàng
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#0B1120] text-[#94A3B8] border border-[#334155]">
                                Tạm nghỉ
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-5 text-right">
                        <div class="inline-flex items-center gap-2">
                            <a href="{{ route('admin.barbers.edit', $barber->id) }}" class="p-2 rounded-xl bg-[#0B1120] hover:bg-[#6366F1] hover:text-white border border-[#334155] text-[#CBD5E1] transition-colors" title="Sửa & Lịch nghỉ">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </a>
                            <form action="{{ route('admin.barbers.destroy', $barber->id) }}" method="POST" data-confirm="Xoá hồ sơ stylist {{ $barber->user->name ?? '' }}?" class="inline form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-xl bg-[#0B1120] hover:bg-[#F43F5E] hover:text-white border border-[#334155] text-[#94A3B8] transition-colors" title="Xoá">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-12 text-[#94A3B8]">Chưa có thợ cắt tóc nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-5 border-t border-[#334155] flex justify-end">
        {{ $barbers->links() }}
    </div>
</div>
@endsection
