<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            [
                'email' => 'admin@erp.com'
            ],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('12345678')
            ]
        );

        $user->assignRole('Super Admin');
    }
}