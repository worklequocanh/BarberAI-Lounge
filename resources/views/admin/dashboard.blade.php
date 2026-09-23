@extends('layouts.admin')

@section('title', 'Bảng Điều Khiển Tổng Quan')
@section('page-title', 'Bảng Điều Khiển Tổng Quan')
@section('page-description', 'Theo dõi doanh thu, lịch hẹn cắt tóc và số liệu tư vấn kiểu tóc AI theo thời gian thực.')

@section('breadcrumb')
    <span class="text-[#22D3EE] font-semibold">Dashboard</span>
@endsection

@section('content')
<!-- Row 1: 4 Key Metric Cards (Slate 800 Card, Border Slate 600, Text White/Slate 300) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <!-- Metric 1: Revenue -->
    <div class="relative overflow-hidden p-6 rounded-2xl bg-[#1E293B] border border-[#334155] shadow-xl group hover:bg-[#273449] hover:border-[#6366F1]/50 transition-all duration-300">
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-[#6366F1]/10 rounded-full blur-2xl group-hover:bg-[#6366F1]/20 transition-colors"></div>
        <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-bold uppercase tracking-wider text-[#94A3B8]">Doanh Thu Hôm Nay</span>
            <div class="w-10 h-10 rounded-xl bg-[#6366F1]/15 border border-[#6366F1]/30 flex items-center justify-center text-[#818CF8] text-base shadow-sm">
                <i class="fa-solid fa-sack-dollar"></i>
            </div>
        </div>
        <div class="text-2xl sm:text-3xl font-black tracking-tight text-[#F8FAFC] mb-1">
            {{ number_format($revenueToday, 0, ',', '.') }}<span class="text-[#22D3EE] text-lg ml-0.5">đ</span>
        </div>
        <div class="flex items-center justify-between text-xs text-[#94A3B8] pt-3 border-t border-[#334155]">
            <span>Tổng tích luỹ:</span>
            <span class="font-semibold text-[#CBD5E1]">{{ number_format($totalRevenue, 0, ',', '.') }}đ</span>
        </div>
    </div>

    <!-- Metric 2: Today Appointments -->
    <div class="relative overflow-hidden p-6 rounded-2xl bg-[#1E293B] border border-[#334155] shadow-xl group hover:bg-[#273449] hover:border-[#22D3EE]/50 transition-all duration-300">
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-[#22D3EE]/10 rounded-full blur-2xl group-hover:bg-[#22D3EE]/20 transition-colors"></div>
        <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-bold uppercase tracking-wider text-[#94A3B8]">Lịch Hẹn Hôm Nay</span>
            <div class="w-10 h-10 rounded-xl bg-[#22D3EE]/15 border border-[#22D3EE]/30 flex items-center justify-center text-[#22D3EE] text-base shadow-sm">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
        </div>
        <div class="text-2xl sm:text-3xl font-black tracking-tight text-[#F8FAFC] mb-1">
            {{ $todayAppointmentsCount }} <span class="text-sm font-medium text-[#94A3B8]">lịch</span>
        </div>
        <div class="flex items-center justify-between text-xs text-[#94A3B8] pt-3 border-t border-[#334155]">
            <span class="text-[#F59E0B] font-semibold flex items-center gap-1.5">
                <i class="fa-solid fa-clock-rotate-left"></i> {{ $pendingAppointmentsCount }} chờ duyệt
            </span>
            <a href="{{ route('admin.appointments.timeline') }}" class="text-[#22D3EE] hover:text-white font-bold hover:underline">Matrix &rarr;</a>
        </div>
    </div>

    <!-- Metric 3: Active Barbers -->
    <div class="relative overflow-hidden p-6 rounded-2xl bg-[#1E293B] border border-[#334155] shadow-xl group hover:bg-[#273449] hover:border-[#10B981]/50 transition-all duration-300">
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-[#10B981]/10 rounded-full blur-2xl group-hover:bg-[#10B981]/20 transition-colors"></div>
        <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-bold uppercase tracking-wider text-[#94A3B8]">Thợ Hoạt Động</span>
            <div class="w-10 h-10 rounded-xl bg-[#10B981]/15 border border-[#10B981]/30 flex items-center justify-center text-[#10B981] text-base shadow-sm">
                <i class="fa-solid fa-scissors"></i>
            </div>
        </div>
        <div class="text-2xl sm:text-3xl font-black tracking-tight text-[#F8FAFC] mb-1">
            {{ $activeBarbersCount }} <span class="text-sm font-medium text-[#94A3B8]">/ {{ $totalBarbersCount }} Thợ</span>
        </div>
        <div class="flex items-center justify-between text-xs text-[#94A3B8] pt-3 border-t border-[#334155]">
            @if($barbersOnLeaveToday > 0)
                <span class="text-[#F43F5E] font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-person-circle-xmark"></i> {{ $barbersOnLeaveToday }} nghỉ phép
                </span>
            @else
                <span class="text-[#10B981] font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-circle-check"></i> Đủ 100% nhân sự
                </span>
            @endif
            <span class="text-[#94A3B8]">Trực tại quầy</span>
        </div>
    </div>

    <!-- Metric 4: AI Consultations -->
    <div class="relative overflow-hidden p-6 rounded-2xl bg-[#1E293B] border border-[#334155] shadow-xl group hover:bg-[#273449] hover:border-[#A78BFA]/50 transition-all duration-300">
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-[#6366F1]/10 rounded-full blur-2xl group-hover:bg-[#6366F1]/20 transition-colors"></div>
        <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-bold uppercase tracking-wider text-[#94A3B8]">Lượt Tư Vấn AI</span>
            <div class="w-10 h-10 rounded-xl bg-[#6366F1]/15 border border-[#6366F1]/30 flex items-center justify-center text-[#A78BFA] text-base shadow-sm">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </div>
        </div>
        <div class="text-2xl sm:text-3xl font-black tracking-tight text-[#F8FAFC] mb-1">
            {{ $aiConversationsCount }} <span class="text-sm font-medium text-[#94A3B8]">lượt</span>
        </div>
        <div class="flex items-center justify-between text-xs text-[#94A3B8] pt-3 border-t border-[#334155]">
            <span class="text-[#CBD5E1] font-medium">Gemini 1.5 Pro</span>
            <span class="px-2 py-0.5 rounded-full bg-[#6366F1]/20 text-[#A78BFA] font-bold text-[10px]">AI Active</span>
        </div>
    </div>
</div>

<!-- Row 2: Quick Action Hub & Popular Combos -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Quick Operation Hub Banner (2 Columns) -->
    <div class="lg:col-span-2 p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-[#1E293B] via-[#1E293B] to-[#111827] border border-[#334155] shadow-2xl relative overflow-hidden flex flex-col justify-between">
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-[#6366F1]/10 rounded-full blur-3xl pointer-events-none"></div>

        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#6366F1]/20 text-[#22D3EE] border border-[#6366F1]/30 text-xs font-bold mb-4">
                <i class="fa-solid fa-crown text-[#22D3EE]"></i> BarberAI Executive Workspace
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#F8FAFC] tracking-tight leading-tight">
                Không Gian Điều Hành Salon Thông Minh
            </h2>
            <p class="text-[#94A3B8] text-sm mt-2 max-w-xl">
                Quản lý lịch cắt thời gian thực, điều phối thợ trực tránh trùng slot, và triển khai các chiến dịch Email Marketing kéo khách quay lại salon trong 1 click.
            </p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-6 pt-6 border-t border-[#334155]">
            <a href="{{ route('admin.appointments.timeline') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-[#0B1120] hover:bg-[#6366F1] hover:text-white border border-[#334155] transition-all duration-200 group text-center">
                <i class="fa-solid fa-table-cells text-[#22D3EE] group-hover:text-white text-xl mb-1.5 transition-colors"></i>
                <span class="text-xs font-bold text-[#CBD5E1] group-hover:text-white">Matrix Timeline</span>
            </a>
            <a href="{{ route('admin.appointments.create') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-[#0B1120] hover:bg-[#6366F1] hover:text-white border border-[#334155] transition-all duration-200 group text-center">
                <i class="fa-solid fa-calendar-plus text-[#22D3EE] group-hover:text-white text-xl mb-1.5 transition-colors"></i>
                <span class="text-xs font-bold text-[#CBD5E1] group-hover:text-white">Tạo Lịch Hẹn</span>
            </a>
            <a href="{{ route('admin.campaigns.create') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-[#0B1120] hover:bg-[#6366F1] hover:text-white border border-[#334155] transition-all duration-200 group text-center">
                <i class="fa-solid fa-paper-plane text-[#22D3EE] group-hover:text-white text-xl mb-1.5 transition-colors"></i>
                <span class="text-xs font-bold text-[#CBD5E1] group-hover:text-white">Email Chăm Sóc</span>
            </a>
            <a href="{{ route('admin.ai.index') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-[#0B1120] hover:bg-[#6366F1] hover:text-white border border-[#334155] transition-all duration-200 group text-center">
                <i class="fa-solid fa-brain text-[#22D3EE] group-hover:text-white text-xl mb-1.5 transition-colors"></i>
                <span class="text-xs font-bold text-[#CBD5E1] group-hover:text-white">AI Consultation</span>
            </a>
        </div>
    </div>

    <!-- Popular Services & Combos Panel -->
    <div class="p-6 rounded-3xl bg-[#1E293B] border border-[#334155] shadow-xl flex flex-col justify-between">
        <div class="flex items-center justify-between pb-4 border-b border-[#334155]">
            <div>
                <h3 class="text-base font-bold text-[#F8FAFC]">Dịch Vụ Phổ Biến</h3>
                <p class="text-xs text-[#94A3B8]">Các gói dịch vụ được ưa chuộng</p>
            </div>
            <a href="{{ route('admin.services.index') }}" class="text-xs text-[#22D3EE] hover:text-white font-bold">Xem tất cả</a>
        </div>

        <div class="divide-y divide-[#334155] my-2">
            @forelse($popularServices as $svc)
            <div class="py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-[#6366F1]/15 border border-[#6366F1]/30 text-[#818CF8] flex items-center justify-center text-sm shrink-0">
                        <i class="fa-solid fa-scissors"></i>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-[#F8FAFC] flex items-center gap-1.5">
                            {{ $svc->name }}
                            @if($svc->is_combo)
                                <span class="text-[9px] px-1.5 py-0.5 rounded bg-emerald-500/20 text-emerald-400 font-extrabold uppercase">Combo</span>
                            @endif
                        </div>
                        <div class="text-xs text-[#94A3B8]">{{ $svc->duration_min }} phút • {{ $svc->category->name ?? 'Dịch vụ' }}</div>
                    </div>
                </div>
                <div class="text-right">
                    <span class="font-extrabold text-sm text-[#22D3EE]">{{ number_format($svc->price, 0, ',', '.') }}đ</span>
                </div>
            </div>
            @empty
            <p class="text-xs text-[#94A3B8] text-center py-4">Chưa có dịch vụ nào</p>
            @endforelse
        </div>

        <div class="pt-3 border-t border-[#334155] text-xs text-[#94A3B8] flex items-center justify-between">
            <span>Tổng {{ $combosCount }} gói combo siêu ưu đãi</span>
            <i class="fa-solid fa-sparkles text-[#22D3EE]"></i>
        </div>
    </div>
</div>

<!-- Row 3: Recent Appointments Table & Top Stylists -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left: 6 Most Recent Appointments -->
    <div class="lg:col-span-2 rounded-3xl bg-[#1E293B] border border-[#334155] shadow-xl overflow-hidden flex flex-col">
        <div class="p-6 border-b border-[#334155] flex items-center justify-between bg-[#111827]/60">
            <div>
                <h3 class="text-base font-bold text-[#F8FAFC]">Lịch Hẹn Cắt Tóc Gần Nhất</h3>
                <p class="text-xs text-[#94A3B8]">Cập nhật trực tiếp các đơn đặt lịch mới nhất</p>
            </div>
            <a href="{{ route('admin.appointments.index') }}" class="px-3 py-1.5 rounded-xl bg-[#0B1120] hover:bg-[#273449] border border-[#334155] text-[#CBD5E1] text-xs font-semibold transition-colors">
                Xem tất cả lịch hẹn
            </a>
        </div>

        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-[#334155] bg-[#0B1120]/40 text-[11px] font-bold uppercase tracking-wider text-[#94A3B8]">
                        <th class="py-3 px-5">MÃ ĐẶT</th>
                        <th class="py-3 px-4">KHÁCH HÀNG</th>
                        <th class="py-3 px-4">THỢ ĐẢM NHẬN</th>
                        <th class="py-3 px-4">GIỜ HẸN</th>
                        <th class="py-3 px-4">TỔNG TIỀN</th>
                        <th class="py-3 px-5 text-right">TRẠNG THÁI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#334155]">
                    @forelse($recentAppointments as $apt)
                    <tr class="hover:bg-[#273449] transition-colors">
                        <td class="py-3.5 px-5 font-mono text-xs font-bold text-[#22D3EE]">
                            #{{ $apt->code ?? ('APT-' . str_pad($apt->id, 5, '0', STR_PAD_LEFT)) }}
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="font-bold text-[#F8FAFC]">{{ $apt->customer->name ?? 'Khách lẻ' }}</div>
                            <div class="text-xs text-[#94A3B8]">{{ $apt->customer->phone ?? '---' }}</div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center gap-1.5 text-xs text-[#CBD5E1] font-medium">
                                <i class="fa-solid fa-scissors text-[11px] text-[#22D3EE]"></i>
                                {{ $apt->barber->user->name ?? 'Stylist chỉ định' }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="text-xs font-semibold text-[#CBD5E1]">{{ \Carbon\Carbon::parse($apt->appointment_date)->format('d/m/Y') }}</div>
                            <div class="text-[11px] text-[#22D3EE] font-bold">{{ $apt->start_time ?? '09:00' }}</div>
                        </td>
                        <td class="py-3.5 px-4 font-bold text-[#10B981] text-xs">
                            {{ number_format($apt->total_price, 0, ',', '.') }}đ
                        </td>
                        <td class="py-3.5 px-5 text-right">
                            @if($apt->status === 'completed')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-[#10B981]/15 text-[#10B981] border border-[#10B981]/30">
                                    <i class="fa-solid fa-circle-check text-[10px]"></i> Hoàn thành
                                </span>
                            @elseif($apt->status === 'confirmed')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-[#38BDF8]/15 text-[#38BDF8] border border-[#38BDF8]/30">
                                    <i class="fa-solid fa-circle-dot text-[10px]"></i> Đã xác nhận
                                </span>
                            @elseif($apt->status === 'cancelled')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-[#F43F5E]/15 text-[#F43F5E] border border-[#F43F5E]/30">
                                    <i class="fa-solid fa-circle-xmark text-[10px]"></i> Đã huỷ
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-[#F59E0B]/15 text-[#F59E0B] border border-[#F59E0B]/30">
                                    <i class="fa-solid fa-clock text-[10px]"></i> Chờ duyệt
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-[#94A3B8] text-xs">Chưa có lịch hẹn nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Right: Top Stylists Column -->
    <div class="rounded-3xl bg-[#1E293B] border border-[#334155] shadow-xl p-6 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between pb-4 border-b border-[#334155]">
                <div>
                    <h3 class="text-base font-bold text-[#F8FAFC]">Thợ Cắt Tóc Tiêu Biểu</h3>
                    <p class="text-xs text-[#94A3B8]">Đội ngũ Stylist xuất sắc nhất</p>
                </div>
                <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded-full bg-[#6366F1]/20 text-[#22D3EE]">Top Rank</span>
            </div>

            <div class="space-y-4 mt-4">
                @forelse($topBarbers as $barber)
                <div class="flex items-center justify-between p-3 rounded-2xl bg-[#0B1120] border border-[#334155] hover:bg-[#273449] hover:border-[#6366F1]/40 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-[#6366F1] to-[#22D3EE] p-0.5 shrink-0">
                            <div class="w-full h-full rounded-[10px] bg-[#0B1120] flex items-center justify-center text-[#22D3EE] font-bold text-sm">
                                <i class="fa-solid fa-user-tie"></i>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-[#F8FAFC]">{{ $barber->user->name ?? 'Stylist' }}</h4>
                            <p class="text-xs text-[#94A3B8]">{{ $barber->title ?? 'Master Barber' }} ({{ $barber->experience_years }} năm KN)</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center gap-1 text-xs font-bold text-[#F59E0B] bg-[#F59E0B]/10 px-2 py-1 rounded-lg border border-[#F59E0B]/20">
                            <i class="fa-solid fa-star text-[10px]"></i> {{ number_format($barber->rating_avg, 1) }}
                        </span>
                    </div>
                </div>
                @empty
                <p class="text-xs text-[#94A3B8] text-center py-4">Chưa có dữ liệu thợ</p>
                @endforelse
            </div>
        </div>

        <div class="mt-6 pt-4 border-t border-[#334155] flex items-center justify-between">
            <span class="text-xs text-[#94A3B8]">Quản lý lịch trực & nghỉ phép</span>
            <a href="{{ route('admin.barbers.index') }}" class="text-xs font-bold text-[#22D3EE] hover:text-white">
                Stylist Hub &rarr;
            </a>
        </div>
    </div>
</div>
@endsection
