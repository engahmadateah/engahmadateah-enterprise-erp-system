<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            ['code' => '1000', 'name' => 'Cash',           'type' => 'asset'],
            ['code' => '1100', 'name' => 'Inventory',      'type' => 'asset'],
            ['code' => '4000', 'name' => 'Sales Revenue',  'type' => 'revenue'],
            ['code' => '5000', 'name' => 'Salary Expense', 'type' => 'expense'],
        ];

        foreach ($accounts as $account) {
            Account::updateOrCreate(
                ['code' => $account['code']],
                $account + ['is_active' => true]
            );
        }
    }
}
