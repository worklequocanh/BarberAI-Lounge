<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                        <i class="bi bi-scissors text-primary fs-3"></i>
                        <span class="fs-4 font-bold text-dark">Barber<span class="text-primary">AI</span></span>
                    </a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Bảng Điều Khiển</li>

                <li class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-title">Vận Hành & Đặt Lịch</li>

                <li class="sidebar-item has-sub {{ request()->is('admin/appointments*') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-calendar-check-fill"></i>
                        <span>Lịch Hẹn Cắt Tóc</span>
                    </a>
                    <ul class="submenu {{ request()->is('admin/appointments*') ? 'active' : '' }}">
                        <li class="submenu-item {{ request()->routeIs('admin.appointments.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.appointments.index') }}">Tất cả lịch hẹn</a>
                        </li>
                        <li class="submenu-item {{ request()->routeIs('admin.appointments.timeline') ? 'active' : '' }}">
                            <a href="{{ route('admin.appointments.timeline') }}">Matrix Timeline (Bản đồ giờ)</a>
                        </li>
                        <li class="submenu-item {{ request()->routeIs('admin.appointments.create') ? 'active' : '' }}">
                            <a href="{{ route('admin.appointments.create') }}">Tạo lịch hẹn mới</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item has-sub {{ request()->is('admin/barbers*') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-person-badge-fill"></i>
                        <span>Thợ Cắt Tóc</span>
                    </a>
                    <ul class="submenu {{ request()->is('admin/barbers*') ? 'active' : '' }}">
                        <li class="submenu-item {{ request()->routeIs('admin.barbers.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.barbers.index') }}">Danh sách thợ</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-title">Dịch Vụ & Tạo Mẫu</li>

                <li class="sidebar-item has-sub {{ request()->is('admin/services*') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-scissors"></i>
                        <span>Dịch Vụ & Combo</span>
                    </a>
                    <ul class="submenu {{ request()->is('admin/services*') ? 'active' : '' }}">
                        <li class="submenu-item {{ request()->routeIs('admin.services.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.services.index') }}">Bảng giá dịch vụ & Combo</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item has-sub {{ request()->is('admin/hairstyles*') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-person-bounding-box"></i>
                        <span>Kiểu Tóc & Dáng Mặt</span>
                    </a>
                    <ul class="submenu {{ request()->is('admin/hairstyles*') ? 'active' : '' }}">
                        <li class="submenu-item {{ request()->routeIs('admin.hairstyles.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.hairstyles.index') }}">Bộ sưu tập kiểu tóc</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-title">AI Tư Vấn Kiểu Tóc</li>

                <li class="sidebar-item {{ request()->routeIs('admin.ai.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.ai.index') }}" class='sidebar-link'>
                        <i class="bi bi-cpu-fill"></i>
                        <span>AI Styling Assistant</span>
                    </a>
                </li>

                <li class="sidebar-title">Marketing & Khách Hàng</li>

                <li class="sidebar-item {{ request()->is('admin/campaigns*') ? 'active' : '' }}">
                    <a href="{{ route('admin.campaigns.index') }}" class='sidebar-link'>
                        <i class="bi bi-envelope-paper-heart-fill"></i>
                        <span>Email Marketing</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('admin/coupons*') ? 'active' : '' }}">
                    <a href="{{ route('admin.coupons.index') }}" class='sidebar-link'>
                        <i class="bi bi-ticket-perforated-fill"></i>
                        <span>Mã Giảm Giá (Coupons)</span>
                    </a>
                </li>

                <li class="sidebar-title">Quản Trị & Người Dùng</li>

                <li class="sidebar-item {{ request()->is('admin/users*') ? 'active' : '' }}">
                    <a href="{{ route('admin.users.index') }}" class='sidebar-link'>
                        <i class="bi bi-people-fill"></i>
                        <span>Tài Khoản Người Dùng</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{ url('/') }}" class='sidebar-link text-primary'>
                        <i class="bi bi-box-arrow-up-right"></i>
                        <span>Xem Trang Chủ Website</span>
                    </a>
                </li>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
