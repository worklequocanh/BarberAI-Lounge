@extends('layouts.admin')

@section('title', 'Bản Đồ Lịch Đặt Tóc (Matrix Timeline)')
@section('page-title', 'Bản Đồ Lịch Đặt Tóc (Matrix Timeline)')
@section('page-description', 'Theo dõi khung giờ phục vụ của từng Stylist trong ngày, chống trùng slot và tối ưu công suất salon.')

@section('breadcrumb')
    <a href="{{ route('admin.appointments.index') }}" class="hover:text-[#22D3EE]">Lịch Hẹn</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-[#334155] mx-2"></i>
    <span class="text-[#22D3EE] font-semibold">Matrix Timeline</span>
@endsection

@section('content')
<!-- Date Navigator & Quick Actions -->
<div class="p-4 sm:p-5 rounded-3xl bg-[#1E293B] border border-[#334155] shadow-xl mb-6">
    <form action="{{ route('admin.appointments.timeline') }}" method="GET" class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold uppercase text-[#94A3B8] flex items-center gap-1.5">
                <i class="fa-regular fa-calendar text-[#22D3EE]"></i> Ngày:
            </span>
            <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()" class="px-3.5 py-2 rounded-xl bg-[#0B1120] border border-[#334155] text-[#F8FAFC] font-bold text-xs focus:ring-2 focus:ring-[#6366F1] focus:outline-none">
        </div>

        <div class="flex items-center gap-2">
            @php
                $prevDate = \Carbon\Carbon::parse($date)->subDay()->format('Y-m-d');
                $nextDate = \Carbon\Carbon::parse($date)->addDay()->format('Y-m-d');
                $todayDate = \Carbon\Carbon::today()->format('Y-m-d');
            @endphp
            <a href="{{ route('admin.appointments.timeline', ['date' => $prevDate]) }}" class="px-3 py-2 rounded-xl bg-[#0B1120] hover:bg-[#273449] text-[#CBD5E1] text-xs font-semibold border border-[#334155] transition-colors">
                <i class="fa-solid fa-chevron-left mr-1"></i> Hôm trước
            </a>
            <a href="{{ route('admin.appointments.timeline', ['date' => $todayDate]) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition-colors {{ $date === $todayDate ? 'bg-[#6366F1] text-white shadow-md shadow-indigo-500/20' : 'bg-[#0B1120] hover:bg-[#273449] text-[#CBD5E1] border border-[#334155]' }}">
                Hôm nay
            </a>
            <a href="{{ route('admin.appointments.timeline', ['date' => $nextDate]) }}" class="px-3 py-2 rounded-xl bg-[#0B1120] hover:bg-[#273449] text-[#CBD5E1] text-xs font-semibold border border-[#334155] transition-colors">
                Hôm sau <i class="fa-solid fa-chevron-right ml-1"></i>
            </a>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.appointments.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#6366F1] hover:bg-[#818CF8] text-white text-xs font-bold shadow-lg shadow-indigo-500/20 transition-all">
                <i class="fa-solid fa-plus"></i> Đặt Lịch Mới
            </a>
        </div>
    </form>
</div>

<!-- Legend Status Color Indicators -->
<div class="flex flex-wrap items-center gap-4 text-xs mb-4 px-2">
    <div class="flex items-center gap-1.5">
        <span class="w-3 h-3 rounded-md bg-[#10B981]/20 border border-[#10B981]/60 inline-block"></span>
        <span class="text-[#94A3B8] font-medium">Slot trống (Đặt được)</span>
    </div>
    <div class="flex items-center gap-1.5">
        <span class="w-3 h-3 rounded-md bg-[#38BDF8]/30 border border-[#38BDF8]/60 inline-block"></span>
        <span class="text-[#94A3B8] font-medium">Đã xác nhận</span>
    </div>
    <div class="flex items-center gap-1.5">
        <span class="w-3 h-3 rounded-md bg-[#F59E0B]/30 border border-[#F59E0B]/60 inline-block"></span>
        <span class="text-[#94A3B8] font-medium">Chờ duyệt</span>
    </div>
    <div class="flex items-center gap-1.5">
        <span class="w-3 h-3 rounded-md bg-[#111827] border border-[#334155] inline-block"></span>
        <span class="text-[#94A3B8] font-medium">Thợ nghỉ phép</span>
    </div>
</div>

<!-- Matrix Schedule Board -->
<div class="rounded-3xl bg-[#1E293B] border border-[#334155] shadow-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-center border-collapse min-w-[900px]">
            <thead>
                <tr class="border-b border-[#334155] bg-[#0B1120]/70">
                    <th class="py-4 px-5 text-left text-xs font-bold uppercase tracking-wider text-[#94A3B8] w-32 border-r border-[#334155]">
                        KHUNG GIỜ
                    </th>
                    @foreach($barbers as $barber)
                        @php
                            $isOff = $barber->leaves->isNotEmpty();
                        @endphp
                        <th class="py-4 px-4 border-r border-[#334155] last:border-r-0 {{ $isOff ? 'bg-[#0B1120]/40 opacity-60' : '' }}">
                            <div class="flex items-center justify-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-gradient-to-tr from-[#6366F1] to-[#22D3EE] p-0.5 shrink-0">
                                    <div class="w-full h-full rounded-[6px] bg-[#0B1120] flex items-center justify-center text-[#22D3EE] text-xs font-bold">
                                        <i class="fa-solid fa-scissors"></i>
                                    </div>
                                </div>
                                <span class="font-bold text-[#F8FAFC] text-sm">{{ $barber->user->name ?? 'Stylist' }}</span>
                            </div>
                            <div class="text-[10px] uppercase font-semibold mt-1">
                                @if($isOff)
                                    <span class="px-2 py-0.5 rounded-full bg-[#F43F5E]/20 text-[#F43F5E] font-bold">Nghỉ Phép</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full bg-[#10B981]/20 text-[#10B981] font-bold">Đang Trực</span>
                                @endif
                            </div>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-[#334155]">
                @foreach($timeSlots as $slot)
                <tr class="hover:bg-[#273449]/40 transition-colors">
                    <td class="py-3 px-5 text-left font-mono font-bold text-[#22D3EE] text-xs bg-[#0B1120]/40 border-r border-[#334155]">
                        <i class="fa-regular fa-clock mr-1 text-[11px]"></i> {{ $slot }}
                    </td>
                    @foreach($barbers as $barber)
                        @php
                            $isOff = $barber->leaves->isNotEmpty();
                            $matchedAppointment = $appointments->first(function ($apt) use ($barber, $slot) {
                                return $apt->barber_id == $barber->id && str_starts_with($apt->start_time, $slot);
                            });
                        @endphp

                        @if($isOff)
                            <td class="py-2.5 px-3 bg-[#0B1120]/40 border-r border-[#334155] text-[#94A3B8] text-xs last:border-r-0">
                                <i class="fa-solid fa-ban text-[11px] mr-1"></i> Nghỉ
                            </td>
                        @elseif($matchedAppointment)
                            @php
                                $badgeStyle = 'bg-[#38BDF8]/15 border-[#38BDF8]/40 text-[#38BDF8]';
                                if ($matchedAppointment->status === 'pending') {
                                    $badgeStyle = 'bg-[#F59E0B]/15 border-[#F59E0B]/40 text-[#F59E0B]';
                                } elseif ($matchedAppointment->status === 'completed') {
                                    $badgeStyle = 'bg-[#10B981]/15 border-[#10B981]/40 text-[#10B981]';
                                }
                            @endphp
                            <td class="p-1.5 border-r border-[#334155] last:border-r-0">
                                <div class="p-2.5 rounded-xl border text-left {{ $badgeStyle }} transition-all hover:scale-[1.02] shadow-sm">
                                    <div class="flex items-center justify-between text-xs font-bold mb-1">
                                        <span class="truncate max-w-[120px] text-[#F8FAFC]">{{ $matchedAppointment->customer->name ?? 'Khách' }}</span>
                                        <a href="{{ route('admin.appointments.edit', $matchedAppointment->id) }}" class="text-[#94A3B8] hover:text-white" title="Sửa">
                                            <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                        </a>
                                    </div>
                                    <div class="text-[11px] opacity-75 font-mono">{{ $matchedAppointment->customer->phone ?? '' }}</div>
                                    <div class="text-[11px] font-semibold mt-1 text-[#22D3EE] truncate">
                                        @if($matchedAppointment->services->isNotEmpty())
                                            {{ $matchedAppointment->services->first()->name }}
                                        @else
                                            Cắt tạo kiểu
                                        @endif
                                    </div>
                                </div>
                            </td>
                        @else
                            <td class="p-1.5 border-r border-[#334155] last:border-r-0">
                                <a href="{{ route('admin.appointments.create', ['date' => $date, 'barber_id' => $barber->id, 'start_time' => $slot]) }}"
                                   class="group block p-2 rounded-xl border border-dashed border-[#334155] hover:border-[#10B981]/60 hover:bg-[#10B981]/10 transition-all text-[#94A3B8] hover:text-[#10B981] text-xs">
                                    <i class="fa-solid fa-plus text-[10px] group-hover:scale-125 transition-transform"></i>
                                    <span class="ml-1 text-[11px] font-medium">Trống</span>
                                </a>
                            </td>
                        @endif
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
