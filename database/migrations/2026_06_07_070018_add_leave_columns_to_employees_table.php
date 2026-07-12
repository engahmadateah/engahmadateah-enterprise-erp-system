<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {

            $table->integer('annual_leave_balance')
                  ->default(21);

            $table->integer('used_leave_days')
                  ->default(0);

        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {

            $table->dropColumn([
                'annual_leave_balance',
                'used_leave_days'
            ]);

        });
    }
};