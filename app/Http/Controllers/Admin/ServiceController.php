<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display a listing of services.
     */
    public function index(): View
    {
        $services = Service::with('category')->latest()->paginate(10);

        return view('admin.services.index', compact('services'));
    }

    /**
     * Show form to create service.
     */
    public function create(): View
    {
        $categories = Category::all();

        return view('admin.services.create', compact('categories'));
    }

    /**
     * Store a newly created service in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'duration_min' => 'required|integer|min:5|max:300',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']).'-'.rand(100, 999);
        $validated['is_active'] = $request->has('is_active');

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Đã thêm dịch vụ mới thành công!');
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Service $service): View
    {
        $categories = Category::all();

        return view('admin.services.edit', compact('service', 'categories'));
    }

    /**
     * Update the specified service in storage.
     */
    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'duration_min' => 'required|integer|min:5|max:300',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Cập nhật dịch vụ thành công!');
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Đã xoá dịch vụ thành công!');
    }
}
