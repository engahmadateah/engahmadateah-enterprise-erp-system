<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    public function run(): void
    {
        LeaveType::create([
            'name' => 'Annual Leave',
            'is_deducted' => true
        ]);

        LeaveType::create([
            'name' => 'Sick Leave',
            'is_deducted' => false
        ]);

        LeaveType::create([
            'name' => 'Hourly Leave',
            'is_deducted' => true
        ]);

        LeaveType::create([
            'name' => 'Unpaid Leave',
            'is_deducted' => false
        ]);
    }
}