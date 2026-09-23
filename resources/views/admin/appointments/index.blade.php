@extends('layouts.admin')

@section('title', 'Quản Lý Lịch Hẹn Cắt Tóc')
@section('page-title', 'Danh Sách Lịch Hẹn Cắt Tóc')
@section('page-description', 'Theo dõi và quản lý lịch đặt cắt tóc của khách hàng theo thời gian thực.')

@section('breadcrumb')
    <span class="text-amber-400 font-semibold">Lịch Hẹn</span>
@endsection

@section('content')
<!-- Status Metrics Bar -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    <a href="{{ route('admin.appointments.index') }}" class="p-4 rounded-2xl bg-slate-900/90 border {{ !$status ? 'border-amber-500/60 shadow-lg shadow-amber-500/10' : 'border-slate-800' }} hover:border-amber-500/40 transition-all flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center shrink-0">
            <i class="fa-solid fa-list-check"></i>
        </div>
        <div>
            <div class="text-[11px] font-bold uppercase text-slate-400">Tất Cả Lịch</div>
            <div class="text-xl font-black text-white">{{ $counts['total'] }}</div>
        </div>
    </a>

    <a href="{{ route('admin.appointments.index', ['status' => 'pending']) }}" class="p-4 rounded-2xl bg-slate-900/90 border {{ $status === 'pending' ? 'border-amber-500/60 shadow-lg shadow-amber-500/10' : 'border-slate-800' }} hover:border-amber-500/40 transition-all flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center shrink-0">
            <i class="fa-solid fa-clock-rotate-left"></i>
        </div>
        <div>
            <div class="text-[11px] font-bold uppercase text-slate-400">Chờ Xử Lý</div>
            <div class="text-xl font-black text-amber-400">{{ $counts['pending'] }}</div>
        </div>
    </a>

    <a href="{{ route('admin.appointments.index', ['status' => 'confirmed']) }}" class="p-4 rounded-2xl bg-slate-900/90 border {{ $status === 'confirmed' ? 'border-sky-500/60 shadow-lg shadow-sky-500/10' : 'border-slate-800' }} hover:border-sky-500/40 transition-all flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-sky-500/10 text-sky-400 flex items-center justify-center shrink-0">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div>
            <div class="text-[11px] font-bold uppercase text-slate-400">Đã Xác Nhận</div>
            <div class="text-xl font-black text-sky-400">{{ $counts['confirmed'] }}</div>
        </div>
    </a>

    <a href="{{ route('admin.appointments.index', ['status' => 'completed']) }}" class="p-4 rounded-2xl bg-slate-900/90 border {{ $status === 'completed' ? 'border-emerald-500/60 shadow-lg shadow-emerald-500/10' : 'border-slate-800' }} hover:border-emerald-500/40 transition-all flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center shrink-0">
            <i class="fa-solid fa-sparkles"></i>
        </div>
        <div>
            <div class="text-[11px] font-bold uppercase text-slate-400">Đã Hoàn Thành</div>
            <div class="text-xl font-black text-emerald-400">{{ $counts['completed'] }}</div>
        </div>
    </a>
</div>

