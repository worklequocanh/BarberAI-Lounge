<aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-[#111827]/95 backdrop-blur-xl border-r border-[#334155] flex flex-col transition-transform duration-300 ease-in-out lg:translate-x-0 -translate-x-full">
    <!-- Brand Header -->
    <div class="h-18 flex items-center justify-between px-6 border-b border-[#334155] bg-[#0B1120]/60">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-[#6366F1] to-[#22D3EE] flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:scale-105 transition-transform duration-200">
                <i class="fa-solid fa-scissors text-white text-lg"></i>
            </div>
            <div>
                <span class="font-extrabold text-lg tracking-tight text-[#F8FAFC] block leading-tight">
                    Barber<span class="text-[#22D3EE]">AI</span>
                </span>
                <span class="text-[10px] uppercase font-semibold tracking-wider text-[#94A3B8] block">Lounge OS</span>
            </div>
        </a>
        <button id="sidebar-close-btn" class="lg:hidden text-[#94A3B8] hover:text-white p-1">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 overflow-y-auto px-4 py-6 space-y-6">
        <!-- Section: Tổng Quan -->
        <div>
            <div class="px-3 mb-2 text-[11px] font-bold uppercase tracking-wider text-[#94A3B8]">
                Tổng Quan
            </div>
            <nav class="space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-[#6366F1] text-white shadow-lg shadow-indigo-500/25 font-semibold' : 'text-[#CBD5E1] hover:text-white hover:bg-[#1E293B]' }}">
                    <i class="fa-solid fa-chart-pie w-5 text-center text-sm {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-[#94A3B8]' }}"></i>
                    <span>Dashboard</span>
                </a>
            </nav>
        </div>

        <!-- Section: Vận Hành & Đặt Lịch -->
        <div>
            <div class="px-3 mb-2 text-[11px] font-bold uppercase tracking-wider text-[#94A3B8]">
                Vận Hành & Đặt Lịch
            </div>
            <nav class="space-y-1">
                <a href="{{ route('admin.appointments.timeline') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.appointments.timeline') ? 'bg-[#6366F1] text-white shadow-lg shadow-indigo-500/25 font-semibold' : 'text-[#CBD5E1] hover:text-white hover:bg-[#1E293B]' }}">
                    <i class="fa-solid fa-table-cells w-5 text-center text-sm {{ request()->routeIs('admin.appointments.timeline') ? 'text-white' : 'text-[#94A3B8]' }}"></i>
                    <span class="flex-1">Matrix Timeline</span>
                    <span class="text-[10px] px-1.5 py-0.5 rounded-full {{ request()->routeIs('admin.appointments.timeline') ? 'bg-white/20 text-white' : 'bg-[#22D3EE]/20 text-[#22D3EE]' }} font-bold">Live</span>
                </a>
                <a href="{{ route('admin.appointments.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.appointments.index') ? 'bg-[#6366F1] text-white shadow-lg shadow-indigo-500/25 font-semibold' : 'text-[#CBD5E1] hover:text-white hover:bg-[#1E293B]' }}">
                    <i class="fa-solid fa-calendar-check w-5 text-center text-sm {{ request()->routeIs('admin.appointments.index') ? 'text-white' : 'text-[#94A3B8]' }}"></i>
                    <span>Danh Sách Lịch Hẹn</span>
                </a>
                <a href="{{ route('admin.barbers.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->is('admin/barbers*') ? 'bg-[#6366F1] text-white shadow-lg shadow-indigo-500/25 font-semibold' : 'text-[#CBD5E1] hover:text-white hover:bg-[#1E293B]' }}">
                    <i class="fa-solid fa-user-ninja w-5 text-center text-sm {{ request()->is('admin/barbers*') ? 'text-white' : 'text-[#94A3B8]' }}"></i>
                    <span>Stylists & Lịch Trực</span>
                </a>
            </nav>
        </div>

        <!-- Section: Menu Dịch Vụ & Kiểu Tóc -->
        <div>
            <div class="px-3 mb-2 text-[11px] font-bold uppercase tracking-wider text-[#94A3B8]">
                Menu & Kiểu Tóc
            </div>
            <nav class="space-y-1">
                <a href="{{ route('admin.services.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->is('admin/services*') ? 'bg-[#6366F1] text-white shadow-lg shadow-indigo-500/25 font-semibold' : 'text-[#CBD5E1] hover:text-white hover:bg-[#1E293B]' }}">
                    <i class="fa-solid fa-layer-group w-5 text-center text-sm {{ request()->is('admin/services*') ? 'text-white' : 'text-[#94A3B8]' }}"></i>
                    <span class="flex-1">Dịch Vụ & Combo</span>
                    <span class="text-[10px] px-1.5 py-0.5 rounded-full {{ request()->is('admin/services*') ? 'bg-white/20 text-white' : 'bg-emerald-500/20 text-emerald-400' }} font-bold">Combo</span>
                </a>
                <a href="{{ route('admin.hairstyles.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->is('admin/hairstyles*') ? 'bg-[#6366F1] text-white shadow-lg shadow-indigo-500/25 font-semibold' : 'text-[#CBD5E1] hover:text-white hover:bg-[#1E293B]' }}">
                    <i class="fa-solid fa-camera-retro w-5 text-center text-sm {{ request()->is('admin/hairstyles*') ? 'text-white' : 'text-[#94A3B8]' }}"></i>
                    <span>Bộ Sưu Tập Mẫu Tóc</span>
                </a>
            </nav>
        </div>

        <!-- Section: AI Studio & Marketing -->
        <div>
            <div class="px-3 mb-2 text-[11px] font-bold uppercase tracking-wider text-[#94A3B8]">
                AI & Marketing
            </div>
            <nav class="space-y-1">
                <a href="{{ route('admin.ai.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->is('admin/ai*') ? 'bg-[#6366F1] text-white shadow-lg shadow-indigo-500/25 font-semibold' : 'text-[#CBD5E1] hover:text-white hover:bg-[#1E293B]' }}">
                    <i class="fa-solid fa-wand-magic-sparkles w-5 text-center text-sm {{ request()->is('admin/ai*') ? 'text-white' : 'text-[#22D3EE]' }}"></i>
                    <span class="flex-1">AI Styling Assistant</span>
                    <span class="text-[9px] px-1.5 py-0.5 rounded-full {{ request()->is('admin/ai*') ? 'bg-white/20 text-white' : 'bg-[#22D3EE]/20 text-[#22D3EE]' }} font-black">AI</span>
                </a>
                <a href="{{ route('admin.campaigns.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->is('admin/campaigns*') ? 'bg-[#6366F1] text-white shadow-lg shadow-indigo-500/25 font-semibold' : 'text-[#CBD5E1] hover:text-white hover:bg-[#1E293B]' }}">
                    <i class="fa-solid fa-paper-plane w-5 text-center text-sm {{ request()->is('admin/campaigns*') ? 'text-white' : 'text-[#94A3B8]' }}"></i>
                    <span>Email Marketing</span>
                </a>
                <a href="{{ route('admin.coupons.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->is('admin/coupons*') ? 'bg-[#6366F1] text-white shadow-lg shadow-indigo-500/25 font-semibold' : 'text-[#CBD5E1] hover:text-white hover:bg-[#1E293B]' }}">
                    <i class="fa-solid fa-ticket-simple w-5 text-center text-sm {{ request()->is('admin/coupons*') ? 'text-white' : 'text-[#94A3B8]' }}"></i>
                    <span>Mã Giảm Giá</span>
                </a>
            </nav>
        </div>

        <!-- Section: Khách Hàng -->
        <div>
            <div class="px-3 mb-2 text-[11px] font-bold uppercase tracking-wider text-[#94A3B8]">
                Quan Hệ Khách Hàng
            </div>
            <nav class="space-y-1">
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->is('admin/users*') ? 'bg-[#6366F1] text-white shadow-lg shadow-indigo-500/25 font-semibold' : 'text-[#CBD5E1] hover:text-white hover:bg-[#1E293B]' }}">
                    <i class="fa-solid fa-address-book w-5 text-center text-sm {{ request()->is('admin/users*') ? 'text-white' : 'text-[#94A3B8]' }}"></i>
                    <span class="flex-1">Khách Hàng 360°</span>
                </a>
            </nav>
        </div>
    </div>

    <!-- Quick Salon Portal Link & Profile Card -->
    <div class="p-4 border-t border-[#334155] bg-[#0B1120]/40">
        <a href="{{ url('/') }}" target="_blank" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold text-[#CBD5E1] hover:text-white bg-[#1E293B] hover:bg-[#273449] border border-[#334155] transition-colors mb-3">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-store text-[#22D3EE]"></i>
                <span>Xem Website Khách</span>
            </span>
            <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-[#94A3B8]"></i>
        </a>

        <div class="flex items-center gap-3 px-2">
            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-[#6366F1] to-[#22D3EE] flex items-center justify-center font-bold text-xs text-white">
                AD
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold text-[#F8FAFC] truncate">Administrator</p>
                <p class="text-[11px] text-emerald-400 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Trực Tuyến
                </p>
            </div>
            @if(\Illuminate\Support\Facades\Route::has('logout'))
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" title="Đăng Xuất" class="text-[#94A3B8] hover:text-[#F43F5E] p-1.5 transition-colors">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </button>
                </form>
            @endif
        </div>
    </div>
</aside>

<!-- Mobile Overlay Backdrop -->
<div id="sidebar-backdrop" class="fixed inset-0 z-30 bg-black/60 backdrop-blur-sm hidden lg:hidden"></div>
