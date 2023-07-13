<?php

namespace Database\Seeders;

use App\Models\RepairPriority;
use Illuminate\Database\Seeder;

class RepairPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (RepairPriority::count() !== 0) {
            return;
        }
        $priorities = [
            [
                'value' => 1,
                'name' => 'Low',
                'extra_charge' => 0,
            ],
            [
                'value' => 2,
                'name' => 'Medium',
                'extra_charge' => 1,
            ],
            [
                'value' => 3,
                'name' => 'High',
                'extra_charge' => 2,
            ],
            [
                'value' => 4,
                'name' => 'Urgent',
                'extra_charge' => 5,
            ],
        ];

        foreach ($priorities as $priority) {
            RepairPriority::create($priority);
        }
    }
}
