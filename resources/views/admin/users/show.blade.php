@extends('layouts.admin')

@section('title', 'Hồ Sơ Khách Hàng 360° - ' . $user->name)
@section('page-title', 'Hồ Sơ Khách Hàng 360°')
@section('page-description', 'Toàn bộ lịch sử cắt tóc, thói quen kỹ thuật, Stylist quen thuộc và giá trị trọn đời (LTV).')

@section('breadcrumb')
    <a href="{{ route('admin.users.index') }}" class="hover:text-amber-400">Khách Hàng</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-600 mx-2"></i>
    <span class="text-amber-400 font-semibold">{{ $user->name }}</span>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column: Customer Profile Card (1 Col) -->
    <div class="space-y-6">
        <div class="rounded-3xl bg-slate-900/90 border border-slate-800 shadow-2xl p-6 text-center">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-amber-500 to-amber-300 p-0.5 mx-auto mb-4 shadow-xl shadow-amber-500/20">
                <div class="w-full h-full rounded-[14px] bg-slate-950 flex items-center justify-center text-amber-400 font-extrabold text-2xl">
                    <i class="fa-solid fa-user-astronaut"></i>
                </div>
            </div>
            <h3 class="text-lg font-bold text-white mb-1">{{ $user->name }}</h3>
            <div class="mb-4">
                @if($user->role && ($user->role->slug === 'admin' || str_contains(strtolower($user->role->name), 'admin')))
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-500/20 text-rose-300 border border-rose-500/30">Quản Trị Viên</span>
                @elseif($user->role && ($user->role->slug === 'barber' || str_contains(strtolower($user->role->name), 'barber')))
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">Stylist Salon</span>
                @else
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20">Khách Hàng Thành Viên</span>
                @endif
            </div>

            <div class="flex justify-center gap-2 mb-6">
                <a href="tel:{{ $user->phone }}" class="px-3.5 py-2 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-200 text-xs font-bold border border-slate-700 transition-colors {{ empty($user->phone) ? 'opacity-50 pointer-events-none' : '' }}">
                    <i class="fa-solid fa-phone text-amber-400 mr-1.5"></i> Gọi Điện
                </a>
                <a href="mailto:{{ $user->email }}" class="px-3.5 py-2 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-200 text-xs font-bold border border-slate-700 transition-colors">
                    <i class="fa-solid fa-envelope text-amber-400 mr-1.5"></i> Gửi Mail
                </a>
            </div>

            <div class="space-y-3 text-left pt-4 border-t border-slate-800 text-xs">
                <div class="flex justify-between py-1">
                    <span class="text-slate-400">Số điện thoại:</span>
                    <span class="font-bold text-white font-mono">{{ $user->phone ?? 'Chưa cập nhật' }}</span>
                </div>
                <div class="flex justify-between py-1">
                    <span class="text-slate-400">Email:</span>
                    <span class="text-slate-300 font-mono truncate max-w-[170px]">{{ $user->email }}</span>
                </div>
                <div class="flex justify-between py-1">
                    <span class="text-slate-400">Giới tính:</span>
                    <span class="font-semibold text-slate-300">{{ $user->gender === 'female' ? 'Nữ' : ($user->gender === 'male' ? 'Nam' : 'Khác') }}</span>
                </div>
                <div class="flex justify-between py-1">
                    <span class="text-slate-400">Ngày gia nhập:</span>
                    <span class="text-slate-300">{{ $user->created_at ? $user->created_at->format('d/m/Y') : '---' }}</span>
                </div>
            </div>
        </div>

        <!-- Stylist Ruột -->
        <div class="rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl p-6">
            <h4 class="text-xs font-bold uppercase tracking-wider text-amber-400 mb-3 flex items-center gap-1.5">
                <i class="fa-solid fa-heart text-rose-400"></i> Stylist Thân Thiết ("Thợ Ruột")
            </h4>
            @if($favoriteBarber)
                <div class="flex items-center gap-3 p-3 rounded-2xl bg-slate-950/60 border border-slate-800">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center font-bold text-base shrink-0">
                        <i class="fa-solid fa-scissors"></i>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-white">{{ $favoriteBarber->user->name ?? 'Stylist' }}</div>
                        <div class="text-xs text-slate-400">{{ $favoriteBarber->title ?? 'Master Barber' }} ({{ $favoriteBarber->experience_years }} năm KN)</div>
                    </div>
                </div>
            @else
                <p class="text-xs text-slate-500 py-2">Chưa đủ dữ liệu để xác định thợ quen</p>
            @endif
        </div>
    </div>

    <!-- Right Column: Customer 360 KPIs & Hair Notes & Appointment History (2 Cols) -->
    <div class="lg:col-span-2 space-y-6">
        <!-- 3 KPIs -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="p-5 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl">
                <div class="text-[11px] font-bold uppercase text-slate-400 mb-1">TỔNG CHI TIÊU (LTV)</div>
                <div class="text-2xl font-black text-emerald-400">{{ number_format($totalSpent, 0, ',', '.') }}đ</div>
                <div class="text-[11px] text-slate-500 mt-1">Giá trị tích luỹ salon</div>
            </div>
            <div class="p-5 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl">
                <div class="text-[11px] font-bold uppercase text-slate-400 mb-1">LẦN CẮT HOÀN THÀNH</div>
                <div class="text-2xl font-black text-amber-400">{{ $completedCount }} <span class="text-sm text-slate-400 font-medium">lần</span></div>
                <div class="text-[11px] text-slate-500 mt-1">Tổng {{ $appointments->count() }} lịch hẹn</div>
            </div>
            <div class="p-5 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-xl">
                <div class="text-[11px] font-bold uppercase text-slate-400 mb-1">CHI TIÊU TB / LẦN</div>
                @php
                    $avgTicket = $completedCount > 0 ? round($totalSpent / $completedCount) : 0;
                @endphp
                <div class="text-2xl font-black text-sky-400">{{ number_format($avgTicket, 0, ',', '.') }}đ</div>
                <div class="text-[11px] text-slate-500 mt-1">Ticket size trung bình</div>
            </div>
        </div>

        <!-- Sổ Tay Kỹ Thuật Tóc (Hair Technical Profile) -->
        <div class="rounded-3xl bg-slate-900/90 border border-amber-500/30 shadow-2xl p-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-800 mb-4">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-book-bookmark text-amber-400"></i> Sổ Tay Kỹ Thuật Tóc (Hair Technical Profile)
                </h3>
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-amber-500/20 text-amber-300 font-bold">
                    {{ $hairNotes->count() }} ghi chú
                </span>
            </div>

            @if($hairNotes->isNotEmpty())
                <div class="space-y-3">
                    @foreach($hairNotes as $note)
                    <div class="p-4 rounded-2xl bg-slate-950/60 border border-slate-800/80">
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-400 mb-2">
                            <span>
                                <i class="fa-regular fa-calendar-check text-amber-400 mr-1"></i>
                                {{ \Carbon\Carbon::parse($note->appointment_date)->format('d/m/Y') }} (Stylist: {{ $note->barber->user->name ?? 'Salon' }})
                            </span>
                            <span class="font-mono text-amber-400">#{{ $note->code }}</span>
                        </div>
                        <p class="text-sm text-slate-200 italic">"{{ $note->hair_notes }}"</p>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-slate-500 text-center py-4">Chưa có ghi chú kỹ thuật tóc cho khách hàng này</p>
            @endif
        </div>

        <!-- Lịch sử sử dụng dịch vụ -->
        <div class="rounded-3xl bg-slate-900/90 border border-slate-800 shadow-2xl overflow-hidden">
            <div class="p-5 border-b border-slate-800 flex items-center justify-between bg-slate-950/40">
                <h4 class="text-sm font-bold text-white">Lịch Sử Sử Dụng Dịch Vụ</h4>
                <a href="{{ route('admin.appointments.create', ['customer_name' => $user->name, 'customer_phone' => $user->phone]) }}" class="px-3.5 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-bold transition-colors">
                    <i class="fa-solid fa-plus mr-1"></i> Đặt Lịch Cho Khách
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="border-b border-slate-800 bg-slate-950/60 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="py-3 px-4">MÃ ĐƠN</th>
                            <th class="py-3 px-4">NGÀY HẸN</th>
                            <th class="py-3 px-4">STYLIST</th>
                            <th class="py-3 px-4">DỊCH VỤ</th>
                            <th class="py-3 px-4">TỔNG TIỀN</th>
                            <th class="py-3 px-4 text-right">TRẠNG THÁI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60">
                        @forelse($appointments as $apt)
                        <tr class="hover:bg-slate-800/30">
                            <td class="py-3 px-4 font-mono font-bold text-amber-400">
                                <a href="{{ route('admin.appointments.edit', $apt->id) }}" class="hover:underline">#{{ $apt->code }}</a>
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-semibold text-white">{{ \Carbon\Carbon::parse($apt->appointment_date)->format('d/m/Y') }}</div>
                                <div class="text-slate-400">{{ $apt->start_time }}</div>
                            </td>
                            <td class="py-3 px-4 text-slate-300">
                                {{ $apt->barber->user->name ?? 'Chưa chỉ định' }}
                            </td>
                            <td class="py-3 px-4">
                                @foreach($apt->services as $s)
                                    <span class="px-1.5 py-0.5 rounded bg-slate-800 text-slate-300 text-[10px] mr-1">{{ $s->name }}</span>
                                @endforeach
                            </td>
                            <td class="py-3 px-4 font-bold text-emerald-400">
                                {{ number_format($apt->total_price, 0, ',', '.') }}đ
                            </td>
                            <td class="py-3 px-4 text-right">
                                @if($apt->status === 'completed')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/15 text-emerald-400">Hoàn thành</span>
                                @elseif($apt->status === 'confirmed')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-sky-500/15 text-sky-400">Đã xác nhận</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/15 text-amber-400">Chờ duyệt</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-slate-500">Chưa có lịch sử cắt tóc nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
