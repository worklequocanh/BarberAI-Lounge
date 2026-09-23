@extends('layouts.admin')

@section('title', 'Quản Lý Lịch Hẹn Cắt Tóc')
@section('page-title', 'Danh Sách Lịch Hẹn Cắt Tóc')
@section('page-description', 'Theo dõi và quản lý lịch đặt cắt tóc của khách hàng theo thời gian thực.')

@section('breadcrumb')
    <span class="text-[#22D3EE] font-semibold">Lịch Hẹn</span>
@endsection

@section('content')
<!-- Status Metrics Bar -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    <a href="{{ route('admin.appointments.index') }}" class="p-4 rounded-2xl bg-[#1E293B] border {{ !$status ? 'border-[#6366F1] shadow-lg shadow-indigo-500/10' : 'border-[#334155]' }} hover:bg-[#273449] hover:border-[#6366F1]/50 transition-all flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-[#6366F1]/15 text-[#818CF8] flex items-center justify-center shrink-0">
            <i class="fa-solid fa-list-check"></i>
        </div>
        <div>
            <div class="text-[11px] font-bold uppercase text-[#94A3B8]">Tất Cả Lịch</div>
            <div class="text-xl font-black text-[#F8FAFC]">{{ $counts['total'] }}</div>
        </div>
    </a>

    <a href="{{ route('admin.appointments.index', ['status' => 'pending']) }}" class="p-4 rounded-2xl bg-[#1E293B] border {{ $status === 'pending' ? 'border-[#F59E0B] shadow-lg shadow-amber-500/10' : 'border-[#334155]' }} hover:bg-[#273449] hover:border-[#F59E0B]/50 transition-all flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-[#F59E0B]/15 text-[#F59E0B] flex items-center justify-center shrink-0">
            <i class="fa-solid fa-clock-rotate-left"></i>
        </div>
        <div>
            <div class="text-[11px] font-bold uppercase text-[#94A3B8]">Chờ Xử Lý</div>
            <div class="text-xl font-black text-[#F59E0B]">{{ $counts['pending'] }}</div>
        </div>
    </a>

    <a href="{{ route('admin.appointments.index', ['status' => 'confirmed']) }}" class="p-4 rounded-2xl bg-[#1E293B] border {{ $status === 'confirmed' ? 'border-[#38BDF8] shadow-lg shadow-sky-500/10' : 'border-[#334155]' }} hover:bg-[#273449] hover:border-[#38BDF8]/50 transition-all flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-[#38BDF8]/15 text-[#38BDF8] flex items-center justify-center shrink-0">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div>
            <div class="text-[11px] font-bold uppercase text-[#94A3B8]">Đã Xác Nhận</div>
            <div class="text-xl font-black text-[#38BDF8]">{{ $counts['confirmed'] }}</div>
        </div>
    </a>

    <a href="{{ route('admin.appointments.index', ['status' => 'completed']) }}" class="p-4 rounded-2xl bg-[#1E293B] border {{ $status === 'completed' ? 'border-[#10B981] shadow-lg shadow-emerald-500/10' : 'border-[#334155]' }} hover:bg-[#273449] hover:border-[#10B981]/50 transition-all flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-[#10B981]/15 text-[#10B981] flex items-center justify-center shrink-0">
            <i class="fa-solid fa-sparkles"></i>
        </div>
        <div>
            <div class="text-[11px] font-bold uppercase text-[#94A3B8]">Đã Hoàn Thành</div>
            <div class="text-xl font-black text-[#10B981]">{{ $counts['completed'] }}</div>
        </div>
    </a>
</div>

