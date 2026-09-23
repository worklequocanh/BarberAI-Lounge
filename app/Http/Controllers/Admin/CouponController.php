<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CouponController extends Controller
{
    /**
     * Display a listing of coupons.
     */
    public function index(): View
    {
        $coupons = Coupon::latest()->paginate(10);

        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show form to create coupon.
     */
    public function create(): View
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created coupon.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:1',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['code'] = strtoupper(trim($validated['code']));
        $validated['name'] = $request->input('name') ?? ('Mã '.$validated['code']);
        $validated['is_active'] = $request->has('is_active');
        $validated['used_count'] = 0;

        Coupon::create($validated);

        return redirect()->route('admin.coupons.index')->with('success', 'Đã tạo mã giảm giá '.$validated['code'].' thành công!');
    }

    /**
     * Show form to edit coupon.
     */
    public function edit(Coupon $coupon): View
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Update specified coupon.
     */
    public function update(Request $request, Coupon $coupon): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,'.$coupon->id,
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:1',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['code'] = strtoupper(trim($validated['code']));
        $validated['is_active'] = $request->has('is_active');

        $coupon->update($validated);

        return redirect()->route('admin.coupons.index')->with('success', 'Cập nhật mã giảm giá thành công!');
    }

    /**
     * Delete specified coupon.
     */
    public function destroy(Coupon $coupon): RedirectResponse
    {
        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('success', 'Đã xoá mã giảm giá thành công!');
    }
}
