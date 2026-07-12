<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        Account::insert([

            [
                'code' => '1000',
                'name' => 'Cash',
                'type' => 'asset'
            ],

            [
                'code' => '1100',
                'name' => 'Inventory',
                'type' => 'asset'
            ],

            [
                'code' => '4000',
                'name' => 'Sales Revenue',
                'type' => 'revenue'
            ],

            [
                'code' => '5000',
                'name' => 'Salary Expense',
                'type' => 'expense'
            ],

        ]);
    }
}