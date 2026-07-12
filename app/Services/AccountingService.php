<?php

namespace App\Services;

use App\Models\JournalEntry;
use App\Models\JournalEntryLine;

class AccountingService
{
    public function createEntry(
        $description,
        $userId,
        $lines
    ) {

        $entry = JournalEntry::create([

            'entry_number' =>
                'JE-' .
                now()->format('YmdHis') .
                '-' .
                rand(1000,9999),

            'entry_date' =>
                now(),

            'description' =>
                $description,

            'user_id' =>
                $userId,

        ]);

        foreach ($lines as $line) {

            JournalEntryLine::create([

                'journal_entry_id' =>
                    $entry->id,

                'account_id' =>
                    $line['account_id'],

                'debit' =>
                    $line['debit'] ?? 0,

                'credit' =>
                    $line['credit'] ?? 0,

            ]);
        }

        return $entry;
    }
}
