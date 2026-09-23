<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Barber;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    /**
     * Display a listing of appointments.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status');

        $query = Appointment::with(['customer', 'barber.user', 'services'])->latest();

        if ($status && in_array($status, ['pending', 'confirmed', 'completed', 'cancelled'])) {
            $query->where('status', $status);
        }

        $appointments = $query->paginate(10)->withQueryString();

        $counts = [
            'total' => Appointment::count(),
            'pending' => Appointment::where('status', 'pending')->count(),
            'confirmed' => Appointment::where('status', 'confirmed')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
        ];

        return view('admin.appointments.index', compact('appointments', 'counts', 'status'));
    }

    /**
     * Show form to create appointment.
     */
    public function create(): View
    {
        $barbers = Barber::with('user')->where('is_available', true)->get();
        $services = Service::where('is_active', true)->get();
        return view('admin.appointments.create', compact('barbers', 'services'));
    }

    /**
     * Store newly created appointment.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:150',
            'customer_phone' => 'required|string|max:20',
            'barber_id' => 'nullable|exists:barbers,id',
            'appointment_date' => 'required|date',
            'start_time' => 'required|string',
            'service_ids' => 'required|array',
            'service_ids.*' => 'exists:services,id',
            'note' => 'nullable|string',
        ]);

        // Find or create customer user
        $customer = User::firstOrCreate(
            ['phone' => $validated['customer_phone']],
            [
                'name' => $validated['customer_name'],
                'email' => 'guest_' . time() . rand(10, 99) . '@barber.local',
                'password' => bcrypt('secret123'),
            ]
        );

        $selectedServices = Service::whereIn('id', $validated['service_ids'])->get();
        $totalPrice = $selectedServices->sum('price');

        $appointment = Appointment::create([
            'code' => 'APT' . date('Ymd') . rand(100, 999),
            'customer_id' => $customer->id,
            'barber_id' => $validated['barber_id'] ?: null,
            'appointment_date' => $validated['appointment_date'],
            'start_time' => $validated['start_time'],
            'total_price' => $totalPrice,
            'status' => 'confirmed',
            'payment_status' => 'unpaid',
            'payment_method' => 'cash',
            'note' => $validated['note'],
        ]);

        $appointment->services()->sync($validated['service_ids']);

        return redirect()->route('admin.appointments.index')->with('success', 'Đã tạo lịch hẹn #' . $appointment->code . ' thành công!');
    }

    /**
     * Show form to edit appointment.
     */
    public function edit(Appointment $appointment): View
    {
        $barbers = Barber::with('user')->get();
        $services = Service::all();
        $appointment->load(['customer', 'services']);
        return view('admin.appointments.edit', compact('appointment', 'barbers', 'services'));
    }

    /**
     * Update specified appointment.
     */
    public function update(Request $request, Appointment $appointment): RedirectResponse
    {
        $validated = $request->validate([
            'barber_id' => 'nullable|exists:barbers,id',
            'appointment_date' => 'required|date',
            'start_time' => 'required|string',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'service_ids' => 'required|array',
            'service_ids.*' => 'exists:services,id',
            'note' => 'nullable|string',
        ]);

        $selectedServices = Service::whereIn('id', $validated['service_ids'])->get();
        $totalPrice = $selectedServices->sum('price');

        $appointment->update([
            'barber_id' => $validated['barber_id'] ?: null,
            'appointment_date' => $validated['appointment_date'],
            'start_time' => $validated['start_time'],
            'status' => $validated['status'],
            'total_price' => $totalPrice,
            'note' => $validated['note'],
        ]);

        $appointment->services()->sync($validated['service_ids']);

        return redirect()->route('admin.appointments.index')->with('success', 'Đã cập nhật lịch hẹn thành công!');
    }

    /**
     * Delete specified appointment.
     */
    public function destroy(Appointment $appointment): RedirectResponse
    {
        $appointment->services()->detach();
        $appointment->delete();
        return redirect()->route('admin.appointments.index')->with('success', 'Đã xoá lịch hẹn thành công!');
    }
}
