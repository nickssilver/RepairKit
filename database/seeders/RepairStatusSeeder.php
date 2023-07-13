<?php

namespace Database\Seeders;

use App\Models\RepairStatus;
use Illuminate\Database\Seeder;

class RepairStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (RepairStatus::count() !== 0) {
            return;
        }
        $staues = [
            ['body' => 'Open'],
            ['body' => 'Pending'],
            ['body' => 'Resolved'],
            ['body' => 'Closed'],
        ];
        foreach ($staues as $status) {
            RepairStatus::create($status);
        }
    }
}
