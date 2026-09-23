<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use App\Models\BarberSchedule;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BarberController extends Controller
{
    /**
     * Display a listing of barbers.
     */
    public function index(): View
    {
        $barbers = Barber::with('user')->paginate(10);

        return view('admin.barbers.index', compact('barbers'));
    }

    /**
     * Show form to create barber.
     */
    public function create(): View
    {
        return view('admin.barbers.create');
    }

    /**
     * Store a newly created barber.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'phone' => 'required|string|max:20|unique:users,phone',
            'email' => 'required|email|max:150|unique:users,email',
            'experience_years' => 'required|integer|min:0|max:50',
            'bio' => 'nullable|string',
            'is_available' => 'nullable|boolean',
        ]);

        $barberRole = Role::where('slug', 'barber')->orWhere('name', 'like', '%Barber%')->first();

        $user = User::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'password' => bcrypt('barber123'),
            'role_id' => $barberRole?->id,
        ]);

        $barber = Barber::create([
            'user_id' => $user->id,
            'experience_years' => $validated['experience_years'],
            'bio' => $validated['bio'],
            'is_available' => $request->has('is_available'),
            'rating_avg' => 5.0,
            'total_reviews' => 0,
        ]);

        // Default schedule for new barber (Mon - Sat)
        for ($day = 1; $day <= 6; $day++) {
            BarberSchedule::create([
                'barber_id' => $barber->id,
                'day_of_week' => $day,
                'start_time' => '08:30:00',
                'end_time' => '20:30:00',
                'is_working' => true,
            ]);
        }

        return redirect()->route('admin.barbers.index')->with('success', 'Đã thêm Stylist '.$user->name.' vào đội ngũ salon!');
    }

    /**
     * Show form to edit barber.
     */
    public function edit(Barber $barber): View
    {
        $barber->load('user');

        return view('admin.barbers.edit', compact('barber'));
    }

    /**
     * Update specified barber.
     */
    public function update(Request $request, Barber $barber): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'phone' => 'required|string|max:20|unique:users,phone,'.$barber->user_id,
            'experience_years' => 'required|integer|min:0|max:50',
            'bio' => 'nullable|string',
            'is_available' => 'nullable|boolean',
        ]);

        $barber->user->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
        ]);

        $barber->update([
            'experience_years' => $validated['experience_years'],
            'bio' => $validated['bio'],
            'is_available' => $request->has('is_available'),
        ]);

        return redirect()->route('admin.barbers.index')->with('success', 'Cập nhật hồ sơ Stylist thành công!');
    }

    /**
     * Delete specified barber.
     */
    public function destroy(Barber $barber): RedirectResponse
    {
        $barber->delete();

        return redirect()->route('admin.barbers.index')->with('success', 'Đã xoá hồ sơ thợ cắt tóc thành công!');
    }
}
