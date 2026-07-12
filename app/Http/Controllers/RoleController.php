<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
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
    $permissions = Permission::orderBy('name')
        ->get();

    return view(
        'roles.create',
        compact('permissions')
    );
}
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:roles,name',
    ]);

    $role = Role::create([
        'name' => $request->name,
    ]);

    $role->syncPermissions(
        $request->permissions ?? []
    );

    return redirect()
        ->route('roles.index')
        ->with(
            'success',
            'Role Created Successfully'
        );
}
public function edit(Role $role)
{
    $permissions = Permission::all();

    return view(
        'roles.edit',
        compact(
            'role',
            'permissions'
        )
    );
}
public function update(
    Request $request,
    Role $role
)
{
    $request->validate([
        'name' => 'required'
    ]);

    $role->update([
        'name' => $request->name
    ]);

    $role->syncPermissions(
        $request->permissions ?? []
    );

    return redirect()
        ->route('roles.index')
        ->with(
            'success',
            'Role Updated Successfully'
        );
}
public function destroy(Role $role)
{
    if ($role->name === 'Super Admin') {

        return back()->with(
            'error',
            'Cannot Delete Super Admin'
        );
    }

    $role->delete();

    return back()->with(
        'success',
        'Role Deleted Successfully'
    );
}
}