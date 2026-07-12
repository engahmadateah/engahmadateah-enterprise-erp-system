<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {

            $table->id();
        
            $table->foreignId('employee_id')
                ->constrained()
                ->cascadeOnDelete();
        
            $table->decimal('amount',12,2);
        
            $table->decimal('monthly_installment',12,2);
        
            $table->decimal('remaining_balance',12,2);
        
            $table->date('start_date');
        
            $table->text('notes')->nullable();
        
            $table->boolean('is_closed')
                ->default(false);
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
