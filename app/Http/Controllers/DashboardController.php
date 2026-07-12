<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Product;
// غيّر Sale إلى اسم موديل المبيعات الحقيقي إذا كان مختلفًا
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
     
       
        return view('dashboard.index', [
            'employees'  => Employee::count(),
            'departments' => Department::count(),
            'products'   => Product::count(),
            'sales'      => Sale::count(),
        ]);
    }
}