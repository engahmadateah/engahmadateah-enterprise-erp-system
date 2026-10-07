<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'event' => 'nullable|string|max:60',
            'user'  => 'nullable|integer',
            'q'     => 'nullable|string|max:100',
            'from'  => 'nullable|date',
            'to'    => 'nullable|date|after_or_equal:from',
        ]);

        // escape LIKE wildcards so "%" / "_" are matched literally
        $like = fn (string $v) => '%' . addcslashes($v, '%_\\') . '%';

        $logs = AuditLog::with('user')
            ->when($request->event, fn ($q, $v) => $q->where('event', $v))
            ->when($request->user, fn ($q, $v) => $q->where('user_id', $v))
            ->when($request->q, fn ($q, $v) => $q->where(function ($w) use ($v, $like) {
                $w->where('description', 'like', $like($v))
                  ->orWhere('auditable_type', 'like', $like($v))
                  ->orWhere('ip_address', 'like', $like($v));
            }))
            ->when($request->from, fn ($q, $v) => $q->whereDate('created_at', '>=', $v))
            ->when($request->to, fn ($q, $v) => $q->whereDate('created_at', '<=', $v))
            ->orderByDesc('id')
            ->paginate(30)
            ->withQueryString();

        return view('audit-logs.index', [
            'logs'   => $logs,
            'events' => AuditLog::query()->distinct()->orderBy('event')->pluck('event'),
            'users'  => User::orderBy('name')->get(['id', 'name']),
        ]);
    }
}
