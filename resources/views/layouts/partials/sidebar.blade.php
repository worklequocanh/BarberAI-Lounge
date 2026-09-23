<aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900/95 backdrop-blur-xl border-r border-slate-800 flex flex-col transition-transform duration-300 ease-in-out lg:translate-x-0 -translate-x-full">
    <!-- Brand Header -->
    <div class="h-18 flex items-center justify-between px-6 border-b border-slate-800/80 bg-slate-950/40">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-500 to-amber-300 flex items-center justify-center shadow-lg shadow-amber-500/20 group-hover:scale-105 transition-transform duration-200">
                <i class="fa-solid fa-scissors text-slate-950 text-lg"></i>
            </div>
            <div>
                <span class="font-extrabold text-lg tracking-tight text-white block leading-tight">
                    Barber<span class="text-amber-400">AI</span>
                </span>
                <span class="text-[10px] uppercase font-semibold tracking-wider text-slate-400 block">Lounge Lounge OS</span>
            </div>
        </a>
        <button id="sidebar-close-btn" class="lg:hidden text-slate-400 hover:text-white p-1">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 overflow-y-auto px-4 py-6 space-y-6">
        <!-- Section: Tổng Quan -->
        <div>
            <div class="px-3 mb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                Tổng Quan
            </div>
            <nav class="space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20 font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60' }}">
                    <i class="fa-solid fa-chart-pie w-5 text-center text-sm {{ request()->routeIs('admin.dashboard') ? 'text-amber-400' : 'text-slate-500' }}"></i>
                    <span>Dashboard</span>
                </a>
            </nav>
        </div>

        <!-- Section: Vận Hành & Đặt Lịch -->
        <div>
            <div class="px-3 mb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                Vận Hành & Đặt Lịch
            </div>
            <nav class="space-y-1">
                <a href="{{ route('admin.appointments.timeline') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.appointments.timeline') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20 font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60' }}">
                    <i class="fa-solid fa-table-cells w-5 text-center text-sm {{ request()->routeIs('admin.appointments.timeline') ? 'text-amber-400' : 'text-slate-500' }}"></i>
                    <span class="flex-1">Matrix Timeline</span>
                    <span class="text-[10px] px-1.5 py-0.5 rounded-full bg-amber-400/20 text-amber-300 font-bold">Live</span>
                </a>
                <a href="{{ route('admin.appointments.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.appointments.index') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20 font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60' }}">
                    <i class="fa-solid fa-calendar-check w-5 text-center text-sm {{ request()->routeIs('admin.appointments.index') ? 'text-amber-400' : 'text-slate-500' }}"></i>
                    <span>Danh Sách Lịch Hẹn</span>
                </a>
                <a href="{{ route('admin.barbers.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->is('admin/barbers*') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20 font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60' }}">
                    <i class="fa-solid fa-user-ninja w-5 text-center text-sm {{ request()->is('admin/barbers*') ? 'text-amber-400' : 'text-slate-500' }}"></i>
                    <span>Stylists & Lịch Trực</span>
                </a>
            </nav>
        </div>

        <!-- Section: Menu Dịch Vụ & Kiểu Tóc -->
        <div>
            <div class="px-3 mb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                Menu & Kiểu Tóc
            </div>
            <nav class="space-y-1">
                <a href="{{ route('admin.services.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->is('admin/services*') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20 font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60' }}">
                    <i class="fa-solid fa-wand-magic-sparkles w-5 text-center text-sm {{ request()->is('admin/services*') ? 'text-amber-400' : 'text-slate-500' }}"></i>
                    <span>Dịch Vụ & Combo</span>
                </a>
                <a href="{{ route('admin.hairstyles.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->is('admin/hairstyles*') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20 font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60' }}">
                    <i class="fa-solid fa-head-side-virus w-5 text-center text-sm {{ request()->is('admin/hairstyles*') ? 'text-amber-400' : 'text-slate-500' }}"></i>
                    <span>Bộ Sưu Tập Mẫu Tóc</span>
                </a>
                <a href="{{ route('admin.ai.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.ai.index') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20 font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60' }}">
                    <i class="fa-solid fa-microchip w-5 text-center text-sm {{ request()->routeIs('admin.ai.index') ? 'text-amber-400' : 'text-slate-500' }}"></i>
                    <span class="flex-1">AI Styling Assistant</span>
                    <span class="text-[10px] px-1.5 py-0.5 rounded-md bg-purple-500/20 text-purple-300 font-bold">AI</span>
                </a>
            </nav>
        </div>

        <!-- Section: Khách Hàng & Tiếp Thị -->
        <div>
            <div class="px-3 mb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                Marketing & Hội Viên
            </div>
            <nav class="space-y-1">
                <a href="{{ route('admin.campaigns.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->is('admin/campaigns*') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20 font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60' }}">
                    <i class="fa-solid fa-paper-plane w-5 text-center text-sm {{ request()->is('admin/campaigns*') ? 'text-amber-400' : 'text-slate-500' }}"></i>
                    <span>Email Marketing</span>
                </a>
                <a href="{{ route('admin.coupons.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->is('admin/coupons*') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20 font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60' }}">
                    <i class="fa-solid fa-ticket-simple w-5 text-center text-sm {{ request()->is('admin/coupons*') ? 'text-amber-400' : 'text-slate-500' }}"></i>
                    <span>Mã Khuyến Mãi</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->is('admin/users*') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20 font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60' }}">
                    <i class="fa-solid fa-users-gear w-5 text-center text-sm {{ request()->is('admin/users*') ? 'text-amber-400' : 'text-slate-500' }}"></i>
                    <span>Khách Hàng 360° & Users</span>
                </a>
            </nav>
        </div>
    </div>

    <!-- Quick Salon Portal Link & Profile Card -->
    <div class="p-4 border-t border-slate-800/80 bg-slate-950/50">
        <a href="{{ url('/') }}" target="_blank" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold text-slate-300 hover:text-white bg-slate-800/60 hover:bg-slate-800 border border-slate-700/60 transition-colors mb-3">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-store text-amber-400"></i>
                <span>Xem Website Khách</span>
            </span>
            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
        </a>

        <div class="flex items-center gap-3 px-2">
            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-amber-500 to-amber-300 flex items-center justify-center font-bold text-xs text-slate-950">
                AD
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold text-white truncate">Administrator</p>
                <p class="text-[11px] text-emerald-400 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Trực Tuyến
                </p>
            </div>
        </div>
    </div>
</aside>

<!-- Mobile Overlay Backdrop -->
<div id="sidebar-backdrop" class="fixed inset-0 z-30 bg-black/60 backdrop-blur-sm hidden lg:hidden"></div>
