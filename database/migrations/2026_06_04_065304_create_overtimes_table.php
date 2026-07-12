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
        Schema::create('overtimes', function (Blueprint $table) {

            $table->id();
        
            $table->foreignId('employee_id')
                ->constrained()
                ->cascadeOnDelete();
        
            $table->date('date');
        
            $table->decimal('hours', 8, 2);
        
            $table->decimal('hour_rate', 10, 2);
        
            $table->decimal('total_amount', 12, 2);
        
            $table->text('notes')->nullable();
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overtimes');
    }
};
