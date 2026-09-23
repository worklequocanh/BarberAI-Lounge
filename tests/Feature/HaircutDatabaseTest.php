<?php

namespace Tests\Feature;

use App\Models\AiConversation;
use App\Models\AiMessage;
use App\Models\AiRecommendation;
use App\Models\Appointment;
use App\Models\AppointmentService;
use App\Models\Barber;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Hairstyle;
use App\Models\Review;
use App\Models\Service;
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
    public function test_ai_flow_and_conversations(): void
    {
        $this->seed(DatabaseSeeder::class);

        $customer = User::where('email', 'customer1@barberai.com')->first();

        $conversation = AiConversation::create([
            'user_id' => $customer->id,
            'session_id' => 'sess_test_123456',
            'title' => 'Tư vấn kiểu tóc cho mặt tròn',
            'status' => 'active',
        ]);

        $msg = AiMessage::create([
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

        $this->assertCount(1, $conversation->messages);
        $this->assertCount(1, $conversation->recommendations);
        $this->assertEquals(0.92, (float) $recommendation->confidence_score);
    }

    /**
     * Test coupons creation and query.
     */
    public function test_coupons_configuration(): void
    {
        $this->seed(DatabaseSeeder::class);

        $coupon = Coupon::where('code', 'WELCOME10')->first();
        $this->assertNotNull($coupon);
        $this->assertEquals('percent', $coupon->discount_type);
        $this->assertEquals(10, (int) $coupon->discount_value);
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
}
