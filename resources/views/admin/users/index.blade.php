@extends('layouts.admin')

@section('title', 'Tài Khoản & Người Dùng')
@section('page-title', 'Quản Lý Người Dùng')
@section('page-description', 'Danh sách khách hàng, nhân viên salon và quản trị viên hệ thống.')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Người Dùng</li>
@endsection

@section('content')
<section class="section">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Danh Sách Thành Viên</h5>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-person-plus"></i> Thêm Người Dùng
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>THÀNH VIÊN</th>
                            <th>EMAIL</th>
                            <th>SỐ ĐIỆN THOẠI</th>
                            <th>VAI TRÒ</th>
                            <th>NGÀY THAM GIA</th>
                            <th>HÀNH ĐỘNG</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-md bg-light-primary text-primary me-3 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person font-bold"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 font-bold">{{ $user->name }}</h6>
                                        <small class="text-muted">ID: #{{ $user->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? '---' }}</td>
                            <td>
                                @if($user->role && ($user->role->slug === 'admin' || str_contains(strtolower($user->role->name), 'admin')))
                                    <span class="badge bg-danger">Quản Trị Viên</span>
                                @elseif($user->role && ($user->role->slug === 'barber' || str_contains(strtolower($user->role->name), 'barber')))
                                    <span class="badge bg-primary">Thợ Cắt Tóc</span>
                                @else
                                    <span class="badge bg-light-secondary text-secondary">Khách Hàng</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at ? $user->created_at->format('d/m/Y') : '---' }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary" title="Sửa">
                                        <i class="bi bi-pencil"></i> Sửa
                                    </a>
                                    @if($user->id !== 1)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" data-confirm="Bạn có chắc chắn muốn xoá tài khoản {{ $user->name }}?" class="d-inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Xoá">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Chưa có người dùng nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
