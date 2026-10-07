<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /** Roles the application itself depends on. */
    private const PROTECTED_ROLES = ['Super Admin', 'Employee'];

    /**
     * Privilege-escalation guard: unless you are a Super Admin you can only
     * hand out permissions you hold yourself, and you cannot edit a role you
     * are a member of (otherwise users.roles.edit == full admin).
     */
    private function guardEscalation(array $permissions, ?Role $role = null): void
    {
        $user = auth()->user();

        if ($user->hasRole('Super Admin')) {
            return;
        }

        if ($role) {
            abort_if($user->hasRole($role->name), 403, 'You cannot modify a role that is assigned to you.');
        }

        $mine = $user->getAllPermissions()->pluck('name')->all();

        abort_if(
            array_diff($permissions, $mine) !== [],
            403,
            'You cannot grant permissions you do not have.'
        );
    }

    public function index(Request $request)
    {
        $search = $request->search;

        $roles = Role::with('permissions')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString();

        return view('roles.index', compact('roles', 'search'));
    }

    public function create()
    {
        $permissions = Permission::orderBy('name')->get();

        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:100|unique:roles,name',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $this->guardEscalation($request->permissions ?? []);

        abort_if(in_array($request->name, self::PROTECTED_ROLES, true), 422, 'Reserved role name.');

        $role = Role::create(['name' => $request->name]);

        $role->syncPermissions($request->permissions ?? []);

        \App\Models\AuditLog::record('role.created', $role, "Role {$role->name} created", null, ['permissions' => $request->permissions ?? []]);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role Created Successfully');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('name')->get();

        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        // Super Admin already bypasses every check (Gate::before); renaming it
        // would silently remove that bypass.
        if ($role->name === 'Super Admin') {
            return back()->with('error', 'The Super Admin role cannot be modified');
        }

        $request->validate([
            'name'          => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($role->id)],
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $this->guardEscalation($request->permissions ?? [], $role);

        // built-in roles keep their name (the app looks them up by name)
        $name = in_array($role->name, self::PROTECTED_ROLES, true) ? $role->name : $request->name;
        abort_if(
            $name !== $role->name && in_array($name, self::PROTECTED_ROLES, true),
            422,
            'Reserved role name.'
        );

        $role->update(['name' => $name]);

        $before = $role->permissions()->pluck('name')->sort()->values()->all();

        $role->syncPermissions($request->permissions ?? []);

        \App\Models\AuditLog::record(
            'role.updated', $role, "Role {$role->name} updated",
            ['permissions' => $before],
            ['permissions' => collect($request->permissions ?? [])->sort()->values()->all()]
        );

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role Updated Successfully');
    }

    public function destroy(Role $role)
    {
        if (in_array($role->name, self::PROTECTED_ROLES, true)) {
            return back()->with('error', 'This built-in role cannot be deleted');
        }

        $this->guardEscalation([], $role);

        // deleting a role that is still assigned would silently strip those users' access
        if ($role->users()->exists()) {
            return back()->with('error', 'This role is still assigned to users');
        }

        \App\Models\AuditLog::record('role.deleted', $role, "Role {$role->name} deleted");

        $role->delete();

        return back()->with('success', 'Role Deleted Successfully');
    }
}