<!-- Appointments Master Table Card -->
<div class="rounded-3xl bg-slate-900/90 border border-slate-800 shadow-2xl overflow-hidden">
    <!-- Header Bar -->
    <div class="p-5 sm:p-6 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-950/40">
        <div class="flex items-center gap-3">
            <h3 class="text-base font-bold text-white">Danh Sách Lịch Đặt Chỗ</h3>
            @if($status)
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-800 text-amber-400 border border-slate-700">
                    Lọc: {{ ucfirst($status) }}
                </span>
            @endif
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.appointments.timeline') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-200 border border-slate-700 text-xs font-bold transition-colors">
                <i class="fa-solid fa-table-cells text-amber-400"></i>
                <span>Matrix Timeline</span>
            </a>
            <a href="{{ route('admin.appointments.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-bold shadow-lg shadow-amber-500/20 transition-all">
                <i class="fa-solid fa-plus"></i>
                <span>Tạo Lịch Hẹn Mới</span>
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="border-b border-slate-800 bg-slate-950/60 text-[11px] font-bold uppercase tracking-wider text-slate-400">
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
            <tbody class="divide-y divide-slate-800/60">
                @forelse($appointments as $appointment)
                <tr class="hover:bg-slate-800/30 transition-colors">
                    <td class="py-4 px-5 font-mono text-xs font-bold text-amber-400">
                        #{{ $appointment->code ?? ('APT-' . str_pad($appointment->id, 5, '0', STR_PAD_LEFT)) }}
                    </td>
                    <td class="py-4 px-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-slate-800 text-slate-300 flex items-center justify-center font-bold text-xs shrink-0">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div>
                                <div class="font-bold text-white leading-tight">{{ $appointment->customer->name ?? 'Khách vãng lai' }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">{{ $appointment->customer->phone ?? '---' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-4">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-800/80 text-slate-300 border border-slate-700/60">
                            <i class="fa-solid fa-scissors text-amber-400 text-[11px]"></i>
                            {{ $appointment->barber->user->name ?? 'Chưa chỉ định' }}
                        </span>
                    </td>
                    <td class="py-4 px-4">
                        <div class="text-xs font-semibold text-slate-200">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}</div>
                        <div class="text-[11px] text-amber-400 font-bold">{{ $appointment->start_time ?? '09:00' }}</div>
                    </td>
                    <td class="py-4 px-4">
                        <div class="flex flex-wrap gap-1 max-w-[200px]">
                            @if($appointment->services && $appointment->services->count() > 0)
                                @foreach($appointment->services->take(2) as $s)
                                    <span class="px-2 py-0.5 rounded-md text-[11px] font-medium bg-slate-800 text-slate-300 border border-slate-700">
                                        {{ $s->name }}
                                    </span>
                                @endforeach
                                @if($appointment->services->count() > 2)
                                    <span class="px-1.5 py-0.5 rounded-md text-[10px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                        +{{ $appointment->services->count() - 2 }}
                                    </span>
                                @endif
                            @else
                                <span class="text-xs text-slate-500">Cắt tóc tiêu chuẩn</span>
                            @endif
                        </div>
                    </td>
                    <td class="py-4 px-4 font-black text-emerald-400 text-sm">
                        {{ number_format($appointment->total_price, 0, ',', '.') }}đ
                    </td>
                    <td class="py-4 px-4">
                        @if($appointment->status === 'completed')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                <i class="fa-solid fa-circle-check text-[10px]"></i> Hoàn thành
                            </span>
                        @elseif($appointment->status === 'confirmed')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-sky-500/10 text-sky-400 border border-sky-500/20">
                                <i class="fa-solid fa-circle-dot text-[10px]"></i> Đã xác nhận
                            </span>
                        @elseif($appointment->status === 'cancelled')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                <i class="fa-solid fa-circle-xmark text-[10px]"></i> Đã huỷ
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                <i class="fa-solid fa-clock text-[10px]"></i> Chờ xử lý
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-5 text-right">
                        <div class="inline-flex items-center gap-2">
                            <a href="{{ route('admin.appointments.edit', $appointment->id) }}" class="p-2 rounded-xl bg-slate-800 hover:bg-amber-500 hover:text-slate-950 text-slate-300 transition-colors" title="Chỉnh sửa">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </a>
                            <form action="{{ route('admin.appointments.destroy', $appointment->id) }}" method="POST" data-confirm="Xoá vĩnh viễn lịch hẹn #{{ $appointment->code }}?" class="inline form-delete">
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
                    <td colspan="8" class="text-center py-12 text-slate-500">
                        <i class="fa-regular fa-calendar-xmark text-4xl block mb-2 text-slate-600"></i>
                        Không tìm thấy lịch hẹn nào
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="p-5 border-t border-slate-800 flex justify-end">
        {{ $appointments->links() }}
    </div>
</div>
@endsection
