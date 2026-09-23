<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Barber;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = User::where('role_id', 2)->get();
        $barbers = Barber::all();
        $services = Service::all()->keyBy('id');

        if ($customers->isEmpty() || $barbers->isEmpty() || $services->isEmpty()) {
            return;
        }

        $today = Carbon::today();

        $sampleAppointments = [
            // Hôm nay - Đã hoàn thành (tạo doanh thu thực tế)
            [
                'code' => 'APT20260901',
                'customer_id' => $customers[0]->id,
                'barber_id' => $barbers[0]->id,
                'appointment_date' => $today->format('Y-m-d'),
                'start_time' => '09:00:00',
                'end_time' => '09:45:00',
                'total_price' => 150000,
                'status' => 'completed',
                'payment_status' => 'paid',
                'payment_method' => 'cash',
                'note' => 'Khách quen cắt combo gội sấy',
                'service_ids' => [1, 4],
            ],
            [
                'code' => 'APT20260902',
                'customer_id' => $customers[1]->id,
                'barber_id' => $barbers[1]->id,
                'appointment_date' => $today->format('Y-m-d'),
                'start_time' => '10:00:00',
                'end_time' => '11:00:00',
                'total_price' => 370000,
                'status' => 'completed',
                'payment_status' => 'paid',
                'payment_method' => 'momo',
                'note' => 'Uốn phồng Hàn Quốc + Cắt fade',
                'service_ids' => [2, 6],
            ],
            // Hôm nay - Đang xác nhận (sắp tới)
            [
                'code' => 'APT20260903',
                'customer_id' => $customers[2]->id,
                'barber_id' => $barbers[0]->id,
                'appointment_date' => $today->format('Y-m-d'),
                'start_time' => '14:30:00',
                'end_time' => '15:15:00',
                'total_price' => 120000,
                'status' => 'confirmed',
                'payment_status' => 'unpaid',
                'payment_method' => 'cash',
                'note' => 'Cắt Fade cạo viền sắc',
                'service_ids' => [2],
            ],
            // Hôm nay - Chờ duyệt
            [
                'code' => 'APT20260904',
                'customer_id' => $customers[3]->id,
                'barber_id' => $barbers[2]->id,
                'appointment_date' => $today->format('Y-m-d'),
                'start_time' => '16:00:00',
                'end_time' => '17:00:00',
                'total_price' => 280000,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'payment_method' => 'cash',
                'note' => 'Khách đặt online nhờ tư vấn màu nhuộm khói',
                'service_ids' => [8],
            ],
            // Ngày mai - Đã xác nhận
            [
                'code' => 'APT20260905',
                'customer_id' => $customers[4]->id,
                'barber_id' => $barbers[3]->id,
                'appointment_date' => $today->copy()->addDay()->format('Y-m-d'),
                'start_time' => '10:30:00',
                'end_time' => '11:15:00',
                'total_price' => 150000,
                'status' => 'confirmed',
                'payment_status' => 'unpaid',
                'payment_method' => 'bank',
                'note' => 'Combo VIP Barber King',
                'service_ids' => [10],
            ],
            // Hôm qua - Đã huỷ
            [
                'code' => 'APT20260906',
                'customer_id' => $customers[5]->id,
                'barber_id' => $barbers[1]->id,
                'appointment_date' => $today->copy()->subDay()->format('Y-m-d'),
                'start_time' => '18:00:00',
                'end_time' => '18:45:00',
                'total_price' => 80000,
                'status' => 'cancelled',
                'payment_status' => 'unpaid',
                'payment_method' => 'cash',
                'note' => 'Khách bận công tác đột xuất xin huỷ lịch',
                'service_ids' => [1],
            ],
        ];

        foreach ($sampleAppointments as $aptData) {
            $serviceIds = $aptData['service_ids'];
            unset($aptData['service_ids']);

            $aptData['slot_key'] = "{$aptData['barber_id']}_{$aptData['appointment_date']}_{$aptData['start_time']}";

            $apt = Appointment::updateOrCreate(['code' => $aptData['code']], $aptData);

            $syncData = [];
            foreach ($serviceIds as $sId) {
                if (isset($services[$sId])) {
                    $syncData[$sId] = [
                        'quantity' => 1,
                        'price' => $services[$sId]->price,
                    ];
                }
            }

            $apt->services()->sync($syncData);
        }
    }
}
