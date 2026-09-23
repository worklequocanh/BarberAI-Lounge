@extends('layouts.admin')

@section('title', 'Hồ Sơ Khách Hàng 360° - ' . $user->name)
@section('page-title', 'Hồ Sơ Khách Hàng 360°')
@section('page-description', 'Toàn bộ lịch sử cắt tóc, thói quen kỹ thuật, Stylist quen thuộc và giá trị trọn đời (LTV).')

@section('breadcrumb')
    <a href="{{ route('admin.users.index') }}" class="hover:text-[#22D3EE]">Khách Hàng</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-[#334155] mx-2"></i>
    <span class="text-[#22D3EE] font-semibold">{{ $user->name }}</span>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column: Customer Profile Card (1 Col) -->
    <div class="space-y-6">
        <div class="rounded-3xl bg-[#1E293B] border border-[#334155] shadow-2xl p-6 text-center">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-[#6366F1] to-[#22D3EE] p-0.5 mx-auto mb-4 shadow-xl shadow-indigo-500/20">
                <div class="w-full h-full rounded-[14px] bg-[#0B1120] flex items-center justify-center text-[#22D3EE] font-extrabold text-2xl">
                    <i class="fa-solid fa-user-astronaut"></i>
                </div>
            </div>
            <h3 class="text-lg font-bold text-[#F8FAFC] mb-1">{{ $user->name }}</h3>
            <div class="mb-4">
                @if($user->role && ($user->role->slug === 'admin' || str_contains(strtolower($user->role->name), 'admin')))
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-[#F43F5E]/20 text-[#F43F5E] border border-[#F43F5E]/30">Quản Trị Viên</span>
                @elseif($user->role && ($user->role->slug === 'barber' || str_contains(strtolower($user->role->name), 'barber')))
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-[#6366F1]/20 text-[#818CF8] border border-[#6366F1]/30">Stylist Salon</span>
                @else
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-[#22D3EE]/10 text-[#22D3EE] border border-[#22D3EE]/20">Khách Hàng Thành Viên</span>
                @endif
            </div>

            <div class="flex justify-center gap-2 mb-6">
                <a href="tel:{{ $user->phone }}" class="px-3.5 py-2 rounded-xl bg-[#0B1120] hover:bg-[#273449] text-[#CBD5E1] text-xs font-bold border border-[#334155] transition-colors {{ empty($user->phone) ? 'opacity-50 pointer-events-none' : '' }}">
                    <i class="fa-solid fa-phone text-[#22D3EE] mr-1.5"></i> Gọi Điện
                </a>
                <a href="mailto:{{ $user->email }}" class="px-3.5 py-2 rounded-xl bg-[#0B1120] hover:bg-[#273449] text-[#CBD5E1] text-xs font-bold border border-[#334155] transition-colors">
                    <i class="fa-solid fa-envelope text-[#22D3EE] mr-1.5"></i> Gửi Mail
                </a>
            </div>

            <div class="space-y-3 text-left pt-4 border-t border-[#334155] text-xs">
                <div class="flex justify-between py-1">
                    <span class="text-[#94A3B8]">Số điện thoại:</span>
                    <span class="font-bold text-[#F8FAFC] font-mono">{{ $user->phone ?? 'Chưa cập nhật' }}</span>
                </div>
                <div class="flex justify-between py-1">
                    <span class="text-[#94A3B8]">Email:</span>
                    <span class="text-[#CBD5E1] font-mono truncate max-w-[170px]">{{ $user->email }}</span>
                </div>
                <div class="flex justify-between py-1">
                    <span class="text-[#94A3B8]">Giới tính:</span>
                    <span class="font-semibold text-[#CBD5E1]">{{ $user->gender === 'female' ? 'Nữ' : ($user->gender === 'male' ? 'Nam' : 'Khác') }}</span>
                </div>
                <div class="flex justify-between py-1">
                    <span class="text-[#94A3B8]">Ngày gia nhập:</span>
                    <span class="text-[#CBD5E1]">{{ $user->created_at ? $user->created_at->format('d/m/Y') : '---' }}</span>
                </div>
            </div>
        </div>

        <!-- Stylist Ruột -->
        <div class="rounded-3xl bg-[#1E293B] border border-[#334155] shadow-xl p-6">
            <h4 class="text-xs font-bold uppercase tracking-wider text-[#22D3EE] mb-3 flex items-center gap-1.5">
                <i class="fa-solid fa-heart text-[#F43F5E]"></i> Stylist Thân Thiết ("Thợ Ruột")
            </h4>
            @if($favoriteBarber)
                <div class="flex items-center gap-3 p-3 rounded-2xl bg-[#0B1120] border border-[#334155]">
                    <div class="w-10 h-10 rounded-xl bg-[#6366F1]/15 text-[#818CF8] flex items-center justify-center font-bold text-base shrink-0">
                        <i class="fa-solid fa-scissors"></i>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-[#F8FAFC]">{{ $favoriteBarber->user->name ?? 'Stylist' }}</div>
                        <div class="text-xs text-[#94A3B8]">{{ $favoriteBarber->title ?? 'Master Barber' }} ({{ $favoriteBarber->experience_years }} năm KN)</div>
                    </div>
                </div>
            @else
                <p class="text-xs text-[#94A3B8] py-2">Chưa đủ dữ liệu để xác định thợ quen</p>
            @endif
        </div>
    </div>

    <!-- Right Column: Customer 360 KPIs & Hair Notes & Appointment History (2 Cols) -->
    <div class="lg:col-span-2 space-y-6">
        <!-- 3 KPIs -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="p-5 rounded-3xl bg-[#1E293B] border border-[#334155] shadow-xl">
                <div class="text-[11px] font-bold uppercase text-[#94A3B8] mb-1">TỔNG CHI TIÊU (LTV)</div>
                <div class="text-2xl font-black text-[#10B981]">{{ number_format($totalSpent, 0, ',', '.') }}đ</div>
                <div class="text-[11px] text-[#94A3B8] mt-1">Giá trị tích luỹ salon</div>
            </div>
            <div class="p-5 rounded-3xl bg-[#1E293B] border border-[#334155] shadow-xl">
                <div class="text-[11px] font-bold uppercase text-[#94A3B8] mb-1">LẦN CẮT HOÀN THÀNH</div>
                <div class="text-2xl font-black text-[#22D3EE]">{{ $completedCount }} <span class="text-sm text-[#94A3B8] font-medium">lần</span></div>
                <div class="text-[11px] text-[#94A3B8] mt-1">Tổng {{ $appointments->count() }} lịch hẹn</div>
            </div>
            <div class="p-5 rounded-3xl bg-[#1E293B] border border-[#334155] shadow-xl">
                <div class="text-[11px] font-bold uppercase text-[#94A3B8] mb-1">CHI TIÊU TB / LẦN</div>
                @php
                    $avgTicket = $completedCount > 0 ? round($totalSpent / $completedCount) : 0;
                @endphp
                <div class="text-2xl font-black text-[#38BDF8]">{{ number_format($avgTicket, 0, ',', '.') }}đ</div>
                <div class="text-[11px] text-[#94A3B8] mt-1">Ticket size trung bình</div>
            </div>
        </div>

        <!-- Sổ Tay Kỹ Thuật Tóc (Hair Technical Profile) -->
        <div class="rounded-3xl bg-[#1E293B] border border-[#334155] shadow-2xl p-6">
            <div class="flex items-center justify-between pb-4 border-b border-[#334155] mb-4">
                <h3 class="text-base font-bold text-[#F8FAFC] flex items-center gap-2">
                    <i class="fa-solid fa-book-bookmark text-[#22D3EE]"></i> Sổ Tay Kỹ Thuật Tóc (Hair Technical Profile)
                </h3>
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-[#6366F1]/20 text-[#22D3EE] font-bold">
                    {{ $hairNotes->count() }} ghi chú
                </span>
            </div>

            @if($hairNotes->isNotEmpty())
                <div class="space-y-3">
                    @foreach($hairNotes as $note)
                    <div class="p-4 rounded-2xl bg-[#0B1120] border border-[#334155]">
                        <div class="flex items-center justify-between text-xs font-semibold text-[#94A3B8] mb-2">
                            <span>
                                <i class="fa-regular fa-calendar-check text-[#22D3EE] mr-1"></i>
                                {{ \Carbon\Carbon::parse($note->appointment_date)->format('d/m/Y') }} (Stylist: {{ $note->barber->user->name ?? 'Salon' }})
                            </span>
                            <span class="font-mono text-[#22D3EE]">#{{ $note->code }}</span>
                        </div>
                        <p class="text-sm text-[#CBD5E1] italic">"{{ $note->hair_notes }}"</p>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-[#94A3B8] text-center py-4">Chưa có ghi chú kỹ thuật tóc cho khách hàng này</p>
            @endif
        </div>

        <!-- Lịch sử sử dụng dịch vụ -->
        <div class="rounded-3xl bg-[#1E293B] border border-[#334155] shadow-2xl overflow-hidden">
            <div class="p-5 border-b border-[#334155] flex items-center justify-between bg-[#111827]/60">
                <h4 class="text-sm font-bold text-[#F8FAFC]">Lịch Sử Sử Dụng Dịch Vụ</h4>
                <a href="{{ route('admin.appointments.create', ['customer_name' => $user->name, 'customer_phone' => $user->phone]) }}" class="px-3.5 py-1.5 rounded-xl bg-[#6366F1] hover:bg-[#818CF8] text-white text-xs font-bold transition-colors">
                    <i class="fa-solid fa-plus mr-1"></i> Đặt Lịch Cho Khách
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="border-b border-[#334155] bg-[#0B1120]/40 text-[11px] font-bold uppercase tracking-wider text-[#94A3B8]">
                            <th class="py-3 px-4">MÃ ĐƠN</th>
                            <th class="py-3 px-4">NGÀY HẸN</th>
                            <th class="py-3 px-4">STYLIST</th>
                            <th class="py-3 px-4">DỊCH VỤ</th>
                            <th class="py-3 px-4">TỔNG TIỀN</th>
                            <th class="py-3 px-4 text-right">TRẠNG THÁI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#334155]">
                        @forelse($appointments as $apt)
                        <tr class="hover:bg-[#273449]/40">
                            <td class="py-3 px-4 font-mono font-bold text-[#22D3EE]">
                                <a href="{{ route('admin.appointments.edit', $apt->id) }}" class="hover:underline">#{{ $apt->code }}</a>
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-semibold text-[#F8FAFC]">{{ \Carbon\Carbon::parse($apt->appointment_date)->format('d/m/Y') }}</div>
                                <div class="text-[#94A3B8]">{{ $apt->start_time }}</div>
                            </td>
                            <td class="py-3 px-4 text-[#CBD5E1]">
                                {{ $apt->barber->user->name ?? 'Chưa chỉ định' }}
                            </td>
                            <td class="py-3 px-4">
                                @foreach($apt->services as $s)
                                    <span class="px-1.5 py-0.5 rounded bg-[#0B1120] text-[#CBD5E1] border border-[#334155] text-[10px] mr-1">{{ $s->name }}</span>
                                @endforeach
                            </td>
                            <td class="py-3 px-4 font-bold text-[#10B981]">
                                {{ number_format($apt->total_price, 0, ',', '.') }}đ
                            </td>
                            <td class="py-3 px-4 text-right">
                                @if($apt->status === 'completed')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#10B981]/15 text-[#10B981] border border-[#10B981]/30">Hoàn thành</span>
                                @elseif($apt->status === 'confirmed')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#38BDF8]/15 text-[#38BDF8] border border-[#38BDF8]/30">Đã xác nhận</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#F59E0B]/15 text-[#F59E0B] border border-[#F59E0B]/30">Chờ duyệt</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-[#94A3B8]">Chưa có lịch sử cắt tóc nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
