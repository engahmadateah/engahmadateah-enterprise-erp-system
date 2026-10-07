<?php

namespace App\Console\Commands;

use App\Models\AuditLog;
use Illuminate\Console\Command;

class PruneAuditLogs extends Command
{
    protected $signature = 'audit:prune {--days=365 : keep this many days}';

    protected $description = 'Delete audit log rows older than N days';

    public function handle(): int
    {
        $days = max(30, (int) $this->option('days'));   // never below 30 days

        $deleted = AuditLog::where('created_at', '<', now()->subDays($days))->delete();

        $this->info("Deleted {$deleted} audit rows older than {$days} days.");

        return self::SUCCESS;
    }
}
