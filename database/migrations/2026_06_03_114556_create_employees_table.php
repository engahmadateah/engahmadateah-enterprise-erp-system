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
        Schema::create('employees', function (Blueprint $table) {
    
            $table->id();
    
            $table->string('employee_no')
                  ->unique();
    
            $table->foreignId('department_id')
                  ->constrained()
                  ->cascadeOnDelete();
    
            $table->string('first_name');
    
            $table->string('last_name');
    
            $table->string('email')
                  ->unique();
    
            $table->string('phone')
                  ->nullable();
    
            $table->string('position');
    
            $table->decimal(
                'salary',
                12,
                2
            )->default(0);
    
            $table->date('join_date');
    
            $table->string('avatar')
                  ->nullable();
    
            $table->boolean('is_active')
                  ->default(true);
    
            $table->timestamps();
    
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
