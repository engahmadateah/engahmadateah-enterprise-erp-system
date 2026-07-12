<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::latest()->get();

        return view('warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        return view('warehouses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Warehouse::create([
            'name' => $request->name,
            'location' => $request->location,
        ]);

        return redirect()
            ->route('warehouses.index')
            ->with('success','Warehouse created');
    }

    /* =========================
        EDIT
    ========================= */
    public function edit(Warehouse $warehouse)
    {
        return view('warehouses.edit', compact('warehouse'));
    }

    /* =========================
        UPDATE
    ========================= */
    public function update(Request $request, Warehouse $warehouse)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $warehouse->update([
            'name' => $request->name,
            'location' => $request->location,
        ]);

        return redirect()
            ->route('warehouses.index')
            ->with('success','Warehouse updated');
    }

    /* =========================
        DELETE
    ========================= */
    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();

        return back()->with('success','Warehouse deleted');
    }
}