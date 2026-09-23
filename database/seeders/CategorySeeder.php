<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Cắt tóc nam', 'slug' => 'cat-toc-nam', 'icon' => 'fa-scissors', 'sort' => 1],
            ['name' => 'Gội đầu dưỡng sinh', 'slug' => 'goi-dau-duong-sinh', 'icon' => 'fa-shower', 'sort' => 2],
            ['name' => 'Uốn tóc tạo kiểu', 'slug' => 'uon-toc-tao-kieu', 'icon' => 'fa-wind', 'sort' => 3],
            ['name' => 'Nhuộm tóc thời trang', 'slug' => 'nhuom-toc-thoi-trang', 'icon' => 'fa-palette', 'sort' => 4],
            ['name' => 'Combo Chăm sóc VIP', 'slug' => 'combo-cham-soc-vip', 'icon' => 'fa-crown', 'sort' => 5],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
