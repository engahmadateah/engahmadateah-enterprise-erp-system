<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AccessControlTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_reach_any_protected_page(): void
    {
        foreach ([
            '/dashboard', '/users', '/roles', '/employees', '/payroll', '/payroll/1/slip',
            '/products', '/sales', '/purchases', '/customers', '/accounts',
            '/journal-entries', '/accounting', '/leaves', '/my-leaves',
            '/tickets', '/tickets/manage', '/chat',
        ] as $url) {
            $this->get($url)->assertRedirect(route('login'));
        }
    }

    public function test_user_without_permission_gets_403(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/products')->assertForbidden();
        $this->actingAs($user)->get('/sales/create')->assertForbidden();
        $this->actingAs($user)->post('/sales', [])->assertForbidden();
        $this->actingAs($user)->get('/accounts')->assertForbidden();
    }

    public function test_inactive_user_cannot_log_in(): void
    {
        $user = User::factory()->create(['is_active' => false]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertGuest();
    }

    public function test_super_admin_passes_every_permission_check(): void
    {
        Role::create(['name' => 'Super Admin']);

        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        $this->assertTrue($admin->can('some.permission.that.does.not.exist'));
    }

    public function test_user_manager_cannot_create_a_super_admin(): void
    {
        Role::create(['name' => 'Super Admin']);
        Permission::create(['name' => 'users.create']);

        $manager = User::factory()->create();
        $manager->givePermissionTo('users.create');

        $this->actingAs($manager)->post('/users', [
            'name' => 'Sneaky',
            'email' => 'sneaky@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'Super Admin',
        ])->assertForbidden();

        $this->assertDatabaseMissing('users', ['email' => 'sneaky@example.com']);
    }

    public function test_user_cannot_open_someone_elses_ticket(): void
    {
        Permission::create(['name' => 'tickets.edit']);

        $owner = User::factory()->create();
        $other = User::factory()->create();
        $other->givePermissionTo('tickets.edit');

        $ticket = Ticket::create([
            'ticket_number' => 'TIC-TEST-0001',
            'user_id' => $owner->id,
            'title' => 'Printer',
            'description' => 'Does not print',
            'status' => 'pending',
        ]);

        $this->actingAs($other)->get("/tickets/{$ticket->id}/edit")->assertForbidden();
    }
}
