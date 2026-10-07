<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /** Owner of the ticket, or an IT manager (managetickets.view). */
    private function authorizeTicket(Ticket $ticket): void
    {
        abort_unless(
            $ticket->user_id === auth()->id()
                || auth()->user()->can('managetickets.view'),
            403
        );
    }

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

        'title' => 'required|string|max:255',

        'description' => 'required|string|max:5000',

        'teamviewer_id' => 'nullable|string|max:50',

        'ip_address' => 'nullable|ip',

        'attachments' => 'nullable|array|max:5',

        'attachments.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:4096'

    ]);

    $files = [];

    if ($request->hasFile('attachments')) {

        foreach ($request->file('attachments') as $file) {

            $files[] = $file->store('tickets', 'local');   // private disk
        }
    }

    Ticket::create([

        'ticket_number' =>
            'TIC-' . now()->format('YmdHis') . '-' . \Illuminate\Support\Str::upper(\Illuminate\Support\Str::random(4)),

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
    
    /** Authorised download of a ticket attachment (private disk). */
    public function attachment(Ticket $ticket, int $index)
    {
        $this->authorizeTicket($ticket);

        $path = ($ticket->attachments ?? [])[$index] ?? null;
        abort_unless($path, 404);

        $disk = \Illuminate\Support\Facades\Storage::disk('local');
        if (! $disk->exists($path)) {
            $disk = \Illuminate\Support\Facades\Storage::disk('public'); // legacy uploads
        }
        abort_unless($disk->exists($path), 404);

        return $disk->download($path, null, ['X-Content-Type-Options' => 'nosniff']);
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
        $request->validate([
            'status' => 'required|in:pending,processing,completed',
        ]);

        $ticket->update([
            'status' => $request->status
        ]);
    
        return back()
            ->with('success', 'Status Updated');
    }

    public function show(Ticket $ticket)
{
    $this->authorizeTicket($ticket);

    return view(
        'tickets.show',
        compact('ticket')
    );
}

public function edit(Ticket $ticket)
{
    $this->authorizeTicket($ticket);

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
    $this->authorizeTicket($ticket);

    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:5000',
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
    $this->authorizeTicket($ticket);

    $ticket->delete();

    return redirect()
        ->route('tickets.index')
        ->with(
            'success',
            'Ticket Deleted Successfully'
        );
}
}