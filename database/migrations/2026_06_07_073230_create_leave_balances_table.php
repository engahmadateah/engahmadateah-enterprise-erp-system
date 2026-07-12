<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leave_balances', function (Blueprint $table) {

            $table->id();

            $table->foreignId('employee_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('annual_balance')
                ->default(21);

            $table->integer('used_balance')
                ->default(0);

            $table->integer('remaining_balance')
                ->default(21);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_balances');
    }
};