<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiConversation;
use App\Models\Appointment;
use App\Models\Barber;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with live statistics.
     */
    public function index(): View
    {
        $today = Carbon::today();

        // 1. Doanh thu hôm nay (các đơn đã hoàn thành hôm nay)
        $revenueToday = Appointment::whereDate('appointment_date', $today)
            ->where('status', 'completed')
            ->sum('total_price');

        // Doanh thu tổng
        $totalRevenue = Appointment::where('status', 'completed')->sum('total_price');

        // 2. Lịch hẹn hôm nay & chờ duyệt
        $todayAppointmentsCount = Appointment::whereDate('appointment_date', $today)->count();
        $pendingAppointmentsCount = Appointment::where('status', 'pending')->count();

        // 3. Thợ cắt tóc hoạt động
        $activeBarbersCount = Barber::where('is_available', true)->count();
        $totalBarbersCount = Barber::count();

        // 4. Lượt tư vấn AI
        $aiConversationsCount = AiConversation::count();

        // 5. Thống kê khách hàng
        $totalCustomers = User::count();

        // 6. Danh sách 6 lịch hẹn mới nhất
        $recentAppointments = Appointment::with(['customer', 'barber.user', 'services'])
            ->latest()
            ->take(6)
            ->get();

        // 7. Top Thợ cắt tóc
        $topBarbers = Barber::with('user')
            ->orderByDesc('rating_avg')
            ->take(4)
            ->get();

        // 8. Dịch vụ phổ biến
        $popularServices = Service::with('category')
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('admin.dashboard', compact(
            'revenueToday',
            'totalRevenue',
            'todayAppointmentsCount',
            'pendingAppointmentsCount',
            'activeBarbersCount',
            'totalBarbersCount',
            'aiConversationsCount',
            'totalCustomers',
            'recentAppointments',
            'topBarbers',
            'popularServices'
        ));
    }
}
