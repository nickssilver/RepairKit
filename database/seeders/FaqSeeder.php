<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Faq::count() !== 0) {
            return;
        }
        $pages = [
            [
                'question' => 'How does it work?',
                'answer' => 'Our platform works with your content to provides insights and metrics on how you can grow your business and scale your infrastructure.',
            ],
            [
                'question' => 'Do you offer team pricing?',
                'answer' => 'Yes, we do! Team pricing is available for any plan. You can take advantage of 30% off for signing up for team pricing of 10 users or more.',
            ],
            [
                'question' => 'How do I make changes and configure my site?',
                'answer' => 'You can easily change your site settings inside of your site dashboard by clicking the top right menu and clicking the settings button.',
            ],
            [
                'question' => 'How do I add a custom domain?',
                'answer' => 'You can easily change your site settings inside of your site dashboard by clicking the top right menu and clicking the settings button.',
            ],
        ];

        foreach ($pages as $page) {
            Faq::create($page);
        }
    }
}
