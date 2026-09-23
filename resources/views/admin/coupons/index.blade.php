@extends('layouts.admin')

@section('title', 'Quản Lý Khuyến Mãi')
@section('page-title', 'Mã Giảm Giá & Voucher')
@section('page-description', 'Danh sách mã ưu đãi, giảm giá phần trăm hoặc số tiền cố định cho khách hàng.')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Khuyến Mãi</li>
@endsection

@section('content')
<section class="section">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Danh Sách Mã Giảm Giá</h5>
            <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-tag-fill"></i> Tạo Mã Mới
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>MÃ VOUCHER</th>
                            <th>MỨC GIẢM</th>
                            <th>ĐƠN TỐI THIỂU</th>
                            <th>LƯỢT DÙNG</th>
                            <th>HẠN SỬ DỤNG</th>
                            <th>TRẠNG THÁI</th>
                            <th>HÀNH ĐỘNG</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($coupons as $coupon)
                        <tr>
                            <td>
                                <span class="badge bg-light-danger text-danger fs-6 px-3 py-2 font-bold border border-danger border-dashed">
                                    {{ $coupon->code }}
                                </span>
                            </td>
                            <td class="font-bold text-success">
                                @if($coupon->discount_type === 'percent')
                                    Giảm {{ (int)$coupon->discount_value }}%
                                @else
                                    Giảm {{ number_format($coupon->discount_value, 0, ',', '.') }}đ
                                @endif
                            </td>
                            <td>{{ number_format($coupon->min_order_amount ?? 0, 0, ',', '.') }}đ</td>
                            <td>
                                <strong>{{ $coupon->used_count ?? 0 }}</strong> / {{ $coupon->usage_limit ?? '∞' }}
                            </td>
                            <td>
                                {{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('d/m/Y') : 'Không giới hạn' }}
                            </td>
                            <td>
                                @if($coupon->is_active ?? true)
                                    <span class="badge bg-success">Đang hiệu lực</span>
                                @else
                                    <span class="badge bg-secondary">Tạm khoá</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-sm btn-outline-primary" title="Sửa">
                                        <i class="bi bi-pencil"></i> Sửa
                                    </a>
                                    <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xoá mã {{ $coupon->code }}?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Xoá">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">Chưa có mã giảm giá nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                {{ $coupons->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
