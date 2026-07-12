<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\AdvanceController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LeaveBalanceController;
use App\Http\Controllers\MyLeaveController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\JournalEntryController;
use App\Http\Controllers\AccountingController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ChatController;




Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    */

    Route::middleware('permission:users.view')
        ->group(function () {

            Route::get('/users', [
                UserController::class,
                'index'
            ])->name('users.index');

        });

    Route::middleware('permission:users.create')
        ->group(function () {

            Route::get('/users/create', [
                UserController::class,
                'create'
            ])->name('users.create');

            Route::post('/users', [
                UserController::class,
                'store'
            ])->name('users.store');

        });

    Route::middleware('permission:users.edit')
        ->group(function () {

            Route::get('/users/{user}/edit', [
                UserController::class,
                'edit'
            ])->name('users.edit');

            Route::put('/users/{user}', [
                UserController::class,
                'update'
            ])->name('users.update');

        });

    Route::middleware('permission:users.delete')
        ->group(function () {

            Route::delete('/users/{user}', [
                UserController::class,
                'destroy'
            ])->name('users.destroy');

        });

});


Route::middleware('permission:roles.view')
    ->group(function () {

        Route::get('/roles', [
            RoleController::class,
            'index'
        ])->name('roles.index');

    });

Route::middleware('permission:roles.create')
    ->group(function () {

        Route::get('/roles/create', [
            RoleController::class,
            'create'
        ])->name('roles.create');

        Route::post('/roles', [
            RoleController::class,
            'store'
        ])->name('roles.store');

    });

Route::middleware('permission:roles.edit')
    ->group(function () {

        Route::get('/roles/{role}/edit', [
            RoleController::class,
            'edit'
        ])->name('roles.edit');

        Route::put('/roles/{role}', [
            RoleController::class,
            'update'
        ])->name('roles.update');

    });

Route::middleware('permission:roles.delete')
    ->group(function () {

        Route::delete('/roles/{role}', [
            RoleController::class,
            'destroy'
        ])->name('roles.destroy');

    });
    Route::middleware('permission:departments.view')
->group(function () {

    Route::get(
        '/departments',
        [DepartmentController::class,'index']
    )->name('departments.index');

});
Route::middleware('permission:departments.create')
->group(function () {

    Route::get(
        '/departments/create',
        [DepartmentController::class,'create']
    )->name('departments.create');

    Route::post(
        '/departments',
        [DepartmentController::class,'store']
    )->name('departments.store');

});
Route::middleware('permission:departments.edit')
->group(function () {

    Route::get(
        '/departments/{department}/edit',
        [DepartmentController::class,'edit']
    )->name('departments.edit');

    Route::put(
        '/departments/{department}',
        [DepartmentController::class,'update']
    )->name('departments.update');

});
Route::middleware('permission:departments.delete')
->group(function () {

    Route::delete(
        '/departments/{department}',
        [DepartmentController::class,'destroy']
    )->name('departments.destroy');

});
Route::middleware(
    'permission:employees.view'
)->group(function () {

    Route::get(
        '/employees',
        [EmployeeController::class,'index']
    )->name('employees.index');

});
Route::middleware(
    'permission:employees.create'
)->group(function () {

    Route::get(
        '/employees/create',
        [EmployeeController::class,'create']
    )->name('employees.create');

    Route::post(
        '/employees',
        [EmployeeController::class,'store']
    )->name('employees.store');

});
Route::middleware(
    'permission:employees.edit'
)->group(function () {

    Route::get(
        '/employees/{employee}/edit',
        [EmployeeController::class,'edit']
    )->name('employees.edit');

    Route::put(
        '/employees/{employee}',
        [EmployeeController::class,'update']
    )->name('employees.update');

});
Route::middleware(
    'permission:employees.delete'
)->group(function () {

    Route::delete(
        '/employees/{employee}',
        [EmployeeController::class,'destroy']
    )->name('employees.destroy');

});
Route::middleware(
    ['auth','permission:attendance.view']
)->group(function () {

    Route::get(
        '/attendance',
        [AttendanceController::class,'index']
    )->name('attendance.index');

});
Route::middleware(
    ['auth','permission:attendance.create']
)->group(function () {

    Route::get(
        '/attendance/create',
        [AttendanceController::class,'create']
    )->name('attendance.create');

    Route::post(
        '/attendance',
        [AttendanceController::class,'store']
    )->name('attendance.store');

});
Route::middleware(
    ['auth','permission:attendance.edit']
)->group(function () {

    Route::get(
        '/attendance/{attendance}/edit',
        [AttendanceController::class,'edit']
    )->name('attendance.edit');

    Route::put(
        '/attendance/{attendance}',
        [AttendanceController::class,'update']
    )->name('attendance.update');

});
Route::middleware(
    ['auth','permission:attendance.delete']
)->group(function () {

    Route::delete(
        '/attendance/{attendance}',
        [AttendanceController::class,'destroy']
    )->name('attendance.destroy');

});
Route::middleware([
    'auth',
    'permission:attendance.create'
])->group(function () {

    Route::get(
        '/attendance/daily-sheet',
        [AttendanceController::class, 'dailySheet']
    )->name('attendance.daily-sheet');

    Route::post(
        '/attendance/daily-sheet',
        [AttendanceController::class, 'saveDailySheet']
    )->name('attendance.daily-sheet.save');

});
Route::middleware([
    'auth'
])->group(function () {

    Route::get(
        '/payroll',
        [PayrollController::class,'index']
    )->name('payroll.index');

    Route::get(
        '/payroll/create',
        [PayrollController::class,'create']
    )->name('payroll.create');

    Route::post(
        '/payroll',
        [PayrollController::class,'store']
    )->name('payroll.store');

   

});
Route::get('/payroll/{payroll}/slip', [
    PayrollController::class,
    'slip'
])->name('payroll.slip');

