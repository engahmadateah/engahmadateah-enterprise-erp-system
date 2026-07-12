<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{

    /**
     * Show profile page
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }



    /**
     * Update profile information
     */
    public function update(Request $request): RedirectResponse
    {

        $user = $request->user();


        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $user->id
            ],

            'phone' => [
                'nullable',
                'string',
                'max:50'
            ],

            'password' => [
                'nullable',
                'min:8',
                'confirmed'
            ],

        ]);



        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;



        if (!empty($validated['password'])) {

            $user->password = Hash::make(
                $validated['password']
            );

        }



        $user->save();



        return redirect()
            ->route('profile.edit')
            ->with('success','Profile updated successfully.');

    }




    /**
     * Delete account
     */
    public function destroy(Request $request): RedirectResponse
    {

        $request->validate([

            'password' => [
                'required',
                'current_password'
            ]

        ]);



        $user = $request->user();



        Auth::logout();



        $user->delete();



        $request->session()->invalidate();

        $request->session()->regenerateToken();



        return redirect('/');

    }

}