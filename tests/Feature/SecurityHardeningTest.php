<?php

namespace Tests\Feature;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SecurityHardeningTest extends TestCase
{
    use RefreshDatabase;

    public function test_deactivated_user_is_logged_out_on_next_request(): void
    {
        Permission::create(['name' => 'chat.view']);
        $user = User::factory()->create();
        $user->givePermissionTo('chat.view');

        $this->actingAs($user)->get('/chat')->assertOk();

        $user->update(['is_active' => false]);

        $this->get('/chat')->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_profile_password_change_requires_current_password(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->patch('/profile', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'brand-new-pass-1',
            'password_confirmation' => 'brand-new-pass-1',
        ])->assertSessionHasErrors('current_password');

        $this->actingAs($user)->patch('/profile', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'brand-new-pass-1',
            'password_confirmation' => 'brand-new-pass-1',
            'current_password' => 'password',
        ])->assertSessionHasNoErrors();
    }

    public function test_self_delete_route_no_longer_exists(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->delete('/profile', ['password' => 'password'])
            ->assertStatus(405);
    }

    public function test_role_editor_cannot_grant_permissions_they_do_not_have(): void
    {
        Permission::create(['name' => 'roles.edit']);
        Permission::create(['name' => 'users.delete']);
        $role = Role::create(['name' => 'Helper']);

        $editor = User::factory()->create();
        $editor->givePermissionTo('roles.edit');

        $this->actingAs($editor)->put("/roles/{$role->id}", [
            'name' => 'Helper',
            'permissions' => ['users.delete'],
        ])->assertForbidden();
    }

    public function test_role_editor_cannot_edit_their_own_role(): void
    {
        Permission::create(['name' => 'roles.edit']);
        $role = Role::create(['name' => 'Editors']);
        $role->givePermissionTo('roles.edit');

        $editor = User::factory()->create();
        $editor->assignRole($role);

        $this->actingAs($editor)->put("/roles/{$role->id}", [
            'name' => 'Editors',
            'permissions' => ['roles.edit'],
        ])->assertForbidden();
    }

    public function test_chat_attachment_is_private_and_only_members_can_download(): void
    {
        Storage::fake('local');
        Permission::create(['name' => 'chat.view']);

        [$a, $b, $outsider] = User::factory()->count(3)->create();
        foreach ([$a, $b, $outsider] as $u) {
            $u->givePermissionTo('chat.view');
        }

        $conversation = Conversation::create(['type' => 'private']);
        $conversation->users()->attach([$a->id, $b->id]);

        $this->actingAs($a)->post("/chat/{$conversation->id}", [
            'attachment' => UploadedFile::fake()->create('report.pdf', 20, 'application/pdf'),
        ]);

        $message = Message::firstOrFail();
        Storage::disk('local')->assertExists($message->attachment);

        $this->actingAs($b)->get(route('chat.attachment', $message))->assertOk();
        $this->actingAs($outsider)->get(route('chat.attachment', $message))->assertForbidden();
    }

    public function test_chat_rejects_html_and_svg_uploads(): void
    {
        Storage::fake('local');
        Permission::create(['name' => 'chat.view']);

        [$a, $b] = User::factory()->count(2)->create();
        $a->givePermissionTo('chat.view');

        $conversation = Conversation::create(['type' => 'private']);
        $conversation->users()->attach([$a->id, $b->id]);

        foreach (['x.html', 'x.svg', 'x.php'] as $name) {
            $this->actingAs($a)->post("/chat/{$conversation->id}", [
                'attachment' => UploadedFile::fake()->createWithContent($name, '<script>alert(1)</script>'),
            ])->assertSessionHasErrors('attachment');
        }

        $this->assertSame(0, Message::count());
    }

    public function test_stock_cannot_be_sold_below_zero(): void
    {
        Permission::create(['name' => 'stock.out']);
        $user = User::factory()->create();
        $user->givePermissionTo('stock.out');

        $product = Product::forceCreate([
            'name' => 'P', 'sku' => 'SKU1', 'quantity' => 2,
            'purchase_price' => 1, 'sale_price' => 2,
        ]);

        $this->actingAs($user)->post("/products/{$product->id}/sell-stock", ['quantity' => 5])
            ->assertSessionHas('error');

        $this->assertSame(2, (int) $product->fresh()->quantity);
    }

    public function test_security_headers_are_sent(): void
    {
        $this->get('/login')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'SAMEORIGIN');
    }
}
