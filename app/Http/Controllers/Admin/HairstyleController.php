<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hairstyle;
use App\Models\FaceShape;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HairstyleController extends Controller
{
    /**
     * Display a listing of hairstyles.
     */
    public function index(): View
    {
        $hairstyles = Hairstyle::latest()->paginate(9);
        $faceShapes = FaceShape::all()->keyBy('id');
        return view('admin.hairstyles.index', compact('hairstyles', 'faceShapes'));
    }

    /**
     * Show form to create hairstyle.
     */
    public function create(): View
    {
        $faceShapes = FaceShape::all();
        return view('admin.hairstyles.create', compact('faceShapes'));
    }

    /**
     * Store a newly created hairstyle.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'difficulty' => 'required|integer|min:1|max:5',
            'face_shape_ids' => 'nullable|array',
            'face_shape_ids.*' => 'integer|exists:face_shapes,id',
            'tags' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . rand(100, 999);
        $validated['is_active'] = $request->has('is_active');
        $validated['face_shape_ids'] = array_map('intval', $request->input('face_shape_ids', []));

        if ($request->filled('tags')) {
            $validated['tags'] = array_map('trim', explode(',', $request->input('tags')));
        }

        Hairstyle::create($validated);

        return redirect()->route('admin.hairstyles.index')->with('success', 'Đã thêm mẫu kiểu tóc mới thành công!');
    }

    /**
     * Show form to edit hairstyle.
     */
    public function edit(Hairstyle $hairstyle): View
    {
        $faceShapes = FaceShape::all();
        return view('admin.hairstyles.edit', compact('hairstyle', 'faceShapes'));
    }

    /**
     * Update the specified hairstyle.
     */
    public function update(Request $request, Hairstyle $hairstyle): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'difficulty' => 'required|integer|min:1|max:5',
            'face_shape_ids' => 'nullable|array',
            'face_shape_ids.*' => 'integer|exists:face_shapes,id',
            'tags' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['face_shape_ids'] = array_map('intval', $request->input('face_shape_ids', []));

        if ($request->filled('tags')) {
            $validated['tags'] = array_map('trim', explode(',', $request->input('tags')));
        }

        $hairstyle->update($validated);

        return redirect()->route('admin.hairstyles.index')->with('success', 'Cập nhật mẫu tóc thành công!');
    }

    /**
     * Remove the specified hairstyle.
     */
    public function destroy(Hairstyle $hairstyle): RedirectResponse
    {
        $hairstyle->delete();
        return redirect()->route('admin.hairstyles.index')->with('success', 'Đã xoá mẫu tóc khỏi bộ sưu tập!');
    }
}
