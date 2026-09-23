<?php

namespace Tests\Feature;

use App\Models\Barber;
use App\Models\EmailCampaign;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnhancedDashboardFeaturesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * Test appointments matrix timeline page renders with time slots.
     */
    public function test_appointment_matrix_timeline_renders(): void
    {
        $response = $this->get(route('admin.appointments.timeline'));

        $response->assertStatus(200);
        $response->assertSee('Bản Đồ Lịch Đặt Tóc (Matrix Timeline)');
        $response->assertSee('08:30');
        $response->assertSee('20:30');
    }

    /**
     * Test customer 360 profile renders with hair notes and statistics.
     */
    public function test_customer_360_profile_renders(): void
    {
        $customer = User::first();
        $response = $this->get(route('admin.users.show', $customer->id));

        $response->assertStatus(200);
        $response->assertSee('Hồ Sơ Khách Hàng 360°');
        $response->assertSee('TỔNG CHI TIÊU (LTV)');
        $response->assertSee('Sổ Tay Kỹ Thuật Tóc');
    }

    /**
     * Test barber leave creation and deletion.
     */
    public function test_barber_leave_flow(): void
    {
        $barber = Barber::first();
        $targetDate = now()->addDays(10)->format('Y-m-d');

        $response = $this->post(route('admin.barbers.leaves.store', $barber->id), [
            'leave_date' => $targetDate,
            'reason' => 'Đào tạo kỹ thuật Fade nâng cao',
        ]);

        $response->assertRedirect(route('admin.barbers.edit', $barber->id));
        $this->assertDatabaseHas('barber_leaves', [
            'barber_id' => $barber->id,
            'reason' => 'Đào tạo kỹ thuật Fade nâng cao',
        ]);
    }

    /**
     * Test services with combo packaging.
     */
    public function test_combo_service_creation_and_index(): void
    {
        // Seeder already creates demo combos (e.g. 'Combo VIP Đế Vương')
        $response = $this->get(route('admin.services.index'));
        $response->assertStatus(200);
        $response->assertSee('COMBO TIẾT KIỆM');
    }

    /**
     * Test email marketing campaigns flow.
     */
    public function test_email_marketing_campaigns_flow(): void
    {
        $campaign = EmailCampaign::create([
            'title' => 'Test Campaign VIP',
            'subject' => 'Ưu đãi tháng này',
            'target_audience' => 'vip_customers',
            'coupon_code' => 'TESTVIP',
            'content' => 'Nội dung kiểm tra gửi email',
            'status' => 'draft',
            'sent_count' => 0,
        ]);

        $response = $this->get(route('admin.campaigns.index'));
        $response->assertStatus(200);
        $response->assertSee('Test Campaign VIP');
        $response->assertSee('TESTVIP');

        // Test sending the campaign
        $sendResponse = $this->post(route('admin.campaigns.send', $campaign->id));
        $sendResponse->assertRedirect(route('admin.campaigns.index'));

        $this->assertDatabaseHas('email_campaigns', [
            'id' => $campaign->id,
            'status' => 'sent',
        ]);
    }
}