Route::get('/payroll/verify/{id}', [
    PayrollController::class,
    'verify'
])->name('payroll.verify');

Route::middleware([
    'auth',
    'permission:overtime.view'
])->group(function () {

    Route::get(
        '/overtimes',
        [OvertimeController::class,'index']
    )->name('overtimes.index');

});

Route::middleware([
    'auth',
    'permission:overtime.create'
])->group(function () {

    Route::get(
        '/overtimes/create',
        [OvertimeController::class,'create']
    )->name('overtimes.create');

});
Route::post(
    '/overtimes',
    [OvertimeController::class,'store']
)->name('overtimes.store');
Route::middleware([
    'auth',
    'permission:bonus.view'
])->group(function () {

    Route::get(
        '/bonuses',
        [BonusController::class,'index']
    )->name('bonuses.index');

});
Route::middleware([
    'auth',
    'permission:bonus.create'
])->group(function () {

    Route::get(
        '/bonuses/create',
        [BonusController::class,'create']
    )->name('bonuses.create');

    Route::post(
        '/bonuses',
        [BonusController::class,'store']
    )->name('bonuses.store');

});
Route::middleware([
    'auth',
    'permission:advance.view'
])->group(function () {

    Route::get(
        '/advances',
        [AdvanceController::class,'index']
    )->name('advances.index');

});
Route::middleware([
    'auth',
    'permission:advance.create'
])->group(function () {

    Route::get(
        '/advances/create',
        [AdvanceController::class,'create']
    )->name('advances.create');

    Route::post(
        '/advances',
        [AdvanceController::class,'store']
    )->name('advances.store');

});
Route::middleware([
    'auth',
    'permission:loans.view'
])->group(function () {

    Route::get(
        '/loans',
        [LoanController::class,'index']
    )->name('loans.index');

});
Route::middleware([
    'auth',
    'permission:loans.create'
])->group(function () {

    Route::get(
        '/loans/create',
        [LoanController::class,'create']
    )->name('loans.create');

    Route::post(
        '/loans',
        [LoanController::class,'store']
    )->name('loans.store');

});
Route::post(
    '/payroll/generate',
    [PayrollController::class,'generateMonthlyPayroll']
)->name('payroll.generate');
Route::get(
    '/leave-balances',
    [LeaveBalanceController::class,'index']
)->name('leave-balances.index');

