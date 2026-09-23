@extends('layouts.admin')

@section('title', 'Bảng Điều Khiển Tổng Quan')
@section('page-title', 'Bảng Điều Khiển Tổng Quan')
@section('page-description', 'Theo dõi doanh thu, lịch hẹn cắt tóc và số liệu tư vấn kiểu tóc AI theo thời gian thực.')

@section('breadcrumb')
    <span class="text-amber-400 font-semibold">Dashboard</span>
@endsection

@section('content')
<!-- Row 1: 4 Key Metric Cards (Glassmorphism & Micro-interactions) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <!-- Metric 1: Revenue -->
    <div class="relative overflow-hidden p-6 rounded-2xl bg-gradient-to-b from-slate-900 to-slate-900/60 border border-slate-800 shadow-xl group hover:border-amber-500/40 transition-all duration-300">
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-amber-500/5 rounded-full blur-2xl group-hover:bg-amber-500/10 transition-colors"></div>
        <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Doanh Thu Hôm Nay</span>
            <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 text-base shadow-sm">
                <i class="fa-solid fa-sack-dollar"></i>
            </div>
        </div>
        <div class="text-2xl sm:text-3xl font-black tracking-tight text-white mb-1">
            {{ number_format($revenueToday, 0, ',', '.') }}<span class="text-amber-400 text-lg ml-0.5">đ</span>
        </div>
        <div class="flex items-center justify-between text-xs text-slate-400 pt-3 border-t border-slate-800/80">
            <span>Tổng tích luỹ:</span>
            <span class="font-semibold text-slate-300">{{ number_format($totalRevenue, 0, ',', '.') }}đ</span>
        </div>
    </div>

    <!-- Metric 2: Today Appointments -->
    <div class="relative overflow-hidden p-6 rounded-2xl bg-gradient-to-b from-slate-900 to-slate-900/60 border border-slate-800 shadow-xl group hover:border-sky-500/40 transition-all duration-300">
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-sky-500/5 rounded-full blur-2xl group-hover:bg-sky-500/10 transition-colors"></div>
        <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Lịch Hẹn Hôm Nay</span>
            <div class="w-10 h-10 rounded-xl bg-sky-500/10 border border-sky-500/20 flex items-center justify-center text-sky-400 text-base shadow-sm">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
        </div>
        <div class="text-2xl sm:text-3xl font-black tracking-tight text-white mb-1">
            {{ $todayAppointmentsCount }} <span class="text-sm font-medium text-slate-400">lịch</span>
        </div>
        <div class="flex items-center justify-between text-xs text-slate-400 pt-3 border-t border-slate-800/80">
            <span class="text-amber-400 font-semibold flex items-center gap-1.5">
                <i class="fa-solid fa-clock-rotate-left"></i> {{ $pendingAppointmentsCount }} chờ duyệt
            </span>
            <a href="{{ route('admin.appointments.timeline') }}" class="text-sky-400 hover:text-sky-300 font-bold hover:underline">Matrix &rarr;</a>
        </div>
    </div>

    <!-- Metric 3: Active Barbers -->
    <div class="relative overflow-hidden p-6 rounded-2xl bg-gradient-to-b from-slate-900 to-slate-900/60 border border-slate-800 shadow-xl group hover:border-emerald-500/40 transition-all duration-300">
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-emerald-500/5 rounded-full blur-2xl group-hover:bg-emerald-500/10 transition-colors"></div>
        <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Thợ Hoạt Động</span>
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 text-base shadow-sm">
                <i class="fa-solid fa-scissors"></i>
            </div>
        </div>
        <div class="text-2xl sm:text-3xl font-black tracking-tight text-white mb-1">
            {{ $activeBarbersCount }} <span class="text-sm font-medium text-slate-400">/ {{ $totalBarbersCount }} Thợ</span>
        </div>
        <div class="flex items-center justify-between text-xs text-slate-400 pt-3 border-t border-slate-800/80">
            @if($barbersOnLeaveToday > 0)
                <span class="text-rose-400 font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-person-circle-xmark"></i> {{ $barbersOnLeaveToday }} nghỉ phép
                </span>
            @else
                <span class="text-emerald-400 font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-circle-check"></i> Đủ 100% nhân sự
                </span>
            @endif
            <span class="text-slate-400">Trực tại quầy</span>
        </div>
    </div>

    <!-- Metric 4: AI Consultations -->
    <div class="relative overflow-hidden p-6 rounded-2xl bg-gradient-to-b from-slate-900 to-slate-900/60 border border-slate-800 shadow-xl group hover:border-purple-500/40 transition-all duration-300">
        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-purple-500/5 rounded-full blur-2xl group-hover:bg-purple-500/10 transition-colors"></div>
        <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Lượt Tư Vấn AI</span>
            <div class="w-10 h-10 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400 text-base shadow-sm">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </div>
        </div>
        <div class="text-2xl sm:text-3xl font-black tracking-tight text-white mb-1">
            {{ $aiConversationsCount }} <span class="text-sm font-medium text-slate-400">lượt</span>
        </div>
        <div class="flex items-center justify-between text-xs text-slate-400 pt-3 border-t border-slate-800/80">
            <span class="text-purple-300 font-medium">Gemini 1.5 Pro</span>
            <span class="px-2 py-0.5 rounded-full bg-purple-500/20 text-purple-300 font-bold text-[10px]">AI Active</span>
        </div>
    </div>
