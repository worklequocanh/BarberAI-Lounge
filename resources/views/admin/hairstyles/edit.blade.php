@extends('layouts.admin')

@section('title', 'Chỉnh Sửa: ' . $hairstyle->name)
@section('page-title', 'Chỉnh Sửa Kiểu Tóc')
@section('page-description', 'Cập nhật lại dáng mặt phù hợp, độ khó hoặc mô tả tạo kiểu.')

@section('breadcrumb')
    <a href="{{ route('admin.hairstyles.index') }}" class="hover:text-amber-400">Kiểu Tóc</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-600 mx-2"></i>
    <span class="text-amber-400 font-semibold">Chỉnh Sửa</span>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 rounded-3xl bg-slate-900/90 border border-slate-800 shadow-2xl p-6 sm:p-8">
        <form action="{{ route('admin.hairstyles.update', $hairstyle->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-2">Tên Kiểu Tóc <span class="text-rose-400">*</span></label>
                <input type="text" name="name" value="{{ old('name', $hairstyle->name) }}" required
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-2">Độ Khó Chăm Sóc / Tạo Kiểu</label>
                <select name="difficulty" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                    <option value="1" {{ old('difficulty', $hairstyle->difficulty) == 1 ? 'selected' : '' }}>1 Sao - Rất dễ</option>
                    <option value="2" {{ old('difficulty', $hairstyle->difficulty) == 2 ? 'selected' : '' }}>2 Sao - Dễ</option>
                    <option value="3" {{ old('difficulty', $hairstyle->difficulty) == 3 ? 'selected' : '' }}>3 Sao - Trung bình</option>
                    <option value="4" {{ old('difficulty', $hairstyle->difficulty) == 4 ? 'selected' : '' }}>4 Sao - Khó</option>
                    <option value="5" {{ old('difficulty', $hairstyle->difficulty) == 5 ? 'selected' : '' }}>5 Sao - Rất cầu kỳ</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-2">Dáng Mặt Phù Hợp (Dùng Cho AI Matching)</label>
                @php
                    $selectedShapes = is_array($hairstyle->face_shape_ids) ? $hairstyle->face_shape_ids : [];
                @endphp
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach($faceShapes as $shape)
                    <label class="flex items-center gap-2.5 p-3 rounded-xl bg-slate-950/60 border border-slate-800 hover:border-amber-500/40 cursor-pointer">
                        <input type="checkbox" name="face_shape_ids[]" value="{{ $shape->id }}" {{ in_array($shape->id, $selectedShapes) ? 'checked' : '' }}
                            class="w-4 h-4 rounded text-amber-500 focus:ring-amber-400 bg-slate-900 border-slate-700">
                        <span class="text-xs font-semibold text-slate-200">{{ $shape->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-2">Thẻ Phân Loại (Tags)</label>
                <input type="text" name="tags" value="{{ old('tags', $hairstyle->tags) }}"
                    class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-2">Mô Tả Kiểu Tóc & Cách Vuốt Sáp</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none">{{ old('description', $hairstyle->description) }}</textarea>
            </div>

            <div class="pt-6 border-t border-slate-800 flex justify-end gap-3">
                <a href="{{ route('admin.hairstyles.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-300 text-xs font-bold transition-colors">
                    Huỷ Bỏ
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-extrabold shadow-lg shadow-amber-500/20 transition-all">
                    Cập Nhật
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
