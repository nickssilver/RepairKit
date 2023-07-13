<?php

namespace Database\Seeders;

use App\Models\CustomPage;
use Illuminate\Database\Seeder;

class CustomPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (CustomPage::count() !== 0) {
            return;
        }
        $pages = [
            [
                'title' => 'Terms and conditions',
                'slug' => 'terms-and-conditions',
                'status' => true,
                'content' => 'Not updated terms and conditions',
            ],
            [
                'title' => 'Privacy policy',
                'slug' => 'privacy-policy',
                'status' => true,
                'content' => 'Not updated privacy policies',

            ],
        ];

        foreach ($pages as $page) {
            CustomPage::create($page);
        }
    }
}
