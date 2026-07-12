<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::latest()->get();

        return view(
            'accounts.index',
            compact('accounts')
        );
    }

    public function create()
    {
        return view('accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([

            'code' => 'required|unique:accounts',

            'name' => 'required',

            'type' => 'required'

        ]);

        Account::create([

            'code' => $request->code,

            'name' => $request->name,

            'type' => $request->type,

            'is_active' =>
                $request->has('is_active')

        ]);

        return redirect()
            ->route('accounts.index')
            ->with(
                'success',
                'Account Created'
            );
    }

    public function edit(Account $account)
    {
        return view(
            'accounts.edit',
            compact('account')
        );
    }

    public function update(
        Request $request,
        Account $account
    )
    {
        $request->validate([

            'code' => 'required',

            'name' => 'required',

            'type' => 'required'

        ]);

        $account->update([

            'code' => $request->code,

            'name' => $request->name,

            'type' => $request->type,

            'is_active' =>
                $request->has('is_active')

        ]);

        return redirect()
            ->route('accounts.index');
    }

    public function destroy(Account $account)
    {
        $account->delete();

        return redirect()
            ->route('accounts.index');
    }
}