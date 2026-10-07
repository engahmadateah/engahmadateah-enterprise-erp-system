<?php

namespace Tests\Unit;

use App\Services\AccountingService;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class AccountingServiceTest extends TestCase
{
    public function test_unbalanced_entry_is_rejected_before_touching_the_database(): void
    {
        $this->expectException(RuntimeException::class);

        (new AccountingService())->createEntry('Bad entry', 1, [
            ['account_id' => 1, 'debit' => 100],
            ['account_id' => 2, 'credit' => 90],
        ]);
    }
}
