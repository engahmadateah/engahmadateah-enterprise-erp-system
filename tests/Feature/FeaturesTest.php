<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\AuditLog;
use App\Models\Customer;
use App\Models\JournalEntry;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class FeaturesTest extends TestCase
{
    use RefreshDatabase;

    private function userWith(string ...$permissions): User
    {
        $user = User::factory()->create();

        foreach ($permissions as $p) {
            Permission::findOrCreate($p);
            $user->givePermissionTo($p);
        }

        return $user;
    }

    private function seedAccounts(): void
    {
        foreach ([['1000', 'Cash', 'asset'], ['4000', 'Revenue', 'revenue'], ['1100', 'Inventory', 'asset']] as [$c, $n, $t]) {
            Account::forceCreate(['code' => $c, 'name' => $n, 'type' => $t, 'is_active' => true]);
        }
    }

    private function makeSale(User $cashier, int $qty = 3): array
    {
        $product = Product::forceCreate([
            'name' => 'Widget', 'sku' => 'W-1', 'quantity' => 10,
            'purchase_price' => 5, 'sale_price' => 10,
        ]);
        $customer = Customer::forceCreate(['name' => 'ACME']);
        $warehouse = Warehouse::forceCreate(['name' => 'Main']);

        $this->actingAs($cashier)->post('/sales', [
            'customer_id' => $customer->id, 'product_id' => $product->id,
            'warehouse_id' => $warehouse->id, 'quantity' => $qty,
        ])->assertSessionHasNoErrors();

        return [Sale::firstOrFail(), $product];
    }

    /* ------------------------------------------------------------ audit */

    public function test_model_changes_are_audited_and_passwords_are_never_stored(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $user->update(['name' => 'Renamed', 'password' => 'a-brand-new-secret']);

        $log = AuditLog::where('event', 'updated')->where('auditable_type', 'User')->latest('id')->firstOrFail();

        $this->assertSame('Renamed', $log->new_values['name']);
        $this->assertArrayNotHasKey('password', $log->new_values);
        $this->assertArrayNotHasKey('password', $log->old_values);
        $this->assertSame('Password changed', $log->description);
    }

    public function test_login_and_failed_login_are_audited(): void
    {
        $user = User::factory()->create();

        $this->post('/login', ['email' => $user->email, 'password' => 'wrong']);
        $this->post('/login', ['email' => $user->email, 'password' => 'password']);

        $this->assertDatabaseHas('audit_logs', ['event' => 'login_failed']);
        $this->assertDatabaseHas('audit_logs', ['event' => 'login', 'user_id' => $user->id]);
        $this->assertStringNotContainsString('wrong', AuditLog::where('event', 'login_failed')->value('description'));
    }

    public function test_audit_log_page_needs_permission(): void
    {
        $this->actingAs(User::factory()->create())->get('/audit-logs')->assertForbidden();
        $this->actingAs($this->userWith('audit.view'))->get('/audit-logs?q=%25')->assertOk();
    }

    public function test_audit_prune_keeps_recent_rows(): void
    {
        AuditLog::record('old');
        AuditLog::record('new');
        AuditLog::where('event', 'old')->update(['created_at' => now()->subDays(400)]);

        $this->artisan('audit:prune', ['--days' => 365])->assertSuccessful();

        $this->assertDatabaseMissing('audit_logs', ['event' => 'old']);
        $this->assertDatabaseHas('audit_logs', ['event' => 'new']);
    }

    /* ------------------------------------------------------ sale cancel */

    public function test_cancelling_a_sale_restores_stock_and_posts_a_reversal_once(): void
    {
        $this->seedAccounts();
        $user = $this->userWith('sales.create', 'sales.cancel');

        [$sale, $product] = $this->makeSale($user, 3);
        $this->assertSame(7, (int) $product->fresh()->quantity);

        $entriesBefore = JournalEntry::count();

        $this->actingAs($user)->post("/sales/{$sale->id}/cancel", ['reason' => 'customer returned'])
            ->assertSessionHas('success');

        $this->assertSame(10, (int) $product->fresh()->quantity);
        $this->assertSame('cancelled', $sale->fresh()->status);
        $this->assertSame($entriesBefore + 1, JournalEntry::count());

        // second attempt must not restore the stock again
        $this->actingAs($user)->post("/sales/{$sale->id}/cancel", ['reason' => 'again'])
            ->assertSessionHas('error');

        $this->assertSame(10, (int) $product->fresh()->quantity);
        $this->assertSame($entriesBefore + 1, JournalEntry::count());
    }

    public function test_cancel_requires_permission_and_a_reason(): void
    {
        $this->seedAccounts();
        $cashier = $this->userWith('sales.create');
        [$sale] = $this->makeSale($cashier);

        $this->actingAs($cashier)->post("/sales/{$sale->id}/cancel", ['reason' => 'x'])->assertForbidden();

        $manager = $this->userWith('sales.cancel');
        $this->actingAs($manager)->post("/sales/{$sale->id}/cancel", [])->assertSessionHasErrors('reason');
    }

    public function test_sales_index_shows_cancel_button_then_cancelled_badge(): void
    {
        $this->seedAccounts();
        $user = $this->userWith('sales.view', 'sales.create', 'sales.cancel');
        [$sale] = $this->makeSale($user);

        $this->actingAs($user)->get('/sales')->assertOk()->assertSee('Cancel')->assertDontSee('CANCELLED');

        $this->post("/sales/{$sale->id}/cancel", ['reason' => 'test']);

        $this->get('/sales')->assertOk()->assertSee('CANCELLED');
    }

    /* ------------------------------------------------- reports / export */

    public function test_csv_export_neutralises_spreadsheet_formulas(): void
    {
        Product::forceCreate([
            'name' => '=HYPERLINK("http://evil","x")', 'sku' => 'F-1', 'quantity' => 1,
            'purchase_price' => 1, 'sale_price' => 2,
        ]);

        $csv = $this->actingAs($this->userWith('reports.view', 'products.view'))
            ->get('/reports/export/products')
            ->assertOk()
            ->streamedContent();

        $this->assertStringContainsString("'=HYPERLINK", $csv);
        $this->assertStringNotContainsString(',=HYPERLINK', $csv);
    }

    public function test_reports_page_and_export_are_permission_gated(): void
    {
        $this->actingAs(User::factory()->create())->get('/reports')->assertForbidden();
        $this->actingAs($this->userWith('reports.view'))->get('/reports')->assertOk();
        $this->actingAs($this->userWith('reports.view'))->get('/reports/export/sales')->assertForbidden();
    }

    /* --------------------------------------------------------- dashboard */

    public function test_dashboard_does_not_leak_figures_to_users_without_access(): void
    {
        Product::forceCreate([
            'name' => 'Low', 'sku' => 'L-1', 'quantity' => 1, 'low_stock' => 5,
            'purchase_price' => 1, 'sale_price' => 2, 'is_active' => true,
        ]);

        $plain = User::factory()->create();
        $this->actingAs($plain)->get('/dashboard')->assertOk()->assertDontSee('Low-stock products');

        $stock = $this->userWith('products.view');
        $this->actingAs($stock)->get('/dashboard')->assertOk()->assertSee('Low-stock products');
    }

    /* ---------------------------------------------------------- misc */

    public function test_employee_numbers_are_derived_from_the_id(): void
    {
        $this->seedRolesForEmployee();
        $dept = \App\Models\Department::forceCreate(['name' => 'IT', 'code' => 'IT', 'is_active' => true]);

        $hr = $this->userWith('employees.create');

        foreach (['a', 'b'] as $n) {
            $this->actingAs($hr)->post('/employees', [
                'department_id' => $dept->id, 'first_name' => $n, 'last_name' => 'x',
                'email' => "$n@example.com", 'position' => 'dev', 'salary' => 1000, 'join_date' => '2026-01-01',
            ])->assertSessionHasNoErrors();
        }

        $numbers = \App\Models\Employee::orderBy('id')->pluck('employee_no')->all();
        $this->assertSame(['EMP-00001', 'EMP-00002'], $numbers);
    }

    private function seedRolesForEmployee(): void
    {
        \Spatie\Permission\Models\Role::findOrCreate('Employee');
    }
}
