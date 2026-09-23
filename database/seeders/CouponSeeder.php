<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role_id', 1)->first();

        $coupons = [
            [
                'code' => 'WELCOME10',
                'name' => 'Giảm 10% cho khách hàng lần đầu cắt tóc',
                'discount_type' => 'percent',
                'discount_value' => 10,
                'min_order_amount' => 80000,
                'usage_limit' => 200,
                'used_count' => 18,
                'starts_at' => now()->subDays(10),
                'expires_at' => now()->addMonths(6),
                'is_active' => true,
                'created_by' => $admin?->id,
            ],
            [
                'code' => 'VIP50K',
                'name' => 'Giảm ngay 50.000đ cho gói Combo VIP',
                'discount_type' => 'fixed',
                'discount_value' => 50000,
                'min_order_amount' => 150000,
                'usage_limit' => 100,
                'used_count' => 35,
                'starts_at' => now()->subDays(10),
                'expires_at' => now()->addMonths(3),
                'is_active' => true,
                'created_by' => $admin?->id,
            ],
            [
                'code' => 'UONHOT20',
                'name' => 'Ưu đãi 20% cho gói dịch vụ Uốn Hàn Quốc',
                'discount_type' => 'percent',
                'discount_value' => 20,
                'min_order_amount' => 250000,
                'usage_limit' => 50,
                'used_count' => 12,
                'starts_at' => now()->subDays(5),
                'expires_at' => now()->addMonth(),
                'is_active' => true,
                'created_by' => $admin?->id,
            ],
            [
                'code' => 'SINHNHAT100K',
                'name' => 'Quà tặng sinh nhật thành viên Salon',
                'discount_type' => 'fixed',
                'discount_value' => 100000,
                'min_order_amount' => 300000,
                'usage_limit' => 30,
                'used_count' => 8,
                'starts_at' => now()->subDays(15),
                'expires_at' => now()->addMonths(2),
                'is_active' => true,
                'created_by' => $admin?->id,
            ],
            [
                'code' => 'EXPIRED2025',
                'name' => 'Mã giảm giá năm cũ (Đã hết hạn)',
                'discount_type' => 'percent',
                'discount_value' => 15,
                'min_order_amount' => 100000,
                'usage_limit' => 50,
                'used_count' => 50,
                'starts_at' => now()->subMonths(6),
                'expires_at' => now()->subMonth(),
                'is_active' => false,
                'created_by' => $admin?->id,
            ],
        ];

        foreach ($coupons as $c) {
            Coupon::updateOrCreate(['code' => $c['code']], $c);
        }
    }
}
