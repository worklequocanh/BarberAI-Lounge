@extends('layouts.admin')

@section('title', 'Bộ Sưu Tập Kiểu Tóc')
@section('page-title', 'Kiểu Tóc & Dáng Mặt AI')
@section('page-description', 'Thư viện mẫu tóc nam phong cách, liên kết với nhận diện khuôn mặt AI.')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Kiểu Tóc</li>
@endsection

@section('content')
<section class="section">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Bộ Sưu Tập Xu Hướng 2026</h5>
            <a href="{{ route('admin.hairstyles.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i> Thêm Kiểu Tóc Mới
            </a>
        </div>
        <div class="card-body">
            <div class="row g-4">
                @forelse($hairstyles as $hair)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 border shadow-none">
                        <div class="position-relative bg-light rounded-top text-center p-4" style="height: 160px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1e293b, #0f172a);">
                            <i class="bi bi-scissors fs-1 text-primary"></i>
                            <span class="position-absolute top-0 end-0 m-3 badge bg-primary">
                                {{ $hair->difficulty }} ★ Độ khó
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title font-bold mb-2">{{ $hair->name }}</h5>
                            <p class="card-text text-muted small mb-3">
                                {{ Str::limit($hair->description ?? 'Kiểu tóc thời thượng, tạo vẻ nam tính, thanh lịch.', 80) }}
                            </p>
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1 font-bold">Phù hợp dáng mặt AI:</small>
                                @if(is_array($hair->face_shape_ids) && count($hair->face_shape_ids) > 0)
                                    @foreach($hair->face_shape_ids as $sid)
                                        @if(isset($faceShapes[$sid]))
                                            <span class="badge bg-light-info text-info me-1">{{ $faceShapes[$sid]->name }}</span>
                                        @endif
                                    @endforeach
                                @else
                                    <span class="badge bg-light-secondary text-secondary">Tất cả khuôn mặt</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 d-flex justify-content-between align-items-center">
                            <span class="text-muted small"><i class="bi bi-eye"></i> {{ $hair->views ?? 0 }} lượt xem</span>
                            <div class="btn-group">
                                <a href="{{ route('admin.hairstyles.edit', $hair->id) }}" class="btn btn-sm btn-outline-primary" title="Sửa">
                                    <i class="bi bi-pencil"></i> Sửa
                                </a>
                                <form action="{{ route('admin.hairstyles.destroy', $hair->id) }}" method="POST" data-confirm="Bạn có chắc chắn muốn xoá kiểu tóc {{ $hair->name }}?" class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Xoá">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5 text-muted">
                    <p>Chưa có dữ liệu kiểu tóc nào</p>
                </div>
                @endforelse
            </div>

            <div class="mt-4 d-flex justify-content-end">
                {{ $hairstyles->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
