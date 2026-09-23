@extends('layouts.admin')

@section('title', 'Bộ Sưu Tập Kiểu Tóc & Dáng Mặt AI')
@section('page-title', 'Bộ Sưu Tập Kiểu Tóc')
@section('page-description', 'Thư viện mẫu tóc nam phong cách, liên kết với nhận diện khuôn mặt AI.')

@section('breadcrumb')
    <span class="text-amber-400 font-semibold">Kiểu Tóc</span>
@endsection

@section('content')
<div class="rounded-3xl bg-slate-900/90 border border-slate-800 shadow-2xl p-6 sm:p-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-800 mb-6">
        <div>
            <h3 class="text-base font-bold text-white">Mẫu Tóc Xu Hướng 2026</h3>
            <p class="text-xs text-slate-400">Các mẫu tóc liên kết trực tiếp với gợi ý thông minh từ AI</p>
        </div>
        <a href="{{ route('admin.hairstyles.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-bold shadow-lg shadow-amber-500/20 transition-all">
            <i class="fa-solid fa-plus"></i> Thêm Kiểu Tóc Mới
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($hairstyles as $hair)
        <div class="rounded-2xl bg-slate-950/60 border border-slate-800 hover:border-amber-500/40 transition-all overflow-hidden flex flex-col justify-between shadow-xl">
            <div class="h-40 bg-gradient-to-tr from-slate-900 via-slate-850 to-slate-900 p-4 flex items-center justify-center relative">
                <i class="fa-solid fa-scissors text-amber-500/30 text-5xl"></i>
                <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full bg-slate-900/80 border border-slate-700/80 text-[10px] font-bold text-amber-400">
                    <i class="fa-solid fa-star text-[9px] mr-0.5"></i> Độ khó: {{ $hair->difficulty }}/5
                </span>
            </div>

            <div class="p-5 flex-1 flex flex-col justify-between">
                <div>
                    <h4 class="text-base font-bold text-white mb-2">{{ $hair->name }}</h4>
                    <p class="text-xs text-slate-400 mb-4 line-clamp-2">
                        {{ $hair->description ?? 'Kiểu tóc thời thượng, tạo vẻ nam tính và cuốn hút cho phái mạnh.' }}
                    </p>

                    <div class="mb-4">
                        <span class="text-[10px] uppercase font-bold text-slate-500 block mb-1.5">Dáng mặt AI tôn dáng:</span>
                        <div class="flex flex-wrap gap-1">
                            @if(is_array($hair->face_shape_ids) && count($hair->face_shape_ids) > 0)
                                @foreach($hair->face_shape_ids as $sid)
                                    @if(isset($faceShapes[$sid]))
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-slate-800 text-amber-400 border border-slate-700">
                                            {{ $faceShapes[$sid]->name }}
                                        </span>
                                    @endif
                                @endforeach
                            @else
                                <span class="text-[11px] text-slate-500">Mọi dáng mặt</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-800/80 flex items-center justify-between">
                    <span class="text-xs text-slate-500 font-mono">
                        <i class="fa-regular fa-eye mr-1"></i> {{ $hair->views ?? 0 }} views
                    </span>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.hairstyles.edit', $hair->id) }}" class="p-2 rounded-xl bg-slate-800 hover:bg-amber-500 hover:text-slate-950 text-slate-300 transition-colors" title="Sửa">
                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                        </a>
                        <form action="{{ route('admin.hairstyles.destroy', $hair->id) }}" method="POST" data-confirm="Xoá kiểu tóc {{ $hair->name }}?" class="inline form-delete">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-xl bg-slate-800 hover:bg-rose-500 hover:text-white text-slate-400 transition-colors" title="Xoá">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12 text-slate-500">
            Chưa có kiểu tóc nào trong bộ sưu tập
        </div>
        @endforelse
    </div>
</div>
@endsection