</div>

<!-- Row 2: Quick Action Hub & Popular Combos -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Quick Operation Hub Banner (2 Columns) -->
    <div class="lg:col-span-2 p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-amber-500/15 via-slate-900 to-slate-900 border border-amber-500/30 shadow-2xl relative overflow-hidden flex flex-col justify-between">
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/30 text-xs font-bold mb-4">
                <i class="fa-solid fa-crown text-amber-400"></i> BarberAI Executive Workspace
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight leading-tight">
                Không Gian Điều Hành Salon Thông Minh
            </h2>
            <p class="text-slate-400 text-sm mt-2 max-w-xl">
                Quản lý lịch cắt thời gian thực, điều phối thợ trực tránh trùng slot, và triển khai các chiến dịch Email Marketing kéo khách quay lại salon trong 1 click.
            </p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-6 pt-6 border-t border-slate-800/80">
            <a href="{{ route('admin.appointments.timeline') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-slate-950/60 hover:bg-amber-500 hover:text-slate-950 border border-slate-800 transition-all duration-200 group text-center">
                <i class="fa-solid fa-table-cells text-amber-400 group-hover:text-slate-950 text-xl mb-1.5 transition-colors"></i>
                <span class="text-xs font-bold text-slate-200 group-hover:text-slate-950">Matrix Timeline</span>
            </a>
            <a href="{{ route('admin.appointments.create') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-slate-950/60 hover:bg-amber-500 hover:text-slate-950 border border-slate-800 transition-all duration-200 group text-center">
                <i class="fa-solid fa-calendar-plus text-amber-400 group-hover:text-slate-950 text-xl mb-1.5 transition-colors"></i>
                <span class="text-xs font-bold text-slate-200 group-hover:text-slate-950">Tạo Lịch Hẹn</span>
            </a>
            <a href="{{ route('admin.campaigns.create') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-slate-950/60 hover:bg-amber-500 hover:text-slate-950 border border-slate-800 transition-all duration-200 group text-center">
                <i class="fa-solid fa-paper-plane text-amber-400 group-hover:text-slate-950 text-xl mb-1.5 transition-colors"></i>
                <span class="text-xs font-bold text-slate-200 group-hover:text-slate-950">Email Chăm Sóc</span>
            </a>
            <a href="{{ route('admin.ai.index') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-slate-950/60 hover:bg-amber-500 hover:text-slate-950 border border-slate-800 transition-all duration-200 group text-center">
                <i class="fa-solid fa-brain text-amber-400 group-hover:text-slate-950 text-xl mb-1.5 transition-colors"></i>
                <span class="text-xs font-bold text-slate-200 group-hover:text-slate-950">AI Consultation</span>
            </a>
        </div>
    </div>

    <!-- Popular Services & Combos Panel -->
    <div class="p-6 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl flex flex-col justify-between">
        <div class="flex items-center justify-between pb-4 border-b border-slate-800">
            <div>
                <h3 class="text-base font-bold text-white">Dịch Vụ Phổ Biến</h3>
                <p class="text-xs text-slate-400">Các gói dịch vụ được ưa chuộng</p>
            </div>
            <a href="{{ route('admin.services.index') }}" class="text-xs text-amber-400 hover:text-amber-300 font-bold">Xem tất cả</a>
        </div>

        <div class="divide-y divide-slate-800/80 my-2">
            @forelse($popularServices as $svc)
            <div class="py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center text-sm shrink-0">
                        <i class="fa-solid fa-scissors"></i>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-white flex items-center gap-1.5">
                            {{ $svc->name }}
                            @if($svc->is_combo)
                                <span class="text-[9px] px-1.5 py-0.2 rounded bg-amber-500/20 text-amber-300 font-extrabold uppercase">Combo</span>
                            @endif
                        </div>
                        <div class="text-xs text-slate-400">{{ $svc->duration_min }} phút • {{ $svc->category->name ?? 'Dịch vụ' }}</div>
                    </div>
                </div>
                <div class="text-right">
                    <span class="font-extrabold text-sm text-amber-400">{{ number_format($svc->price, 0, ',', '.') }}đ</span>
                </div>
            </div>
            @empty
            <p class="text-xs text-slate-500 text-center py-4">Chưa có dịch vụ nào</p>
            @endforelse
        </div>

        <div class="pt-3 border-t border-slate-800 text-xs text-slate-400 flex items-center justify-between">
            <span>Tổng {{ $combosCount }} gói combo siêu ưu đãi</span>
            <i class="fa-solid fa-sparkles text-amber-400"></i>
        </div>
    </div>
