<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index()
    {
        $movements = StockMovement::with([
            'product',
            'warehouse',
            'user'
        ])
        ->latest()
        ->paginate(20);

        return view('stock-movements.index', compact('movements'));
    }
}