<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Barber;
use App\Models\BarberLeave;
use App\Models\EmailCampaign;
use App\Models\Hairstyle;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EnhancementDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Link Hairstyle -> Recommended Combos
        $koreanCombo = Service::where('slug', 'combo-uon-idol-han-quoc')->first();
        $colorCombo = Service::where('slug', 'combo-nhuom-tay-khoi-fashion-king')->first();
        $royalCombo = Service::where('slug', 'combo-royal-grooming')->first();

        if ($koreanCombo) {
            Hairstyle::whereIn('slug', ['side-part-7-3-hien-dai', 'two-block-han-quoc-lang-tu'])
                ->update(['recommended_combo_id' => $koreanCombo->id]);
        }

        if ($colorCombo) {
            Hairstyle::whereIn('slug', ['modern-mullet-fade-ca-tinh', 'textured-crop-tre-trung'])
                ->update(['recommended_combo_id' => $colorCombo->id]);
        }

        if ($royalCombo) {
            Hairstyle::whereIn('slug', ['classic-pompadour-quy-toc', 'ivy-league-chuan-hoc-vien'])
                ->update(['recommended_combo_id' => $royalCombo->id]);
        }

        // 2. Demo Barber Leaves
        $barbers = Barber::all();
        if ($barbers->count() >= 2) {
            BarberLeave::updateOrCreate(
                ['barber_id' => $barbers[0]->id, 'leave_date' => Carbon::today()->addDays(2)->format('Y-m-d')],
                ['reason' => 'Nghỉ phép việc gia đình', 'status' => 'approved']
            );

            BarberLeave::updateOrCreate(
                ['barber_id' => $barbers[1]->id, 'leave_date' => Carbon::today()->addDays(5)->format('Y-m-d')],
                ['reason' => 'Tham gia khoá đào tạo Master Barber', 'status' => 'approved']
            );
        }

        // 3. Demo Hair notes for Appointments
        $completedApts = Appointment::where('status', 'completed')->get();
        $notes = [
            'Khách tóc dày rễ tre, yêu cầu skin fade cữ 1.5mm cạo sát, phần mái tỉa texture vuốt sáp clay mờ.',
            'Tóc uốn phồng chân Hàn Quốc trục 16, tóc con nhiều, sấy chiều thuận giữ nếp tự nhiên.',
            'Khách da đầu nhạy cảm, dùng nước ấm vừa phải, tỉa cạo viền kéo tỉa mỏng nhẹ phần đỉnh.',
        ];

        foreach ($completedApts as $idx => $apt) {
            $apt->update([
                'hair_notes' => $notes[$idx % count($notes)],
                'result_photos' => ['/images/hairstyles/sidepart_result_demo.jpg'],
            ]);
        }

        // 4. Demo Email Marketing Campaigns
        $campaigns = [
            [
                'title' => 'Chăm sóc khách hàng: Tóc bạn đã dài lại chưa?',
                'subject' => '✂️ Đã 30 ngày rồi, bạn đã sẵn sàng làm mới lại mái tóc cùng BarberAI?',
                'target_audience' => 'inactive_30d',
                'coupon_code' => 'WELCOME10',
                'content' => 'Chào bạn, đã gần 1 tháng kể từ lần cuối bạn ghé BarberAI Lounge. Một mái tóc chuẩn phom luôn giúp bạn tự tin trong công việc. Chúng tôi gửi tặng bạn mã giảm giá 10% cho lần hẹn tuần này!',
                'status' => 'sent',
                'sent_count' => 84,
                'sent_at' => Carbon::now()->subDays(3),
            ],
            [
                'title' => 'Mừng Sinh Nhật Thành Viên Tháng '.date('m'),
                'subject' => '🎂 BarberAI Lounge chúc mừng sinh nhật - Tặng bạn Voucher 100K!',
                'target_audience' => 'birthday_month',
                'coupon_code' => 'SINHNHAT100K',
                'content' => 'Chúc bạn một tuổi mới nhiều thành công và luôn giữ phong độ đỉnh cao! Món quà sinh nhật đặc biệt dành riêng cho bạn: Voucher 100.000đ áp dụng cho mọi gói dịch vụ tại salon.',
                'status' => 'draft',
                'sent_count' => 0,
            ],
            [
                'title' => 'Ra Mắt Combo Uốn Idol Hàn Quốc Chuẩn Form',
                'subject' => '🔥 Trải nghiệm Combo Uốn Phồng Side Part chỉ 299K (Giá gốc 380K)',
                'target_audience' => 'all',
                'coupon_code' => 'UONHOT20',
                'content' => 'Tự tin sở hữu mái tóc bồng bềnh chuẩn sao Hàn Quốc với công nghệ uốn lạnh Down Perm không hại da đầu, giữ nếp 3 tháng không cần sấy cầu kỳ.',
                'status' => 'sent',
                'sent_count' => 250,
                'sent_at' => Carbon::now()->subDays(7),
            ],
        ];

        foreach ($campaigns as $camp) {
            EmailCampaign::updateOrCreate(['title' => $camp['title']], $camp);
        }
    }
}
