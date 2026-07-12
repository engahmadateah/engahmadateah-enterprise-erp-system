<aside class="w-64 bg-slate-900 text-white flex flex-col">

    <!-- Logo -->
    <div class="h-16 flex items-center justify-center border-b border-slate-700">

        <h1 class="text-2xl font-bold tracking-wider">
            ERP
        </h1>

    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4 overflow-y-auto">

        <!-- Dashboard -->
        <div class="mb-4">

            <a href="{{ route('dashboard') }}"
               class="block px-4 py-2 rounded hover:bg-slate-800 transition">

                Dashboard

            </a>

        </div>

        <!-- User Management -->
        <div class="pt-2">

            <h3 class="text-xs uppercase text-slate-400 mb-2 px-2">
                User Management
            </h3>

            @can('users.view')

            <a href="{{ route('users.index') }}"
               class="block px-4 py-2 rounded hover:bg-slate-800 transition">

                Users

            </a>

            @endcan

            @can('roles.view')

            <a href="{{ route('roles.index') }}"
               class="block px-4 py-2 rounded hover:bg-slate-800 transition">

                Roles

            </a>

            @endcan

        </div>

        <!-- HR -->
<div class="pt-6">

<h3 class="text-xs uppercase text-slate-400 mb-2 px-2">
    Human Resources
</h3>

@can('employees.view')

<a href="{{ route('employees.index') }}"
   class="block px-4 py-2 rounded hover:bg-slate-800 transition">

    Employees

</a>

@endcan

@can('departments.view')

<a href="{{ route('departments.index') }}"
   class="block px-4 py-2 rounded hover:bg-slate-800 transition">

    Departments

</a>

@endcan

@can('attendance.view')

<a href="{{ route('attendance.daily-sheet') }}"
   class="block px-4 py-2 rounded hover:bg-slate-800 transition">

    Daily Attendance

</a>

@endcan

@can('attendance.view')

<a href="{{ route('attendance.index') }}"
   class="block px-4 py-2 rounded hover:bg-slate-800 transition">

    Attendance

</a>

@endcan

@can('leaves.view')

<a href="{{ route('leaves.index') }}"
   class="block px-4 py-2 rounded hover:bg-slate-800 transition">

    Leave Requests

</a>

@endcan

@can('leave-balance.view')

<a href="{{ route('leave-balances.index') }}"
   class="block px-4 py-2 rounded hover:bg-slate-800 transition">

    Leave Balances

</a>

@endcan
@can('my-leaves.view')

<a href="{{ route('my-leaves.index') }}"
   class="block px-4 py-2 rounded hover:bg-slate-800 transition">

    My Leaves

</a>

@endcan

</div>
      <!-- Payroll -->
<div class="pt-6">

<h3 class="text-xs uppercase text-slate-400 mb-2 px-2">
    Payroll
</h3>

@can('payroll.view')

<a href="{{ route('payroll.index') }}"
   class="block px-4 py-2 rounded hover:bg-slate-800 transition">

    Payroll List

</a>

@endcan

@can('payroll.create')

<a href="{{ route('payroll.generate.form') }}"
   class="block px-4 py-2 rounded hover:bg-slate-800 transition">

    Generate Payroll

</a>

@endcan


@can('bonus.view')

<a href="{{ route('bonuses.index') }}"
   class="block px-4 py-2 rounded hover:bg-slate-800 transition">

    Bonuses

</a>

@endcan


@can('overtime.view')

<a href="{{ route('overtimes.index') }}"
   class="block px-4 py-2 rounded hover:bg-slate-800 transition">

    Overtime

</a>

@endcan


@can('advance.view')

<a href="{{ route('advances.index') }}"
   class="block px-4 py-2 rounded hover:bg-slate-800 transition">

    Advances

</a>

@endcan


@can('loans.view')

<a href="{{ route('loans.index') }}"
   class="block px-4 py-2 rounded hover:bg-slate-800 transition">

    Loans

</a>

@endcan

</div>


        <!-- Inventory -->
        <div class="pt-6">

            <h3 class="text-xs uppercase text-slate-400 mb-2 px-2">
                Inventory
            </h3>

            @can('products.view')

<a href="{{ route('products.index') }}"
   class="block px-4 py-2 rounded hover:bg-slate-800 transition">

    Products

</a>

@endcan
            @can('categories.view')

<a href="{{ route('categories.index') }}"
   class="block px-4 py-2 rounded hover:bg-slate-800 transition">

   Categories

</a>

@endcan

@can('warehouses.view')

<a href="{{ route('warehouses.index') }}"
   class="block px-4 py-2 rounded hover:bg-slate-800 transition">

   Warehouses

</a>

@endcan

@can('stock.view')

<a href="{{ route('stock-movements.index') }}"
   class="block px-4 py-2 rounded hover:bg-slate-800 transition">

   StockMovements

</a>

@endcan

@can('suppliers.view')

<a href="{{ route('suppliers.index') }}"
   class="block px-4 py-2 rounded hover:bg-slate-800">

    Suppliers

</a>

@endcan

@can('purchases.view')

<a href="{{ route('purchases.index') }}"
   class="block px-4 py-2 rounded hover:bg-slate-800">

    Purchases

</a>

@endcan

@can('sales.view')

<a href="{{ route('sales.index') }}"
   class="block px-4 py-2 rounded hover:bg-slate-800 transition">

    Sales

</a>

@endcan

@can('customers.view')

<a href="{{ route('customers.index') }}"
   class="block px-4 py-2 rounded hover:bg-slate-800 transition">

    Customers

</a>

@endcan

        </div>



 <!-- IT tickets-->
 <div class="pt-6">

<h3 class="text-xs uppercase text-slate-400 mb-2 px-2">
IT Support
</h3>
@can('tickets.view')

<a href="{{ route('tickets.index') }}"
   class="block px-4 py-2 rounded hover:bg-slate-800 transition">

   IT Support

</a>


@endcan
@can('tickets.create')

<a href="{{ route('tickets.create') }}"
   class="block px-4 py-2 rounded hover:bg-slate-800 transition">

  Request IT support

</a>


@endcan


@can('managetickets.view')
<a href="{{ route('tickets.manage') }}"
   class="block px-4 py-2 rounded hover:bg-slate-800 transition">

  Manage IT support

</a>


@endcan


</div>
<!-- ACCOUNTING -->
<div class="pt-6">

    <h3 class="text-xs uppercase text-slate-400 mb-2 px-2">
    ACCOUNTING
    </h3>

    @can('accounting.view')

    <a href="{{ route('accounts.index') }}"
       class="block px-4 py-2 rounded hover:bg-slate-800 transition">

         Accounts

    </a>
    <a href="{{ route('journal-entries.index') }}"
       class="block px-4 py-2 rounded hover:bg-slate-800 transition">

       Journal Entries

    </a>
    <a href="{{ route('accounting.index') }}"
       class="block px-4 py-2 rounded hover:bg-slate-800 transition">

       Accounting

    </a>

    @endcan

</div>

<!-- CHAT -->
<div class="pt-6">

    <h3 class="text-xs uppercase text-slate-400 mb-2 px-2">
        Chat
    </h3>

    @can('chat.view')

    <a href="{{ route('chat.index') }}"
       class="block px-4 py-2 rounded hover:bg-slate-800 transition">

        Messages

    </a>

    @endcan

</div>


       

    </nav>

</aside>