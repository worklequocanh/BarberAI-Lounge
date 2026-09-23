@extends('layouts.admin')

@section('title', 'Bảng Giá & Dịch Vụ Salon')
@section('page-title', 'Bảng Giá Dịch Vụ & Combo')
@section('page-description', 'Danh mục các dịch vụ cắt, uốn, nhuộm, chăm sóc tóc và các gói Combo ưu đãi.')

@section('breadcrumb')
    <span class="text-[#22D3EE] font-semibold">Dịch Vụ</span>
@endsection

@section('content')
<div class="rounded-3xl bg-[#1E293B] border border-[#334155] shadow-2xl overflow-hidden">
    <div class="p-5 sm:p-6 border-b border-[#334155] flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-[#111827]/60">
        <div>
            <h3 class="text-base font-bold text-[#F8FAFC]">Tất Cả Dịch Vụ & Combo</h3>
            <p class="text-xs text-[#94A3B8]">Thiết lập menu giá niêm yết và các gói tiết kiệm cho khách</p>
        </div>
        <a href="{{ route('admin.services.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#6366F1] hover:bg-[#818CF8] text-white text-xs font-bold shadow-lg shadow-indigo-500/20 transition-all">
            <i class="fa-solid fa-plus"></i> Thêm Dịch Vụ / Combo Mới
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="border-b border-[#334155] bg-[#0B1120]/40 text-[11px] font-bold uppercase tracking-wider text-[#94A3B8]">
                    <th class="py-3.5 px-5">TÊN DỊCH VỤ</th>
                    <th class="py-3.5 px-4">DANH MỤC</th>
                    <th class="py-3.5 px-4">THỜI GIAN</th>
                    <th class="py-3.5 px-4">GIÁ BÁN</th>
                    <th class="py-3.5 px-4">TRẠNG THÁI</th>
                    <th class="py-3.5 px-5 text-right">THAO TÁC</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#334155]">
                @forelse($services as $service)
                <tr class="hover:bg-[#273449]/40 transition-colors">
                    <td class="py-4 px-5">
                        <div class="flex items-center gap-2 font-bold text-[#F8FAFC]">
                            {{ $service->name }}
                            @if($service->is_combo)
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-[#10B981]/20 text-[#10B981] border border-[#10B981]/30">
                                    <i class="fa-solid fa-crown text-[9px] mr-0.5"></i> COMBO TIẾT KIỆM
                                </span>
                            @endif
                        </div>
                        <div class="text-xs text-[#94A3B8] mt-0.5">{{ Str::limit($service->description, 60) }}</div>
                    </td>
                    <td class="py-4 px-4">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-medium bg-[#0B1120] text-[#CBD5E1] border border-[#334155]">
                            {{ $service->category->name ?? 'Dịch Vụ Chung' }}
                        </span>
                    </td>
                    <td class="py-4 px-4 text-xs text-[#CBD5E1] font-medium">
                        <i class="fa-regular fa-clock text-[#22D3EE] mr-1"></i> {{ $service->duration_min ?? 30 }} phút
                    </td>
                    <td class="py-4 px-4">
                        <div class="font-extrabold text-[#22D3EE] text-sm">
                            {{ number_format($service->price, 0, ',', '.') }}đ
                        </div>
                        @if($service->original_price && $service->original_price > $service->price)
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <span class="text-xs text-[#94A3B8] line-through">
                                    {{ number_format($service->original_price, 0, ',', '.') }}đ
                                </span>
                                <span class="text-[10px] font-bold px-1.5 py-0.2 rounded bg-[#F43F5E]/20 text-[#F43F5E]">
                                    -{{ round((($service->original_price - $service->price) / $service->original_price) * 100) }}%
                                </span>
                            </div>
                        @endif
                    </td>
                    <td class="py-4 px-4">
                        @if($service->is_active ?? true)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#10B981]/15 text-[#10B981] border border-[#10B981]/30">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#10B981]"></span> Đang phục vụ
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#0B1120] text-[#94A3B8] border border-[#334155]">
                                Tạm ngừng
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-5 text-right">
                        <div class="inline-flex items-center gap-2">
                            <a href="{{ route('admin.services.edit', $service->id) }}" class="p-2 rounded-xl bg-[#0B1120] hover:bg-[#6366F1] hover:text-white border border-[#334155] text-[#CBD5E1] transition-colors" title="Sửa">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </a>
                            <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" data-confirm="Xoá dịch vụ '{{ $service->name }}'?" class="inline form-delete">
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
                    <td colspan="6" class="text-center py-12 text-[#94A3B8]">Chưa có dịch vụ nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-5 border-t border-[#334155] flex justify-end">
        {{ $services->links() }}
    </div>
</div>
@endsection
