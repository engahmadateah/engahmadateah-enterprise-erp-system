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
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\ReportController;

Route::get('/', fn () => redirect()->route('dashboard'));

/*
|--------------------------------------------------------------------------
| Helper: register a resource where every action is protected by the
| matching permission  ( <prefix>.view / .create / .edit / .delete )
|--------------------------------------------------------------------------
*/
$crud = function (
    string $uri,
    string $controller,
    string $perm,
    array $actions = ['index', 'create', 'store', 'edit', 'update', 'destroy']
) {
    $map = [
        'index'   => 'view',
        'show'    => 'view',
        'create'  => 'create',
        'store'   => 'create',
        'edit'    => 'edit',
        'update'  => 'edit',
        'destroy' => 'delete',
    ];

    // order matters: create must be registered before show ({param})
    foreach ($actions as $action) {
        Route::resource($uri, $controller)
            ->only([$action])
            ->middleware('permission:' . $perm . '.' . $map[$action]);
    }
};

Route::middleware('auth')->group(function () use ($crud) {

    /* ---------------- Dashboard & Profile ---------------- */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    /* ---------------- Users / Roles ---------------- */

    $crud('users', UserController::class, 'users');
    $crud('roles', RoleController::class, 'roles');

    /* ---------------- HR ---------------- */

    $crud('departments', DepartmentController::class, 'departments');
    $crud('employees', EmployeeController::class, 'employees');

    // daily-sheet routes must not clash with attendance/{attendance}
    Route::middleware('permission:attendance.create')->group(function () {
        Route::get('/attendance/daily-sheet', [AttendanceController::class, 'dailySheet'])
            ->name('attendance.daily-sheet');
        Route::post('/attendance/daily-sheet', [AttendanceController::class, 'saveDailySheet'])
            ->name('attendance.daily-sheet.save');
    });
    $crud('attendance', AttendanceController::class, 'attendance');

    $crud('overtimes', OvertimeController::class, 'overtime', ['index', 'create', 'store']);
    $crud('bonuses', BonusController::class, 'bonus', ['index', 'create', 'store']);
    $crud('advances', AdvanceController::class, 'advance', ['index', 'create', 'store']);
    $crud('loans', LoanController::class, 'loans', ['index', 'create', 'store']);

    /* ---------------- Payroll ---------------- */

    Route::middleware('permission:payroll.view')->group(function () {
        Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');
        Route::get('/payroll/verify/{id}', [PayrollController::class, 'verify'])->name('payroll.verify');
    });

    Route::middleware('permission:payroll.create')->group(function () {
        Route::get('/payroll/create', [PayrollController::class, 'create'])->name('payroll.create');
        Route::post('/payroll', [PayrollController::class, 'store'])->name('payroll.store');
        Route::get('/payroll/generate', fn () => view('payroll.generate'))->name('payroll.generate.form');
        Route::post('/payroll/generate', [PayrollController::class, 'generateMonthlyPayroll'])->name('payroll.generate');
    });

    // access check (payroll.view OR own slip) is done inside the controller
    Route::get('/payroll/{payroll}/slip', [PayrollController::class, 'slip'])->name('payroll.slip');

    /* ---------------- Leaves ---------------- */

    Route::middleware('permission:leaves.view')->get('/leaves', [LeaveController::class, 'index'])->name('leaves.index');
    Route::middleware('permission:leaves.edit')->group(function () {
        Route::post('/leaves/{leave}/approve', [LeaveController::class, 'approve'])->name('leaves.approve');
        Route::post('/leaves/{leave}/reject', [LeaveController::class, 'reject'])->name('leaves.reject');
    });

    Route::middleware('permission:leave-balance.view')->get('/leave-balances', [LeaveBalanceController::class, 'index'])->name('leave-balances.index');
    Route::middleware('permission:leave-balance.edit')->group(function () {
        Route::get('/leave-balances/{leaveBalance}/edit', [LeaveBalanceController::class, 'edit'])->name('leave-balances.edit');
        Route::put('/leave-balances/{leaveBalance}', [LeaveBalanceController::class, 'update'])->name('leave-balances.update');
    });

    Route::middleware('permission:my-leaves.view')->get('/my-leaves', [MyLeaveController::class, 'index'])->name('my-leaves.index');
    Route::middleware('permission:my-leaves.create')->group(function () {
        Route::get('/my-leaves/create', [MyLeaveController::class, 'create'])->name('my-leaves.create');
        Route::post('/my-leaves', [MyLeaveController::class, 'store'])->name('my-leaves.store');
    });

    /* ---------------- Inventory ---------------- */

    Route::middleware('permission:stock.in')
        ->post('/products/{product}/add-stock', [ProductController::class, 'addStock'])
        ->name('products.addStock');
    Route::middleware('permission:stock.out')
        ->post('/products/{product}/sell-stock', [ProductController::class, 'sellStock'])
        ->name('products.sellStock');

    $crud('products', ProductController::class, 'products', ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
    $crud('categories', CategoryController::class, 'categories');
    $crud('warehouses', WarehouseController::class, 'warehouses');

    Route::middleware('permission:stock.view')
        ->get('/stock-movements', [StockMovementController::class, 'index'])
        ->name('stock-movements.index');

    /* ---------------- Purchases / Sales ---------------- */

    $crud('suppliers', SupplierController::class, 'suppliers');
    $crud('purchases', PurchaseController::class, 'purchases', ['index', 'create', 'store']);
    $crud('customers', CustomerController::class, 'customers');

    Route::middleware('permission:sales.view')->group(function () {
        Route::get('/sales/{sale}/invoice', [SaleController::class, 'invoice'])->name('sales.invoice');
        Route::get('/sales/{sale}/pdf', [SaleController::class, 'pdf'])->name('sales.pdf');
    });
    $crud('sales', SaleController::class, 'sales', ['index', 'create', 'store']);

    /* ---------------- Accounting ---------------- */

    // the sidebar shows Accounts / Journal under "accounting.view",
    // so either permission is accepted for the listing pages
    Route::middleware('permission:accounts.view|accounting.view')
        ->get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::middleware('permission:accounts.create')->group(function () {
        Route::get('/accounts/create', [AccountController::class, 'create'])->name('accounts.create');
        Route::post('/accounts', [AccountController::class, 'store'])->name('accounts.store');
    });
    Route::middleware('permission:accounts.edit')->group(function () {
        Route::get('/accounts/{account}/edit', [AccountController::class, 'edit'])->name('accounts.edit');
        Route::put('/accounts/{account}', [AccountController::class, 'update'])->name('accounts.update');
    });
    Route::middleware('permission:accounts.delete')
        ->delete('/accounts/{account}', [AccountController::class, 'destroy'])->name('accounts.destroy');

    Route::middleware('permission:journal-entries.view|accounting.view')
        ->get('/journal-entries', [JournalEntryController::class, 'index'])->name('journal-entries.index');

    Route::middleware('permission:accounting.view')
        ->get('/accounting', [AccountingController::class, 'index'])->name('accounting.index');

    Route::middleware('permission:sales.cancel')
        ->post('/sales/{sale}/cancel', [SaleController::class, 'cancel'])->name('sales.cancel');

    /* ---------------- Reports / Audit ---------------- */

    Route::middleware('permission:reports.view')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export/sales', [ReportController::class, 'exportSales'])
            ->middleware('permission:sales.view')->name('reports.export.sales');
        Route::get('/reports/export/products', [ReportController::class, 'exportProducts'])
            ->middleware('permission:products.view')->name('reports.export.products');
    });

    Route::middleware('permission:audit.view')
        ->get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');

    /* ---------------- Tickets ---------------- */

    // 'manage' must be declared before tickets/{ticket}
    Route::middleware('permission:managetickets.view')->group(function () {
        Route::get('/tickets/manage', [TicketController::class, 'manage'])->name('tickets.manage');
        Route::put('/tickets/{ticket}/status', [TicketController::class, 'updateStatus'])->name('tickets.status');
    });
    Route::middleware('permission:tickets.create')->group(function () {
        Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
        Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    });
    Route::get('/tickets/{ticket}/attachment/{index}', [TicketController::class, 'attachment'])
        ->whereNumber('index')->name('tickets.attachment');
    Route::middleware('permission:tickets.view')->get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::middleware('permission:tickets.edit')->group(function () {
        Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
        Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    });
    Route::middleware('permission:tickets.delete')
        ->delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');

    /* ---------------- Chat ---------------- */

    Route::middleware('permission:chat.view')->group(function () {
        Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
        Route::get('/chat/users', [ChatController::class, 'users'])->name('chat.users');
        Route::post('/chat/start/{user}', [ChatController::class, 'start'])->name('chat.start');
        Route::get('/chat/attachment/{message}', [ChatController::class, 'attachment'])->name('chat.attachment');
        Route::get('/chat/{conversation}', [ChatController::class, 'show'])->name('chat.show');
        Route::post('/chat/{conversation}', [ChatController::class, 'send'])->name('chat.send');
    });
});

require __DIR__.'/auth.php';
