<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * One payroll row per employee per month, enforced by the database
 * (two parallel "generate" clicks could create duplicates before).
 * Skipped automatically if duplicates already exist: clean them first.
 */
return new class extends Migration
{
    public function up(): void
    {
        $hasDuplicates = DB::table('payrolls')
            ->select('employee_id', 'month', 'year')
            ->groupBy('employee_id', 'month', 'year')
            ->havingRaw('COUNT(*) > 1')
            ->exists();

        if ($hasDuplicates) {
            return;
        }

        Schema::table('payrolls', function (Blueprint $table) {
            $table->unique(['employee_id', 'month', 'year'], 'payrolls_employee_period_unique');
        });
    }

    public function down(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->dropUnique('payrolls_employee_period_unique');
        });
    }
};