Route::get(
    '/leave-balances/{leaveBalance}/edit',
    [LeaveBalanceController::class,'edit']
)->name('leave-balances.edit');

Route::put(
    '/leave-balances/{leaveBalance}',
    [LeaveBalanceController::class,'update']
)->name('leave-balances.update');
Route::get(
    '/my-leaves',
    [MyLeaveController::class,'index']
)->name('my-leaves.index');

Route::get(
    '/my-leaves/create',
    [MyLeaveController::class,'create']
)->name('my-leaves.create');

Route::post(
    '/my-leaves',
    [MyLeaveController::class,'store']
)->name('my-leaves.store');
Route::get(
    '/leaves',
    [LeaveController::class,'index']
)->name('leaves.index');

Route::post(
    '/leaves/{leave}/approve',
    [LeaveController::class,'approve']
)->name('leaves.approve');

Route::post(
    '/leaves/{leave}/reject',
    [LeaveController::class,'reject']
)->name('leaves.reject');
Route::resource(
    'products',
    ProductController::class
);
Route::resource(
    'categories',
    CategoryController::class
);
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
    ->name('categories.destroy');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])
    ->name('products.destroy');
    Route::get('/warehouses', [WarehouseController::class,'index'])
    ->name('warehouses.index');

Route::get('/warehouses/create', [WarehouseController::class,'create'])
    ->name('warehouses.create');

Route::post('/warehouses', [WarehouseController::class,'store'])
    ->name('warehouses.store');

Route::get('/stock-movements', [StockMovementController::class,'index'])
    ->name('stock-movements.index');

// stock actions
Route::post('/products/{product}/add-stock', [ProductController::class,'addStock'])
    ->name('products.addStock');

Route::post('/products/{product}/sell-stock', [ProductController::class,'sellStock'])
    ->name('products.sellStock');
    Route::get('/products/{product}', [ProductController::class,'show'])
    ->name('products.show');
    Route::get('/warehouses/{warehouse}/edit', [WarehouseController::class,'edit'])->name('warehouses.edit');
Route::put('/warehouses/{warehouse}', [WarehouseController::class,'update'])->name('warehouses.update');
Route::delete('/warehouses/{warehouse}', [WarehouseController::class,'destroy'])->name('warehouses.destroy');

Route::resource(
    'suppliers',
    SupplierController::class
);

Route::resource(
    'purchases',
    PurchaseController::class
);

Route::resource(
    'sales',
    SaleController::class
);

Route::resource(
    'customers',
    CustomerController::class
);
Route::get(
    '/sales/{sale}/invoice',
    [SaleController::class,'invoice']
)->name('sales.invoice');

Route::get(
    '/sales/{sale}/pdf',
    [SaleController::class,'pdf']
)->name('sales.pdf');

Route::resource(
    'accounts',
    AccountController::class
);
Route::resource(
    'journal-entries',
    JournalEntryController::class
);
Route::get('/accounting', [AccountingController::class, 'index'])
    ->name('accounting.index');

    Route::get(
        'tickets/manage',
        [TicketController::class, 'manage']
    )->name('tickets.manage');
    
    Route::put(
        'tickets/{ticket}/status',
        [TicketController::class, 'updateStatus']
    )->name('tickets.status');

    Route::resource(
        'tickets',
        TicketController::class
    );
    Route::get(
        '/chat',
        [ChatController::class,'index']
    )->name('chat.index');
    
    Route::get(
        '/chat/users',
        [ChatController::class,'users']
    )->name('chat.users');
    
    Route::get(
        '/chat/start/{user}',
        [ChatController::class,'start']
    )->name('chat.start');
    
    Route::get(
        '/chat/{conversation}',
        [ChatController::class,'show']
    )->name('chat.show');
    
    Route::post(
        '/chat/{conversation}',
        [ChatController::class,'send']
    )->name('chat.send');
    
require __DIR__.'/auth.php';