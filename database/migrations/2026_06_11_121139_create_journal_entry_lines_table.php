<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journal_entry_lines', function (Blueprint $table) {

            $table->id();

            $table->foreignId('journal_entry_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('account_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal(
                'debit',
                12,
                2
            )->default(0);

            $table->decimal(
                'credit',
                12,
                2
            )->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_entry_lines');
    }
};