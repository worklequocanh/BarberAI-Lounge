<?php

namespace Database\Seeders;

use App\Models\FaceShape;
use Illuminate\Database\Seeder;

class FaceShapeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shapes = [
            ['name' => 'Oval', 'description' => 'Khuôn mặt trái xoan cân đối, phù hợp với hầu hết mọi kiểu tóc nam.', 'image' => null],
            ['name' => 'Round', 'description' => 'Khuôn mặt tròn có chiều dài và rộng tương đương, hợp với kiểu undercut, pompadour vuốt cao.', 'image' => null],
            ['name' => 'Square', 'description' => 'Khuôn mặt vuông góc cạnh nam tính, hợp kiểu fade ngắn hoặc slick back cổ điển.', 'image' => null],
            ['name' => 'Diamond', 'description' => 'Khuôn mặt kim cương với gò má rộng, cằm nhọn, hợp kiểu side part hoặc tóc tỉa layer.', 'image' => null],
            ['name' => 'Heart', 'description' => 'Khuôn mặt trái tim trán rộng cằm thon, hợp kiểu tóc textured crop hoặc uốn xoăn nhẹ.', 'image' => null],
            ['name' => 'Triangle', 'description' => 'Khuôn mặt tam giác có quai hàm rộng hơn trán, hợp các kiểu tóc phồng dày ở phần đỉnh.', 'image' => null],
        ];

        foreach ($shapes as $shape) {
            FaceShape::updateOrCreate(['name' => $shape['name']], $shape);
        }
    }
}
