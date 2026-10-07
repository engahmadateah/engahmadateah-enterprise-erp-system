<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['Annual Leave', true],
            ['Sick Leave', false],
            ['Hourly Leave', true],
            ['Unpaid Leave', false],
        ] as [$name, $deducted]) {
            LeaveType::updateOrCreate(
                ['name' => $name],
                ['is_deducted' => $deducted]
            );
        }
    }
}
