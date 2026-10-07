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

            'code' => 'required|string|max:20|unique:accounts',
            'name' => 'required|string|max:255',
            'type' => 'required|in:asset,liability,equity,revenue,expense'

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

    /** Accounts the sales / purchase / payroll code posts to by code. */
    private const SYSTEM_CODES = ['1000', '1100', '4000', '5000'];

    public function update(
        Request $request,
        Account $account
    )
    {
        $request->validate([

            'code' => 'required|string|max:20|unique:accounts,code,' . $account->id,
            'name' => 'required|string|max:255',

            'type' => 'required|in:asset,liability,equity,revenue,expense'

        ]);

        abort_if(
            in_array($account->code, self::SYSTEM_CODES, true) && $request->code !== $account->code,
            422,
            'System account codes cannot be changed.'
        );

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
        if (in_array($account->code, self::SYSTEM_CODES, true)) {
            return back()->with('error', 'System accounts cannot be deleted.');
        }

        $account->delete();

        return redirect()
            ->route('accounts.index');
    }
}