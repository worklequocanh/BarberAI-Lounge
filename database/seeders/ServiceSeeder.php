<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catCut = Category::where('slug', 'cat-toc-nam')->first();
        $catWash = Category::where('slug', 'goi-dau-duong-sinh')->first();
        $catPerm = Category::where('slug', 'uon-toc-tao-kieu')->first();
        $catColor = Category::where('slug', 'nhuom-toc-thoi-trang')->first();
        $catCombo = Category::where('slug', 'combo-cham-soc-vip')->first();

        $services = [
            [
                'category_id' => $catCut?->id,
                'name' => 'Cắt tóc nam tiêu chuẩn (Standard Cut)',
                'slug' => 'cat-toc-nam-tieu-chuan',
                'description' => 'Tư vấn kiểu tóc phù hợp, cắt và sấy tạo kiểu chuyên nghiệp.',
                'price' => 80000,
                'duration_min' => 30,
                'is_active' => true,
            ],
            [
                'category_id' => $catCut?->id,
                'name' => 'Cắt tạo kiểu Fade nghệ thuật (Skin Fade)',
                'slug' => 'cat-tao-kieu-fade-nghe-thuat',
                'description' => 'Kỹ thuật fade mờ đỉnh cao, cạo viền sắc nét, cạo mặt êm ái.',
                'price' => 120000,
                'duration_min' => 45,
                'is_active' => true,
            ],
            [
                'category_id' => $catCut?->id,
                'name' => 'Tỉa râu & Chăm sóc râu quai nón chuyên nghiệp',
                'slug' => 'tia-rau-cham-soc-rau',
                'description' => 'Định hình form râu, cạo khăn nóng, dưỡng dầu râu nam tính.',
                'price' => 90000,
                'duration_min' => 25,
                'is_active' => true,
            ],
            [
                'category_id' => $catWash?->id,
                'name' => 'Gội đầu dưỡng sinh & Massage bấm huyệt',
                'slug' => 'goi-dau-duong-sinh-massage',
                'description' => 'Gội thảo dược, massage thư giãn vùng đầu cổ vai gáy giải tỏa căng thẳng.',
                'price' => 70000,
                'duration_min' => 30,
                'is_active' => true,
            ],
            [
                'category_id' => $catWash?->id,
                'name' => 'Tẩy tế bào chết da đầu & Thải độc Nano',
                'slug' => 'tay-te-bao-chet-da-dau',
                'description' => 'Làm sạch sâu bã nhờn, trị gàu, kích thích mọc tóc tự nhiên.',
                'price' => 110000,
                'duration_min' => 35,
                'is_active' => true,
            ],
            [
                'category_id' => $catPerm?->id,
                'name' => 'Uốn phồng chân tóc kiểu Hàn Quốc (Root Perm)',
                'slug' => 'uon-phong-chan-toc-han-quoc',
                'description' => 'Giúp tóc bồng bềnh tự nhiên, giải quyết tình trạng tóc xẹp dính da đầu.',
                'price' => 250000,
                'duration_min' => 60,
                'is_active' => true,
            ],
            [
                'category_id' => $catPerm?->id,
                'name' => 'Uốn xoăn Textured / Sóng lơi lãng tử',
                'slug' => 'uon-xoan-textured',
                'description' => 'Tạo độ lượn sóng tự nhiên, giữ nếp lâu mà không bị khô rối.',
                'price' => 300000,
                'duration_min' => 75,
                'is_active' => true,
            ],
            [
                'category_id' => $catColor?->id,
                'name' => 'Nhuộm màu thời trang nam cao cấp',
                'slug' => 'nhuom-mau-thoi-trang-nam',
                'description' => 'Nhuộm nâu hạt dẻ, xám khói, xanh đen... Thuốc nhuộm hữu cơ bảo vệ da đầu.',
                'price' => 280000,
                'duration_min' => 60,
                'is_active' => true,
            ],
            [
                'category_id' => $catColor?->id,
                'name' => 'Tẩy tóc bạch kim / Khói sáng công nghệ Olaplex',
                'slug' => 'tay-toc-bach-kim-olaplex',
                'description' => 'Tẩy chuẩn tone level 9-10, bổ sung dưỡng chất Olaplex chống đứt gãy tóc.',
                'price' => 450000,
                'duration_min' => 90,
                'is_active' => true,
            ],
            [
                'category_id' => $catCombo?->id,
                'name' => 'Combo VIP 7 bước Barber King',
                'slug' => 'combo-vip-7-buoc-barber-king',
                'description' => 'Cắt + Gội thảo dược + Cạo mặt êm + Đắp khăn nóng + Rửa mặt bọt tuyết + Vuốt sáp xịt gôm.',
                'price' => 150000,
                'duration_min' => 50,
                'is_active' => true,
            ],
            [
                'category_id' => $catCombo?->id,
                'name' => 'Combo Royal Grooming (Trọn gói Quý Tộc)',
                'slug' => 'combo-royal-grooming',
                'description' => 'Full Combo Cắt Fade + Uốn phồng + Gội dưỡng sinh bấm huyệt 15 phút.',
                'price' => 420000,
                'duration_min' => 100,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], $service);
        }
    }
}
