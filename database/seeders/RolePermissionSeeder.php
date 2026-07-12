<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            'dashboard.view',

            'users.view',
            'users.create',
            'users.edit',
            'users.delete',

            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',

            'employees.view',
            'employees.create',
            'employees.edit',
            'employees.delete',

            'departments.view',

            'attendance.view',

            'payroll.view',

            'inventory.view',

            'sales.view',

            'purchases.view',

            'reports.view',
            'departments.view',


'departments.create',
'departments.edit',
'departments.delete',

'employees.view',
'employees.create',
'employees.edit',
'employees.delete',
'attendance.view',

'attendance.create',
'attendance.edit',
'attendance.delete',
 
'overtime.view',
'overtime.create',
'overtime.edit',
'overtime.delete',

'bonus.view',
'bonus.create',
'bonus.edit',
'bonus.delete',
'advance.view',

'advance.create',
'advance.edit',
'advance.delete',

'loans.view',
'loans.create',
'loans.edit',
'loans.delete',

'leaves.view',
'leaves.create',
'leaves.edit',
'leaves.delete',

'leave-balance.view',
'leave-balance.edit',

'my-leaves.view',
'my-leaves.create',

'products.view',
'products.create',
'products.edit',
'products.delete',

'categories.view',
'categories.create',
'categories.edit',
'categories.delete',

'inventory.view',

'products.view',
'products.create',
'products.edit',
'products.delete',

'categories.view',
'categories.create',
'categories.edit',
'categories.delete',

'warehouses.view',
'warehouses.create',
'warehouses.edit',
'warehouses.delete',

'stock.view',
'stock.in',
'stock.out',

'suppliers.view',
'suppliers.create',
'suppliers.edit',
'suppliers.delete',

'purchases.view',
'purchases.create',
'purchases.edit',
'purchases.delete',

'sales.view',
'sales.create',
'sales.edit',
'sales.delete',

'customers.view',
'customers.create',
'customers.edit',
'customers.delete',

'accounts.view',
'accounts.create',
'accounts.edit',
'accounts.delete',

'journal-entries.view',
'journal-entries.create',
'journal-entries.edit',
'journal-entries.delete',

'accounting.view',
'accounting.create',
'accounting.edit',
'accounting.delete',

'tickets.view',
'tickets.create',
'tickets.edit',
'tickets.delete',
'managetickets.view',

'chat.view',

'accounting.view',



        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission
            ]);
        }

        $superAdmin = Role::firstOrCreate([
            'name' => 'Super Admin'
        ]);

        $superAdmin->givePermissionTo(
            Permission::all()
        );

        Role::firstOrCreate([
            'name' => 'Admin'
        ]);

        Role::firstOrCreate([
            'name' => 'Manager'
        ]);

        Role::firstOrCreate([
            'name' => 'HR'
        ]);

        Role::firstOrCreate([
            'name' => 'Accountant'
        ]);

        Role::firstOrCreate([
            'name' => 'Employee'
        ]);
    }
}