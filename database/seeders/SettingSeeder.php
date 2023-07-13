<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Setting::count() !== 0) {
            return;
        }
        Setting::create(
            [
                'app_https' => false,
                'app_name' => 'Repair Box',
                'app_url' => config('app.url'),
                'app_phone' => '7866718114',
                'app_date_format' => 'Y-m-d h:s:i',
                'app_address' => '4466 Scheuvront Drive Centennial, CO 80112',
                'tax_rate' => 17,
                'mail_from_name' => 'Repair Box - Tracking And Workshop Management System',
                'mail_from_address' => 'setyourmail@yourdomain.com',
                'mail_mailer' => 'log',
                'meta_keywords' => 'Repair tracking',
                'meta_home_title' => 'Repair box - Repair booking and tracking system',
                'meta_description' => 'A simple and clean platform that allows users to book repair and get notification from workshop or lab engineer',
                'app_about' => 'A repair box is a system for booking and managing repair services. Where can customers submit defective devices and the technician can take them to the workshop to repair and fix physical issues with the device. It is a very clean and simple interface, where every technician can go to the workshop to handle repair orders assigned to that particular technician. In the workshop, the technician can update the repair log with customer notification on each update while repairing',
            ]
        );
    }
}
