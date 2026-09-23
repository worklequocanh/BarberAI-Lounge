@extends('layouts.admin')

@section('title', 'Quản Lý Người Dùng & Hội Viên')
@section('page-title', 'Tài Khoản & Người Dùng')
@section('page-description', 'Danh sách khách hàng, nhân viên salon và quản trị viên hệ thống.')

@section('breadcrumb')
    <span class="text-amber-400 font-semibold">Người Dùng</span>
@endsection

@section('content')
<div class="rounded-3xl bg-slate-900/90 border border-slate-800 shadow-2xl overflow-hidden">
    <div class="p-5 sm:p-6 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-950/40">
        <div>
            <h3 class="text-base font-bold text-white">Danh Sách Thành Viên & Khách Hàng</h3>
            <p class="text-xs text-slate-400">Xem hồ sơ 360°, tổng chi tiêu LTV và thói quen làm tóc</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-xs font-bold shadow-lg shadow-amber-500/20 transition-all">
            <i class="fa-solid fa-user-plus"></i> Thêm Người Dùng
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="border-b border-slate-800 bg-slate-950/60 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                    <th class="py-3.5 px-5">THÀNH VIÊN</th>
                    <th class="py-3.5 px-4">EMAIL</th>
                    <th class="py-3.5 px-4">SỐ ĐIỆN THOẠI</th>
                    <th class="py-3.5 px-4">VAI TRÒ</th>
                    <th class="py-3.5 px-4">NGÀY THAM GIA</th>
                    <th class="py-3.5 px-5 text-right">THAO TÁC</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/60">
                @forelse($users as $user)
                <tr class="hover:bg-slate-800/30 transition-colors">
                    <td class="py-4 px-5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-slate-800 text-amber-400 flex items-center justify-center font-bold text-xs shrink-0 border border-slate-700/60">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div>
                                <div class="font-bold text-white leading-tight">{{ $user->name }}</div>
                                <div class="text-[11px] text-slate-500 font-mono mt-0.5">UID: #{{ $user->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-4 text-xs text-slate-300 font-mono">
                        {{ $user->email }}
                    </td>
                    <td class="py-4 px-4 text-xs text-slate-300 font-mono">
                        {{ $user->phone ?? '---' }}
                    </td>
                    <td class="py-4 px-4">
                        @if($user->role && ($user->role->slug === 'admin' || str_contains(strtolower($user->role->name), 'admin')))
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-500/15 text-rose-400 border border-rose-500/30">
                                <i class="fa-solid fa-shield-halved text-[10px]"></i> Admin
                            </span>
                        @elseif($user->role && ($user->role->slug === 'barber' || str_contains(strtolower($user->role->name), 'barber')))
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-500/15 text-amber-400 border border-amber-500/30">
                                <i class="fa-solid fa-scissors text-[10px]"></i> Stylist
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-800 text-slate-300 border border-slate-700">
                                Khách Hàng
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-4 text-xs text-slate-400">
                        {{ $user->created_at ? $user->created_at->format('d/m/Y') : '---' }}
                    </td>
                    <td class="py-4 px-5 text-right">
                        <div class="inline-flex items-center gap-2">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-500/10 hover:bg-amber-500 hover:text-slate-950 text-amber-400 text-xs font-bold border border-amber-500/20 transition-all" title="Hồ sơ 360°">
                                <i class="fa-solid fa-eye text-xs"></i>
                                <span>Hồ sơ 360°</span>
                            </a>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 transition-colors" title="Sửa">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </a>
                            @if($user->id !== 1)
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" data-confirm="Xoá tài khoản {{ $user->name }}?" class="inline form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-xl bg-slate-800 hover:bg-rose-500 hover:text-white text-slate-400 transition-colors" title="Xoá">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-12 text-slate-500">Chưa có người dùng nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-5 border-t border-slate-800 flex justify-end">
        {{ $users->links() }}
    </div>
</div>
@endsection
