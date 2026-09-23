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
                'type' => 'percent',
                'value' => 10,
                'min_order' => 80000,
                'max_discount' => 30000,
                'quantity' => 200,
                'used_count' => 18,
                'start_date' => now()->subDays(10),
                'end_date' => now()->addMonths(6),
                'is_active' => true,
                'created_by' => $admin?->id,
            ],
            [
                'code' => 'VIP50K',
                'name' => 'Giảm ngay 50.000đ cho gói Combo VIP',
                'type' => 'fixed',
                'value' => 50000,
                'min_order' => 150000,
                'max_discount' => 50000,
                'quantity' => 100,
                'used_count' => 35,
                'start_date' => now()->subDays(10),
                'end_date' => now()->addMonths(3),
                'is_active' => true,
                'created_by' => $admin?->id,
            ],
            [
                'code' => 'UONHOT20',
                'name' => 'Ưu đãi 20% cho gói dịch vụ Uốn Hàn Quốc',
                'type' => 'percent',
                'value' => 20,
                'min_order' => 250000,
                'max_discount' => 80000,
                'quantity' => 50,
                'used_count' => 12,
                'start_date' => now()->subDays(5),
                'end_date' => now()->addMonth(),
                'is_active' => true,
                'created_by' => $admin?->id,
            ],
            [
                'code' => 'SINHNHAT100K',
                'name' => 'Quà tặng sinh nhật thành viên Salon',
                'type' => 'fixed',
                'value' => 100000,
                'min_order' => 300000,
                'max_discount' => 100000,
                'quantity' => 30,
                'used_count' => 8,
                'start_date' => now()->subDays(15),
                'end_date' => now()->addMonths(2),
                'is_active' => true,
                'created_by' => $admin?->id,
            ],
            [
                'code' => 'EXPIRED2025',
                'name' => 'Mã giảm giá năm cũ (Đã hết hạn)',
                'type' => 'percent',
                'value' => 15,
                'min_order' => 100000,
                'max_discount' => 50000,
                'quantity' => 50,
                'used_count' => 50,
                'start_date' => now()->subMonths(6),
                'end_date' => now()->subMonth(),
                'is_active' => false,
                'created_by' => $admin?->id,
            ],
        ];

        foreach ($coupons as $c) {
            Coupon::updateOrCreate(['code' => $c['code']], $c);
        }
    }
}
