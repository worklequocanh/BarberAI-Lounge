<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(): View
    {
        $users = User::with('role')->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show form to create user.
     */
    public function create(): View
    {
        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150|unique:users,email',
            'phone' => 'nullable|string|max:20|unique:users,phone',
            'password' => 'required|string|min:6',
            'role_id' => 'required|exists:roles,id',
            'gender' => 'nullable|in:male,female,other',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->has('is_active');

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'Đã tạo tài khoản thành công!');
    }

    /**
     * Show detailed Customer 360 profile with appointment history and hair notes.
     */
    public function show(User $user): View
    {
        $user->load(['role', 'appointments' => function ($q) {
            $q->with(['barber.user', 'services'])->latest();
        }]);

        $appointments = $user->appointments;
        $totalSpent = $appointments->where('status', 'completed')->sum('total_price');
        $completedCount = $appointments->where('status', 'completed')->count();

        // Find favorite barber
        $barberStats = $appointments->whereNotNull('barber_id')
            ->groupBy('barber_id')
            ->map->count()
            ->sortDesc();

        $favoriteBarberId = $barberStats->keys()->first();
        $favoriteBarber = $favoriteBarberId ? Barber::with('user')->find($favoriteBarberId) : null;

        // Collect all hair notes
        $hairNotes = $appointments->whereNotNull('hair_notes')->filter(fn ($a) => ! empty(trim($a->hair_notes)));

        return view('admin.users.show', compact('user', 'appointments', 'totalSpent', 'completedCount', 'favoriteBarber', 'hairNotes'));
    }

    /**
     * Show form to edit user.
     */
    public function edit(User $user): View
    {
        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:20|unique:users,phone,'.$user->id,
            'password' => 'nullable|string|min:6',
            'role_id' => 'required|exists:roles,id',
            'gender' => 'nullable|in:male,female,other',
            'is_active' => 'nullable|boolean',
        ]);

        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_active'] = $request->has('is_active');

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật tài khoản người dùng thành công!');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Prevent deleting the main admin account
        if ($user->id === 1) {
            return redirect()->route('admin.users.index')->with('error', 'Không thể xoá tài khoản Quản trị viên tối cao!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Đã xoá tài khoản người dùng!');
    }
}
