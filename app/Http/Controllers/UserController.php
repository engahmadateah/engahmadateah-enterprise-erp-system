<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
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
    $roles = Role::all();

    return view(
        'users.create',
        compact('roles')
    );
}
public function store(StoreUserRequest $request)
{
    $user = User::create([

        'name' => $request->name,

        'email' => $request->email,

        'phone' => $request->phone,

        'password' => Hash::make(
            $request->password
        ),

    ]);

    $user->assignRole(
        $request->role
    );

    return redirect()
        ->route('users.index')
        ->with(
            'success',
            'User Created Successfully'
        );
}
public function edit(User $user)
{
    $roles = \Spatie\Permission\Models\Role::all();

    return view(
        'users.edit',
        compact('user', 'roles')
    );
}
public function update(
    UpdateUserRequest $request,
    User $user
)
{
    $user->update([

        'name' => $request->name,

        'email' => $request->email,

        'phone' => $request->phone,

        'is_active' => $request->has('is_active'),

    ]);

    if ($request->filled('password')) {

        $user->update([
            'password' => bcrypt(
                $request->password
            )
        ]);
    }

    $user->syncRoles([
        $request->role
    ]);

    return redirect()
        ->route('users.index')
        ->with(
            'success',
            'User Updated Successfully'
        );
}
public function destroy(User $user)
{
    if ($user->id === auth()->id()) {

        return back()->with(
            'error',
            'You cannot delete yourself'
        );
    }

    $user->delete();

    return back()->with(
        'success',
        'User Deleted Successfully'
    );
}

}