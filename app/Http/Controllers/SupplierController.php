<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::latest()
            ->paginate(20);

        return view(
            'suppliers.index',
            compact('suppliers')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            'suppliers.create'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:50',
            'email'   => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        Supplier::create([

            'name' =>
                $request->name,

            'phone' =>
                $request->phone,

            'email' =>
                $request->email,

            'address' =>
                $request->address,

            'is_active' =>
                $request->has('is_active'),

        ]);

        return redirect()
            ->route('suppliers.index')
            ->with(
                'success',
                'Supplier Created Successfully'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Supplier $supplier
    )
    {
        return view(
            'suppliers.show',
            compact('supplier')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        Supplier $supplier
    )
    {
        return view(
            'suppliers.edit',
            compact('supplier')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
        Supplier $supplier
    )
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:50',
            'email'   => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        $supplier->update([

            'name' =>
                $request->name,

            'phone' =>
                $request->phone,

            'email' =>
                $request->email,

            'address' =>
                $request->address,

            'is_active' =>
                $request->has('is_active'),

        ]);

        return redirect()
            ->route('suppliers.index')
            ->with(
                'success',
                'Supplier Updated'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Supplier $supplier
    )
    {
        $supplier->delete();

        return redirect()
            ->route('suppliers.index')
            ->with(
                'success',
                'Supplier Deleted'
            );
    }
}