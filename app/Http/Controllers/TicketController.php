<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where(
            'user_id',
            auth()->id()
        )->latest()->get();
    
        return view(
            'tickets.index',
            compact('tickets')
        );
    }
    
    public function create()
    {
        return view('tickets.create');
    }
    
    public function store(Request $request)
{
    $request->validate([

        'title' => 'required',

        'description' => 'required',

        'attachments.*' => 'image|max:4096'

    ]);

    $files = [];

    if ($request->hasFile('attachments')) {

        foreach ($request->file('attachments') as $file) {

            $files[] = $file->store(
                'tickets',
                'public'
            );
        }
    }

    Ticket::create([

        'ticket_number' =>
            'TIC-' . now()->format('YmdHis'),

        'user_id' =>
            auth()->id(),

        'title' =>
            $request->title,

        'description' =>
            $request->description,

        'teamviewer_id' =>
            $request->teamviewer_id,

        'ip_address' =>
            $request->ip_address,

        'attachments' =>
            $files,

        'status' =>
            'pending'
    ]);

    return redirect()
        ->route('tickets.index')
        ->with(
            'success',
            'Ticket Created Successfully'
        );
}
    
    public function manage()
    {
        $tickets = Ticket::with('user')
            ->latest()
            ->get();
    
        return view(
            'tickets.manage',
            compact('tickets')
        );
    }
    
    public function updateStatus(
        Request $request,
        Ticket $ticket
    )
    {
        $ticket->update([
            'status' => $request->status
        ]);
    
        return back()
            ->with('success', 'Status Updated');
    }

    public function show(Ticket $ticket)
{
    return view(
        'tickets.show',
        compact('ticket')
    );
}

public function edit(Ticket $ticket)
{
    return view(
        'tickets.edit',
        compact('ticket')
    );
}

public function update(
    Request $request,
    Ticket $ticket
)
{
    $request->validate([
        'title' => 'required',
        'description' => 'required',
    ]);

    $ticket->update([
        'title' => $request->title,
        'description' => $request->description,
    ]);

    return redirect()
        ->route('tickets.index')
        ->with(
            'success',
            'Ticket Updated Successfully'
        );
}

public function destroy(Ticket $ticket)
{
    $ticket->delete();

    return redirect()
        ->route('tickets.index')
        ->with(
            'success',
            'Ticket Deleted Successfully'
        );
}
}