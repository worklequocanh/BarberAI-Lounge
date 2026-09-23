<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['id' => 1, 'name' => 'Quản trị viên (Admin)', 'slug' => 'admin'],
            ['id' => 2, 'name' => 'Khách hàng (Customer)', 'slug' => 'customer'],
            ['id' => 3, 'name' => 'Thợ cắt tóc (Barber)', 'slug' => 'barber'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['id' => $role['id']], $role);
        }
    }
}
