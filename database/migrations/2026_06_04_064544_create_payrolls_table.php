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
    Schema::create('payrolls', function (Blueprint $table) {

        $table->id();
    
        $table->foreignId('employee_id')
            ->constrained()
            ->cascadeOnDelete();
    
        $table->integer('month');
    
        $table->integer('year');
    
        $table->decimal('basic_salary',12,2);
    
        $table->decimal('attendance_salary',12,2)
            ->default(0);
    
        $table->decimal('overtime_amount',12,2)
            ->default(0);
    
        $table->decimal('bonus_amount',12,2)
            ->default(0);
    
        $table->decimal('advance_deduction',12,2)
            ->default(0);
    
        $table->decimal('loan_deduction',12,2)
            ->default(0);
    
        $table->decimal('net_salary',12,2);
    
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
