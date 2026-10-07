<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Set SUPERADMIN_PASSWORD in .env, otherwise a random one is generated
        // and printed ONCE here (the old hard-coded 12345678 is gone).
        $password = env('SUPERADMIN_PASSWORD') ?: Str::random(16);

        $user = User::firstOrCreate(
            ['email' => 'admin@erp.com'],
            [
                'name'      => 'Super Admin',
                'password'  => Hash::make($password),
                'is_active' => true,
            ]
        );

        $user->assignRole('Super Admin');

        if ($user->wasRecentlyCreated && $this->command) {
            $this->command->warn("Super Admin created: admin@erp.com / {$password}");
        }
    }
}
