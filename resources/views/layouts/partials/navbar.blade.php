<header class="sticky top-0 z-20 h-18 bg-slate-900/80 backdrop-blur-xl border-b border-slate-800 flex items-center justify-between px-4 sm:px-6 lg:px-8">
    <div class="flex items-center gap-4">
        <!-- Mobile Sidebar Toggle Button -->
        <button id="sidebar-open-btn" class="lg:hidden p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 transition-colors">
            <i class="fa-solid fa-bars text-lg"></i>
        </button>

        <!-- Live Salon Status Pill -->
        <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-semibold">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
            <span>Salon Hoạt Động (08:30 - 21:00)</span>
        </div>
    </div>

    <!-- Right Controls -->
    <div class="flex items-center gap-3">
        <!-- Quick Action: New Appointment -->
        <a href="{{ route('admin.appointments.create') }}" class="hidden md:inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-bold text-xs tracking-wide shadow-lg shadow-amber-500/20 transition-all duration-200 hover:scale-[1.02]">
            <i class="fa-solid fa-plus"></i>
            <span>Tạo Lịch Nhanh</span>
        </a>

        <!-- Timeline shortcut -->
        <a href="{{ route('admin.appointments.timeline') }}" title="Matrix Timeline" class="p-2.5 rounded-xl text-slate-400 hover:text-amber-400 hover:bg-slate-800 border border-slate-800 transition-colors">
            <i class="fa-solid fa-table-cells text-sm"></i>
        </a>

        <!-- Notifications Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button class="relative p-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 border border-slate-800 transition-colors">
                <i class="fa-regular fa-bell text-sm"></i>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-amber-500"></span>
            </button>
        </div>

        <div class="h-6 w-px bg-slate-800 mx-1"></div>

        <!-- Admin User Profile Menu -->
        <div class="flex items-center gap-3 pl-2">
            <div class="hidden text-right sm:block">
                <span class="block text-xs font-bold text-slate-200">Admin Quản Trị</span>
                <span class="block text-[11px] text-slate-500">Super Administrator</span>
            </div>
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-amber-500 to-amber-300 p-0.5 shadow-md shadow-amber-500/20">
                <div class="w-full h-full rounded-[10px] bg-slate-950 flex items-center justify-center text-amber-400 font-extrabold text-xs">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
            </div>
        </div>
    </div>
</header>
