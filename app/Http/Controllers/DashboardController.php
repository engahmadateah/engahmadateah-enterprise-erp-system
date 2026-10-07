<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // every figure is computed only if the user may see that module,
        // so the dashboard no longer leaks company data to plain employees
        $count = fn (string $permission, callable $q) => $user->can($permission) ? $q() : null;

        $kpis = [];

        if ($user->can('sales.view')) {
            $kpis['sales_today'] = (float) Sale::active()->whereDate('created_at', today())->sum('total');
            $kpis['sales_month'] = (float) Sale::active()
                ->where('created_at', '>=', now()->startOfMonth())->sum('total');
        }

        if ($user->can('products.view')) {
            $kpis['low_stock'] = Product::where('is_active', true)
                ->whereColumn('quantity', '<=', 'low_stock')->count();
        }

        if ($user->can('leaves.view')) {
            $kpis['pending_leaves'] = Leave::where('status', 'pending')->count();
        }

        if ($user->can('managetickets.view')) {
            $kpis['open_tickets'] = Ticket::where('status', '!=', 'completed')->count();
        }

        return view('dashboard.index', [
            'employees'   => $count('employees.view', fn () => Employee::count()) ?? '—',
            'departments' => $count('departments.view', fn () => Department::count()) ?? '—',
            'products'    => $count('products.view', fn () => Product::count()) ?? '—',
            'sales'       => $count('sales.view', fn () => Sale::active()->count()) ?? '—',
            'kpis'        => $kpis,
        ]);
    }
}
