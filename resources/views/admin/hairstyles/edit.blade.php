@extends('layouts.admin')

@section('title', 'Chỉnh Sửa Kiểu Tóc')
@section('page-title', 'Chỉnh Sửa: ' . $hairstyle->name)
@section('page-description', 'Cập nhật lại dáng mặt phù hợp, độ khó hoặc mô tả tạo kiểu.')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.hairstyles.index') }}">Kiểu Tóc</a></li>
    <li class="breadcrumb-item active" aria-current="page">Chỉnh Sửa</li>
@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h5 class="card-title mb-0">Cập Nhật Thông Tin Mẫu Tóc</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.hairstyles.update', $hairstyle->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label font-bold">Tên Kiểu Tóc <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $hairstyle->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-bold">Độ Khó Chăm Sóc / Tạo Kiểu</label>
                            <select name="difficulty" class="form-select @error('difficulty') is-invalid @enderror">
                                <option value="1" {{ old('difficulty', $hairstyle->difficulty) == 1 ? 'selected' : '' }}>1 Sao - Rất dễ (Chỉ cần sấy khô)</option>
                                <option value="2" {{ old('difficulty', $hairstyle->difficulty) == 2 ? 'selected' : '' }}>2 Sao - Dễ (Sấy nhẹ vuốt sáp nhanh)</option>
                                <option value="3" {{ old('difficulty', $hairstyle->difficulty) == 3 ? 'selected' : '' }}>3 Sao - Trung bình (Cần sấy tạo phồng)</option>
                                <option value="4" {{ old('difficulty', $hairstyle->difficulty) == 4 ? 'selected' : '' }}>4 Sao - Khó (Cần sấy lược tròn + gôm)</option>
                                <option value="5" {{ old('difficulty', $hairstyle->difficulty) == 5 ? 'selected' : '' }}>5 Sao - Rất cầu kỳ (Cần uốn và giữ nếp chuẩn)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-bold">Dáng Mặt Phù Hợp (Dùng cho AI Matching)</label>
                            <p class="text-muted text-xs mb-2">Tích chọn các dáng mặt mà kiểu tóc này tôn đường nét nhất</p>
                            @php
                                $selectedShapes = is_array($hairstyle->face_shape_ids) ? $hairstyle->face_shape_ids : [];
                            @endphp
                            <div class="row g-2">
                                @foreach($faceShapes as $shape)
                                <div class="col-6 col-md-4">
                                    <div class="form-check border rounded p-2 ps-4">
                                        <input class="form-check-input" type="checkbox" name="face_shape_ids[]" value="{{ $shape->id }}" id="fs_{{ $shape->id }}" {{ in_array($shape->id, $selectedShapes) ? 'checked' : '' }}>
                                        <label class="form-check-label font-bold" for="fs_{{ $shape->id }}">
                                            {{ $shape->name }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-bold">Thẻ Phân Loại (Tags)</label>
                            <input type="text" name="tags" class="form-control" value="{{ old('tags', is_array($hairstyle->tags) ? implode(', ', $hairstyle->tags) : '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-bold">Mô Tả Kiểu Tóc & Lời Khuyên Stylist</label>
                            <textarea name="description" rows="4" class="form-control">{{ old('description', $hairstyle->description) }}</textarea>
                        </div>

                        <div class="mb-4 form-check form-switch ps-5">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitch" value="1" {{ old('is_active', $hairstyle->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label font-bold" for="isActiveSwitch">Hiển thị mẫu tóc này trên catalogue & cho phép AI gợi ý</label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-outline-danger" onclick="if(confirm('Bạn có chắc chắn muốn xoá kiểu tóc này?')) document.getElementById('delete-hair-form').submit();">
                                <i class="bi bi-trash"></i> Xoá Kiểu Tóc
                            </button>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.hairstyles.index') }}" class="btn btn-light-secondary">Huỷ Bỏ</a>
                                <button type="submit" class="btn btn-primary px-4">Cập Nhật</button>
                            </div>
                        </div>
                    </form>

                    <form id="delete-hair-form" action="{{ route('admin.hairstyles.destroy', $hairstyle->id) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
