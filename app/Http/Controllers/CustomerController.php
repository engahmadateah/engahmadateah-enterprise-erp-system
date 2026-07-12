<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()
            ->paginate(20);

        return view(
            'customers.index',
            compact('customers')
        );
    }

    public function create()
    {
        return view(
            'customers.create'
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required'

        ]);

        Customer::create([

            'name' => $request->name,

            'phone' => $request->phone,

            'email' => $request->email,

            'address' => $request->address,

            'is_active' =>
                $request->has('is_active'),

        ]);

        return redirect()
            ->route('customers.index')
            ->with(
                'success',
                'Customer Created Successfully'
            );
    }

    public function edit(
        Customer $customer
    )
    {
        return view(
            'customers.edit',
            compact('customer')
        );
    }

    public function update(
        Request $request,
        Customer $customer
    )
    {
        $request->validate([

            'name' => 'required'

        ]);

        $customer->update([

            'name' => $request->name,

            'phone' => $request->phone,

            'email' => $request->email,

            'address' => $request->address,

            'is_active' =>
                $request->has('is_active'),

        ]);

        return redirect()
            ->route('customers.index')
            ->with(
                'success',
                'Customer Updated'
            );
    }

    public function destroy(
        Customer $customer
    )
    {
        $customer->delete();

        return redirect()
            ->route('customers.index')
            ->with(
                'success',
                'Customer Deleted'
            );
    }
}