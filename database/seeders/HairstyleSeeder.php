<?php

namespace Database\Seeders;

use App\Models\FaceShape;
use App\Models\Hairstyle;
use App\Models\Service;
use Illuminate\Database\Seeder;

class HairstyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $oval = FaceShape::where('name', 'Oval')->first()?->id;
        $square = FaceShape::where('name', 'Square')->first()?->id;
        $round = FaceShape::where('name', 'Round')->first()?->id;
        $heart = FaceShape::where('name', 'Heart')->first()?->id;
        $diamond = FaceShape::where('name', 'Diamond')->first()?->id;
        $triangle = FaceShape::where('name', 'Triangle')->first()?->id;

        $hairstyles = [
            [
                'name' => 'Side Part 7/3 Hiện Đại',
                'slug' => 'side-part-7-3-hien-dai',
                'description' => 'Kiểu tóc rẽ ngôi lịch lãm, dễ phối đồ công sở, dự tiệc và tôn đường nét khuôn mặt.',
                'difficulty' => 2,
                'face_shape_ids' => array_values(array_filter([$oval, $square, $round])),
                'hair_types' => ['straight', 'wavy'],
                'tags' => ['trending', 'gentleman', 'office'],
                'views' => 450,
                'is_active' => true,
            ],
            [
                'name' => 'Textured Crop Trẻ Trung',
                'slug' => 'textured-crop-tre-trung',
                'description' => 'Mái ngố ngắn tỉa tầng textured, phong cách thể thao năng động, cực kỳ mát mẻ.',
                'difficulty' => 1,
                'face_shape_ids' => array_values(array_filter([$oval, $heart, $diamond])),
                'hair_types' => ['straight', 'curly'],
                'tags' => ['short', 'sport', 'youth'],
                'views' => 380,
                'is_active' => true,
            ],
            [
                'name' => 'Classic Pompadour Quý Tộc',
                'slug' => 'classic-pompadour-quy-toc',
                'description' => 'Kiểu tóc vuốt ngược phồng phần mái, tạo vẻ ngoài cuốn hút và phong độ đỉnh cao.',
                'difficulty' => 4,
                'face_shape_ids' => array_values(array_filter([$oval, $round, $square])),
                'hair_types' => ['straight', 'wavy'],
                'tags' => ['classic', 'vintage', 'pomade'],
                'views' => 290,
                'is_active' => true,
            ],
            [
                'name' => 'Ivy League Chuẩn Học Viện',
                'slug' => 'ivy-league-chuan-hoc-vien',
                'description' => 'Mẫu tóc quý tộc được giới trẻ săn đón, vuốt nhẹ phần mái tạo cảm giác thông minh, bảnh bao.',
                'difficulty' => 2,
                'face_shape_ids' => array_values(array_filter([$oval, $square, $diamond])),
                'hair_types' => ['straight'],
                'tags' => ['trending', 'ivyleague', 'hot'],
                'views' => 610,
                'is_active' => true,
            ],
            [
                'name' => 'Modern Mullet Fade Cá Tính',
                'slug' => 'modern-mullet-fade-ca-tinh',
                'description' => 'Đuôi tóc dài lãng tử kết hợp fade sát hai bên, phong cách nghệ thuật nổi bật.',
                'difficulty' => 3,
                'face_shape_ids' => array_values(array_filter([$oval, $triangle, $heart])),
                'hair_types' => ['straight', 'wavy'],
                'tags' => ['rock', 'art', 'streetwear'],
                'views' => 520,
                'is_active' => true,
            ],
            [
                'name' => 'Buzz Cut Fade Nam Tính',
                'slug' => 'buzz-cut-fade-nam-tinh',
                'description' => 'Kiểu tóc húi cua kết hợp skin fade sắc nét, góc cạnh, không tốn thời gian chăm sóc.',
                'difficulty' => 1,
                'face_shape_ids' => array_values(array_filter([$square, $diamond, $oval])),
                'hair_types' => ['straight', 'curly'],
                'tags' => ['military', 'minimal', 'easy'],
                'views' => 210,
                'is_active' => true,
            ],
            [
                'name' => 'Two Block Hàn Quốc Lãng Tử',
                'slug' => 'two-block-han-quoc-lang-tu',
                'description' => 'Cắt ngắn gọn gàng 2 bên và sau gáy, giữ phần mái dài bồng bềnh chuẩn idol Kpop.',
                'difficulty' => 3,
                'face_shape_ids' => array_values(array_filter([$round, $heart, $oval])),
                'hair_types' => ['wavy', 'straight'],
                'tags' => ['korean', 'idol', 'fluffy'],
                'views' => 840,
                'is_active' => true,
            ],
        ];

        $cutService = Service::where('slug', 'cat-toc-nam-tieu-chuan')->first();
        $fadeService = Service::where('slug', 'cat-tao-kieu-fade-nghe-thuat')->first();

        foreach ($hairstyles as $item) {
            $hair = Hairstyle::updateOrCreate(['slug' => $item['slug']], $item);
            if ($cutService && $fadeService) {
                $hair->services()->syncWithoutDetaching([$cutService->id, $fadeService->id]);
            }
        }
    }
}
