<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;

class AccountingController extends Controller
{
    public function index()
    {
        $entries = JournalEntry::with('lines.account')
            ->latest()
            ->paginate(20);

        return view('accounting.index', compact('entries'));
    }
}