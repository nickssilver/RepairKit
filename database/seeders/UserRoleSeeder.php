<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (UserRole::count() !== 0) {
            return;
        }
        UserRole::create(
            [
                'name' => 'Admin',
                'is_primary' => true,
                'permissions' => [],
            ]
        );
        UserRole::create(
            [
                'name' => 'Technician',
                'is_primary' => false,
                'permissions' => ["manage_repair_defects", "manage_repair_devices", "manage_repairable_brands"],
            ]
        );
    }
}
