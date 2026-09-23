<!DOCTYPE html>
<html lang="vi" class="h-full bg-[#0B1120] text-[#F8FAFC] antialiased dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Barber AI Lounge</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">

    <!-- Vite Assets: Tailwind v4 + FontAwesome 6 + SweetAlert2 -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="h-full bg-[#0B1120] text-[#CBD5E1] font-sans selection:bg-[#6366F1] selection:text-white overflow-x-hidden">
    <!-- App Container -->
    <div class="min-h-full flex flex-col">
        <!-- Sidebar Navigation -->
        @include('layouts.partials.sidebar')

        <!-- Main Workspace (Offset for desktop sidebar w-64) -->
        <div class="lg:pl-64 flex flex-col flex-1 min-h-screen">
            <!-- Header Topbar -->
            @include('layouts.partials.navbar')

            <!-- Main Content Area -->
            <main class="flex-1 px-4 sm:px-6 lg:px-8 py-8 max-w-7xl w-full mx-auto">
                <!-- Page Title & Breadcrumbs -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white flex items-center gap-3">
                            @yield('page-title', 'Dashboard')
                        </h1>
                        <p class="text-sm text-slate-400 mt-1">@yield('page-description', 'Hệ thống quản trị tiệm tóc nam & AI tư vấn kiểu tóc.')</p>
                    </div>

                    <!-- Breadcrumbs -->
                    <nav class="flex items-center text-xs font-medium text-[#94A3B8] space-x-2 shrink-0">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#22D3EE] transition-colors">Admin</a>
                        <i class="fa-solid fa-chevron-right text-[10px] text-[#334155]"></i>
                        @yield('breadcrumb')
                    </nav>
                </div>

                <!-- Alert Messages -->
                @include('layouts.partials.alerts')

                <!-- Primary Content Slot -->
                @yield('content')
            </main>

            <!-- Footer -->
            @include('layouts.partials.footer')
        </div>
    </div>

    <!-- SweetAlert2 Trigger Listener -->
    @include('layouts.partials.sweetalert')

    <!-- Interactive Mobile Drawer Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('admin-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            const openBtn = document.getElementById('sidebar-open-btn');
            const closeBtn = document.getElementById('sidebar-close-btn');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            if (openBtn) openBtn.addEventListener('click', openSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (backdrop) backdrop.addEventListener('click', closeSidebar);
        });
    </script>

    @stack('scripts')
</body>

</html>