</div>

<!-- Row 3: Recent Appointments Table & Top Stylists -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left: 6 Most Recent Appointments -->
    <div class="lg:col-span-2 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl overflow-hidden flex flex-col">
        <div class="p-6 border-b border-slate-800 flex items-center justify-between bg-slate-950/40">
            <div>
                <h3 class="text-base font-bold text-white">Lịch Hẹn Cắt Tóc Gần Nhất</h3>
                <p class="text-xs text-slate-400">Cập nhật trực tiếp các đơn đặt lịch mới nhất</p>
            </div>
            <a href="{{ route('admin.appointments.index') }}" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold transition-colors">
                Xem tất cả lịch hẹn
            </a>
        </div>

        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-slate-800 bg-slate-950/60 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                        <th class="py-3 px-5">MÃ ĐẶT</th>
                        <th class="py-3 px-4">KHÁCH HÀNG</th>
                        <th class="py-3 px-4">THỢ ĐẢM NHẬN</th>
                        <th class="py-3 px-4">GIỜ HẸN</th>
                        <th class="py-3 px-4">TỔNG TIỀN</th>
                        <th class="py-3 px-5 text-right">TRẠNG THÁI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($recentAppointments as $apt)
                    <tr class="hover:bg-slate-800/30 transition-colors">
                        <td class="py-3.5 px-5 font-mono text-xs font-bold text-amber-400">
                            #{{ $apt->code ?? ('APT-' . str_pad($apt->id, 5, '0', STR_PAD_LEFT)) }}
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="font-bold text-white">{{ $apt->customer->name ?? 'Khách lẻ' }}</div>
                            <div class="text-xs text-slate-400">{{ $apt->customer->phone ?? '---' }}</div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center gap-1.5 text-xs text-slate-300 font-medium">
                                <i class="fa-solid fa-scissors text-[11px] text-amber-400"></i>
                                {{ $apt->barber->user->name ?? 'Stylist chỉ định' }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="text-xs font-semibold text-slate-200">{{ \Carbon\Carbon::parse($apt->appointment_date)->format('d/m/Y') }}</div>
                            <div class="text-[11px] text-amber-400 font-bold">{{ $apt->start_time ?? '09:00' }}</div>
                        </td>
                        <td class="py-3.5 px-4 font-bold text-emerald-400 text-xs">
                            {{ number_format($apt->total_price, 0, ',', '.') }}đ
                        </td>
                        <td class="py-3.5 px-5 text-right">
                            @if($apt->status === 'completed')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    <i class="fa-solid fa-circle-check text-[10px]"></i> Hoàn thành
                                </span>
                            @elseif($apt->status === 'confirmed')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-sky-500/10 text-sky-400 border border-sky-500/20">
                                    <i class="fa-solid fa-circle-dot text-[10px]"></i> Đã xác nhận
                                </span>
                            @elseif($apt->status === 'cancelled')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                    <i class="fa-solid fa-circle-xmark text-[10px]"></i> Đã huỷ
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                    <i class="fa-solid fa-clock text-[10px]"></i> Chờ duyệt
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-slate-500 text-xs">Chưa có lịch hẹn nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Right: Top Stylists Column -->
    <div class="rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl p-6 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                <div>
                    <h3 class="text-base font-bold text-white">Thợ Cắt Tóc Tiêu Biểu</h3>
                    <p class="text-xs text-slate-400">Đội ngũ Stylist xuất sắc nhất</p>
                </div>
                <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-300">Top Rank</span>
            </div>

            <div class="space-y-4 mt-4">
                @forelse($topBarbers as $barber)
                <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-950/40 border border-slate-800/80 hover:border-amber-500/30 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-500 to-amber-300 p-0.5 shrink-0">
                            <div class="w-full h-full rounded-[10px] bg-slate-950 flex items-center justify-center text-amber-400 font-bold text-sm">
                                <i class="fa-solid fa-user-tie"></i>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-white">{{ $barber->user->name ?? 'Stylist' }}</h4>
                            <p class="text-xs text-slate-400">{{ $barber->title ?? 'Master Barber' }} ({{ $barber->experience_years }} năm KN)</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center gap-1 text-xs font-bold text-amber-400 bg-amber-500/10 px-2 py-1 rounded-lg border border-amber-500/20">
                            <i class="fa-solid fa-star text-[10px]"></i> {{ number_format($barber->rating_avg, 1) }}
                        </span>
                    </div>
                </div>
                @empty
                <p class="text-xs text-slate-500 text-center py-4">Chưa có dữ liệu thợ</p>
                @endforelse
            </div>
        </div>

        <div class="mt-6 pt-4 border-t border-slate-800 flex items-center justify-between">
            <span class="text-xs text-slate-400">Quản lý lịch trực & nghỉ phép</span>
            <a href="{{ route('admin.barbers.index') }}" class="text-xs font-bold text-amber-400 hover:text-amber-300">
                Stylist Hub &rarr;
            </a>
        </div>
    </div>
</div>
@endsection