<!-- Appointments Master Table Card -->
<div class="rounded-3xl bg-[#1E293B] border border-[#334155] shadow-2xl overflow-hidden">
    <!-- Header Bar -->
    <div class="p-5 sm:p-6 border-b border-[#334155] flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-[#111827]/60">
        <div class="flex items-center gap-3">
            <h3 class="text-base font-bold text-[#F8FAFC]">Danh Sách Lịch Đặt Chỗ</h3>
            @if($status)
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-[#0B1120] text-[#22D3EE] border border-[#334155]">
                    Lọc: {{ ucfirst($status) }}
                </span>
            @endif
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.appointments.timeline') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-[#0B1120] hover:bg-[#273449] text-[#CBD5E1] border border-[#334155] text-xs font-bold transition-colors">
                <i class="fa-solid fa-table-cells text-[#22D3EE]"></i>
                <span>Matrix Timeline</span>
            </a>
            <a href="{{ route('admin.appointments.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#6366F1] hover:bg-[#818CF8] text-white text-xs font-bold shadow-lg shadow-indigo-500/20 transition-all">
                <i class="fa-solid fa-plus"></i>
                <span>Tạo Lịch Hẹn Mới</span>
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="border-b border-[#334155] bg-[#0B1120]/40 text-[11px] font-bold uppercase tracking-wider text-[#94A3B8]">
                    <th class="py-3.5 px-5">MÃ LỊCH</th>
                    <th class="py-3.5 px-4">KHÁCH HÀNG</th>
                    <th class="py-3.5 px-4">BARBER</th>
                    <th class="py-3.5 px-4">NGÀY & GIỜ</th>
                    <th class="py-3.5 px-4">DỊCH VỤ</th>
                    <th class="py-3.5 px-4">TỔNG TIỀN</th>
                    <th class="py-3.5 px-4">TRẠNG THÁI</th>
                    <th class="py-3.5 px-5 text-right">THAO TÁC</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#334155]">
                @forelse($appointments as $appointment)
                <tr class="hover:bg-[#273449]/40 transition-colors">
                    <td class="py-4 px-5 font-mono text-xs font-bold text-[#22D3EE]">
                        #{{ $appointment->code ?? ('APT-' . str_pad($appointment->id, 5, '0', STR_PAD_LEFT)) }}
                    </td>
                    <td class="py-4 px-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-[#0B1120] border border-[#334155] text-[#CBD5E1] flex items-center justify-center font-bold text-xs shrink-0">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div>
                                <div class="font-bold text-[#F8FAFC] leading-tight">{{ $appointment->customer->name ?? 'Khách vãng lai' }}</div>
                                <div class="text-xs text-[#94A3B8] mt-0.5">{{ $appointment->customer->phone ?? '---' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-4">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-[#0B1120] text-[#CBD5E1] border border-[#334155]">
                            <i class="fa-solid fa-scissors text-[#22D3EE] text-[11px]"></i>
                            {{ $appointment->barber->user->name ?? 'Chưa chỉ định' }}
                        </span>
                    </td>
                    <td class="py-4 px-4">
                        <div class="text-xs font-semibold text-[#CBD5E1]">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}</div>
                        <div class="text-[11px] text-[#22D3EE] font-bold">{{ $appointment->start_time ?? '09:00' }}</div>
                    </td>
                    <td class="py-4 px-4">
                        <div class="flex flex-wrap gap-1 max-w-[200px]">
                            @if($appointment->services && $appointment->services->count() > 0)
                                @foreach($appointment->services->take(2) as $s)
                                    <span class="px-2 py-0.5 rounded-md text-[11px] font-medium bg-[#0B1120] text-[#CBD5E1] border border-[#334155]">
                                        {{ $s->name }}
                                    </span>
                                @endforeach
                                @if($appointment->services->count() > 2)
                                    <span class="px-1.5 py-0.5 rounded-md text-[10px] font-bold bg-[#6366F1]/20 text-[#818CF8] border border-[#6366F1]/30">
                                        +{{ $appointment->services->count() - 2 }}
                                    </span>
                                @endif
                            @else
                                <span class="text-xs text-[#94A3B8]">Cắt tóc tiêu chuẩn</span>
                            @endif
                        </div>
                    </td>
                    <td class="py-4 px-4 font-black text-[#10B981] text-sm">
                        {{ number_format($appointment->total_price, 0, ',', '.') }}đ
                    </td>
                    <td class="py-4 px-4">
                        @if($appointment->status === 'completed')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-[#10B981]/15 text-[#10B981] border border-[#10B981]/30">
                                <i class="fa-solid fa-circle-check text-[10px]"></i> Hoàn thành
                            </span>
                        @elseif($appointment->status === 'confirmed')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-[#38BDF8]/15 text-[#38BDF8] border border-[#38BDF8]/30">
                                <i class="fa-solid fa-circle-dot text-[10px]"></i> Đã xác nhận
                            </span>
                        @elseif($appointment->status === 'cancelled')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-[#F43F5E]/15 text-[#F43F5E] border border-[#F43F5E]/30">
                                <i class="fa-solid fa-circle-xmark text-[10px]"></i> Đã huỷ
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-[#F59E0B]/15 text-[#F59E0B] border border-[#F59E0B]/30">
                                <i class="fa-solid fa-clock text-[10px]"></i> Chờ xử lý
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-5 text-right">
                        <div class="inline-flex items-center gap-2">
                            <a href="{{ route('admin.appointments.edit', $appointment->id) }}" class="p-2 rounded-xl bg-[#0B1120] hover:bg-[#6366F1] hover:text-white border border-[#334155] text-[#CBD5E1] transition-colors" title="Chỉnh sửa">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </a>
                            <form action="{{ route('admin.appointments.destroy', $appointment->id) }}" method="POST" data-confirm="Xoá vĩnh viễn lịch hẹn #{{ $appointment->code }}?" class="inline form-delete">
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
                    <td colspan="8" class="text-center py-12 text-[#94A3B8]">
                        <i class="fa-regular fa-calendar-xmark text-4xl block mb-2 text-[#334155]"></i>
                        Không tìm thấy lịch hẹn nào
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="p-5 border-t border-[#334155] flex justify-end">
        {{ $appointments->links() }}
    </div>
</div>
@endsection
