<?php

namespace Tests\Feature;

use App\Models\Barber;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Hairstyle;
use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManagementCRUDTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * Test adding a new Appointment (Create view & Store).
     */
    public function test_can_render_create_and_store_new_appointment(): void
    {
        $response = $this->get(route('admin.appointments.create'));
        $response->assertStatus(200);
        $response->assertSee('Tạo Lịch Đặt Chỗ');

        $barber = Barber::first();
        $service = Service::first();

        $storeResponse = $this->post(route('admin.appointments.store'), [
            'customer_name' => 'Khách Test Mới',
            'customer_phone' => '0999888777',
            'barber_id' => $barber->id,
            'appointment_date' => date('Y-m-d'),
            'start_time' => '15:00:00',
            'service_ids' => [$service->id],
            'note' => 'Ghi chú kiểm tra thêm mới lịch hẹn',
        ]);

        $storeResponse->assertRedirect(route('admin.appointments.index'));
        $storeResponse->assertSessionHas('success');

        $this->assertDatabaseHas('appointments', [
            'barber_id' => $barber->id,
            'start_time' => '15:00:00',
        ]);
        $this->assertDatabaseHas('users', [
            'phone' => '0999888777',
            'name' => 'Khách Test Mới',
        ]);
    }

    /**
     * Test adding a new Barber (Create view & Store).
     */
    public function test_can_render_create_and_store_new_barber(): void
    {
        $response = $this->get(route('admin.barbers.create'));
        $response->assertStatus(200);
        $response->assertSee('Thêm Stylist & Barber Mới');

        $storeResponse = $this->post(route('admin.barbers.store'), [
            'name' => 'Stylist Vũ Đăng Khoa',
            'phone' => '0911223344',
            'email' => 'khoa.barber@barberai.com',
            'experience_years' => 6,
            'bio' => 'Chuyên gia uốn Textured perm và cắt mullet.',
            'is_available' => '1',
        ]);

        $storeResponse->assertRedirect(route('admin.barbers.index'));
        $storeResponse->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'email' => 'khoa.barber@barberai.com',
            'name' => 'Stylist Vũ Đăng Khoa',
        ]);

        $user = User::where('email', 'khoa.barber@barberai.com')->first();
        $this->assertNotNull($user->barber);
        $this->assertEquals(6, $user->barber->experience_years);
        $this->assertGreaterThan(0, $user->barber->schedules()->count());
    }

    /**
     * Test adding a new Service (Create view & Store).
     */
    public function test_can_render_create_and_store_new_service(): void
    {
        $response = $this->get(route('admin.services.create'));
        $response->assertStatus(200);
        $response->assertSee('Thêm Dịch Vụ Salon');

        $category = Category::first();

        $storeResponse = $this->post(route('admin.services.store'), [
            'name' => 'Dịch Vụ Nhuộm Tẩy Màu Khói VIP',
            'category_id' => $category?->id,
            'price' => 350000,
            'duration_min' => 60,
            'description' => 'Tẩy nâng tông chuẩn và nhuộm phủ bóng nano.',
            'is_active' => '1',
        ]);

        $storeResponse->assertRedirect(route('admin.services.index'));
        $storeResponse->assertSessionHas('success');

        $this->assertDatabaseHas('services', [
            'name' => 'Dịch Vụ Nhuộm Tẩy Màu Khói VIP',
            'price' => 350000,
        ]);
    }

    /**
     * Test adding a new Hairstyle (Create view & Store).
     */
    public function test_can_render_create_and_store_new_hairstyle(): void
    {
        $response = $this->get(route('admin.hairstyles.create'));
        $response->assertStatus(200);
        $response->assertSee('Thêm Kiểu Tóc Mới');

        $storeResponse = $this->post(route('admin.hairstyles.store'), [
            'name' => 'Kiểu Tóc Caesar Cut Trẻ Trung',
            'difficulty' => 2,
            'face_shape_ids' => [1, 2],
            'tags' => 'caesar, trending, short',
            'description' => 'Mẫu tóc ngắn gọn gàng thích hợp sinh viên, học sinh.',
            'is_active' => '1',
        ]);

        $storeResponse->assertRedirect(route('admin.hairstyles.index'));
        $storeResponse->assertSessionHas('success');

        $this->assertDatabaseHas('hairstyles', [
            'name' => 'Kiểu Tóc Caesar Cut Trẻ Trung',
            'difficulty' => 2,
        ]);
    }

    /**
     * Test adding a new Coupon (Create view & Store).
     */
    public function test_can_render_create_and_store_new_coupon(): void
    {
        $response = $this->get(route('admin.coupons.create'));
        $response->assertStatus(200);
        $response->assertSee('Tạo Voucher Khuyến Mãi');

        $storeResponse = $this->post(route('admin.coupons.store'), [
            'code' => 'TET2026',
            'discount_type' => 'percent',
            'discount_value' => 25,
            'min_order_amount' => 120000,
            'usage_limit' => 50,
            'starts_at' => date('Y-m-d'),
            'expires_at' => date('Y-m-d', strtotime('+30 days')),
            'is_active' => '1',
        ]);

        $storeResponse->assertRedirect(route('admin.coupons.index'));
        $storeResponse->assertSessionHas('success');

        $this->assertDatabaseHas('coupons', [
            'code' => 'TET2026',
            'discount_type' => 'percent',
            'discount_value' => 25,
        ]);
    }

    /**
     * Test adding a new User (Create view & Store).
     */
    public function test_can_render_create_and_store_new_user(): void
    {
        $response = $this->get(route('admin.users.create'));
        $response->assertStatus(200);
        $response->assertSee('Thêm Người Dùng Mới');

        $customerRole = Role::where('slug', 'customer')->first();

        $storeResponse = $this->post(route('admin.users.store'), [
            'name' => 'Phạm Hoàng Nam',
            'email' => 'nam.pham@example.com',
            'phone' => '0933445566',
            'password' => 'password123',
            'role_id' => $customerRole?->id,
            'gender' => 'male',
            'is_active' => '1',
        ]);

        $storeResponse->assertRedirect(route('admin.users.index'));
        $storeResponse->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'email' => 'nam.pham@example.com',
            'name' => 'Phạm Hoàng Nam',
            'role_id' => $customerRole?->id,
        ]);
    }
}
