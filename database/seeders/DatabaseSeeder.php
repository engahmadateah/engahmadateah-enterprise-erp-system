<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            SuperAdminSeeder::class,
            AccountSeeder::class,
            LeaveTypeSeeder::class,   // was missing: leave requests need leave types
        ]);
    }
}
