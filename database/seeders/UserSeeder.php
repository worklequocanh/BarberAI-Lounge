<?php

namespace Database\Seeders;

use App\Models\Barber;
use App\Models\BarberSchedule;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Admin
        User::updateOrCreate(
            ['email' => 'admin@barberai.com'],
            [
                'name' => 'Admin Quản Trị',
                'phone' => '0909000001',
                'password' => Hash::make('password123'),
                'gender' => 'male',
                'role_id' => 1,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // 2. Demo Customers (Tạo nhiều khách hàng để test danh sách và lịch hẹn)
        $customers = [
            ['name' => 'Nguyễn Văn Khách', 'phone' => '0909000002', 'email' => 'customer1@barberai.com', 'gender' => 'male'],
            ['name' => 'Trần Hoàng Long', 'phone' => '0912345678', 'email' => 'long.tran@gmail.com', 'gender' => 'male'],
            ['name' => 'Lê Minh Quân', 'phone' => '0988776655', 'email' => 'quan.le@gmail.com', 'gender' => 'male'],
            ['name' => 'Phạm Gia Bảo', 'phone' => '0933221100', 'email' => 'bao.pham@gmail.com', 'gender' => 'male'],
            ['name' => 'Đặng Quốc Huy', 'phone' => '0977665544', 'email' => 'huy.dang@gmail.com', 'gender' => 'male'],
            ['name' => 'Vũ Tuấn Kiệt', 'phone' => '0966554433', 'email' => 'kiet.vu@gmail.com', 'gender' => 'male'],
        ];

        foreach ($customers as $c) {
            User::updateOrCreate(
                ['phone' => $c['phone']],
                [
                    'name' => $c['name'],
                    'email' => $c['email'],
                    'password' => Hash::make('password123'),
                    'gender' => $c['gender'],
                    'role_id' => 2,
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );
        }

        // 3. Demo Barbers (Nhiều thợ với chuyên môn và danh hiệu khác nhau)
        $barbersData = [
            [
                'name' => 'Hoàng Tuấn Anh',
                'email' => 'tuananh@barberai.com',
                'phone' => '0909000003',
                'bio' => 'Master Barber với hơn 8 năm kinh nghiệm, bậc thầy Fade và Uốn phồng Hàn Quốc.',
                'experience_years' => 8,
                'specialties' => ['Skin Fade', 'Korean Perm', 'Mullet'],
                'rating_avg' => 4.95,
                'total_reviews' => 128,
            ],
            [
                'name' => 'Lê Thanh Tùng',
                'email' => 'thanhtung@barberai.com',
                'phone' => '0909000004',
                'bio' => 'Senior Stylist chuyên gia tạo mẫu Side Part công sở và Pompadour cổ điển.',
                'experience_years' => 5,
                'specialties' => ['Side Part', 'Pompadour', 'Classic Cut'],
                'rating_avg' => 4.85,
                'total_reviews' => 96,
            ],
            [
                'name' => 'Nguyễn Minh Hải',
                'email' => 'minhhai@barberai.com',
                'phone' => '0909000005',
                'bio' => 'Chuyên gia xử lý tóc tẩy nhuộm thời trang và uốn Texture cá tính.',
                'experience_years' => 4,
                'specialties' => ['Coloring', 'Texture Perm', 'Textured Crop'],
                'rating_avg' => 4.90,
                'total_reviews' => 84,
            ],
            [
                'name' => 'Trần Quang Vinh',
                'email' => 'quangvinh@barberai.com',
                'phone' => '0909000006',
                'bio' => 'Stylist trẻ tài năng, bắt trend nhanh các mẫu Ivy League, Buzz Cut.',
                'experience_years' => 3,
                'specialties' => ['Ivy League', 'Buzz Fade', 'Two Block'],
                'rating_avg' => 4.80,
                'total_reviews' => 62,
            ],
        ];

        foreach ($barbersData as $bData) {
            $user = User::updateOrCreate(
                ['email' => $bData['email']],
                [
                    'name' => $bData['name'],
                    'phone' => $bData['phone'],
                    'password' => Hash::make('barber123'),
                    'gender' => 'male',
                    'role_id' => 3,
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );

            $barber = Barber::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'bio' => $bData['bio'],
                    'experience_years' => $bData['experience_years'],
                    'specialties' => $bData['specialties'],
                    'rating_avg' => $bData['rating_avg'],
                    'total_reviews' => $bData['total_reviews'],
                    'is_available' => true,
                ]
            );

            // Schedule for Barber
            for ($day = 1; $day <= 6; $day++) {
                BarberSchedule::updateOrCreate(
                    ['barber_id' => $barber->id, 'day_of_week' => $day],
                    [
                        'start_time' => '08:30:00',
                        'end_time' => '20:30:00',
                        'is_working' => true,
                    ]
                );
            }
        }
    }
}
