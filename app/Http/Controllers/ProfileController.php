<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone'    => ['nullable', 'string', 'max:50'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        // changing the e-mail or the password needs the current password,
        // otherwise a hijacked / unattended session means account takeover
        $sensitive = $validated['email'] !== $user->email || ! empty($validated['password']);

        if ($sensitive) {
            $request->validate([
                'current_password' => ['required', 'current_password'],
            ]);
        }

        $user->name  = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        if (! empty($validated['password'])) {
            // keep THIS session alive, every other session of the user is dropped
            $request->session()->put('password_hash_web', $user->getAuthPassword());
        }

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profile updated successfully.');
    }
}
