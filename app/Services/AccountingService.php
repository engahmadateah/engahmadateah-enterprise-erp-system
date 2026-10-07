<?php

namespace App\Services;

use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalEntryLine;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

class AccountingService
{
    /**
     * Fetch accounts by code or fail with a clear message
     * (instead of "Attempt to read property id on null").
     *
     * @param  array<string>  $codes
     * @return \Illuminate\Support\Collection  keyed by code
     */
    public function accounts(array $codes)
    {
        $accounts = Account::whereIn('code', $codes)->get()->keyBy('code');

        foreach ($codes as $code) {
            if (! $accounts->has($code)) {
                throw new RuntimeException(
                    "Account {$code} is missing. Run: php artisan db:seed --class=AccountSeeder"
                );
            }
        }

        return $accounts;
    }

    /**
     * Create a balanced journal entry.
     * $lines = [['account_id' => 1, 'debit' => 10], ['account_id' => 2, 'credit' => 10]]
     */
    public function createEntry($description, $userId, $lines): JournalEntry
    {
        $debit  = round(collect($lines)->sum(fn ($l) => $l['debit'] ?? 0), 2);
        $credit = round(collect($lines)->sum(fn ($l) => $l['credit'] ?? 0), 2);

        if ($debit !== $credit) {
            throw new RuntimeException(
                "Journal entry is not balanced (debit {$debit} / credit {$credit})."
            );
        }

        return DB::transaction(function () use ($description, $userId, $lines) {

            $entry = JournalEntry::create([
                'entry_number' => 'JE-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(6)),
                'entry_date'   => now(),
                'description'  => $description,
                'user_id'      => $userId,
            ]);

            foreach ($lines as $line) {
                JournalEntryLine::create([
                    'journal_entry_id' => $entry->id,
                    'account_id'       => $line['account_id'],
                    'debit'            => $line['debit'] ?? 0,
                    'credit'           => $line['credit'] ?? 0,
                ]);
            }

            return $entry;
        });
    }
}
