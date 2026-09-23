<?php

namespace Tests\Feature;

use App\Models\AiConversation;
use App\Models\AiMessage;
use App\Models\AiRecommendation;
use App\Models\AiUsageLog;
use App\Models\Appointment;
use App\Models\AppointmentService;
use App\Models\AuditLog;
use App\Models\Banner;
use App\Models\Barber;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\DailyStatistic;
use App\Models\Hairstyle;
use App\Models\Media;
use App\Models\Notification;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Review;
use App\Models\Role;
use App\Models\Service;
use App\Models\StaffRole;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HaircutDatabaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test database seeding creates expected initial data.
     */
    public function test_database_seeder_populates_master_data(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseCount('roles', 3);
        $this->assertDatabaseHas('roles', ['slug' => 'admin']);
        $this->assertDatabaseHas('roles', ['slug' => 'customer']);
        $this->assertDatabaseHas('roles', ['slug' => 'barber']);

        $this->assertDatabaseCount('face_shapes', 6);
        $this->assertDatabaseHas('face_shapes', ['name' => 'Oval']);

        $this->assertDatabaseHas('settings', ['key_name' => 'app_name']);
        $this->assertDatabaseHas('users', ['email' => 'admin@barberai.com']);
        $this->assertDatabaseHas('barbers', ['experience_years' => 8]);
    }

    /**
     * Test user and barber relationships.
     */
    public function test_user_and_barber_relationships(): void
    {
        $this->seed(DatabaseSeeder::class);

        $barberUser = User::where('email', 'tuananh@barberai.com')->first();
        $this->assertNotNull($barberUser);
        $this->assertEquals(3, $barberUser->role_id);
        $this->assertEquals('barber', $barberUser->role->slug);

        $barber = $barberUser->barber;
        $this->assertNotNull($barber);
        $this->assertEquals($barberUser->id, $barber->user->id);
        $this->assertGreaterThan(0, $barber->schedules()->count());
    }

    /**
     * Test categories, services, hairstyles and many-to-many pivot.
     */
    public function test_services_and_hairstyles_relationship(): void
    {
        $this->seed(DatabaseSeeder::class);

        $category = Category::where('slug', 'cat-toc-nam')->first();
        $this->assertNotNull($category);
        $this->assertGreaterThan(0, $category->services()->count());

        $hairstyle = Hairstyle::where('slug', 'side-part-7-3-hien-dai')->first();
        $this->assertNotNull($hairstyle);
        $this->assertGreaterThan(0, $hairstyle->services()->count());
    }

    /**
     * Test booking appointment flow and review creation.
     */
    public function test_appointment_booking_and_review_flow(): void
    {
        $this->seed(DatabaseSeeder::class);

        $customer = User::where('email', 'customer1@barberai.com')->first();
        $barber = Barber::first();
        $service = Service::first();

        $appointment = Appointment::create([
            'code' => 'BK202609160001',
            'customer_id' => $customer->id,
            'barber_id' => $barber->id,
            'appointment_date' => '2026-09-20',
            'start_time' => '10:00:00',
            'end_time' => '10:30:00',
            'total_price' => $service->price,
            'status' => 'confirmed',
            'payment_method' => 'cash',
            'payment_status' => 'unpaid',
            'note' => 'Cắt ngắn gọn gàng',
        ]);

        AppointmentService::create([
            'appointment_id' => $appointment->id,
            'service_id' => $service->id,
            'quantity' => 1,
            'price' => $service->price,
        ]);

        $this->assertCount(1, $appointment->appointmentServices);
        $this->assertEquals($service->id, $appointment->services()->first()->id);

        // Add Review
        Review::create([
            'appointment_id' => $appointment->id,
            'customer_id' => $customer->id,
            'barber_id' => $barber->id,
            'rating' => 5,
            'comment' => 'Thợ cắt rất có tâm, tóc đẹp đúng ý!',
        ]);

        $this->assertEquals(5, $appointment->fresh()->review->rating);
    }

    /**
     * Test AI conversations, messages and recommendation flow.
     */
    public function test_ai_flow_and_logs(): void
    {
        $this->seed(DatabaseSeeder::class);

        $customer = User::where('email', 'customer1@barberai.com')->first();

        $conversation = AiConversation::create([
            'user_id' => $customer->id,
            'session_id' => 'sess_test_123456',
            'title' => 'Tư vấn kiểu tóc cho mặt tròn',
            'status' => 'active',
        ]);

        AiMessage::create([
            'conversation_id' => $conversation->id,
            'role' => 'user',
            'content' => 'Mặt tôi tròn hơi góc cạnh thì nên cắt kiểu gì?',
            'tokens_used' => 25,
            'ai_model' => 'gemini-1.5-flash',
        ]);

        $recommendation = AiRecommendation::create([
            'conversation_id' => $conversation->id,
            'user_id' => $customer->id,
            'detected_face_shape' => 'Round',
            'hair_type' => 'straight',
            'hairstyle_ids' => [1, 2],
            'services_ids' => [1],
            'ai_reason' => 'Kiểu tóc phồng vuốt lên giúp kéo dài gương mặt tròn.',
            'confidence_score' => 0.92,
        ]);

        AiUsageLog::create([
            'user_id' => $customer->id,
            'ip_address' => '127.0.0.1',
            'provider' => 'gemini',
            'request_type' => 'text',
            'tokens_used' => 150,
            'status' => 'success',
        ]);

        $notification = Notification::create([
            'user_id' => $customer->id,
            'type' => 'ai_recommendation_ready',
            'title' => 'Gợi ý kiểu tóc AI đã sẵn sàng',
            'content' => 'AI vừa đề xuất 2 kiểu tóc phù hợp với khuôn mặt của bạn.',
            'data' => ['recommendation_id' => $recommendation->id],
            'is_read' => false,
        ]);

        $this->assertCount(1, $conversation->messages);
        $this->assertCount(1, $conversation->recommendations);
        $this->assertEquals(0.92, (float) $recommendation->confidence_score);
        $this->assertFalse($notification->is_read);
    }

    /**
     * Test Admin Dashboard: RBAC permissions and audit logs.
     */
    public function test_admin_rbac_and_audit_logs(): void
    {
        $this->seed(DatabaseSeeder::class);

        $adminRole = Role::where('slug', 'admin')->first();
        $this->assertNotNull($adminRole);
        $this->assertGreaterThan(10, $adminRole->permissions()->count());

        $adminUser = User::where('email', 'admin@barberai.com')->first();
        $this->assertNotNull($adminUser);

        // Record Audit Log
        $log = AuditLog::create([
            'user_id' => $adminUser->id,
            'action' => 'update',
            'model_type' => Service::class,
            'model_id' => 1,
            'old_values' => ['price' => 80000],
            'new_values' => ['price' => 90000],
            'ip_address' => '127.0.0.1',
            'user_agent' => 'PHPUnit Test Agent',
        ]);

        $this->assertDatabaseHas('audit_logs', ['id' => $log->id, 'action' => 'update']);
        $this->assertEquals(90000, $log->new_values['price']);

        // Staff Role
        $staffRole = StaffRole::create([
            'name' => 'Lễ tân (Receptionist)',
            'permissions' => ['appointment.view', 'appointment.create'],
        ]);
        $this->assertDatabaseHas('staff_roles', ['id' => $staffRole->id]);
    }

    /**
     * Test Admin Dashboard: Marketing, Banners, Coupons and Usage.
     */
    public function test_admin_marketing_and_coupons(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertGreaterThan(0, Banner::where('is_active', true)->count());

        $coupon = Coupon::where('code', 'WELCOME10')->first();
        $this->assertNotNull($coupon);
        $this->assertEquals('percent', $coupon->type);

        $customer = User::where('email', 'customer1@barberai.com')->first();
        $barber = Barber::first();
        $service = Service::first();

        $appointment = Appointment::create([
            'code' => 'BK202609160002',
            'customer_id' => $customer->id,
            'barber_id' => $barber->id,
            'appointment_date' => '2026-09-22',
            'start_time' => '14:00:00',
            'end_time' => '14:30:00',
            'total_price' => 72000,
            'status' => 'pending',
            'payment_method' => 'cash',
            'payment_status' => 'unpaid',
        ]);

        $usage = CouponUsage::create([
            'coupon_id' => $coupon->id,
            'user_id' => $customer->id,
            'appointment_id' => $appointment->id,
            'discount_amount' => 8000,
        ]);

        $this->assertNotNull($appointment->couponUsage);
        $this->assertEquals(8000, (float) $appointment->couponUsage->discount_amount);
    }

    /**
     * Test Admin Dashboard: Blog, Contact Messages, Daily Statistics, Media.
     */
    public function test_admin_content_stats_and_media(): void
    {
        $this->seed(DatabaseSeeder::class);

        // Blog
        $this->assertGreaterThan(0, PostCategory::count());
        $this->assertGreaterThan(0, Post::where('status', 'published')->count());

        $admin = User::where('email', 'admin@barberai.com')->first();

        // Contact Message
        $contact = ContactMessage::create([
            'name' => 'Trần Văn Hùng',
            'email' => 'hung@example.com',
            'phone' => '0912345678',
            'subject' => 'Hỏi về combo uốn tóc',
            'message' => 'Tóc ngắn 5cm có uốn side part được không?',
            'status' => 'new',
        ]);
        $this->assertDatabaseHas('contact_messages', ['id' => $contact->id]);

        // Daily Statistics (Dashboard chart)
        $this->assertEquals(14, DailyStatistic::count());
        $totalRevenue = DailyStatistic::sum('revenue');
        $this->assertGreaterThan(0, $totalRevenue);

        // Media Library
        $media = Media::create([
            'user_id' => $admin->id,
            'filename' => 'hairstyle_sidepart.jpg',
            'original_name' => 'sidepart_photo.jpg',
            'mime_type' => 'image/jpeg',
            'size' => 204850,
            'path' => 'uploads/hairstyles/hairstyle_sidepart.jpg',
            'disk' => 'local',
            'folder' => 'hairstyles',
        ]);
        $this->assertDatabaseHas('media', ['id' => $media->id]);
    }

    /**
     * Test soft deletes on service, hairstyle, barber, coupon.
     */
    public function test_soft_deletes_and_restoration(): void
    {
        $this->seed(DatabaseSeeder::class);

        $service = Service::first();
        $serviceId = $service->id;
        $service->delete();

        $this->assertSoftDeleted('services', ['id' => $serviceId]);
        $this->assertNull(Service::find($serviceId));
        $this->assertNotNull(Service::withTrashed()->find($serviceId));

        $service->restore();
        $this->assertNotNull(Service::find($serviceId));

        $barber = Barber::first();
        $barberId = $barber->id;
        $barber->delete();
        $this->assertSoftDeleted('barbers', ['id' => $barberId]);

        $hairstyle = Hairstyle::first();
        $hairstyleId = $hairstyle->id;
        $hairstyle->delete();
        $this->assertSoftDeleted('hairstyles', ['id' => $hairstyleId]);

        $coupon = Coupon::first();
        $couponId = $coupon->id;
        $coupon->delete();
        $this->assertSoftDeleted('coupons', ['id' => $couponId]);
    }

    /**
     * Test AI recommendations feedback and conversation index.
     */
    public function test_ai_recommendation_feedback_and_slot_key(): void
    {
        $this->seed(DatabaseSeeder::class);

        $customer = User::where('email', 'customer1@barberai.com')->first();
        $conversation = AiConversation::create([
            'user_id' => $customer->id,
            'title' => 'Tư vấn tóc mùa hè',
            'status' => 'active',
        ]);

        $recommendation = AiRecommendation::create([
            'conversation_id' => $conversation->id,
            'user_id' => $customer->id,
            'detected_face_shape' => 'Oval',
            'hairstyle_ids' => [1, 2],
            'confidence_score' => 0.95,
            'feedback_rating' => 5,
            'feedback_note' => 'Gợi ý kiểu Side Part rất hợp với khuôn mặt!',
        ]);

        $this->assertDatabaseHas('ai_recommendations', [
            'id' => $recommendation->id,
            'feedback_rating' => 5,
            'feedback_note' => 'Gợi ý kiểu Side Part rất hợp với khuôn mặt!',
        ]);

        $barber = Barber::first();
        $appointment = Appointment::create([
            'code' => 'BK_TEST_SLOT_01',
            'customer_id' => $customer->id,
            'barber_id' => $barber->id,
            'appointment_date' => '2026-09-30',
            'start_time' => '11:00:00',
            'end_time' => '11:30:00',
            'slot_key' => "{$barber->id}_2026-09-30_11:00:00",
            'total_price' => 100000,
            'status' => 'confirmed',
        ]);

        $this->assertDatabaseHas('appointments', [
            'slot_key' => "{$barber->id}_2026-09-30_11:00:00",
        ]);
    }
}
