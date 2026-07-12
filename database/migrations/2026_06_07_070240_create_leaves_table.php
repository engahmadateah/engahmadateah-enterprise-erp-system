<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leaves', function (Blueprint $table) {

            $table->id();

            $table->foreignId('employee_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('leave_type_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('start_date');

            $table->date('end_date');

            $table->decimal(
                'days',
                8,
                2
            )->default(0);

            $table->text('reason')
                ->nullable();

            $table->enum(
                'status',
                [
                    'pending',
                    'approved',
                    'rejected'
                ]
            )->default('pending');

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')
                ->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};