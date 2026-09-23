<header class="sticky top-0 z-20 h-18 bg-[#111827]/80 backdrop-blur-xl border-b border-[#334155] flex items-center justify-between px-4 sm:px-6 lg:px-8">
    <div class="flex items-center gap-4">
        <!-- Mobile Sidebar Toggle Button -->
        <button id="sidebar-open-btn" class="lg:hidden p-2 rounded-xl text-[#94A3B8] hover:text-[#F8FAFC] hover:bg-[#1E293B] transition-colors">
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
        <!-- Quick Action: New Appointment (Indigo Primary Button) -->
        <a href="{{ route('admin.appointments.create') }}" class="hidden md:inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#6366F1] hover:bg-[#818CF8] text-white font-semibold text-xs tracking-wide shadow-lg shadow-indigo-500/20 transition-all duration-200 hover:scale-[1.02]">
            <i class="fa-solid fa-plus"></i>
            <span>Tạo Lịch Nhanh</span>
        </a>

        <!-- Timeline shortcut -->
        <a href="{{ route('admin.appointments.timeline') }}" title="Matrix Timeline" class="p-2.5 rounded-xl text-[#94A3B8] hover:text-[#22D3EE] hover:bg-[#1E293B] border border-[#334155] transition-colors">
            <i class="fa-solid fa-table-cells text-sm"></i>
        </a>

        <!-- Notifications Dropdown -->
        <div class="relative">
            <button class="relative p-2.5 rounded-xl text-[#94A3B8] hover:text-[#F8FAFC] hover:bg-[#1E293B] border border-[#334155] transition-colors">
                <i class="fa-regular fa-bell text-sm"></i>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-[#22D3EE]"></span>
            </button>
        </div>

        <div class="h-6 w-px bg-[#334155] mx-1"></div>

        <!-- Admin User Profile Menu -->
        <div class="flex items-center gap-3 pl-2">
            <div class="hidden text-right sm:block">
                <span class="block text-xs font-bold text-[#F8FAFC]">{{ auth()->user()->name ?? 'Admin Quản Trị' }}</span>
                <span class="block text-[11px] text-[#94A3B8]">Super Administrator</span>
            </div>
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-[#6366F1] to-[#22D3EE] p-0.5 shadow-md shadow-indigo-500/20">
                <div class="w-full h-full rounded-[10px] bg-[#0B1120] flex items-center justify-center text-[#22D3EE] font-extrabold text-xs">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
            </div>
        </div>
    </div>
</header>
