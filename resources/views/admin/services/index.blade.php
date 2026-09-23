@extends('layouts.admin')

@section('title', 'Bảng Giá & Dịch Vụ Salon')
@section('page-title', 'Bảng Giá Dịch Vụ & Combo')
@section('page-description', 'Danh mục các dịch vụ cắt, uốn, nhuộm, chăm sóc tóc và các gói Combo ưu đãi.')

@section('breadcrumb')
    <span class="text-amber-400 font-semibold">Dịch Vụ</span>
@endsection

@section('content')
<div class="rounded-3xl bg-slate-900/90 border border-slate-800 shadow-2xl overflow-hidden">
    <div class="p-5 sm:p-6 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-950/40">
        <div>
            <h3 class="text-base font-bold text-white">Tất Cả Dịch Vụ & Combo</h3>
            <p class="text-xs text-slate-400">Thiết lập menu giá niêm yết và các gói tiết kiệm cho khách</p>
        </div>
        <a href="{{ route('admin.services.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-bold shadow-lg shadow-amber-500/20 transition-all">
            <i class="fa-solid fa-plus"></i> Thêm Dịch Vụ / Combo Mới
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="border-b border-slate-800 bg-slate-950/60 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                    <th class="py-3.5 px-5">TÊN DỊCH VỤ</th>
                    <th class="py-3.5 px-4">DANH MỤC</th>
                    <th class="py-3.5 px-4">THỜI GIAN</th>
                    <th class="py-3.5 px-4">GIÁ BÁN</th>
                    <th class="py-3.5 px-4">TRẠNG THÁI</th>
                    <th class="py-3.5 px-5 text-right">THAO TÁC</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/60">
                @forelse($services as $service)
                <tr class="hover:bg-slate-800/30 transition-colors">
                    <td class="py-4 px-5">
                        <div class="flex items-center gap-2 font-bold text-white">
                            {{ $service->name }}
                            @if($service->is_combo)
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-gradient-to-r from-amber-500/20 to-amber-300/20 text-amber-300 border border-amber-500/30">
                                    <i class="fa-solid fa-crown text-[9px] mr-0.5"></i> COMBO TIẾT KIỆM
                                </span>
                            @endif
                        </div>
                        <div class="text-xs text-slate-400 mt-0.5">{{ Str::limit($service->description, 60) }}</div>
                    </td>
                    <td class="py-4 px-4">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-800 text-slate-300 border border-slate-700">
                            {{ $service->category->name ?? 'Dịch Vụ Chung' }}
                        </span>
                    </td>
                    <td class="py-4 px-4 text-xs text-slate-300 font-medium">
                        <i class="fa-regular fa-clock text-amber-400 mr-1"></i> {{ $service->duration_min ?? 30 }} phút
                    </td>
                    <td class="py-4 px-4">
                        <div class="font-extrabold text-amber-400 text-sm">
                            {{ number_format($service->price, 0, ',', '.') }}đ
                        </div>
                        @if($service->original_price && $service->original_price > $service->price)
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <span class="text-xs text-slate-500 line-through">
                                    {{ number_format($service->original_price, 0, ',', '.') }}đ
                                </span>
                                <span class="text-[10px] font-bold px-1.5 py-0.2 rounded bg-rose-500/20 text-rose-400">
                                    -{{ round((($service->original_price - $service->price) / $service->original_price) * 100) }}%
                                </span>
                            </div>
                        @endif
                    </td>
                    <td class="py-4 px-4">
                        @if($service->is_active ?? true)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Đang phục vụ
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-800 text-slate-400 border border-slate-700">
                                Tạm ngừng
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-5 text-right">
                        <div class="inline-flex items-center gap-2">
                            <a href="{{ route('admin.services.edit', $service->id) }}" class="p-2 rounded-xl bg-slate-800 hover:bg-amber-500 hover:text-slate-950 text-slate-300 transition-colors" title="Sửa">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </a>
                            <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" data-confirm="Xoá dịch vụ '{{ $service->name }}'?" class="inline form-delete">
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
                    <td colspan="6" class="text-center py-12 text-slate-500">Chưa có dịch vụ nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-5 border-t border-slate-800 flex justify-end">
        {{ $services->links() }}
    </div>
</div>
@endsection
