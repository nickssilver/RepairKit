<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() !== 0) {
            return;
        }
        User::create(
            [
                'name' => 'Rose Finch',
                'email' => 'admin@admin.com',
                'password' => bcrypt(12345678),
                'role_id' => 1,
            ]
        );
        User::create(
            [
                'name' => 'Technician',
                'email' => 'user@user.com',
                'password' => bcrypt(12345678),
                'role_id' => 2,
            ]
        );
    }
}
