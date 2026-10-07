<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $users = User::with('roles')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create', ['roles' => $this->assignableRoles()]);
    }

    public function store(StoreUserRequest $request)
    {
        $this->guardSuperAdmin(null, $request->role);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        \App\Models\AuditLog::record('user.role_assigned', $user, "Role {$request->role} assigned", null, ['role' => $request->role]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User Created Successfully');
    }

    public function edit(User $user)
    {
        $this->guardSuperAdmin($user);

        return view('users.edit', [
            'user'  => $user,
            'roles' => $this->assignableRoles(),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->guardSuperAdmin($user, $request->role);

        // never lock everybody out: the last active Super Admin must stay
        // a Super Admin and must stay active
        if (
            $this->isLastSuperAdmin($user)
            && ($request->role !== 'Super Admin' || ! $request->has('is_active'))
        ) {
            return back()->with(
                'error',
                'This is the last active Super Admin: keep the role and keep the account active.'
            );
        }

        $user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $oldRole = $user->getRoleNames()->first();

        $user->syncRoles([$request->role]);

        if ($oldRole !== $request->role) {
            \App\Models\AuditLog::record('user.role_changed', $user, "Role changed for {$user->email}", ['role' => $oldRole], ['role' => $request->role]);
        }

        return redirect()
            ->route('users.index')
            ->with('success', 'User Updated Successfully');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself');
        }

        $this->guardSuperAdmin($user);

        if ($this->isLastSuperAdmin($user)) {
            return back()->with('error', 'You cannot delete the last Super Admin');
        }

        $user->delete();

        return back()->with('success', 'User Deleted Successfully');
    }

    /* ------------------------------------------------------------------ */

    /** Only a Super Admin may see / hand out the Super Admin role. */
    private function assignableRoles()
    {
        return auth()->user()->hasRole('Super Admin')
            ? Role::all()
            : Role::where('name', '!=', 'Super Admin')->get();
    }

    /**
     * Without this, anyone with users.create/users.edit could make
     * themselves (or a friend) a Super Admin.
     */
    private function guardSuperAdmin(?User $target, ?string $newRole = null): void
    {
        if (auth()->user()->hasRole('Super Admin')) {
            return;
        }

        abort_if($newRole === 'Super Admin', 403, 'Only a Super Admin can assign this role.');
        abort_if($target && $target->hasRole('Super Admin'), 403, 'Only a Super Admin can manage this account.');
    }

    private function isLastSuperAdmin(User $user): bool
    {
        return $user->hasRole('Super Admin')
            && User::role('Super Admin')->where('is_active', true)->count() <= 1;
    }
}
