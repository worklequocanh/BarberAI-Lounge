<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test admin dashboard route returns HTTP 200 and key UI components.
     */
    public function test_admin_dashboard_renders_successfully(): void
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('BarberAI');
        $response->assertSee('Doanh Thu Hôm Nay');
        $response->assertSee('Lịch Hẹn Hôm Nay');
        $response->assertSee('Thợ Hoạt Động');
        $response->assertSee('Lượt Tư Vấn AI');
        $response->assertSee('Lịch Hẹn Cắt Tóc Gần Nhất');
        $response->assertSee('Thợ Cắt Tóc Tiêu Biểu');
    }
}
